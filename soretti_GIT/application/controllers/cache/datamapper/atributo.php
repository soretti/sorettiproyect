<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'cat_atributos',
  'fields' => 
  array (
    0 => 'id',
    1 => 'nombre',
    2 => 'tipo',
    3 => 'is_enable',
    4 => 'padre_id',
    5 => 'sort',
    6 => 'micolor',
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
    'tipo' => 
    array (
      'field' => 'tipo',
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
    'padre_id' => 
    array (
      'field' => 'padre_id',
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
    'micolor' => 
    array (
      'field' => 'micolor',
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