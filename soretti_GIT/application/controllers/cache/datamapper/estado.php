<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'sep_estados',
  'fields' => 
  array (
    0 => 'id',
    1 => 'titulo',
    2 => 'c_estado',
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
    'titulo' => 
    array (
      'field' => 'titulo',
      'rules' => 
      array (
      ),
    ),
    'c_estado' => 
    array (
      'field' => 'c_estado',
      'rules' => 
      array (
      ),
    ),
    'municipio' => 
    array (
      'field' => 'municipio',
      'rules' => 
      array (
      ),
    ),
    'tiendadireccion' => 
    array (
      'field' => 'tiendadireccion',
      'rules' => 
      array (
      ),
    ),
    'ciudad' => 
    array (
      'field' => 'ciudad',
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
    'municipio' => 
    array (
      'class' => 'municipio',
      'other_field' => 'estado',
      'join_self_as' => 'estado',
      'join_other_as' => 'municipio',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'tiendadireccion' => 
    array (
      'class' => 'tiendadireccion',
      'other_field' => 'estado',
      'join_self_as' => 'estado',
      'join_other_as' => 'tiendadireccion',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'ciudad' => 
    array (
      'class' => 'ciudad',
      'other_field' => 'estado',
      'join_self_as' => 'estado',
      'join_other_as' => 'ciudad',
      'join_table' => '',
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