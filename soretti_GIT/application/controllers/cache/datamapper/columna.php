<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'columnas',
  'fields' => 
  array (
    0 => 'id',
    1 => 'nombre',
    2 => 'modulos',
    3 => 'is_enable',
    4 => 'width',
    5 => 'height',
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
    'nombre' => 
    array (
      'field' => 'nombre',
      'rules' => 
      array (
      ),
    ),
    'modulos' => 
    array (
      'field' => 'modulos',
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
    'width' => 
    array (
      'field' => 'width',
      'rules' => 
      array (
      ),
    ),
    'height' => 
    array (
      'field' => 'height',
      'rules' => 
      array (
      ),
    ),
    'modulo' => 
    array (
      'field' => 'modulo',
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
    'modulo' => 
    array (
      'class' => 'modulo',
      'other_field' => 'columna',
      'join_self_as' => 'columna',
      'join_other_as' => 'modulo',
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