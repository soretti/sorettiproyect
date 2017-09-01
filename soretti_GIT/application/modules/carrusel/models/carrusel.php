<?php
require_once(APPPATH."modules/bloque/models/bloquecontenidos.php");
class Carrusel extends Bloquecontenidos
{

	function __construct($id=null){
		parent::__construct($id);
	}

	public $img_width=300;
	public $img_height=221;

	public $validation = array(
		'titulo' => array('rules' => array('required')),
		'imagen' => array('rules' => array('required')),
		'fecha_creacion' => array('rules' => array('date')),
		'fecha_activacion' => array('rules' => array('date')),
		'fecha_desactivacion' => array('rules' => array('date')),
	);


	public $configuracion=array('max-items'=>0,'sortable'=>1);

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
