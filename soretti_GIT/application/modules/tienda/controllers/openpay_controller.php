<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Openpay_controller extends MX_Controller {

	public function __construct()
	{
		parent::__construct();

	}

	public function notificaciones(){  
			$this->load->library('openpaytrahc');
			$this->openpaytrahc->hook();
	}
}
