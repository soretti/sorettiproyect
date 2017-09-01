<?php

class Tipo extends DataMapper
{

    function __construct($id=null)
    {
        parent::__construct($id);
    }


	 public $table = "tipos";
	 public $prefix = "chat_";
	 public $has_many= array('respuesta');
	 public $has_one= array();

	public $validation = array(
		'titulo' => array('rules' => array('required','unique')),
	);
}
