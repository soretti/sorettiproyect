<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'sep_ciudad',
  'fields' => 
  array (
    0 => 'id',
    1 => 'titulo',
    2 => 'estado_id',
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
    'titulo' => 
    array (
      'field' => 'titulo',
      'rules' => 
      array (
      ),
    ),
    'estado_id' => 
    array (
      'field' => 'estado_id',
      'rules' => 
      array (
      ),
    ),
    'estado' => 
    array (
      'field' => 'estado',
      'rules' => 
      array (
      ),
    ),
    'colonia' => 
    array (
      'field' => 'colonia',
      'rules' => 
      array (
      ),
    ),
    'tiendadireccion' => 
    array (
      'field' => 'tiendadireccion',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
    'estado' => 
    array (
      'class' => 'estado',
      'other_field' => 'ciudad',
      'join_self_as' => 'ciudad',
      'join_other_as' => 'estado',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
  ),
  'has_many' => 
  array (
    'colonia' => 
    array (
      'class' => 'colonia',
      'other_field' => 'ciudad',
      'join_self_as' => 'ciudad',
      'join_other_as' => 'colonia',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'tiendadireccion' => 
    array (
      'class' => 'tiendadireccion',
      'other_field' => 'ciudad',
      'join_self_as' => 'ciudad',
      'join_other_as' => 'tiendadireccion',
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