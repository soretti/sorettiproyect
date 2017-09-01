<?php

class Cat_marca extends DataMapper
{

	public $lista_w=0;
	public $lista_h=43;
	
	public $table='marcas';
    public $prefix = "cat_";

	public $error_prefix = '<div class="error">';
    public $error_suffix = '</div>';

	public $has_many = array(
            'producto'=>array('class' => 'producto' ,'join_table'=>'cat_productos','join_self_as'=>'marca')
	);

    function __construct($id=0)
    {
		parent::__construct($id);
	}

	public $validation = array(
		'titulo' => array('rules' => array('required')),
		'uri' => array('rules' => array('trim','uri','required','unique'))
	);

	function _uri($field)
	{
		$this->{$field}=url_title($this->{$field});
		return TRUE;
	}
}