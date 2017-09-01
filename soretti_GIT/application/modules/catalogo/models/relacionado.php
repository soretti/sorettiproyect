<?php
class Relacionado extends DataMapper
{

	 public $table = "cat_relacionados";

	 public $has_one= array('producto');

	 function __construct($id=null){
		parent::__construct($id);
	}

}
