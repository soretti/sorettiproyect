<?php
require_once(APPPATH."modules/bloque/controllers/bloque_controller.php");

class Formsliderorg_controller extends Bloque_controller
{
  	public function __construct()
    {
        parent::__construct();

        $this->load->model('formsliderorg','ContenidoBloque');
        $this->acceso->carga_permisos('pagina');
    }

	public function index()
	{
		$bloque = $this->_data(16);
		$sliders = $bloque->bloquecontenidos->is_active()->order_by('sort','ASC')->get();
		$this->load->view('formsliderorg',array('sliders'=>$sliders , 'bloques'=> $bloque ));
	}

}
