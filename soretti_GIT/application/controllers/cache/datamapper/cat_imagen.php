<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'cat_imagenes',
  'fields' => 
  array (
    0 => 'id',
    1 => 'titulo',
    2 => 'imagen',
    3 => 'producto_id',
    4 => 'sort',
  ),
  'validation' => 
  array (
    'imagen' => 
    array (
      'label' => 'imagen',
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'imagen',
    ),
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
      ),
    ),
    'titulo' => 
    array (
      'field' => 'titulo',
      'rules' => 
      array (
      ),
    ),
    'producto_id' => 
    array (
      'field' => 'producto_id',
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
    'producto' => 
    array (
      'class' => 'producto',
      'other_field' => 'cat_imagen',
      'join_self_as' => 'cat_imagen',
      'join_other_as' => 'producto',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
  ),
  'has_many' => 
  array (
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