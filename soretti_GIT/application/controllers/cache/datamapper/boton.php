<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'botones',
  'fields' => 
  array (
    0 => 'id',
    1 => 'padre_id',
    2 => 'menu_id',
    3 => 'titulo',
    4 => 'link',
    5 => 'target',
    6 => 'posicion',
    7 => 'tipo',
    8 => 'titulo_en',
    9 => 'texto',
    10 => 'texto_en',
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
    'padre_id' => 
    array (
      'field' => 'padre_id',
      'rules' => 
      array (
      ),
    ),
    'menu_id' => 
    array (
      'field' => 'menu_id',
      'rules' => 
      array (
      ),
    ),
    'link' => 
    array (
      'field' => 'link',
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
    'posicion' => 
    array (
      'field' => 'posicion',
      'rules' => 
      array (
      ),
    ),
    'tipo' => 
    array (
      'field' => 'tipo',
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
    'texto' => 
    array (
      'field' => 'texto',
      'rules' => 
      array (
      ),
    ),
    'texto_en' => 
    array (
      'field' => 'texto_en',
      'rules' => 
      array (
      ),
    ),
    'menu' => 
    array (
      'field' => 'menu',
      'rules' => 
      array (
      ),
    ),
    'padre' => 
    array (
      'field' => 'padre',
      'rules' => 
      array (
      ),
    ),
    'related_link' => 
    array (
      'field' => 'related_link',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
    'padre' => 
    array (
      'class' => 'boton',
      'other_field' => 'related_link',
      'reciprocal' => false,
      'join_self_as' => 'related_link',
      'join_other_as' => 'padre',
      'join_table' => '',
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'menu' => 
    array (
      'class' => 'menu',
      'other_field' => 'boton',
      'join_self_as' => 'boton',
      'join_other_as' => 'menu',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
  ),
  'has_many' => 
  array (
    'related_link' => 
    array (
      'class' => 'boton',
      'other_field' => 'padre',
      'reciprocal' => true,
      'join_self_as' => 'padre',
      'join_other_as' => 'related_link',
      'join_table' => '',
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