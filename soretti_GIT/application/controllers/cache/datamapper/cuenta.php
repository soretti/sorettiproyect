<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'boletin_cuentas',
  'fields' => 
  array (
    0 => 'id',
    1 => 'email',
    2 => 'host',
    3 => 'password',
    4 => 'alias',
    5 => 'puerto',
  ),
  'validation' => 
  array (
    'host' => 
    array (
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'host',
    ),
    'puerto' => 
    array (
      'rules' => 
      array (
        0 => 'required',
        1 => 'numeric',
      ),
      'field' => 'puerto',
    ),
    'alias' => 
    array (
      'rules' => 
      array (
        0 => 'required',
        1 => 'xss',
      ),
      'field' => 'alias',
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
    'password' => 
    array (
      'rules' => 
      array (
        0 => 'required',
        1 => 'trim',
      ),
      'field' => 'password',
    ),
    'confirmar' => 
    array (
      'rules' => 
      array (
        0 => 'required',
        'confirmarPassword' => 
        array (
          0 => 'password',
          1 => 'confirmar',
        ),
      ),
      'field' => 'confirmar',
    ),
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
      ),
    ),
    'newsletter' => 
    array (
      'field' => 'newsletter',
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
      'other_field' => 'cuenta',
      'join_self_as' => 'cuenta',
      'join_other_as' => 'newsletter',
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