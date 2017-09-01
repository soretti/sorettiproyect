<?php

class {{nombre_modelo}} extends DataMapper
{
	function __construct($id=null){
		parent::__construct($id);
	} 
	public $table='{{table}}';

	public $validation = array(
		// 'titulo' => array('rules' => array('required'))
	);
}