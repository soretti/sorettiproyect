<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Colonia extends DataMapper {

	function __construct($id=null)
	{
		parent::__construct($id);
	}

	public $table='colonia';
	public $prefix = "sep_";
	public $has_one= array('municipio','ciudad');
	public $has_many= array(
		'tiendadireccion'=>array('class' => 'tiendadireccion' ,'join_table'=>'direcciones','join_self_as'=>'colonia'));

}
