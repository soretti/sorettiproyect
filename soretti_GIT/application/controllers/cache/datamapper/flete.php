<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'fletes',
  'fields' => 
  array (
    0 => 'id',
    1 => 'titulo',
    2 => 'url',
    3 => 'imagen',
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
    'url' => 
    array (
      'field' => 'url',
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
    'order' => 
    array (
      'field' => 'order',
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
    'order' => 
    array (
      'class' => 'order',
      'other_field' => 'flete',
      'join_self_as' => 'flete',
      'join_other_as' => 'order',
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