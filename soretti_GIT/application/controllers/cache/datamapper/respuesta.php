<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'chat_respuestas',
  'fields' => 
  array (
    0 => 'id',
    1 => 'tipo_id',
    2 => 'respuesta',
    3 => 'snipet',
    4 => 'titulo',
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
    'respuesta' => 
    array (
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'respuesta',
    ),
    'snipet' => 
    array (
      'rules' => 
      array (
        0 => 'unique',
      ),
      'field' => 'snipet',
    ),
    'tipo_id' => 
    array (
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'tipo_id',
    ),
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
      ),
    ),
    'tipo' => 
    array (
      'field' => 'tipo',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
    'tipo' => 
    array (
      'class' => 'tipo',
      'other_field' => 'respuesta',
      'join_self_as' => 'respuesta',
      'join_other_as' => 'tipo',
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