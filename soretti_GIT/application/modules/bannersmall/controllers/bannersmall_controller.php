<?php
require_once(APPPATH."modules/bloque/controllers/bloque_controller.php");


class Bannersmall_controller extends Bloque_controller
{
  	public function __construct()
    {
        parent::__construct();

        $this->load->model('bannersmall','ContenidoBloque');
        $this->acceso->carga_permisos('pagina');
    }

	public function index()
	{
		$bloque = $this->_data(13);
		$sliders = $bloque->bloquecontenidos->is_active()->order_by('sort','random')->limit(2)->get();
		$this->load->view('index',array('sliders'=>$sliders , 'bloque'=> $bloque));
	}
}