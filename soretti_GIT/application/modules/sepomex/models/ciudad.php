<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ciudad extends DataMapper {

	function __construct($id=null)
	{
		parent::__construct($id);
	}

	public $table='ciudad';
	public $prefix = "sep_";
	public $has_many= array('colonia','tiendadireccion');
	public $has_one= array('estado');
}
