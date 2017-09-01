<?php
class Banners extends DataMapper
{

	 public $table = "banners";

	 public $validation = array(
		'titulo' => array('rules' => array('required','unique')),
		'imagen' => array('rules' => array('required')),
	);


	function __construct($id=null){
		parent::__construct($id);
	}

}
