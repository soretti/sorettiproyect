<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'boletin_newsletter',
  'fields' => 
  array (
    0 => 'id',
    1 => 'asunto',
    2 => 'grupos',
    3 => 'fecha_envio',
    4 => 'contenido',
    5 => 'status',
    6 => 'is_enable',
    7 => 'cuentas_id',
  ),
  'validation' => 
  array (
    'asunto' => 
    array (
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'asunto',
    ),
    'grupos' => 
    array (
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'grupos',
    ),
    'fecha_envio' => 
    array (
      'rules' => 
      array (
        0 => 'date',
        1 => 'required',
      ),
      'field' => 'fecha_envio',
    ),
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
      ),
    ),
    'contenido' => 
    array (
      'field' => 'contenido',
      'rules' => 
      array (
      ),
    ),
    'status' => 
    array (
      'field' => 'status',
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
    'cuentas_id' => 
    array (
      'field' => 'cuentas_id',
      'rules' => 
      array (
      ),
    ),
    'cuentas' => 
    array (
      'field' => 'cuentas',
      'rules' => 
      array (
      ),
    ),
    'boletin_newsletterstatus' => 
    array (
      'field' => 'boletin_newsletterstatus',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
    'cuentas' => 
    array (
      'class' => 'cuentas',
      'other_field' => 'newsletter',
      'join_self_as' => 'newsletter',
      'join_other_as' => 'cuentas',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
  ),
  'has_many' => 
  array (
    'boletin_newsletterstatus' => 
    array (
      'class' => 'boletin_newsletterstatus',
      'other_field' => 'newsletter',
      'join_self_as' => 'newsletter',
      'join_other_as' => 'boletin_newsletterstatus',
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