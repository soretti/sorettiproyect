<?php

class Cupon extends DataMapper
{

	public $lista_w=0;
	public $lista_h=43;

	public $table='cupones';


	public $error_prefix = '<div class="error">';
    public $error_suffix = '</div>';

 	public $has_one = array();
	public $has_many = array('usuario');

    function __construct($id=0)
    {
		parent::__construct($id);
	}

	public $validation = array(
		'cupon' => array('rules' => array('required','unique','max_length' => 50)),
		'descuento' => array('rules' => array('required','numeric')),
		'compra_minima' => array('rules' => array('numeric')),
		'tipo_descuento' => array('rules' => array('required')),
 		'fecha_activacion' => array('rules' => array('date')),
		'fecha_desactivacion' => array('rules' => array('date')),
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

	function is_active()
	{
		$this->where("fecha_activacion <= '".date('Y-m-d H:i:s')."'",null);
	        	$this->where("if(fecha_desactivacion='0000-00-00 00:00:00',1,  if(fecha_desactivacion >= '".date('Y-m-d H:i:s')."',1,0) )",null);
	        	$this->where('is_enable',1);
	        	return $this;
	}


}
