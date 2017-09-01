<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'modulos',
  'fields' => 
  array (
    0 => 'id',
    1 => 'columna_id',
    2 => 'posicion',
    3 => 'nombre',
    4 => 'columnas',
    5 => 'is_enable',
  ),
  'validation' => 
  array (
    'nombre' => 
    array (
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'nombre',
    ),
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
      ),
    ),
    'columna_id' => 
    array (
      'field' => 'columna_id',
      'rules' => 
      array (
      ),
    ),
    'posicion' => 
    array (
      'field' => 'posicion',
      'rules' => 
      array (
      ),
    ),
    'columnas' => 
    array (
      'field' => 'columnas',
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
    'columna' => 
    array (
      'field' => 'columna',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
    'columna' => 
    array (
      'class' => 'columna',
      'other_field' => 'modulo',
      'join_self_as' => 'modulo',
      'join_other_as' => 'columna',
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