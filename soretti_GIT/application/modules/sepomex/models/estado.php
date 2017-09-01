<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estado extends DataMapper {

	function __construct($id=null)
	{
		parent::__construct($id);
	}

	 public $table='sep_estados';
 	 public $has_many= array('municipio','tiendadireccion','ciudad');
}
