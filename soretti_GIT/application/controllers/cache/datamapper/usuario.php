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
    'rol_id' => 
    array (
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'rol_id',
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
    'password' => 
    array (
      'rules' => 
      array (
        0 => 'required',
        1 => 'trim',
        'min_length' => 3,
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
    'rol' => 
    array (
      'field' => 'rol',
      'rules' => 
      array (
      ),
    ),
    'descuento' => 
    array (
      'field' => 'descuento',
      'rules' => 
      array (
      ),
    ),
    'cupon' => 
    array (
      'field' => 'cupon',
      'rules' => 
      array (
      ),
    ),
    'articulo' => 
    array (
      'field' => 'articulo',
      'rules' => 
      array (
      ),
    ),
    'pagina' => 
    array (
      'field' => 'pagina',
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
    'tienda/order' => 
    array (
      'field' => 'tienda/order',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
    'rol' => 
    array (
      'class' => 'rol',
      'other_field' => 'usuario',
      'join_self_as' => 'usuario',
      'join_other_as' => 'rol',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'descuento' => 
    array (
      'class' => 'descuento',
      'other_field' => 'usuario',
      'join_self_as' => 'usuario',
      'join_other_as' => 'descuento',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'cupon' => 
    array (
      'class' => 'cupon',
      'other_field' => 'usuario',
      'join_self_as' => 'usuario',
      'join_other_as' => 'cupon',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
  ),
  'has_many' => 
  array (
    'articulo' => 
    array (
      'class' => 'articulo',
      'other_field' => 'usuario',
      'join_self_as' => 'usuario',
      'join_other_as' => 'articulo',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'pagina' => 
    array (
      'class' => 'pagina',
      'other_field' => 'usuario',
      'join_self_as' => 'usuario',
      'join_other_as' => 'pagina',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'tiendadireccion' => 
    array (
      'class' => 'tiendadireccion',
      'other_field' => 'usuario',
      'join_self_as' => 'usuario',
      'join_other_as' => 'tiendadireccion',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'tienda/order' => 
    array (
      'class' => 'tienda/order',
      'other_field' => 'usuario',
      'join_self_as' => 'usuario',
      'join_other_as' => 'tienda/order',
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