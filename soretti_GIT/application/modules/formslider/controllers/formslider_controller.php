<?php
require_once(APPPATH."modules/bloque/controllers/bloque_controller.php");

class Formslider_controller extends Bloque_controller
{
  	public function __construct()
    {
        parent::__construct();

        $this->load->model('formslider','ContenidoBloque');
        $this->acceso->carga_permisos('pagina');
    }

	public function index()
	{
		$bloque = $this->_data(15);
		$sliders = $bloque->bloquecontenidos->is_active()->order_by('sort','ASC')->get();
		$this->load->view('formslider',array('sliders'=>$sliders , 'bloques'=> $bloque ));
	}

}
