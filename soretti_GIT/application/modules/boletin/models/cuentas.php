<?php

class Cuentas extends DataMapper
{
	public $prefix='boletin_';
	public $table='cuentas';

	public $has_one=array('newsletter');


 	public $validation = array(
		'host' => array('rules' => array('required')),
		'puerto' => array('rules' => array('required','numeric')),
		'alias' => array('rules' => array('required','xss')),
		'email' => array('rules' => array('required','trim','unique','valid_email')),
		'password' => array('rules' => array('required', 'trim')),
		'confirmar' => array('rules' => array('required','confirmarPassword' => array('password','confirmar') ) )
	);

	function _confirmarPassword($campo,$parametros)
	{

		if($this->{$parametros[0]}!=$this->{$parametros[1]}){
			return FALSE;
		}else{
			return TRUE;
		}
	}

	function __construct($id=null){
		parent::__construct($id);
	}


}