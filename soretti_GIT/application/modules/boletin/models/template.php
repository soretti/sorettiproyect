<?php

class Template extends DataMapper
{
	function __construct($id=null){
		parent::__construct($id);
	}

	public $table='templates';
    public $prefix = "boletin_";

	public $error_prefix = '<div class="error">';
    public $error_suffix = '</div>';

	public $validation = array(
		'titulo' => array('rules' => array('required'))
	);
}