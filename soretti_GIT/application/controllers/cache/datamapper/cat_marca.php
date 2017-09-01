<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'cat_marcas',
  'fields' => 
  array (
    0 => 'id',
    1 => 'titulo',
    2 => 'uri',
    3 => 'descripcion',
    4 => 'imagen',
    5 => 'metatitulo',
    6 => 'palabras_clave',
    7 => 'descripcion_en',
    8 => 'palabras_clave_en',
  ),
  'validation' => 
  array (
    'titulo' => 
    array (
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'titulo',
    ),
    'uri' => 
    array (
      'rules' => 
      array (
        0 => 'trim',
        1 => 'uri',
        2 => 'required',
        3 => 'unique',
      ),
      'field' => 'uri',
    ),
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
      ),
    ),
    'descripcion' => 
    array (
      'field' => 'descripcion',
      'rules' => 
      array (
      ),
    ),
    'imagen' => 
    array (
      'field' => 'imagen',
      'rules' => 
      array (
      ),
    ),
    'metatitulo' => 
    array (
      'field' => 'metatitulo',
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
    'producto' => 
    array (
      'field' => 'producto',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
  ),
  'has_many' => 
  array (
    'producto' => 
    array (
      'class' => 'producto',
      'join_table' => 'cat_productos',
      'join_self_as' => 'marca',
      'other_field' => 'cat_marca',
      'join_other_as' => 'producto',
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