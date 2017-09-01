<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'roles',
  'fields' => 
  array (
    0 => 'id',
    1 => 'nombre',
    2 => 'descripcion',
    3 => 'is_enable',
  ),
  'validation' => 
  array (
    'nombre' => 
    array (
      'rules' => 
      array (
        0 => 'required',
        1 => 'unique',
        2 => 'xss',
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
    'descripcion' => 
    array (
      'field' => 'descripcion',
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
    'usuario' => 
    array (
      'field' => 'usuario',
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
    'usuario' => 
    array (
      'class' => 'usuario',
      'other_field' => 'rol',
      'join_self_as' => 'rol',
      'join_other_as' => 'usuario',
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