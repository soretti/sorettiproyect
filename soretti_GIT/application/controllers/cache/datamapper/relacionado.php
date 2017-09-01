<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'cat_relacionados',
  'fields' => 
  array (
    0 => 'id',
    1 => 'producto_id',
    2 => 'rootproducto_id',
    3 => 'sort',
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
    'producto_id' => 
    array (
      'field' => 'producto_id',
      'rules' => 
      array (
      ),
    ),
    'rootproducto_id' => 
    array (
      'field' => 'rootproducto_id',
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
      'other_field' => 'relacionado',
      'join_self_as' => 'relacionado',
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