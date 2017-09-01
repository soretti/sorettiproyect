<?php
class Destacado extends DataMapper
{

	 public $table = "cat_destacados";

	 public $has_one= array('producto');

	 function __construct($id=null){
		parent::__construct($id);
	}

}
