<?php
require_once(APPPATH."modules/bloque/controllers/bloque_controller.php");

class Servicios_controller extends Bloque_controller
{
  	public function __construct()
    {
        parent::__construct();
        $this->load->model('servicios','ContenidoBloque');
        $this->acceso->carga_permisos('pagina');
    }

	public function index()
	{	
		$bloque = $this->_data(2);
		$servicios = $bloque->bloquecontenidos->is_active()->order_by('sort','ASC')->get();
		$this->load->view('servicios',array('servicios'=>$servicios , 'bloque'=> $bloque ));
	}
}