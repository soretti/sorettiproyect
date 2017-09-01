<?php
class Mapa extends DataMapper
{
	function __construct($id=null){
		parent::__construct($id);
	}
	public $table='mapas';

	public $validation = array( 
					'coordenadas' => array('rules' => array('required'))
	);

	public $has_one=array('direccion'=>array('join_table'=>'bloquecontenidos','join_other_as'=>'bloquecontenido'));

}