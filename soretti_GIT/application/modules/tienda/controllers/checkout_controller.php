<?php
class Checkout_controller extends MX_Controller {


	public function __construct(){
		parent::__construct();
		$this->load->model("tiendaDireccion");
		$this->load->model("sepomex/estado");
		$this->load->model("sepomex/municipio");
		$this->load->model("sepomex/colonia");
		$this->load->model("sepomex/ciudad");
		$this->load->model("catalogo/descuento");
	}


 	function mostrar() {

		identificar('tienda/checkout/mostrar');
		if(!$this->session->userdata("checkout_paso") ) {
			$this->session->set_userdata("checkout_paso",1);
		}
		$titulo='Datos de envío';
		if ($this->session->userdata("checkout_paso")==2) $titulo='Forma de entrega';
		if ($this->session->userdata("checkout_paso")==3) $titulo='Datos de facturación';
		if ($this->session->userdata("checkout_paso")==4) $titulo='Forma de pago';
		if ($this->session->userdata("checkout_paso")==5) $titulo='Resumen del pedido';

		$data["meta"]        = array("descripcion"=>"","palabras_clave"=>"","titulo"=>"Tienda | ".$titulo);

		$this->layout_content = $this->load->view('tienda/checkout',$data,true);
		$this->load->view('plantilla/sincolumna');
	}


	function envio() {
		identificar('tienda/checkout/mostrar');
		$codigo_postal = null;
		$direccion_id  = null;
		$estado_id     = null;
		$municipio_id  = null;
		$colonia_id    = null;
		$nombreColonia = null;
		$direccion     = new TiendaDireccion();
		$direcciones   = new TiendaDireccion();
		$estados       = new Estado();
		$municipios    = new Municipio();
		$colonias      = new Colonia();
		$colonia       = new Colonia();

		$direcciones->where("usuario_id",$this->session->userdata('usuario_id'))->where('tipo',1)->get();
		$estados->order_by('titulo')->get();
		
		if(!$direcciones->result_count() && !$_POST){
			 $usr=new Usuario($this->session->userdata('usuario_id'));
			 $direccion->nombre=$usr->nombre;
			 $direccion->apellidoPaterno=$usr->apellidoPaterno;
			 $direccion->apellidoMaterno=$usr->apellidoMaterno;
			 $direccion->lada=$usr->lada;
			 $direccion->telefono=$usr->telefono;
		}

		if($this->input->post()) {
			$campos = array(
					'nombre','apellidoPaterno','apellidoMaterno',
					'razon_social','colonia_id','nombreColonia',
					'ciudad_id','estado_id',
					'municipio_id','lada','telefono',
					'celular','codigo','calle',
					'numero_ext','numero_int',
					'suplente','referencia');
			$direccion->from_array($_POST,$campos);


			if($this->input->post('nombreColonia') || $this->input->post('colonia_id')=='n/a'){
				$direccion->validation['nombreColonia']=array( 'field' => 'nombreColonia','label' => 'Nombre de la colonia','rules' => array('required') );
				$direccion->ciudad_id='';
			}

			if(is_numeric($this->input->post('colonia_id'))){
				$colonia_list=new colonia($this->input->post('colonia_id'));
				if( $colonia_list->exists() && $colonia_list->ciudad_id )  $direccion->ciudad_id=$colonia_list->ciudad_id;
			}

		}

		if($this->input->post('guardar_direccion')) {
			if($this->input->post('direccion_id') && $this->input->post('direccion_id') != "nueva_direccion") {
				$direccion->where('id',$this->input->post('direccion_id'))
						  ->where('usuario_id',$this->session->userdata('usuario_id'))
						  ->get();
				if($direccion->result_count()) {
					$this->session->set_userdata("checkout_envio",$direccion->id);
					$this->session->set_userdata("checkout_paso",2);
					return $this->load->view('tienda/checkout/envio');
				}else{
					echo "¡alerta, esta dirección no te pertenece!";
					die();
				}
			}else{
				$direccion->usuario_id = $this->session->userdata('usuario_id');
				$direccion->tipo = 1;
				if($direccion->save()) {
					$this->session->set_userdata("checkout_envio",$direccion->id);
					$this->session->set_userdata("checkout_paso",2);
					return $this->load->view('tienda/checkout/envio');
				}else{
					$codigo_postal = $direccion->codigo;
					$estado_id     = $direccion->estado_id;
					$municipio_id  = $direccion->municipio_id;
					$colonia_id    = $direccion->colonia_id;
					$direccion_id  = "nueva_direccion";
				}
			}
		}else{
			if($this->input->post('codigo')) {
				$codigo_postal = $this->input->post('codigo');
			}else{
				if($this->session->userdata('cp')) {
					$codigo_postal = $this->session->userdata('cp');
				}
			}

			if($this->input->post('direccion_id')) {
				$direccion_id = $this->input->post('direccion_id');
			}else{
				if($codigo_postal && $direcciones->result_count()) {
					foreach ($direcciones as $key => $d) {
						if($d->codigo==$codigo_postal) {
							$direccion_id = $d->id;
							break;
						}
					}
				}
			}

			if($this->input->post('estado_id')) {
				$estado_id = $this->input->post('estado_id');
				if($this->input->post('municipio_id')) {
					$municipio_id = $this->input->post('municipio_id');
					if($this->input->post('colonia_id')) {
						$colonia_id = $this->input->post('colonia_id');
					}
				}
			}else{
				if($codigo_postal) {
					$colonia->include_related('municipio')->where("cp",$codigo_postal)->get();
					$estado_id    = $colonia->municipio_estado_id;
					$municipio_id = $colonia->municipio_id;
					$colonia_id   = $colonia->id;
				}
			}
		}

		if($estado_id) {
			$municipios->order_by('titulo')->where("estado_id",$estado_id)->get();
		}
		if($municipio_id) {
			$colonias->order_by('titulo')->where("municipio_id",$municipio_id)->get();
		}

		$data = array(
			"direccion"     => $direccion,
			"codigo_postal" => $codigo_postal,
			"direccion_id"  => $direccion_id,
			"estado_id"     => $estado_id,
			"nombreColonia" => $nombreColonia,
			"municipio_id"  => $municipio_id,
			"colonia_id"    => $colonia_id,
			"direcciones"   => $direcciones,
			"estados"       => $estados,
			"municipios"    => $municipios,
			"colonias"      => $colonias
			);

		$this->load->view('tienda/checkout/envio', $data);
	}

	function envio_resumen()
	{
		identificar('tienda/checkout/mostrar');
		if(($this->session->userdata("checkout_paso")>1) && $this->session->userdata("checkout_envio")) {
			$this->tiendaDireccion->where('id',$this->session->userdata("checkout_envio"))->get();
			if($this->tiendaDireccion->result_count() && ($this->tiendaDireccion->usuario_id == $this->session->userdata('usuario_id'))){
				$this->load->view('tienda/checkout/envio_resumen',array('direccion'=>$this->tiendaDireccion));
			}else{
				show_error('lo sentimos, la dirección no existe');
			}
		}
	}

	function extras()
	{
		identificar('tienda/checkout/mostrar');

		if($this->input->post("aceptar_envio"))
				$this->session->set_userdata('forma_entrega', $this->input->post('forma_entrega') );

		if($this->session->userdata('forma_entrega')) $_POST['forma_entrega']=$this->session->userdata('forma_entrega');

		if($this->session->userdata('checkout_paso') && $this->session->userdata('checkout_paso') == 2) {
			$this->tiendaDireccion->where('id',$this->session->userdata("checkout_envio"))->get();

			$array = modules::run('tienda/envio/calcular_flete', $this->tiendaDireccion->codigo);


			if($this->input->post("aceptar_envio")) {
			 	$this->session->set_userdata('forma_entrega', $this->input->post('forma_entrega') );

				if(!$this->input->post('forma_entrega')){
					$array['error']='Seleccione una forma de entrega';
				}
				if($this->input->post('forma_entrega') && $this->input->post('forma_entrega')!=3){
						$this->session->set_userdata('checkout_paso',3);
				}

				if($array['error']=='' && $this->input->post('forma_entrega')==3){
					$this->session->set_userdata('checkout_paso',3);

				}

			}

			$this->layout_content = $this->load->view('tienda/checkout/extras',array("flete"=>$array));
		}else{
			$this->layout_content = $this->load->view('tienda/checkout/extras');
		}
	}

	function extras_resumen() {
		identificar('tienda/checkout/mostrar');
		if(($this->session->userdata("checkout_paso")>2) ) {
			$this->tiendaDireccion->where('id',$this->session->userdata("checkout_envio"))->get();

			if($this->tiendaDireccion->result_count() && ($this->tiendaDireccion->usuario_id == $this->session->userdata('usuario_id'))){
				$array =  modules::run('tienda/envio/calcular_flete', $this->tiendaDireccion->codigo);
				$this->load->view('tienda/checkout/extras_resumen',array("flete"=>$array));
			}else{
				show_error('lo sentimos, la dirección no existe');
			}
		}
	}

	function factura() {
		identificar('tienda/checkout/mostrar');
		if($this->session->userdata('checkout_paso') && $this->session->userdata('checkout_paso') == 3){

			if($this->input->post('guardar_direccion_fiscal')) {
				if(!$this->input->post('factura_requerida')) {
					$this->session->set_userdata("checkout_factura", 0);
					$this->session->set_userdata("checkout_paso" , 4);

					return $this->load->view('tienda/checkout/factura');
				}else{

					if($this->input->post('direccion_id')=='nueva_direccion') {
						$direccion = new TiendaDireccion();

						$fields = array('rfc','razon_social','nombreColonia','estado_id','municipio_id','colonia_id','calle','codigo','numero_ext','numero_int','correo');

						if($this->input->post('nombreColonia') || $this->input->post('colonia_id')=='n/a'){
							$direccion->validation['nombreColonia']=array( 'field' => 'nombreColonia','label' => 'Nombre de la colonia','rules' => array('required') );
							$direccion->ciudad_id='';
						}

						if(is_numeric($this->input->post('colonia_id'))){
							$colonia_list=new colonia($this->input->post('colonia_id'));
							if( $colonia_list->exists() && $colonia_list->ciudad_id )  $direccion->ciudad_id=$colonia_list->ciudad_id;
						}

						$direcciones_list = new TiendaDireccion();
						$direcciones_list->where("usuario_id",$this->session->userdata('usuario_id'))->where('tipo',1)->get();
						$data["direcciones_list"]=$direcciones_list;

						$direccion->from_array($_POST, $fields);

						$direccion->usuario_id = $this->session->userdata("usuario_id");
						$direccion->tipo=2;

						$direccion->validation = array('calle' => array('label' => 'Calle','rules' => array('required')),'numero_ext' => array('label' => 'Número exterior','rules' => array('required')),'codigo' => array('label' => 'Código postal','rules' => array('required')),'estado_id' => array('label' => 'Estado','rules' => array('required')),'municipio_id' => array('label' => 'Municipio','rules' => array('required')),'colonia_id' => array('label' => 'Colonia','rules' => array('required')),'rfc' => array('label' => 'RFC','rules' => array('required')),'razon_social' => array('label' => 'Razón Social','rules' => array('required')));
						if($direccion->save()) {
							$this->session->set_userdata("checkout_factura", $direccion->id);
							$this->session->set_userdata("checkout_paso" , 4);
							return $this->load->view('tienda/checkout/factura');
						}else{
							$data["direccion"] = $direccion;
							$direcciones = new TiendaDireccion();
							$data["direcciones"] = $direcciones->where("usuario_id",$this->session->userdata('usuario_id'))->where('tipo',2)->get();
							$data["estados"] = $this->estado->order_by('titulo')->get();
							if($this->input->post('estado_id')) {
								$data["municipios"] = $this->municipio->where('estado_id',$this->input->post('estado_id'))->order_by('titulo')->get();
								if($this->input->post('municipio_id')) {
									$data["colonias"] = $this->colonia->where('municipio_id',$this->input->post('municipio_id'))->order_by('titulo')->get();
								}
							}
							return $this->load->view('tienda/checkout/factura',$data);
						}
					}else{
					    $direccion = new TiendaDireccion($this->input->post("direccion_id"));
						$this->session->set_userdata("checkout_factura", $direccion->id);
						$this->session->set_userdata("checkout_paso" , 4);
					}
				}
			}


			if(!$this->input->post('factura_requerida')) {
				return $this->load->view('tienda/checkout/factura');
			}else{
				$direccion = new TiendaDireccion();
				$direcciones = new TiendaDireccion();
				$direcciones->where("usuario_id",$this->session->userdata('usuario_id'))->where('tipo',2)->get();

				if( $this->input->post("direccion_id") == "nueva_direccion") {

						if($this->input->post('direccion_select_factura')){
								$nDirecion=new tiendaDireccion();
								$nDirecion->where('usuario_id',$this->session->userdata('usuario_id'))->where('id',$this->input->post('direccion_select_factura'))->get();
								if($nDirecion->exists()){
									$_POST['estado_id']=$nDirecion->estado_id;
									$_POST['municipio_id']=$nDirecion->municipio_id;
									$_POST['colonia_id']=$nDirecion->colonia_id;
									$_POST['nombreColonia']=$nDirecion->nombreColonia;
									$_POST['calle']=$nDirecion->calle;
									$_POST['codigo']=$nDirecion->codigo;
									$_POST['numero_ext']=$nDirecion->numero_ext;
									$_POST['numero_int']=$nDirecion->numero_int;
								}
								$direccion->from_array($_POST,array( 'rfc','razon_social','nombreColonia','estado_id','municipio_id','colonia_id','calle','codigo','numero_ext','numero_int'));
						}



					$data["estados"] = $this->estado->order_by('titulo')->get();
					if($this->input->post('estado_id')) {
						$data["municipios"] = $this->municipio->where('estado_id',$this->input->post('estado_id'))->order_by('titulo')->get();
						if($this->input->post('municipio_id')) {
							$data["colonias"] = $this->colonia->where('municipio_id',$this->input->post('municipio_id'))->order_by('titulo')->get();
						}
					}
				}

				$data["direcciones"] = $direcciones;
				$data["direccion"]   = $direccion;
				$direcciones_list = new TiendaDireccion();
				$direcciones_list->where("usuario_id",$this->session->userdata('usuario_id'))->where('tipo',1)->get();
				$data["direcciones_list"]=$direcciones_list;
				return $this->load->view('tienda/checkout/factura',$data);
			}

		}else{
			$this->load->view('tienda/checkout/factura');
		}

	}

	function factura_resumen() {
		identificar('tienda/checkout/mostrar');
		if(($this->session->userdata("checkout_paso")>3) ) {

			$data = array();
			if($this->session->userdata("checkout_factura")) {
				$data['factura_requerida'] = 1;
				$data['direccion'] = $this->tiendaDireccion->where('id',$this->session->userdata("checkout_factura"))->get();
			}else{
				$data['factura_requerida'] = 0;
			}
			$this->load->view('tienda/checkout/factura_resumen',$data);
		}

	}

	function pago() {
		identificar('tienda/checkout/mostrar');
		$error='';
		$metodos_de_pago=$this->config->item('metodos_pago','proyecto');

		if($this->session->userdata('checkout_paso') && $this->session->userdata('checkout_paso') == 4) {
			if($this->input->post('guardar_pago')) {
				if( $this->input->post('metodo_pago')  && array_key_exists($this->input->post('metodo_pago'),$metodos_de_pago)) {
					$this->session->set_userdata("checkout_pago", $this->input->post('metodo_pago'));
					$this->session->set_userdata("checkout_paso" , 5);
				}else{
					$error="Seleccione una forma de pago";
				}
			}
		}
		$this->load->view('tienda/checkout/pago',array('metodos_de_pago'=>$metodos_de_pago,'error'=>$error));
	}

	function pago_resumen() {
		identificar('tienda/checkout/mostrar');
		$metodos_de_pago=$this->config->item('metodos_pago','proyecto');
		if(($this->session->userdata("checkout_paso")>4)   && $this->session->userdata("checkout_pago")) {
			$this->load->view('tienda/checkout/pago_resumen', array('metedos_de_pago'=>$metodos_de_pago,'metodo_pago'=>$this->session->userdata("checkout_pago")));
		}
	}

	function resumen() {
		identificar('tienda/checkout/mostrar');
		if($this->session->userdata('checkout_paso') && $this->session->userdata('checkout_paso') == 5) {
				$datos=array();

			$usuario_tienda=new Usuario($this->session->userdata('usuario_id'));
			$total=$this->cart->total();

				/*SI EXISTE EL CUPON MOSTRARLO*/
				if($this->session->userdata('cupon') && !$usuario_tienda->descuento_id){

					$cupon = new Cupon();
					$datos=array();
					$cupon->is_active()->where('cupon',$this->session->userdata('cupon'))->get();

					if($cupon->tipo_descuento=='cantidad'){
						$datos['cantidadcupon']=$cupon->descuento;
					}
					if($cupon->tipo_descuento=='porcentaje'){
						$datos['cantidadcupon']=(($this->cart->total()*$cupon->descuento)/100);
					}
					$total=$total-$datos['cantidadcupon'];
				}else{
					$datos['cantidadcupon']=0;
				}
				if($this->session->userdata('usuario_id')){
					$this->load->model('usuario');
					$datos['usuario_tienda']=new Usuario($this->session->userdata('usuario_id'));
				}

			/* CALCULA FLETE */
			$this->tiendaDireccion->where('id',$this->session->userdata("checkout_envio"))->get();

			if($this->tiendaDireccion->result_count() && ($this->tiendaDireccion->usuario_id == $this->session->userdata('usuario_id'))){
				$flete_array =  modules::run('tienda/envio/calcular_flete', $this->tiendaDireccion->codigo);
				$flete_array['forma_entrega']=$this->session->userdata('forma_entrega');
				if($flete_array['forma_entrega']!=3){
					$flete_array['precio']=0;
				}
				$total = $total + $flete_array['precio'];
			}

			if(!isset($flete_array) || empty($flete_array)) {
				echo  "Error al calcular flete"; die();
			}


			/* calculo de descuento al mayoreo, no aplica si el usuario es distribuidor*/
			$promocion='';
			if(!$usuario_tienda->descuento_id){
				$promociones=$this->config->item('promociones','proyecto');
				if($total>=$promociones['promocion2']['monto_minimo']){
					$promocion=$promociones['promocion2'];
				}elseif($total>=$promociones['promocion1']['monto_minimo']){
					$promocion=$promociones['promocion1'];
				}
				if(is_array($promocion)){
					 $promocion['importe_descuento']=(($total*$promocion['porcentaje'])/100);
					 $total=$total-$promocion['importe_descuento'];
				}
			}

			$metodos_entrega=$this->config->item('metodos_entrega','proyecto');
			$this->load->view('tienda/checkout/resumen',array('datos'=>$datos,'total'=>$total,'promocion'=>$promocion,'flete'=>$flete_array,'metodos_entrega'=>$metodos_entrega,'openpay'=>$this->config->item('openpay','proyecto')));

		}else{
			$this->load->view('tienda/checkout/resumen');
		}
	}

	function regresar($paso=1) {
		identificar('tienda/checkout/mostrar');
		$this->session->set_userdata("checkout_paso",$paso);

		redirect('tienda/checkout/mostrar');
	}

	function _guardar_items($order){
		identificar('tienda/checkout/mostrar');
		
		$this->load->model('item','catalogo/producto','catalogo/cat_precio');

		foreach ($this->cart->contents() as $items){

			$producto=new Producto();
			$producto->include_related('cat_precio')->where('id',$items['id']);
			
			$item = new item();
			$item->producto_id       = $items['id'];
            $item->SKU      = $items['sku'];
            $item->titulo   = $items['name'];
	        $item->cantidad = $items['qty'];
	        $item->precio   = $items['price'];
	        $item->extra    = json_encode(array('precio'=>$producto->cat_precio_precio, 'precio'=>$producto->cat_precio_precio ));

	      /*Obtener cupon y revisar si pertene a un distribuidor*/
	        /*Si pertenece a un distribuidor obtener su porcentaje de desuento */
	        /*Aplicar el porcentaje a $items['price']  y gardarlo en el campo precioDistribuidor*/

		   $usuario_tienda=new Usuario($this->session->userdata('usuario_id'));

	        /*SI EXISTE EL CUPON MOSTRARLO*/
		   if($this->session->userdata('cupon') && !$usuario_tienda->descuento_id){

		 	$cupon = new Cupon();
		 	$cupon->where('cupon',$this->session->userdata('cupon'))->get();

		 	$usuario = new Usuario();
		 	$usuario->where('cupon_id',$cupon->id)->get();

		 	$descuento = new Descuento();
		 	$descuento->where('id', $usuario->descuento_id)->get();

		 	$totaldescuento=(($items['price']*$descuento->porcentaje)/100);

		 	$item->preciodistribuidor=$items['price']-$totaldescuento;
		 }

	        $item->imagen   = $items['imagen'];
	        $item->options  = utf8_decode(json_encode($items['options']));
	        $item->save($order);
		}
	}

	function procesar_compra() {
		identificar('tienda/checkout/mostrar');

		$this->load->library('openpaytrahc');
		$this->load->helper('string');

		$usuario_tienda=new Usuario($this->session->userdata('usuario_id'));
		$total=$this->cart->total();

		if($this->session->userdata('checkout_paso') && $this->session->userdata('checkout_paso') == 5 && $this->session->userdata('checkout_pago')) {

			$this->load->model('order');
			$this->order->usuario_id = $this->session->userdata('usuario_id');
			$this->order->fecha_creacion = date('Y-m-d H:i:s');
			$this->order->datos_envio = utf8_decode($this->tiendaDireccion->where("id",$this->session->userdata('checkout_envio'))->get()->to_json());
			$codigo_postal = $this->tiendaDireccion->codigo;
			$flete_array =  modules::run('tienda/envio/calcular_flete', $codigo_postal);

			$this->load->model('usuario/usuario');
			$this->order->datos_usuario = utf8_decode($this->usuario->where("id", $this->session->userdata('usuario_id'))->get()->to_json());
			$this->order->datos_factura = utf8_decode($this->tiendaDireccion->where("id",$this->session->userdata('checkout_factura'))->get()->to_json());
			$datos_pago["subtotal"] = $this->cart->total();

			/*SI EXISTE EL CUPON MOSTRARLO*/
			if($this->session->userdata('cupon') && !$usuario_tienda->descuento_id){
				$cupon = new Cupon();
				$datos=array();
				$cupon->is_active()->where('cupon',$this->session->userdata('cupon'))->get();
				$cupon->canjeado=$cupon->canjeado+1;
				$cupon->save();

				if($cupon->tipo_descuento=='cantidad'){
					$cantidadCupon=$cupon->descuento;
				}
				if($cupon->tipo_descuento=='porcentaje'){
					$cantidadCupon=(($this->cart->total()*$cupon->descuento)/100);
				}
				$total=$total-$cantidadCupon;
				$this->order->cupon_id=$cupon->id;
				$this->order->cupon=$this->session->userdata('cupon');
				if($cupon->tipo_descuento=='porcentaje') $this->order->cuponPorcentaje=$cupon->descuento;
			}else{
				$cantidadCupon=0;
			}


			/* Fin cupon*/

			/*Flete*/
			$flete_array['forma_entrega']=$this->session->userdata('forma_entrega');
			if($flete_array['forma_entrega']!=3){
					$flete_array['precio']=0;
			}
			$total = $total + $flete_array['precio'];
			/*Fin flete*/


			/* calculo de descuento al mayoreo, no aplica si el usuario es distribuidor*/
			$descuento_mayoreo=0;
			if(!$usuario_tienda->descuento_id){
				$promociones=$this->config->item('promociones','proyecto');
				if($total>=$promociones['promocion2']['monto_minimo']){
					$promocion=$promociones['promocion2'];
				}elseif($total>=$promociones['promocion1']['monto_minimo']){
					$promocion=$promociones['promocion1'];
				}
				if(isset($promocion) && is_array($promocion)){
					 $descuento_mayoreo=(($total*$promocion['porcentaje'])/100);
					 $this->order->mayoreoPorcentaje=$promocion['porcentaje'];
					 $total=$total-$descuento_mayoreo;
				}
			}

			$datos_pago["forma_entrega"] = $flete_array['forma_entrega'];
			$datos_pago["descuentoCupon"] = $cantidadCupon;
			$datos_pago["descuentoMayoreo"] = $descuento_mayoreo;
			$datos_pago["flete"] = $flete_array['precio'];
			$datos_pago["flete_gratis"] = $flete_array['gratis'];
			$datos_pago["total"] = $total;
			$this->order->total = $total;

			if($this->session->userdata('checkout_pago')==1) { /*API  BANAMEX OPENPAY TDC*/
				$this->order->estatus = 0;
				$datos_pago["metodo_pago"]=1;

				$this->order->datos_pago = utf8_decode(json_encode($datos_pago));
				if($this->order->save()) {
					$this->_guardar_items($this->order);
					//$amount = $this->cart->total() + $flete_array['precio'];
					//BANAMEX  $amount = formato_precio_banamex($amount);
					//BANAMEX  $amount = substr($amount, 0, -2);
					//BANAMEX  $amount = $amount . "00";
					//BANAMEX  $this->_enviar_datos_a_banamex($this->order->id,random_string('alnum', 16),$amount);
					/*OpenPay*/
					$response=$this->openpaytrahc->tarjeta_credito($this->order);
					if(isset($response['error'])){
						$this->session->set_flashdata('error', $response['error']);
						redirect('tienda/checkout/mostrar','refresh');
					}else{
						$this->cart->destroy();
						$this->session->set_flashdata('order_id', $this->order->id);
						$this->_enviar_mail($this->order->id);
						$this->session->set_flashdata(
						'mensaje',
						'Tu pago  ha sido aceptado. En esta sección podrás revisar el estatus de orden. También te hemos
						 enviado un correo a tu cuenta con todos los datos al respecto.');
						redirect('tienda/order/listar');
					}
				}else{
					die('Error al guardar la orden');
				}
			} elseif ($this->session->userdata('checkout_pago')==4 || $this->session->userdata('checkout_pago')==2|| $this->session->userdata('checkout_pago')==3) { /* DEPOSITOS BANCARIOS | tiendas de conveniencia */
				$this->order->estatus = 1;
				$datos_pago["metodo_pago"]=$this->session->userdata('checkout_pago');
				$this->order->datos_pago = utf8_decode(json_encode($datos_pago));
				$this->order->datos_banco = '';
				if($this->order->save()) {
					$this->_guardar_items($this->order);
					$this->session->set_userdata("checkout_paso",1);
					if($this->session->userdata('checkout_pago')==2) $this->openpaytrahc->tiendas_de_conveniencia($this->order);
					if($this->session->userdata('checkout_pago')==3) $this->openpaytrahc->cargo_banco($this->order);
					$this->_enviar_mail($this->order->id);
					$this->cart->destroy();
					$this->session->set_flashdata('order_id', $this->order->id);
					$this->session->set_flashdata(
						'mensaje',
						'Tu orden ha sido registrada, esperamos tu pago en un lapso
						 no mayor a 2 días. En esta sección podrás revisar tu compra a detalle
						 y el procedimiento de pago. También te hemos
						 enviado un correo a tu cuenta con todos los datos al respecto.');
					redirect('tienda/order/listar');
				}else{
					echo "error al guardar compra con deposito";
					die();
				}

			}else{
				die("forma de pago incorrecta");
			}
		}
	}

	function _enviar_datos_a_banamex($vpc_OrderInfo,$vpc_MerchTxnRef,$vpc_Amount) {
		identificar('tienda/checkout/mostrar');
		$this->load->helper('PaymentCodesHelper');
		$this->load->model('VPCPaymentConnection');


		$conn = new VPCPaymentConnection();


		// This is secret for encoding the SHA256 hash
		// This secret will vary from merchant to merchant

		$secureSecret = "6C218C08A17BBBD54F46CF19B1666A31";

		// Set the Secure Hash Secret used by the VPC connection object
		$conn->setSecureSecret($secureSecret);


		// *******************************************
		// START OF MAIN PROGRAM
		// *******************************************

		// add the start of the vpcURL querystring parameters
		$vpcURL = "https://banamex.dialectpayments.com/vpcpay";

		// This is the title for display
		$title  = "VegaNet Pago con Tarjeta de Crédito";


		$vpc_data_arr = array(
			"vpc_Version"                 => "1",
			"vpc_Command"                 => "pay",
			"vpc_AccessCode"              => "ACCA590D",
			"vpc_MerchTxnRef"             => $vpc_MerchTxnRef,
			"vpc_Merchant"                => "test1043684",
			"vpc_OrderInfo"               => $vpc_OrderInfo,
			"vpc_Amount"                  => $vpc_Amount,
			"vpc_ReturnURL"               => base_url('tienda/checkout/procesar_respuesta_banamex'),
			"vpc_Locale"                  => "es_MX",
			"vpc_Currency"                => "MXN",
			"vpc_CustomPaymentPlanPlanId" => ""
			);

		ksort($vpc_data_arr);

		// Add VPC post data to the Digital Order
		foreach($vpc_data_arr as $key => $value) {
			if (strlen($value) > 0) {
				$conn->addDigitalOrderField($key, $value);
			}
		}

		// Add original order HTML so that another transaction can be attempted.
		//$conn->addDigitalOrderField("AgainLink", "againLink");

		// Obtain a one-way hash of the Digital Order data and add this to the Digital Order
		$secureHash = $conn->hashAllFields();
		$conn->addDigitalOrderField("Title", $title);
		$conn->addDigitalOrderField("vpc_SecureHash", $secureHash);
		$conn->addDigitalOrderField("vpc_SecureHashType", "SHA256");

		// Obtain the redirection URL and redirect the web browser
		$vpcURL = $conn->getDigitalOrder($vpcURL);

		// die($vpcURL);

		header("Location: ".$vpcURL);
		//echo "<a href=$vpcURL>$vpcURL</a>";
	}

	function procesar_respuesta_banamex() {
		identificar('tienda/checkout/mostrar');
		$this->load->helper('PaymentCodesHelper');
		$this->load->model('VPCPaymentConnection');

		$conn = new VPCPaymentConnection();

		$secureSecret = "6C218C08A17BBBD54F46CF19B1666A31";

		$conn->setSecureSecret($secureSecret);

		$errorsExist = false;

		$title  = $_GET["Title"];

		foreach($_GET as $key => $value) {
			if (($key!="vpc_SecureHash") && ($key != "vpc_SecureHashType") && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
				$conn->addDigitalOrderField($key, $value);
			}
		}

		$serverSecureHash	= array_key_exists("vpc_SecureHash", $_GET)	? $_GET["vpc_SecureHash"] : "";
		$secureHash = $conn->hashAllFields();
		if ($secureHash==$serverSecureHash) {
			$hashValidated = "<font color='#00AA00'><strong>CORRECT</strong></font>";
		} else {
			$hashValidated = "<font color='#FF0066'><strong>INVALID HASH</strong></font>";
			$errorsExist = true;
		}

		$txnResponseCodeDesc = "";
		$cscResultCodeDesc = "";
		$avsResultCodeDesc = "";

		$txnResponseCode = $_GET['vpc_TxnResponseCode'];
	    if ($txnResponseCode != "No Value Returned") {
	        $txnResponseCodeDesc = getResultDescription($txnResponseCode);
	    }

	    $cscResultCode = $_GET["vpc_CSCResultCode"];
	    if ($cscResultCode != "No Value Returned") {
	        $cscResultCodeDesc = getCSCResultDescription($cscResultCode);
	    }

		$error = "";
	    // Show this page as an error page if error condition
	    if ($txnResponseCode=="7" || $txnResponseCode=="No Value Returned" || $errorsExist) {
	        $error = "Error ";
	    }

	    $datos_banco['error'] = $error;
	    $datos_banco['cscResultCodeDesc']   = $cscResultCodeDesc;
	    $datos_banco['avsResultCodeDesc']   = $avsResultCodeDesc;
	    $datos_banco['txnResponseCodeDesc'] = $txnResponseCodeDesc;
	    $datos_banco['hashValidated']       = $hashValidated;
	    $datos_banco['errorsExist']         = $errorsExist;
	    $datos_banco['title']               = $title;

	    $datos_banco['Title']				= array_key_exists("Title", $_GET) 						? $_GET["Title"] 				: "";
		$datos_banco['againLink']			= array_key_exists("AgainLink", $_GET) 					? $_GET["AgainLink"] 			: "";
		$datos_banco['amount'] 			= array_key_exists("vpc_Amount", $_GET) 				? $_GET["vpc_Amount"] 			: "";
		$datos_banco['locale'] 			= array_key_exists("vpc_Locale", $_GET) 				? $_GET["vpc_Locale"] 			: "";
		$datos_banco['batchNo'] 			= array_key_exists("vpc_BatchNo", $_GET) 				? $_GET["vpc_BatchNo"] 			: "";
		$datos_banco['command'] 			= array_key_exists("vpc_Command", $_GET) 				? $_GET["vpc_Command"] 			: "";
		$datos_banco['message'] 			= array_key_exists("vpc_Message", $_GET) 				? $_GET["vpc_Message"]			: "";
		$datos_banco['version']  			= array_key_exists("vpc_Version", $_GET) 				? $_GET["vpc_Version"] 			: "";
		$datos_banco['cardType']   		= array_key_exists("vpc_Card", $_GET) 					? $_GET["vpc_Card"] 			: "";
		$datos_banco['orderInfo'] 			= array_key_exists("vpc_OrderInfo", $_GET) 				? $_GET["vpc_OrderInfo"] 		: "";
		$datos_banco['receiptNo'] 			= array_key_exists("vpc_ReceiptNo", $_GET) 				? $_GET["vpc_ReceiptNo"] 		: "";
		$datos_banco['merchantID']  		= array_key_exists("vpc_Merchant", $_GET) 				? $_GET["vpc_Merchant"] 		: "";
		$datos_banco['merchTxnRef'] 		= array_key_exists("vpc_MerchTxnRef", $_GET) 			? $_GET["vpc_MerchTxnRef"]		: "";
		$datos_banco['authorizeID'] 		= array_key_exists("vpc_AuthorizeId", $_GET) 			? $_GET["vpc_AuthorizeId"] 		: "";
		$datos_banco['transactionNo']  	= array_key_exists("vpc_TransactionNo", $_GET) 			? $_GET["vpc_TransactionNo"] 	: "";
		$datos_banco['acqResponseCode'] 	= array_key_exists("vpc_AcqResponseCode", $_GET) 		? $_GET["vpc_AcqResponseCode"] 	: "";
		$datos_banco['txnResponseCode'] 	= array_key_exists("vpc_TxnResponseCode", $_GET) 		? $_GET["vpc_TxnResponseCode"] 	: "";
		$datos_banco['riskOverallResult']	= array_key_exists("vpc_RiskOverallResult", $_GET) 		? $_GET["vpc_RiskOverallResult"]: "";

				// Obtain the 3DS response
		$datos_banco['vpc_3DSECI']				= array_key_exists("vpc_3DSECI", $_GET) 			? $_GET["vpc_3DSECI"] : "";
		$datos_banco['vpc_3DSXID']				= array_key_exists("vpc_3DSXID", $_GET) 			? $_GET["vpc_3DSXID"] : "";
		$datos_banco['vpc_3DSenrolled'] 		= array_key_exists("vpc_3DSenrolled", $_GET) 		? $_GET["vpc_3DSenrolled"] : "";
		$datos_banco['vpc_3DSstatus'] 			= array_key_exists("vpc_3DSstatus", $_GET) 			? $_GET["vpc_3DSstatus"] : "";
		$datos_banco['vpc_VerToken'] 			= array_key_exists("vpc_VerToken", $_GET) 			? $_GET["vpc_VerToken"] : "";
		$datos_banco['vpc_VerType'] 			= array_key_exists("vpc_VerType", $_GET) 			? $_GET["vpc_VerType"] : "";
		$datos_banco['vpc_VerStatus']			= array_key_exists("vpc_VerStatus", $_GET) 			? $_GET["vpc_VerStatus"] : "";
		$datos_banco['vpc_VerSecurityLevel']	= array_key_exists("vpc_VerSecurityLevel", $_GET) 	? $_GET["vpc_VerSecurityLevel"] : "";

		    // CSC Receipt datos_banco
		$datos_banco['cscResultCode'] 	= array_key_exists("vpc_CSCResultCode", $_GET)  			? $_GET["vpc_CSCResultCode"] : "";
		$datos_banco['ACQCSCRespCode'] = array_key_exists("vpc_AcqCSCRespCode", $_GET) 			? $_GET["vpc_AcqCSCRespCode"] : "";



		if($datos_banco['txnResponseCode']) {
			$this->session->set_flashdata('declined', 1);
			redirect('tienda/checkout/mostrar');
		}else{
			$this->load->model('order');
			$this->order->where('id',$datos_banco['orderInfo'])->get();
			$this->order->datos_banco = utf8_decode(json_encode($datos_banco));
			$this->order->estatus = 2;

			if($this->order->save()) {

				$this->_guardar_items($this->order);
				$this->session->set_userdata("checkout_paso",1);
				$this->_enviar_mail($this->order->id);
				$this->cart->destroy();

				$this->session->set_flashdata('order_id', $this->order->id);
				$this->session->set_flashdata(
					'mensaje',
					'Gracias por tu compra, en esta sección puedes ver todo lo
					 relacionado con ella, incluyendo su estatus. También te hemos
					 enviado un correo a tu cuenta con todos los datos al respecto.');
				redirect('tienda/order/listar');
			}else{
				echo "datos NO guardados...!";
				die();
			}
		}
	}

	public function _enviar_mail($order_id) {

		$this->load->library('email');
		$this->load->model('order');
		$this->load->model('item');
		$this->load->model('flete');
		$this->order->include_related('flete');
		$this->order->where("id",$order_id)->get();

		$status=$this->config->item('status_tienda','proyecto');
		$estatus=$status[$this->order->estatus];

		$usuario = json_decode($this->order->datos_usuario);

		$to = $usuario->email;
		if(ENVIRONMENT=='development')
		{
			$to = 'ob@paginasweb.mx';
		}
		$subject = 'PEDIDO #' . $this->order->id . " - " . $estatus;
		$frase='';


		if($this->order->estatus==1){
			$frase='Por medio del presente correo te confirmamos tu orden y te damos las gracias por elegirnos como tu tienda de preferencia.';
		}
		if($this->order->estatus==2){
			$frase='Por medio del presente correo te confirmamos tu pago ha sido aceptado';
		}
		if($this->order->estatus==3){
			$frase='Por medio del presente correo te confirmamos que estamos preparando tu pedido';
		}
		if($this->order->estatus==4){
			$frase='
			Por medio del presente correo te confirmamos tu orden esta en transito <br>
			Puedes seguir su ubicación actual haciendo clic en la pagina de la paqueteria: ('.$this->order->flete_titulo.') <a href="'.$this->order->flete_url.'">'.$this->order->flete_url.'</a> con  el siguiente numero de guia: '.$this->order->numero_guia;
		}
		if($this->order->estatus==5){
			$frase='Por medio del presente correo te confirmamos tu orden ha sido entregada';
		}
		if($this->order->estatus==6){
			$frase='Por medio del presente correo te confirmamos tu orden ha sido cancelada';
		}


		$data['usuario']   = $usuario;
		$data['estatus']   =  $estatus;
		$data['pago']      = json_decode($this->order->datos_pago);
		$data['envio']     = json_decode($this->order->datos_envio);
		$data['factura']   = json_decode($this->order->datos_factura);
		$data['banco']    = json_decode($this->order->datos_banco);
		$data['fecha']     = $this->dateutils->datees(strtotime($this->order->fecha_creacion),'c','c');
		$data['order_id']  = $this->order->id;
		$data['items']     = $this->item->where("order_id",$this->order->id)->get();
		$data['titulo']    = $subject;
		$data['order']    = $this->order;
		$data['frase']    = $frase;



		/* OBJETO EMAIL */
		$data_mail=$this->config->item('send_mail_tienda','proyecto');
		$config['protocol'] = 'smtp';
        $config['smtp_host'] =$data_mail['smtp_host'];
        $config['smtp_user'] = $data_mail['smtp_user'];
        $config['smtp_pass'] = $data_mail['smtp_pass'];
        $config['smtp_port'] =  $data_mail['smtp_port'];
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';

        $data['email']    = $data_mail['smtp_user'];
        $data['dominio']    = $this->config->item('dominio','proyecto');
        $data['empresa']    = $this->config->item('empresa','proyecto');
        $data['telefonos']    = $this->config->item('telefonos','proyecto');
        $data['metodos_de_pago']    = $this->config->item('metodos_pago','proyecto');
        $message = $this->load->view('tienda/checkout/mail',$data,true);



        $this->email->initialize($config);
        $this->email->from($data_mail['smtp_user'],$data_mail['alias']);
        $this->email->to($to);

        if(ENVIRONMENT=='production')
        {
        		$this->email->cc('pedidos@algaespirulina.mx');
        }else{
        	$this->email->cc('ob@paginasweb.mx');
        }

        
        if($this->order->estatus==2)
        {
        	if(ENVIRONMENT=='production')
        	{
        	 	$this->email->bcc('confirmados@aeh.mx');
        	}	
        }
        
        if(in_array($usuario->email, array('pedidos@algaespirulina.com','pedidos@espirulina360.com'))) return false;

        $this->email->subject($subject);
        $this->email->message($message);

        if(!$this->email->send()){
        	echo "ERROR: CORREO NO ENVIADO!<br>";
        	echo "<pre>";
            print_r($this->email->print_debugger());
            echo "</pre>";
            die();
        }else{
        	$data_factura=json_decode($this->order->datos_factura);
        	if($this->order->estatus==2  && isset($data_factura->rfc) ) {
        		$this->order->solicitud_factura=1;
        		$this->order->skip_validation()->save();
        		if(ENVIRONMENT=='production')
        		{
	         		$this->email->subject('SUPERFOODS SOLICITO ELABORACIÓN DE FACTURA  PEDIDO # '.$this->order->id);
		        	$this->email->from('facturacion@algaespirulina.mx','Facturación Super Foods');
		        	$this->email->to('cmontoyavela@hotmail.com');
	        		$this->email->cc('pedidos@algaespirulina.mx');
		        	$this->email->send();       			
        		}

	        }
        }
	}
}
