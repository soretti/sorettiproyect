<?php

class atributo extends DataMapper
{
	public $table='atributos';
	public $prefix = "cat_";
	public $tipos = array("Lista desplegable", "Opciones radio", "Colores");

	function __construct($id=0){
		parent::__construct($id);
	}

	public $validation = array(
		'nombre' => array('rules' => array('required'))
	);
}