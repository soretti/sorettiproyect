<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'chat_mensajes',
  'fields' => 
  array (
    0 => 'id',
    1 => 'visitante_id',
    2 => 'usuario',
    3 => 'mensaje',
    4 => 'fecha',
    5 => 'leido',
    6 => 'dominio',
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
    'visitante_id' => 
    array (
      'field' => 'visitante_id',
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
    'mensaje' => 
    array (
      'field' => 'mensaje',
      'rules' => 
      array (
      ),
    ),
    'fecha' => 
    array (
      'field' => 'fecha',
      'rules' => 
      array (
      ),
    ),
    'leido' => 
    array (
      'field' => 'leido',
      'rules' => 
      array (
      ),
    ),
    'dominio' => 
    array (
      'field' => 'dominio',
      'rules' => 
      array (
      ),
    ),
    'visitante' => 
    array (
      'field' => 'visitante',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
    'visitante' => 
    array (
      'class' => 'visitante',
      'other_field' => 'mensaje',
      'join_self_as' => 'mensaje',
      'join_other_as' => 'visitante',
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