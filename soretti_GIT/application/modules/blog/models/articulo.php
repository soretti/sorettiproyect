<?php
class Articulo extends DataMapper
{
	function __construct($id=null)
	{
		parent::__construct($id);
	}
	public $thumb_width=373;
	public $thumb_height=245;
	public $table='articulos';
	public $prefix = "blog_";
	public $has_one=array('pagina','blog_categoria'=>array('class'=>'blog_categoria','join_table'=>'blog_categorias','other_field'=>'categoria','join_other_as'=>'categoria'),'usuario');
	
	public $validation = array(
		'titulo' => array('rules' => array('required')),
		'uri' => array('rules' => array('uri','required','unique')),
		'fecha_creacion' => array('rules' => array('date')),
		'fecha_activacion' => array('rules' => array('date')),
		'fecha_desactivacion' => array('rules' => array('date')),
		'pagina_id' => array('rules' => array('required'))
	);

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