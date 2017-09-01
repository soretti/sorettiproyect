<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'acl',
  'fields' => 
  array (
    0 => 'id',
    1 => 'roles_id',
    2 => 'permisos_id',
    3 => 'acl',
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
    'roles_id' => 
    array (
      'field' => 'roles_id',
      'rules' => 
      array (
      ),
    ),
    'permisos_id' => 
    array (
      'field' => 'permisos_id',
      'rules' => 
      array (
      ),
    ),
    'acl' => 
    array (
      'field' => 'acl',
      'rules' => 
      array (
      ),
    ),
    'roles' => 
    array (
      'field' => 'roles',
      'rules' => 
      array (
      ),
    ),
    'permisos' => 
    array (
      'field' => 'permisos',
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
    'roles' => 
    array (
      'class' => 'roles',
      'other_field' => 'acl',
      'join_self_as' => 'acl',
      'join_other_as' => 'roles',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'permisos' => 
    array (
      'class' => 'permisos',
      'other_field' => 'acl',
      'join_self_as' => 'acl',
      'join_other_as' => 'permisos',
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