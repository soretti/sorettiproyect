<?php
require_once(APPPATH."modules/bloque/models/bloquecontenidos.php");
class Textos extends Bloquecontenidos
{
	function __construct($id=null){
		parent::__construct($id);
	}
	
	public $validation = array( 
					// 'titulo' => array('rules' => array('required')),
					'texto' => array('rules' => array('required'))
	);

	public $configuracion=array('max-items'=>0,'sortable'=>0);
}