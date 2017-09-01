<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'permisos',
  'fields' => 
  array (
    0 => 'id',
    1 => 'permiso',
    2 => 'titulo',
    3 => 'descripcion',
    4 => 'configuracion',
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
    'permiso' => 
    array (
      'field' => 'permiso',
      'rules' => 
      array (
      ),
    ),
    'titulo' => 
    array (
      'field' => 'titulo',
      'rules' => 
      array (
      ),
    ),
    'descripcion' => 
    array (
      'field' => 'descripcion',
      'rules' => 
      array (
      ),
    ),
    'configuracion' => 
    array (
      'field' => 'configuracion',
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