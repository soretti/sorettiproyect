<?php
require_once(APPPATH."modules/bloque/controllers/bloque_controller.php");

class Atributos_controller extends Bloque_controller
{
  	public function __construct()
    {
        parent::__construct();
        $this->load->model('atributos','ContenidoBloque');
        $this->acceso->carga_permisos('pagina');
    }

	public function index()
	{	
		$bloque = $this->_data(14);
		$atributos = $bloque->bloquecontenidos->is_active()->order_by('sort','ASC')->get();
		$this->load->view('atributos',array('atributos'=>$atributos , 'bloque'=> $bloque ));
	}
}