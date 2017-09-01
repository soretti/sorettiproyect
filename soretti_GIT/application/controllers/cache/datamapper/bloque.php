<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'bloques',
  'fields' => 
  array (
    0 => 'id',
    1 => 'titulo',
    2 => 'titulo_en',
    3 => 'is_enable',
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
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
      ),
    ),
    'titulo_en' => 
    array (
      'field' => 'titulo_en',
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
    'bloquecontenidos' => 
    array (
      'field' => 'bloquecontenidos',
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
    'bloquecontenidos' => 
    array (
      'class' => 'bloquecontenidos',
      'other_field' => 'bloque',
      'join_self_as' => 'bloque',
      'join_other_as' => 'bloquecontenidos',
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