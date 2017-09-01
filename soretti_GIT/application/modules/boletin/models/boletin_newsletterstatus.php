<?php

class Boletin_newsletterstatus extends DataMapper
{
	public $prefix='boletin_';
	public $table='newsletterstatus';

	public $has_one=array('newsletter'=>array('class'=>'newsletter'),'boletin_usuarios'=>array('class'=>'boletin_usuarios'));

	function __construct($id=null){
		parent::__construct($id);
	}


	 public $validation = array(
	'grupos' => array('rules' => array('required')),
	'nombre' => array('rules' => array('required','xss')),
	'email' => array('rules' => array('required','trim','unique','valid_email')),
	);
}