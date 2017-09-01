<?php

class Galeriaimagenes extends DataMapper
{
	function __construct($id=null){
		parent::__construct($id);
	}

	public $table='galeriaimages';

	public $has_one=array('pagina'=>array('class'=>'pagina'));

	public $validation = array(
		 'path' => array('rules' => array('required'))
	);
	
	 public $width = 700;
	 public $height = 660;
	 public $t_width = 230;
	 public $t_height = 180;


	function is_active()
	{
        $this->where('is_enable',1);
        return $this;
	}


}