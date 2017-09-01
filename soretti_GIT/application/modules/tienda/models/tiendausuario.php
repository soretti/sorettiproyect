<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TiendaUsuario extends DataMapper {

	function __construct($id=null)
	{
		parent::__construct($id);
	}

	public $table='usuarios';

	var $has_many = array('tiendadireccion');

	public $validation = array(
		'nombre' => array('rules' => array('required','xss')),
		'email' => array('rules' => array('required','trim','unique','valid_email')),
		'password' => array('rules' => array('required', 'trim', 'min_length' => 5)),
		'confirmar' => array('rules' => array('required','confirmarPassword' => array('password','confirmar') ) ),
		'privacidad' => array('rules' => array('required'))
	);

	function _confirmarPassword($campo,$parametros)
	{

		if($this->{$parametros[0]}!=$this->{$parametros[1]}){
			return FALSE;
		}else{
			return TRUE;
		}
	}
}
