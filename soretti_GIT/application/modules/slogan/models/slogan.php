<?php
require_once(APPPATH."modules/bloque/models/bloquecontenidos.php");

class Slogan extends Bloquecontenidos
{
	function __construct($id=null){
		parent::__construct($id);
	}

	public $img_width=1920;
	public $img_height=650;
		
	public $validation = array( 
					'titulo' => array('rules' => array('required')),
					'subtitulo' => array('rules' => array('subtitulo')),
					// 'texto' => array('rules' => array('required')),
					'imagen' => array('rules' => array('required'))
					// 'liga' => array('rules' => array('required')),
					 // 'fecha_creacion' => array('rules' => array('date')),
					 // 'fecha_activacion' => array('rules' => array('date')),
					 // 'fecha_desactivacion' => array('rules' => array('date'))
	);

	public $configuracion=array('max-items'=>1,'sortable'=>0);



}