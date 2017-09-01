<?php

class Contacto extends DataMapper
{
	function __construct($id=null){
		parent::__construct($id);
	}

	public $table='contactos';

	public $validation = array(
		'nombre' => array('rules' => array('required')),
		'email' => array('rules' => array('required','unique','valid_email')),
	);
}
