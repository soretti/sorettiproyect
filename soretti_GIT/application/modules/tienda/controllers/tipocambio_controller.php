<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TipoCambio_controller extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('tipocambio');
		$this->acceso->carga_permisos('slider');
	}


	function index(){

	}

	public function listar(){

		$this->titulo="EDITAR TIPO DE CAMBIO";
		$data['bloque'] = new tipocambio();
		$data['bloque']->where('id',1)->get();

		$this->layout_content = $this->load->view('tipocambio/tipogrid', $data,true);
	               $this->load->view('plantilla/backend/form');
	}

	public function guardar()
	    {
	        $this->titulo= "EDITAR TIPO DE CAMBIO";

	       $data['bloque'] = new tipocambio();
	       $data['bloque']->where('id',1)->get();

	      $campos=array('tipocambio');

        	      $rel = $data['bloque']->from_array($_POST, $campos);

        	       $data['bloque']->fecha_creacion = date('Y-m-d H:i:s');

	        if($data['bloque']->save($rel)){
	            $this->session->set_flashdata('mensaje',$this->lang->line('alert_save'));
	            redirect('modulo/tienda/tipocambio/editar');
	        }else{
	            $this->layout_content = $this->load->view('tipocambio/tipoform', $data,true);
	            $this->load->view('plantilla/backend/form');
	        }
	    }

	     public function editar(){
	        $this->titulo='EDITAR TIPO DE CAMBIO ';

	        $data['bloque'] = new tipocambio();
	        $data['bloque']->where('id',1)->get();

	        $this->layout_content = $this->load->view('tipocambio/tipoform', $data,true);
	        $this->load->view('plantilla/backend/form');
	    }




}
