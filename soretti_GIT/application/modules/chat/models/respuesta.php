<?php

class Respuesta extends DataMapper
{

    function __construct($id=null)
    {
        parent::__construct($id);
    }


	 public $table = "respuestas";
	 public $prefix = "chat_";
	 public $has_many= array();
	 public $has_one= array('tipo');

	public $validation = array(
		'titulo' => array('rules' => array('required','unique')),
		'respuesta' => array('rules' => array('required')),
		'snipet' => array('rules' => array('unique')),
		'tipo_id' => array('rules' => array('required')),
	);
}
