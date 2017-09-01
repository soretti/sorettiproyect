<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends DataMapper {

	function __construct($id=null) {
		parent::__construct($id);
	}

	public $table = 'orders';

	var $has_many = array('item');
	var $has_one = array('usuario','flete');

	public $validation = array(
		'usuario_id' => array('rules' => array('required')),
		'estatus'    => array('rules' => array('required')),
		'fecha_creacion' => array('rules' => array('required')),
	);
 

 	function _date($field)
	{
		$fecha=explode(" ",$this->{$field});
		if(count($fecha)<2)
		{
			return FALSE;
		}
		if( strstr($fecha[0], '/') )
		{
			list($day,$month,$year)=explode("/",$fecha[0]);
			$this->{$field}= $year."-".$month."-".$day." ".$fecha[1].":00";
		}
		return TRUE;
	}


}