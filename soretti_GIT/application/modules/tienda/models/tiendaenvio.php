<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TiendaEnvio extends DataMapper {

	function __construct($id=null)
	{
		parent::__construct($id);
	}

	public $table='tienda_envio';

	public $validation = array(
		'gratis_cantidad' => array('rules' => array('numeric','trim','xss')),
		'tarifa' => array('rules' => array('numeric','trim','xss'))
	);

}
