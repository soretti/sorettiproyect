<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'cat_precios',
  'fields' => 
  array (
    0 => 'id',
    1 => 'precio',
    2 => 'costo',
    3 => 'impuesto',
    4 => 'moneda',
    5 => 'precio_mayoreo',
    6 => 'promocion',
    7 => 'cantidad',
    8 => 'descuento_tipo',
    9 => 'descuento_cantidad',
    10 => 'producto_id',
    11 => 'activacion_promocion',
    12 => 'desactivacion_promocion',
  ),
  'validation' => 
  array (
    'precio' => 
    array (
      'rules' => 
      array (
        0 => 'numeric',
      ),
      'field' => 'precio',
    ),
    'descuento_cantidad' => 
    array (
      'rules' => 
      array (
        0 => 'numeric',
      ),
      'field' => 'descuento_cantidad',
    ),
    'activacion_promocion' => 
    array (
      'rules' => 
      array (
        0 => 'date',
      ),
      'field' => 'activacion_promocion',
    ),
    'desactivacion_promocion' => 
    array (
      'rules' => 
      array (
        0 => 'date',
      ),
      'field' => 'desactivacion_promocion',
    ),
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
      ),
    ),
    'costo' => 
    array (
      'field' => 'costo',
      'rules' => 
      array (
      ),
    ),
    'impuesto' => 
    array (
      'field' => 'impuesto',
      'rules' => 
      array (
      ),
    ),
    'moneda' => 
    array (
      'field' => 'moneda',
      'rules' => 
      array (
      ),
    ),
    'precio_mayoreo' => 
    array (
      'field' => 'precio_mayoreo',
      'rules' => 
      array (
      ),
    ),
    'promocion' => 
    array (
      'field' => 'promocion',
      'rules' => 
      array (
      ),
    ),
    'cantidad' => 
    array (
      'field' => 'cantidad',
      'rules' => 
      array (
      ),
    ),
    'descuento_tipo' => 
    array (
      'field' => 'descuento_tipo',
      'rules' => 
      array (
      ),
    ),
    'producto_id' => 
    array (
      'field' => 'producto_id',
      'rules' => 
      array (
      ),
    ),
    'producto' => 
    array (
      'field' => 'producto',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
    'producto' => 
    array (
      'class' => 'producto',
      'other_field' => 'cat_precio',
      'join_self_as' => 'cat_precio',
      'join_other_as' => 'producto',
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