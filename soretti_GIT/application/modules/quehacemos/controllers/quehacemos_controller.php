<?php
require_once(APPPATH."modules/bloque/controllers/bloque_controller.php");

class Quehacemos_controller extends Bloque_controller
{
  	public function __construct()
    {
        parent::__construct();
        $this->load->model('quehacemos','ContenidoBloque');
        $this->acceso->carga_permisos('pagina');
    }

	public function index()
	{	
		$bloque = $this->_data(3);
		$quehacemos = $bloque->bloquecontenidos->is_active()->order_by('sort','ASC')->get();
		$this->load->view('index',array('quehacemos'=>$quehacemos , 'bloque'=> $bloque ));
	}
}