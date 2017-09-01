<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'menus',
  'fields' => 
  array (
    0 => 'id',
    1 => 'titulo',
    2 => 'profundidad',
    3 => 'titulo_en',
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
    'profundidad' => 
    array (
      'field' => 'profundidad',
      'rules' => 
      array (
      ),
    ),
    'titulo_en' => 
    array (
      'field' => 'titulo_en',
      'rules' => 
      array (
      ),
    ),
    'boton' => 
    array (
      'field' => 'boton',
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
    'boton' => 
    array (
      'class' => 'boton',
      'other_field' => 'menu',
      'join_self_as' => 'menu',
      'join_other_as' => 'boton',
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