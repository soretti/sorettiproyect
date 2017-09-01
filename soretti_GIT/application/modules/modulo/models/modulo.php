<?php
class Modulo extends DataMapper
{
	public $table = "modulos";
	public $has_one = array('columna');

	public $validation =array(
		'nombre'=>array('rules'=>array('required'))
		);

	function __construct($id=null){
		parent::__construct($id);
	}

	function is_publicidad()
	{
		$query = $this->db->query("SELECT modulo_id FROM publicidad");
		foreach($query->result_array() as $a) {
		   $array_id[] = $a['modulo_id'];
		}
		if( is_array($array_id) && in_array($this->id,$array_id)){
			return true;
		}
		return false;
	}
}