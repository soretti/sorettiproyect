<?php

class Boletin_usuarios extends DataMapper
{
	public $prefix='boletin_';
	public $table='usuarios';

    // public $has_many=array('boletin_newsletterstatus'=>array('class'=>'boletin_newsletterstatus'));
    // public $has_many=array('boletin_newsletterstatus'=>array('class'=>'boletin_newsletterstatus'));



	function __construct($id=null){
		parent::__construct($id);
	}

	 public $validation = array(
		// 'grupos' => array('rules' => array('required')),
		'nombre' => array('rules' => array('required','xss')),
		'privacidad' => array('rules' => array('required')),
		'email' => array('rules' => array('required','trim','unique','valid_email'))
	);
}
