<?php
class Pagina extends DataMapper
{
	function __construct($id=null)
	{
		parent::__construct($id);
	}

	public $table='paginas';
	public $validation = array(
		'titulo' => array('rules' => array('required','unique')),
		'uri' => array('rules' => array('uri','required','unique')),
		'fecha_creacion' => array('rules' => array('date')),
		'fecha_activacion' => array('rules' => array('date')),
		'fecha_desactivacion' => array('rules' => array('date')),
	);

	public $has_many=array('articulo','blog_categoria','galeriaimagenes'=>array('class'=>'galeriaimagenes','other_field'=>'pagina'));
	public $has_one=array('usuario');

	function _uri($field)
	{
		$this->{$field}=url_title($this->{$field});
		return TRUE;
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
