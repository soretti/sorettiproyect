<?php

class Variante extends DataMapper
{

	function __construct($id=null)
	{
		parent::__construct($id);
	}


	 public $table = "productos";
	 public $prefix = "cat_";
	 public $has_one= array(
        'producto'
	 );

}
