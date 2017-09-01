<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'chat_visitantes',
  'fields' => 
  array (
    0 => 'id',
    1 => 'ip',
    2 => 'fecha',
    3 => 'codigo',
    4 => 'nombre',
    5 => 'atendido',
    6 => 'dominio',
    7 => 'location',
    8 => 'ultimo_movimiento',
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
    'ip' => 
    array (
      'field' => 'ip',
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
    'codigo' => 
    array (
      'field' => 'codigo',
      'rules' => 
      array (
      ),
    ),
    'nombre' => 
    array (
      'field' => 'nombre',
      'rules' => 
      array (
      ),
    ),
    'atendido' => 
    array (
      'field' => 'atendido',
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
    'location' => 
    array (
      'field' => 'location',
      'rules' => 
      array (
      ),
    ),
    'ultimo_movimiento' => 
    array (
      'field' => 'ultimo_movimiento',
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
  ),
  'has_one' => 
  array (
  ),
  'has_many' => 
  array (
    'mensaje' => 
    array (
      'class' => 'mensaje',
      'other_field' => 'visitante',
      'join_self_as' => 'visitante',
      'join_other_as' => 'mensaje',
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