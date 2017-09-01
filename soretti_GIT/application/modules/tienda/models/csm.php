<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Csm extends DataMapper {

	function __construct($id=null) {
		parent::__construct($id);
	}

	public $table = 'csm';

	//var $has_many = array('item');
	//var $has_one = array('usuario','flete');

	// public $validation = array(
	// 	'usuario_id' => array('rules' => array('required')),
	// 	'estatus'    => array('rules' => array('required')),
	// 	'fecha_creacion' => array('rules' => array('required')),
	// 	);
}