<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'chat_tipos',
  'fields' => 
  array (
    0 => 'id',
    1 => 'titulo',
    2 => 'descripcion',
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
    'respuesta' => 
    array (
      'field' => 'respuesta',
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
    'respuesta' => 
    array (
      'class' => 'respuesta',
      'other_field' => 'tipo',
      'join_self_as' => 'tipo',
      'join_other_as' => 'respuesta',
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