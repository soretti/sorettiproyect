<?php

class Cat_imagen extends DataMapper
{

	public $lista_w=620;
	public $lista_h=412;

	public $thumb_w=260;
	public $thumb_h=173;


	public $table = "cat_imagenes";
	public $has_one= array('producto');
	public $validation = array(
		'imagen' =>  array('label' => 'imagen', 'rules' =>array('required'))
	);

	function __construct($id=null){
		parent::__construct($id);
	}
}
