<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'cupones',
  'fields' => 
  array (
    0 => 'id',
    1 => 'cupon',
    2 => 'fecha_activacion',
    3 => 'fecha_desactivacion',
    4 => 'canjeado',
    5 => 'descuento',
    6 => 'tipo_descuento',
    7 => 'is_enable',
    8 => 'compra_minima',
    9 => 'uso',
  ),
  'validation' => 
  array (
    'cupon' => 
    array (
      'rules' => 
      array (
        0 => 'required',
        1 => 'unique',
        'max_length' => 50,
      ),
      'field' => 'cupon',
    ),
    'descuento' => 
    array (
      'rules' => 
      array (
        0 => 'required',
        1 => 'numeric',
      ),
      'field' => 'descuento',
    ),
    'compra_minima' => 
    array (
      'rules' => 
      array (
        0 => 'numeric',
      ),
      'field' => 'compra_minima',
    ),
    'tipo_descuento' => 
    array (
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'tipo_descuento',
    ),
    'fecha_activacion' => 
    array (
      'rules' => 
      array (
        0 => 'date',
      ),
      'field' => 'fecha_activacion',
    ),
    'fecha_desactivacion' => 
    array (
      'rules' => 
      array (
        0 => 'date',
      ),
      'field' => 'fecha_desactivacion',
    ),
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
      ),
    ),
    'canjeado' => 
    array (
      'field' => 'canjeado',
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
    'uso' => 
    array (
      'field' => 'uso',
      'rules' => 
      array (
      ),
    ),
    'usuario' => 
    array (
      'field' => 'usuario',
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
    'usuario' => 
    array (
      'class' => 'usuario',
      'other_field' => 'cupon',
      'join_self_as' => 'cupon',
      'join_other_as' => 'usuario',
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