<?php

class Descuento extends DataMapper
{

	public $table='descuentos';

	public $has_many = array('usuario');

	public $error_prefix = '<div class="error">';
    	public $error_suffix = '</div>';



    function __construct($id=0)
    {
		parent::__construct($id);
	}

	// public $validation = array(
	// 	'titulo' => array('rules' => array('required','unique'))
	// );
}
