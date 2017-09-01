<?php

class Mensaje extends DataMapper
{

    function __construct($id=null)
    {
        parent::__construct($id);
    }


	 public $table = "mensajes";
	 public $prefix = "chat_";
	 public $has_many= array();
	 public $has_one= array('visitante');

	 public $validation = array();
}
