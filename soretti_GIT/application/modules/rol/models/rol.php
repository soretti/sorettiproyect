<?php

class Rol extends DataMapper
{
	public $table='roles';
	public $has_many= array('usuario');

	function __construct($id=null){
		parent::__construct($id);
	}

	public $validation = array(
		'nombre' => array('rules' => array('required','unique','xss'))
	);

}