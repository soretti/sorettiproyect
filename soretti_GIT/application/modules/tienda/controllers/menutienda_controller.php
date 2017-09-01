<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menutienda_controller extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function mostrar() {

		$data['usuario_id'] = $this->session->userdata('usuario_id');
		$data['nombre']     = $this->session->userdata('nombre');
		$data['ruta'] = $this->uri->uri_string();

		$this->load->view('tienda/menutienda', $data);
	}
}
