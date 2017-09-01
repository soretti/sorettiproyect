<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'boletin_usuarios',
  'fields' => 
  array (
    0 => 'id',
    1 => 'nombre',
    2 => 'apellidoPaterno',
    3 => 'apellidoMaterno',
    4 => 'email',
    5 => 'grupos',
    6 => 'is_enable',
    7 => 'fecha_inscripcion',
    8 => 'unsuscribed',
  ),
  'validation' => 
  array (
    'nombre' => 
    array (
      'rules' => 
      array (
        0 => 'required',
        1 => 'xss',
      ),
      'field' => 'nombre',
    ),
    'privacidad' => 
    array (
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'privacidad',
    ),
    'email' => 
    array (
      'rules' => 
      array (
        0 => 'required',
        1 => 'trim',
        2 => 'unique',
        3 => 'valid_email',
      ),
      'field' => 'email',
    ),
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
      ),
    ),
    'apellidoPaterno' => 
    array (
      'field' => 'apellidoPaterno',
      'rules' => 
      array (
      ),
    ),
    'apellidoMaterno' => 
    array (
      'field' => 'apellidoMaterno',
      'rules' => 
      array (
      ),
    ),
    'grupos' => 
    array (
      'field' => 'grupos',
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
    'fecha_inscripcion' => 
    array (
      'field' => 'fecha_inscripcion',
      'rules' => 
      array (
      ),
    ),
    'unsuscribed' => 
    array (
      'field' => 'unsuscribed',
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