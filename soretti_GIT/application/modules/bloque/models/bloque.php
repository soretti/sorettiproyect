<?php

class Bloque extends DataMapper
{
	public $table='bloques';
	public $validation = array( 'titulo' => array('rules' => array('required')) );
	public $has_many=array('bloquecontenidos'=>array('class'=>'bloquecontenidos','other_field'=>'bloque'));

	function __construct($id=null)
	{
		parent::__construct($id);
	} 

	
}