<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'banners',
  'fields' => 
  array (
    0 => 'id',
    1 => 'titulo',
    2 => 'imagen',
    3 => 'liga',
    4 => 'target',
    5 => 'is_enable',
    6 => 'columna_id',
    7 => 'titulo_imagen',
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
    'imagen' => 
    array (
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'imagen',
    ),
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
      ),
    ),
    'liga' => 
    array (
      'field' => 'liga',
      'rules' => 
      array (
      ),
    ),
    'target' => 
    array (
      'field' => 'target',
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
    'columna_id' => 
    array (
      'field' => 'columna_id',
      'rules' => 
      array (
      ),
    ),
    'titulo_imagen' => 
    array (
      'field' => 'titulo_imagen',
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