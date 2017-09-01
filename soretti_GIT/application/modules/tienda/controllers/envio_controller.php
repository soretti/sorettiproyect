<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Envio_controller extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('sepomex/estado');
		$this->load->model('sepomex/ciudad');
		$this->load->model('sepomex/municipio');
		$this->load->model('sepomex/colonia');
		$this->load->model('tienda/csm');
		$this->load->library('form_validation');
	}


	function index(){

	}

	public function mostrar(){

		$this->titulo="EDITAR CONFIGURACION DE ENVIO";
		$data['bloque']= new tiendaenvio();
		$data['bloque']->where('id',1)->get();

		$this->layout_content = $this->load->view('envio/form',$data,true);
		$this->load->view('plantilla/backend/form');
	}

	public function guardar_configuracion()
	    {
	        $this->titulo= "EDITAR TIPO DE CAMBIO";

	       $data['bloque'] = new tiendaenvio();
	       $data['bloque']->where('id',1)->get();

	       if(isset($_POST['gratis'])==1){
	       	$_POST['gratisop']=$_POST['gratisop2'];
	       	$_POST['gratis_cantidad']=$_POST['gratis_cantidad2'];
	       	$_POST['tarifaop']=$_POST['tarifaop2'];
	       	$_POST['tarifa']=$_POST['tarifa2'];
	       }

	      $campos=array('gratis','gratisop','gratis_cantidad','tarifaop','tarifa');

        	      $rel = $data['bloque']->from_array($_POST, $campos);

        	       $data['bloque']->fecha_creacion = date('Y-m-d H:i:s');

	        if($data['bloque']->save($rel)){
	            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
	            redirect('modulo/tienda/envio/mostrar');
	        }else{
	            $this->layout_content = $this->load->view('envio/form', $data,true);
	            $this->load->view('plantilla/backend/form');
	        }
	    }


	function flete_scm($cp,$peso){

		$guia_nacional=60;
		$peso_total=ceil($peso);  

		$iva = 0.16;

		/*Aplicar  + 80 pesos si no ex box  y es reexpedido*/
		$extra_ext = 80;

		$adicional = 0.10;

		$precio_zonas=array(
			1=>array(1=>13.30, 2=>26.60, 3=>39.90, 4=>53.20, 5=>66.50,'extra'=>13.30 ),
			2=>array(1=>15.40, 2=>30.80, 3=>46.20, 4=>61.60, 5=>77.00,'extra'=>15.40 ),
			3=>array(1=>18.20, 2=>36.40, 3=>54.60, 4=>72.80, 5=>91.00,'extra'=>18.20 ),
			4=>array(1=>30.80, 2=>61.60, 3=>92.40, 4=>123.20, 5=>154.00,'extra'=>30.80 ),
			5=>array(1=>35.00, 2=>70.00, 3=>105.00, 4=>140.00, 5=>175.00,'extra'=>35.00 ),
			6=>array(1=>39.20, 2=>78.40, 3=>117.60, 4=>156.80, 5=>196.00,'extra'=>39.20 ),
			7=>array(1=>43.40, 2=>86.80, 3=>130.20, 4=>173.60, 5=>217.00,'extra'=>43.40 ),
			'metro'=>array(1=>10.50, 2=>21.00, 3=>31.50, 4=>42.00, 5=>52.50,'extra'=>10.50 )
		);
	 
		/*Tarifa box*/
		$precio_box=array(5=>70.00,'extra'=>10.00);

		/*Obtener el codigo postal de la tabla csm para determinar si es box  o envio por zona*/
		$csm=new Csm();
		$csm->where('cp',$cp)->get();

		//$cp=db_EjecutarSql("SELECT * FROM unic2_scm WHERE cp='".$cp."' "); 
		//$cp_filas=$db_CantFilas;
		if( !$csm->result_count() ) return FALSE;

		
		/* si es box */
		if($csm->box) { 
			$keys=array_keys($precio_box); 
			if($peso_total<=$keys[0]){ 
				$flete = ($precio_box[5]) + ( ($precio_box[5] * $adicional) );
				$flete = $flete + ($flete * $iva);
				return $flete; 
			}else{
			   	$kilos_extra=ceil($peso_total-$keys[0]);
			   	$importe=$precio_box[5] + ($kilos_extra*$precio_box['extra']);
				$flete = ($importe) + ( $importe * $adicional) ;
				$flete = $flete + ($flete * $iva);
				return $flete;
			}
		}else{
			$zona=$precio_zonas[$csm->zona];
			if($peso_total<=5){
				$precio=$zona[$peso_total] + $guia_nacional;
				$flete=$precio;
				if($csm->ext) $flete=$flete+$extra_ext; 
				$flete = ($flete) + ( ($flete * $adicional) );
				$flete = $flete + ($flete * $iva);
				return $flete;
			}else{
					$kilos_extra=ceil($peso_total-5);
					$precio=$zona[5] + $guia_nacional;
					$flete=$precio + ($kilos_extra*$csm->extra);
					if($csm->ext) $flete=$flete+$extra_ext; 
				    $flete = ($flete) + ( $flete * $adicional) ;
				    $flete = $flete + ($flete * $iva);
				    return $flete;
			}
		}
	}


	public function calcular_flete($cp){
		$colonia= new colonia();
		$municipio= new municipio();
		$estado= new estado();
		$envio = new tiendaenvio();
		$envio->where('id',1)->get();
		$precio=0;
		$mensaje='';
		$error='';
		$gratis=0;
		$peso=0;

		$totalcarrito= $this->cart->total();


		$usuario_tienda=new Usuario($this->session->userdata('usuario_id'));


		/*Tomar en encuenta el cupon en caso que exista y que el usurio no sea distribuidor*/
		if($this->session->userdata('cupon') && !$usuario_tienda->descuento_id){

			$cupon = new Cupon();
			$cupon->is_active()->where('cupon',$this->session->userdata('cupon'))->get();

			if($cupon->tipo_descuento=='cantidad'){
				$cantidadcupon=$cupon->descuento;
			}
			if($cupon->tipo_descuento=='porcentaje'){
				$cantidadcupon=(($this->cart->total()*$cupon->descuento)/100);
			}
			$totalcarrito=$totalcarrito-$cantidadcupon;
		}
		
		if($usuario_tienda->descuento_id) $envio->gratis_cantidad=3000;
				
		 foreach ($this->cart->contents() as $items):
		  	$peso = $peso + $items['weight'];
		 endforeach;
		 $precio_flete=$this->flete_scm($cp,$peso);

		if($envio->gratis==1){

			$gratis=1;

		}else if(($envio->gratisop==1) && ($totalcarrito>=$envio->gratis_cantidad) && $precio_flete < 300)  {

			$gratis=1;

		}else  if($envio->tarifaop==1){

			$precio = $envio->tarifa;

		}else{
			
			$precio=$precio_flete;

			if($precio==0){
				$error="No se puede entregar su pedido en el codigo postal seleccionado";
			} 
		}
			$datos=array('precio'=>$precio,'estado'=>$colonia->ciudad_estado_titulo,'ciudad'=>$colonia->ciudad_titulo,'error'=>$error,'gratis'=>$gratis,'cp'=>$cp,'tarifa'=>$envio->tarifaop);

			return $datos;

	}




}
