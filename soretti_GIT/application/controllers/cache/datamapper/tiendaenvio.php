<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'tienda_envio',
  'fields' => 
  array (
    0 => 'id',
    1 => 'gratis',
    2 => 'gratisop',
    3 => 'gratis_cantidad',
    4 => 'tarifaop',
    5 => 'tarifa',
  ),
  'validation' => 
  array (
    'gratis_cantidad' => 
    array (
      'rules' => 
      array (
        0 => 'numeric',
        1 => 'trim',
        2 => 'xss',
      ),
      'field' => 'gratis_cantidad',
    ),
    'tarifa' => 
    array (
      'rules' => 
      array (
        0 => 'numeric',
        1 => 'trim',
        2 => 'xss',
      ),
      'field' => 'tarifa',
    ),
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
      ),
    ),
    'gratis' => 
    array (
      'field' => 'gratis',
      'rules' => 
      array (
      ),
    ),
    'gratisop' => 
    array (
      'field' => 'gratisop',
      'rules' => 
      array (
      ),
    ),
    'tarifaop' => 
    array (
      'field' => 'tarifaop',
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