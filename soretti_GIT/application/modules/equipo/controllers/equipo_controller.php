<?php
require_once(APPPATH."modules/bloque/controllers/bloque_controller.php");

class Equipo_controller extends Bloque_controller
{
  	public function __construct()
    {
        parent::__construct();
        $this->load->model('equipo','ContenidoBloque');
        $this->acceso->carga_permisos('pagina');
    }

	public function index()
	{
		$bloque = $this->_data(5);
		$equipo = $bloque->bloquecontenidos->is_active()->order_by('sort','ASC')->get();
		$this->load->view('equipo',array('equipo'=>$equipo , 'bloque'=> $bloque ));
	}
}
