<?php
class Bloquecontenidos extends DataMapper
{
	public $table='bloquecontenidos';
	public $has_one=array('bloque'=>array('class'=>'bloque')); 
	public $has_many=array('mapa'=>array('join_table'=>'mapas')); 

	function __construct($id=null){
		parent::__construct($id);
	}

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

	function is_active()
	{
		$this->where("fecha_activacion <= '".date('Y-m-d H:i:s')."'",null);
        $this->where("if(fecha_desactivacion='0000-00-00 00:00:00',1,  if(fecha_desactivacion >= '".date('Y-m-d H:i:s')."',1,0) )",null);
        $this->where('is_enable',1);
        return $this;
	}
}