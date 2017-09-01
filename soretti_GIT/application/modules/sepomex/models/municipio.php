<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Municipio extends DataMapper {

	function __construct($id=null)
	{
		parent::__construct($id);
	}

	public $table='sep_municipio';
	public $has_one=array('estado');
	public $has_many=array('colonia','tiendadireccion');


}
