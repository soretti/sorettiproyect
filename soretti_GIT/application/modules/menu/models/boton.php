<?php

class Boton extends DataMapper
{
	public $table='botones';
	public $error_prefix = '<div class="error">';
    public $error_suffix = '</div>';
    public $success;

    public $has_one = array(
		'menu',
        'padre' => array(
        	'class' => 'boton',
            'other_field' => 'related_link',
            'reciprocal' => TRUE
        )
	);
	public $has_many = array(
        'related_link' => array(
            'class' => 'boton',
            'other_field' => 'padre',
            'reciprocal' => TRUE
        )
	);

    function __construct($id=0){
		parent::__construct($id);
	}
	public $validation = array(
		'titulo' => array('rules' => array('required'))
	);
}