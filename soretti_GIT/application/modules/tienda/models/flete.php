<?php

class Flete extends DataMapper
{

	public $lista_w=0;
	public $lista_h=43;
	
	public $table='fletes';
    // public $prefix = "cat_";

	public $error_prefix = '<div class="error">';
    public $error_suffix = '</div>';

	public $has_many = array( 'order');

    function __construct($id=0)
    {
		parent::__construct($id);
	}

	public $validation = array(
		'titulo' => array('rules' => array('required','unique'))
	); 
}