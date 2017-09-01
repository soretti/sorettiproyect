<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'blog_categorias',
  'fields' => 
  array (
    0 => 'id',
    1 => 'pagina_id',
    2 => 'titulo',
    3 => 'metatitulo',
    4 => 'uri',
    5 => 'is_enable',
    6 => 'sort',
    7 => 'descripcion',
    8 => 'palabras_clave',
    9 => 'titulo_en',
    10 => 'metatitulo_en',
    11 => 'descripcion_en',
    12 => 'palabras_clave_en',
  ),
  'validation' => 
  array (
    'titulo' => 
    array (
      'rules' => 
      array (
        0 => 'required',
        1 => 'unique',
      ),
      'field' => 'titulo',
    ),
    'uri' => 
    array (
      'rules' => 
      array (
        0 => 'uri',
        1 => 'required',
        2 => 'unique',
      ),
      'field' => 'uri',
    ),
    'pagina_id' => 
    array (
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'pagina_id',
    ),
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
      ),
    ),
    'metatitulo' => 
    array (
      'field' => 'metatitulo',
      'rules' => 
      array (
      ),
    ),
    'is_enable' => 
    array (
      'field' => 'is_enable',
      'rules' => 
      array (
      ),
    ),
    'sort' => 
    array (
      'field' => 'sort',
      'rules' => 
      array (
      ),
    ),
    'descripcion' => 
    array (
      'field' => 'descripcion',
      'rules' => 
      array (
      ),
    ),
    'palabras_clave' => 
    array (
      'field' => 'palabras_clave',
      'rules' => 
      array (
      ),
    ),
    'titulo_en' => 
    array (
      'field' => 'titulo_en',
      'rules' => 
      array (
      ),
    ),
    'metatitulo_en' => 
    array (
      'field' => 'metatitulo_en',
      'rules' => 
      array (
      ),
    ),
    'descripcion_en' => 
    array (
      'field' => 'descripcion_en',
      'rules' => 
      array (
      ),
    ),
    'palabras_clave_en' => 
    array (
      'field' => 'palabras_clave_en',
      'rules' => 
      array (
      ),
    ),
    'pagina' => 
    array (
      'field' => 'pagina',
      'rules' => 
      array (
      ),
    ),
    'articulo' => 
    array (
      'field' => 'articulo',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
    'pagina' => 
    array (
      'class' => 'pagina',
      'other_field' => 'blog_categorium',
      'join_self_as' => 'blog_categorium',
      'join_other_as' => 'pagina',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
  ),
  'has_many' => 
  array (
    'articulo' => 
    array (
      'class' => 'articulo',
      'join_table' => 'blog_articulos',
      'other_field' => 'blog_categorium',
      'join_self_as' => 'blog_categorium',
      'join_other_as' => 'articulo',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
  ),
  '_field_tracking' => 
  array (
    'get_rules' => 
    array (
    ),
    'matches' => 
    array (
    ),
    'intval' => 
    array (
      0 => 'id',
    ),
  ),
);