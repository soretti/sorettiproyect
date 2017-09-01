<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'usuarios',
  'fields' => 
  array (
    0 => 'id',
    1 => 'rol_id',
    2 => 'password',
    3 => 'nombre',
    4 => 'apellidoPaterno',
    5 => 'apellidoMaterno',
    6 => 'email',
    7 => 'is_enable',
    8 => 'lada',
    9 => 'telefono',
    10 => 'sexo',
    11 => 'descuento_id',
    12 => 'cupon_id',
    13 => 'chat_dominios',
    14 => 'tipo',
    15 => 'identificacion',
    16 => 'comprobante_domicilio',
    17 => 'rfc',
    18 => 'banco',
    19 => 'clabe',
    20 => 'status_chat',
    21 => 'fecha_creacion',
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
        'min_length' => 5,
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
    'privacidad' => 
    array (
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'privacidad',
    ),
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
      ),
    ),
    'rol_id' => 
    array (
      'field' => 'rol_id',
      'rules' => 
      array (
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
    'is_enable' => 
    array (
      'field' => 'is_enable',
      'rules' => 
      array (
      ),
    ),
    'lada' => 
    array (
      'field' => 'lada',
      'rules' => 
      array (
      ),
    ),
    'telefono' => 
    array (
      'field' => 'telefono',
      'rules' => 
      array (
      ),
    ),
    'sexo' => 
    array (
      'field' => 'sexo',
      'rules' => 
      array (
      ),
    ),
    'descuento_id' => 
    array (
      'field' => 'descuento_id',
      'rules' => 
      array (
      ),
    ),
    'cupon_id' => 
    array (
      'field' => 'cupon_id',
      'rules' => 
      array (
      ),
    ),
    'chat_dominios' => 
    array (
      'field' => 'chat_dominios',
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
    'identificacion' => 
    array (
      'field' => 'identificacion',
      'rules' => 
      array (
      ),
    ),
    'comprobante_domicilio' => 
    array (
      'field' => 'comprobante_domicilio',
      'rules' => 
      array (
      ),
    ),
    'rfc' => 
    array (
      'field' => 'rfc',
      'rules' => 
      array (
      ),
    ),
    'banco' => 
    array (
      'field' => 'banco',
      'rules' => 
      array (
      ),
    ),
    'clabe' => 
    array (
      'field' => 'clabe',
      'rules' => 
      array (
      ),
    ),
    'status_chat' => 
    array (
      'field' => 'status_chat',
      'rules' => 
      array (
      ),
    ),
    'fecha_creacion' => 
    array (
      'field' => 'fecha_creacion',
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
  ),
  'has_many' => 
  array (
    'tiendadireccion' => 
    array (
      'class' => 'tiendadireccion',
      'other_field' => 'tiendausuario',
      'join_self_as' => 'tiendausuario',
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