<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'boletin_grupos',
  'fields' => 
  array (
    0 => 'id',
    1 => 'nombre',
    2 => 'is_enable',
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
    'is_enable' => 
    array (
      'field' => 'is_enable',
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