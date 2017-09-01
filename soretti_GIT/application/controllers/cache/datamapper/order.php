<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'orders',
  'fields' => 
  array (
    0 => 'id',
    1 => 'usuario_id',
    2 => 'estatus',
    3 => 'fecha_creacion',
    4 => 'datos_envio',
    5 => 'datos_usuario',
    6 => 'datos_factura',
    7 => 'datos_pago',
    8 => 'datos_banco',
    9 => 'flete_id',
    10 => 'numero_guia',
    11 => 'cupon_id',
    12 => 'cupon',
    13 => 'cuponPorcentaje',
    14 => 'mayoreoPorcentaje',
    15 => 'total',
    16 => 'pago_fecha',
    17 => 'pago_referencia',
    18 => 'costo_flete',
    19 => 'entrega_fecha',
    20 => 'pago_verificado',
    21 => 'pago_verificado_fecha',
    22 => 'numero_compra',
    23 => 'solicitud_factura',
  ),
  'validation' => 
  array (
    'usuario_id' => 
    array (
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'usuario_id',
    ),
    'estatus' => 
    array (
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'estatus',
    ),
    'fecha_creacion' => 
    array (
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'fecha_creacion',
    ),
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
      ),
    ),
    'datos_envio' => 
    array (
      'field' => 'datos_envio',
      'rules' => 
      array (
      ),
    ),
    'datos_usuario' => 
    array (
      'field' => 'datos_usuario',
      'rules' => 
      array (
      ),
    ),
    'datos_factura' => 
    array (
      'field' => 'datos_factura',
      'rules' => 
      array (
      ),
    ),
    'datos_pago' => 
    array (
      'field' => 'datos_pago',
      'rules' => 
      array (
      ),
    ),
    'datos_banco' => 
    array (
      'field' => 'datos_banco',
      'rules' => 
      array (
      ),
    ),
    'flete_id' => 
    array (
      'field' => 'flete_id',
      'rules' => 
      array (
      ),
    ),
    'numero_guia' => 
    array (
      'field' => 'numero_guia',
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
    'cupon' => 
    array (
      'field' => 'cupon',
      'rules' => 
      array (
      ),
    ),
    'cuponPorcentaje' => 
    array (
      'field' => 'cuponPorcentaje',
      'rules' => 
      array (
      ),
    ),
    'mayoreoPorcentaje' => 
    array (
      'field' => 'mayoreoPorcentaje',
      'rules' => 
      array (
      ),
    ),
    'total' => 
    array (
      'field' => 'total',
      'rules' => 
      array (
      ),
    ),
    'pago_fecha' => 
    array (
      'field' => 'pago_fecha',
      'rules' => 
      array (
      ),
    ),
    'pago_referencia' => 
    array (
      'field' => 'pago_referencia',
      'rules' => 
      array (
      ),
    ),
    'costo_flete' => 
    array (
      'field' => 'costo_flete',
      'rules' => 
      array (
      ),
    ),
    'entrega_fecha' => 
    array (
      'field' => 'entrega_fecha',
      'rules' => 
      array (
      ),
    ),
    'pago_verificado' => 
    array (
      'field' => 'pago_verificado',
      'rules' => 
      array (
      ),
    ),
    'pago_verificado_fecha' => 
    array (
      'field' => 'pago_verificado_fecha',
      'rules' => 
      array (
      ),
    ),
    'numero_compra' => 
    array (
      'field' => 'numero_compra',
      'rules' => 
      array (
      ),
    ),
    'solicitud_factura' => 
    array (
      'field' => 'solicitud_factura',
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
    'flete' => 
    array (
      'field' => 'flete',
      'rules' => 
      array (
      ),
    ),
    'item' => 
    array (
      'field' => 'item',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
    'usuario' => 
    array (
      'class' => 'usuario',
      'other_field' => 'order',
      'join_self_as' => 'order',
      'join_other_as' => 'usuario',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'flete' => 
    array (
      'class' => 'flete',
      'other_field' => 'order',
      'join_self_as' => 'order',
      'join_other_as' => 'flete',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
  ),
  'has_many' => 
  array (
    'item' => 
    array (
      'class' => 'item',
      'other_field' => 'order',
      'join_self_as' => 'order',
      'join_other_as' => 'item',
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