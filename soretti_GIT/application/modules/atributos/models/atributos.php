<?php
require_once(APPPATH."modules/bloque/models/bloquecontenidos.php");
class Atributos extends Bloquecontenidos
{
	function __construct($id=null){
		parent::__construct($id);
	}
	
	public $validation = array( 
					'titulo' => array('rules' => array('required')),
					'texto' => array('rules' => array('required')),
					
					'fecha_creacion' => array('rules' => array('date')),
					'fecha_activacion' => array('rules' => array('date')),
					'fecha_desactivacion' => array('rules' => array('date'))
	);

	public $configuracion=array('max-items'=>3,'sortable'=>0);



}