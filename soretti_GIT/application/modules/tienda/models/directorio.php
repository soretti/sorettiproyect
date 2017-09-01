<?php

class Directorio extends DataMapper
{
	 public $table = "directorio";

	 public $has_one= array();

	 function __construct($id=null){
		parent::__construct($id);
	}
}
