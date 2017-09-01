<?php

class Acl extends DataMapper
{
 
	public $table='acl';

	public $has_many= array('roles','permisos');

	function __construct($id=null){
		parent::__construct($id);
	}

	

}