<?php

class Visitante extends DataMapper
{

    function __construct($id=null)
    {
        parent::__construct($id);
    }


	 public $table = "visitantes";
	 public $prefix = "chat_";
	 public $has_many= array('mensaje');
	 public $has_one= array();

	 public $validation = array();
}
