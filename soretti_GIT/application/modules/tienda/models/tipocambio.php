<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TipoCambio extends DataMapper {

	function __construct($id=null)
	{
		parent::__construct($id);
	}

	public $table='tipo_cambio';

	public $validation = array(
		'tipocambio' => array('rules' => array('required','numeric','trim','xss'))
	);

}
