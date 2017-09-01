<?php
require_once(APPPATH."modules/bloque/controllers/bloque_controller.php");

class Carrusel_controller extends Bloque_controller
{
  	public function __construct()
    {
        parent::__construct();

        $this->load->model('carrusel','ContenidoBloque');
        $this->acceso->carga_permisos('pagina');
    }

	public function index()
	{
		$bloque = $this->_data(8);
		$fotos = $bloque->bloquecontenidos->is_active()->order_by('sort','ASC')->get();
		$this->load->view('carrusel',array('fotos'=>$fotos , 'bloque'=> $bloque ));
	}


}
