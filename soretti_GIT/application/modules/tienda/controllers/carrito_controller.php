<?php
class Carrito_controller extends MX_Controller
{

	function Carrito_controller() {

		parent::__construct();
		$this->load->model("catalogo/producto");
		$this->load->model("catalogo/cat_precio");
		$this->load->model("catalogo/cat_categoria");
		$this->load->model("catalogo/cat_imagen");
		$this->load->model('tienda/cupon');
	}

	function agregar($producto_id=0) {

		$this->session->set_flashdata('seguir_comprando', $this->input->post('redirect'));

		$this->cart->product_name_rules = "\d\D";

		$this->producto->include_related('cat_precio')->where("id",$producto_id)->get();

		if(!$this->producto->result_count()) {
			show_error('Lo sentimos, el artículo no existe', 500 );
		}

		if($this->producto->agodato) {
			show_error('Lo sentimos, el artículo esta agotado', 500 );
		}


		$this->producto->cat_imagen->get();
		$imagenes_array = $this->producto->cat_imagen->all_to_array(array('id','imagen'));
		$imagenes=array();

		foreach ($imagenes_array as $item){
			$imagenes[$item['id']]=$item['imagen'];
		}

		if($this->producto->id == $this->input->post("producto_id")) {

			if(!$this->producto->weight($this->producto)){
					$this->session->set_flashdata('is_out_of_stock',"Lo sentimos, por el momento este producto no esta disponible para compra online");
					redirect($this->input->post('redirect'), 'refresh');
			}

			if(  $this->input->post("cantidad") > 0 && $this->input->post("cantidad") > $this->producto->stock && !$this->producto->comprar_sin_stock ) {
					$this->session->set_flashdata('is_out_of_stock',"Lo sentimos, por el momento no contamos con la cantidad de artículos requerida");
					redirect($this->input->post('redirect'), 'refresh');
			}else{
				    $precio=$this->producto->precio($this->input->post("cantidad"), $this->producto);
					$data = array(
			           'id'      => $this->producto->id,
			           'sku'     => $this->producto->SKU,
			           'imagen'  => current($imagenes),
			           'weight'  => $this->producto->weight($this->producto),
			           'qty'     => $this->input->post("cantidad"),
			           'price'   => $precio['precio'],
			           'name'    => $this->producto->titulo,
			           'options' => array()
			        );

					if($this->cart->insert($data)){
						$this->session->set_flashdata('carrito_mensaje', character_limiter($this->producto->titulo,80).' agregado al carrito');
						redirect('tienda/carrito/mostrar');
					}else{
						show_error('Lo sentimos, ha ocurrido un error inesperado al momento de agregar el artículo al carrito', 500 );
					}
			}

		}else{
			$combinacion = new Producto();
			$combinacion->include_related('cat_precio')->where("id",$this->input->post("producto_id"))->get();


			if(!$combinacion->result_count()){
				show_error('Lo sentimos, la combinación no existe', 500);
			}


			if(!$combinacion->weight($this->producto,$combinacion)) {
					$this->session->set_flashdata('is_out_of_stock',"Lo sentimos, por el momento este producto no esta disponible");
					redirect($this->input->post('redirect'), 'refresh');
			}

			$select_image=explode(",",$combinacion->combinacion_imagenes);
			if(is_array($select_image) && isset($imagenes[current($select_image)])) $imagen_combinacion=$imagenes[current($select_image)];
			else $imagen_combinacion=current($imagenes);

			if(  ($this->input->post("cantidad") > 0) && ($this->input->post("cantidad") > $combinacion->stock) && (!$this->producto->comprar_sin_stock) ) {
					$this->session->set_flashdata('is_out_of_stock',"Lo sentimos, por el momento no contamos con la cantidad de artículos requerida");
					redirect($this->input->post('redirect'), 'refresh');
			}else{
				$precio=$this->producto->precio($this->input->post("cantidad"), $this->producto, $combinacion);
				$data = array(
		           'id'      => $this->input->post("producto_id"),
		           'sku'     => $combinacion->SKU,
		           'imagen'  => $imagen_combinacion,
		           'weight'  => $this->producto->weight($this->producto,$combinacion),
		           'qty'     => $this->input->post("cantidad"),
		           'price'   => $precio['precio'],
		           'name'    => $this->producto->titulo,
		           'options' => json_decode($this->input->post("combinaciones"),true)
		        );
				if($this->cart->insert($data)){
					$this->session->set_flashdata('carrito_mensaje', character_limiter($this->producto->titulo,80).' agregado al carrito');
					redirect('tienda/carrito/mostrar');
				}else{
					show_error('Lo sentimos, ha ocurrido un error inesperado al momento de agregar el artículo al carrito', 500 );
				}
		}

	}

}

	function checarcupon(){

		$valido=0;
		$monto='';

		if($this->session->userdata('usuario_id')){
			$this->load->model('usuario');
			$usuario_tienda=new Usuario($this->session->userdata('usuario_id'));
			if($usuario_tienda->descuento_id) return false;
		}

		if($this->input->post('cupon')){
			$cupon = new Cupon();

			$cupon->is_active()->where('cupon',$this->input->post('cupon'))->get();

			if($cupon->result_count()){

				if($cupon->compra_minima && $this->cart->total()<$cupon->compra_minima){ /*Compra mínima*/
					$valido=2;
					$monto=formato_precio($cupon->compra_minima);
				}else if($cupon->uso=='unico' && $cupon->canjeado==1){ /*Si  el cupón  es de uso único*/
					$valido=3;
				}else{
					$valido=1;
					$this->session->set_userdata('cupon',$this->input->post('cupon'));
				}
			}

		}

		$data = array("valido"=>$valido, "monto"=>$monto);

		echo json_encode($data);

	}


	function mostrar()
	{

		$usuario_tienda=new Usuario($this->session->userdata('usuario_id'));
		
		/*Actualizar Cantidades del carrito de compras*/
		if($this->input->post('carritoUpdate')){
			foreach ($this->input->post('items') as $indice=>$value) {
					$this->actualizar($indice,$value);
			}
		}
		$total=$this->cart->total();
		
		/*Remueve el cupon ingresado por el usuario*/
		if($this->input->get('remove-cupon')){
				$this->session->unset_userdata('cupon');
				redirect(current_url());
		}

		/*Tomar en encuenta el cupon en caso que exista y que el usurio no sea distribuidor*/
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

		$data["meta"] = array("descripcion"=>"productos que se han agregado al carrito de compras en alga espirulina","palabras_clave"=>"carrito, compras, alga espirulina, tienda online , superalimento, dietas","titulo"=>"Carrito de compras");
		$flete=array();

		/*Remueve el código postal ingresado por el usuario*/
		if($this->input->get('remove-cp')){
				$this->session->unset_userdata('cp');
				redirect(current_url());
		}

		/*Calcula el flete con el cp ingresado  si retorna un valor  se guarda en sesion*/
		if($this->input->post('calcularenvio'))
		{
		  $flete = modules::run('tienda/envio/calcular_flete',$this->input->post('cp'));
		  if($flete['precio']||($flete['gratis']==1)){
		   	$this->session->set_userdata('cp',$this->input->post('cp'));
		  }else{
		  	 $this->session->unset_userdata('cp');
		  }
		}

 		if($this->input->post('calcularenvio') && !$flete['precio']){
			if($flete['error'] && !$flete['precio']  && ($flete['gratis']==0)){
 				$this->session->set_flashdata('carrito_danger','No es posible entregar tu orden en el código postal dado');
 			}else if($flete['gratis']==1){
 				// print('gratis');
 			}
				redirect(current_url());
		}

		if(!$this->input->post('calcularenvio') && !$this->input->get('ajax')){
			$flete = modules::run('tienda/envio/calcular_flete',$this->session->userdata('cp'));
		}
		$total=$total + $flete['precio'];

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

		$this->layout_content = $this->load->view('tienda/carrito/mostrar',array('flete'=>$flete, 'datos'=>$datos,'promocion'=>$promocion,'total'=>$total),true);
		$this->load->view('plantilla/default', $data);
	}



	function actualizar($rowid=0,$qty=0) {
		$cart_items=$this->cart->contents();
		$cart_item=$cart_items[$rowid];
		$this->producto->include_related('cat_precio')->where("id",$cart_item['id'])->get();


		if( $this->producto->producto_id) {
 			/*combinacion*/
			$producto=$this->producto;
			$producto_padre=new Producto();
			$producto_padre->include_related('cat_precio')->get_by_id($producto->producto_id);
		    	$precio=$producto->precio($qty,$producto_padre,$producto);

		}else{
			/*Producto*/
			$producto_padre=$this->producto;
			$producto=new Producto();
			$producto->include_related('cat_precio')->get_by_id($this->producto->id);
		    $precio=$producto->precio($qty,$producto_padre);
		}


		/*Validar stock de los productos*/
		if($qty > $producto->stock && !$producto_padre->comprar_sin_stock) {
			$this->session->set_flashdata('carrito_danger',' No hay suficiente producto en stock.');
			redirect('tienda/carrito/mostrar');
		}

		if($rowid){
			$data = array(
			 	'rowid' => $rowid,
			 	'price' => $precio['precio'],
			 	'qty'   => $qty
			 );

			$this->cart->update($data);

			if(!$qty)
				$this->session->set_flashdata('carrito_mensaje',' El producto ha sido eliminado del carrito');
			else
				$this->session->set_flashdata('carrito_mensaje',' Carrito actualizado');
			    if(!$this->input->post('carritoUpdate')) redirect('tienda/carrito/mostrar');
		}else{
			show_error('Lo sentimos, el artículo no existe', 500 );
		}
	}
}
