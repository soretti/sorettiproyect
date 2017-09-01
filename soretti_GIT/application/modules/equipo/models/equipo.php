<?php
require_once(APPPATH."modules/bloque/models/bloquecontenidos.php");
class Equipo extends Bloquecontenidos
{
	public $image_w=1953;
    public $image_h=276;

	function __construct($id=null){
		parent::__construct($id);
	}

	public $validation = array(
					'titulo' => array('rules' => array('required')),
					//'texto' => array('rules' => array('required')),
					'imagen' => array('rules' => array('required')),
					//'liga' => array('rules' => array('required')),
					//'fecha_creacion' => array('rules' => array('date')),
					//'fecha_activacion' => array('rules' => array('date')),
					//'fecha_desactivacion' => array('rules' => array('date'))
	);

	public $configuracion=array('max-items'=>0,'sortable'=>1);



}
