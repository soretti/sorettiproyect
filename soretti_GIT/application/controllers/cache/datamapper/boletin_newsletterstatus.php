<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'boletin_newsletterstatus',
  'fields' => 
  array (
    0 => 'id',
    1 => 'boletin_usuarios_id',
    2 => 'newsletter_id',
    3 => 'enviado',
    4 => 'rechazado',
    5 => 'visto',
    6 => 'unsuscribed',
    7 => 'debug',
    8 => 'fecha_envio',
  ),
  'validation' => 
  array (
    'grupos' => 
    array (
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'grupos',
    ),
    'nombre' => 
    array (
      'rules' => 
      array (
        0 => 'required',
        1 => 'xss',
      ),
      'field' => 'nombre',
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
    'boletin_usuarios_id' => 
    array (
      'field' => 'boletin_usuarios_id',
      'rules' => 
      array (
      ),
    ),
    'newsletter_id' => 
    array (
      'field' => 'newsletter_id',
      'rules' => 
      array (
      ),
    ),
    'enviado' => 
    array (
      'field' => 'enviado',
      'rules' => 
      array (
      ),
    ),
    'rechazado' => 
    array (
      'field' => 'rechazado',
      'rules' => 
      array (
      ),
    ),
    'visto' => 
    array (
      'field' => 'visto',
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
    'debug' => 
    array (
      'field' => 'debug',
      'rules' => 
      array (
      ),
    ),
    'fecha_envio' => 
    array (
      'field' => 'fecha_envio',
      'rules' => 
      array (
      ),
    ),
    'newsletter' => 
    array (
      'field' => 'newsletter',
      'rules' => 
      array (
      ),
    ),
    'boletin_usuarios' => 
    array (
      'field' => 'boletin_usuarios',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
    'newsletter' => 
    array (
      'class' => 'newsletter',
      'other_field' => 'boletin_newsletterstatus',
      'join_self_as' => 'boletin_newsletterstatus',
      'join_other_as' => 'newsletter',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'boletin_usuarios' => 
    array (
      'class' => 'boletin_usuarios',
      'other_field' => 'boletin_newsletterstatus',
      'join_self_as' => 'boletin_newsletterstatus',
      'join_other_as' => 'boletin_usuarios',
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