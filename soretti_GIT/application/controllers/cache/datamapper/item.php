<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'items',
  'fields' => 
  array (
    0 => 'id',
    1 => 'order_id',
    2 => 'producto_id',
    3 => 'precio',
    4 => 'preciodistribuidor',
    5 => 'cantidad',
    6 => 'titulo',
    7 => 'SKU',
    8 => 'imagen',
    9 => 'options',
    10 => 'extra',
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
    'order_id' => 
    array (
      'field' => 'order_id',
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
    'precio' => 
    array (
      'field' => 'precio',
      'rules' => 
      array (
      ),
    ),
    'preciodistribuidor' => 
    array (
      'field' => 'preciodistribuidor',
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
    'titulo' => 
    array (
      'field' => 'titulo',
      'rules' => 
      array (
      ),
    ),
    'SKU' => 
    array (
      'field' => 'SKU',
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
    'options' => 
    array (
      'field' => 'options',
      'rules' => 
      array (
      ),
    ),
    'extra' => 
    array (
      'field' => 'extra',
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
    'producto' => 
    array (
      'class' => 'producto',
      'other_field' => 'item',
      'join_self_as' => 'item',
      'join_other_as' => 'producto',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'order' => 
    array (
      'class' => 'order',
      'other_field' => 'item',
      'join_self_as' => 'item',
      'join_other_as' => 'order',
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