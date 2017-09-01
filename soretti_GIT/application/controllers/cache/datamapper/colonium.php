<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'sep_colonia',
  'fields' => 
  array (
    0 => 'id',
    1 => 'titulo',
    2 => 'municipio_id',
    3 => 'ciudad_id',
    4 => 'cp',
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
    'municipio_id' => 
    array (
      'field' => 'municipio_id',
      'rules' => 
      array (
      ),
    ),
    'ciudad_id' => 
    array (
      'field' => 'ciudad_id',
      'rules' => 
      array (
      ),
    ),
    'cp' => 
    array (
      'field' => 'cp',
      'rules' => 
      array (
      ),
    ),
    'municipio' => 
    array (
      'field' => 'municipio',
      'rules' => 
      array (
      ),
    ),
    'ciudad' => 
    array (
      'field' => 'ciudad',
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
    'municipio' => 
    array (
      'class' => 'municipio',
      'other_field' => 'colonium',
      'join_self_as' => 'colonium',
      'join_other_as' => 'municipio',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'ciudad' => 
    array (
      'class' => 'ciudad',
      'other_field' => 'colonium',
      'join_self_as' => 'colonium',
      'join_other_as' => 'ciudad',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
  ),
  'has_many' => 
  array (
    'tiendadireccion' => 
    array (
      'class' => 'tiendadireccion',
      'join_table' => 'direcciones',
      'join_self_as' => 'colonia',
      'other_field' => 'colonium',
      'join_other_as' => 'tiendadireccion',
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