<?php

class Cat_precio extends DataMapper
{

	function __construct($id=null)
	{
		parent::__construct($id);
	}


	public $table = "precios";
	public $prefix = "cat_";
	public $has_one= array('producto');

	public $validation = array(
	 	'precio' => array('rules' => array('numeric')),
	 	'descuento_cantidad' =>array('rules' => array('numeric')),
		'activacion_promocion' => array('rules' => array('date')),
		'desactivacion_promocion' => array('rules' => array('date')),
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

	function promotion_active()
	{
		$this->where("activacion_promocion <= '".date('Y-m-d H:i:s')."'",null);
        $this->where("if(activacion_promocion='0000-00-00 00:00:00',1,  if(desactivacion_promocion >= '".date('Y-m-d H:i:s')."',1,0) )",null);
        return $this;
	}


}
