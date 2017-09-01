<?php
class Blog_categoria extends DataMapper
{
	function __construct($id=null)
	{
		parent::__construct($id);
	}

	public $table='categorias';
	public $prefix = "blog_";
	public $has_many=array('articulo'=>array('class' => 'articulo' ,'join_table'=>'blog_articulos'));
	public $has_one=array('pagina');
	
	
	public $validation = array(
		'titulo' => array('rules' => array('required','unique')),
		'uri' => array('rules' => array('uri','required','unique')),
		'pagina_id' => array('rules' => array('required'))
	);

	function _uri($field)
	{
		$this->{$field}=url_title($this->{$field});
		return TRUE;
	}
}