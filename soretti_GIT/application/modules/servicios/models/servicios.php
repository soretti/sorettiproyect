<?php
require_once(APPPATH."modules/bloque/models/bloquecontenidos.php");
class Servicios extends Bloquecontenidos
{
	function __construct($id=null){
		parent::__construct($id);
	}

	public $img_width=64;
	public $img_height=64;
		
	public $validation = array( 
					'titulo' => array('rules' => array('required')),
					'subtitulo' => array('rules' => array('required')),
					'texto' => array('rules' => array('required')),
					// 'imagen' => array('rules' => array('required')),
					// 'liga' => array('rules' => array('required')),
					'fecha_creacion' => array('rules' => array('date')),
					'fecha_activacion' => array('rules' => array('date')),
					'fecha_desactivacion' => array('rules' => array('date'))
	);

	public $configuracion=array('max-items'=>0,'sortable'=>1);



}