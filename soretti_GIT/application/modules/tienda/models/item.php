<?php

class Item extends DataMapper
{
	 public $table = "items";

	 public $has_one= array('producto','order');

	 function __construct($id=null){
		parent::__construct($id);
	}
}
