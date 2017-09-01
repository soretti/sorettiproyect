<?php
require_once(APPPATH."modules/bloque/controllers/bloque_controller.php");

class Textos_controller extends Bloque_controller
{
  	public function __construct()
    {
        parent::__construct();
        $this->load->model('textos','ContenidoBloque');
        $this->acceso->carga_permisos('pagina');
    }

	public function index($id)
	{	
		$bloque = $this->_data(3);
		$textos = $bloque->bloquecontenidos->get_by_id($id);
		$this->load->view('textos',array('textos'=>$textos , 'bloque'=> $bloque ) );
	}

	public function simple($id)
	{	
		$bloque = $this->_data(3);
		$textos = $bloque->bloquecontenidos->get_by_id($id);
		 $this->load->view('simple_texto',array('textos'=>$textos , 'bloque'=> $bloque ) );
	}
}