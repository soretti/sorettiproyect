<?php

class Galeria extends DataMapper
{
	function __construct($id=null){
		parent::__construct($id);
	} 
	public $table='galerias';

	public $has_many=array('galeriaimagenes'=>array('class'=>'galeriaimagenes','other_field'=>'galeria'));
	
	public $validation = array(
		'title' => array('rules' => array('required')),
		'uri' => array('rules' => array('uri','required','unique'))

	);
}