<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'cat_destacados',
  'fields' => 
  array (
    0 => 'id',
    1 => 'producto_id',
    2 => 'sort',
    3 => 'seccion',
  ),
  'validation' => 
  array (
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
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
    'seccion' => 
    array (
      'field' => 'seccion',
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
      'other_field' => 'destacado',
      'join_self_as' => 'destacado',
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