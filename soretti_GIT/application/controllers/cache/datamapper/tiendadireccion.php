<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'direcciones',
  'fields' => 
  array (
    0 => 'id',
    1 => 'rfc',
    2 => 'razon_social',
    3 => 'usuario_id',
    4 => 'colonia_id',
    5 => 'ciudad_id',
    6 => 'estado_id',
    7 => 'municipio_id',
    8 => 'alias',
    9 => 'nombre',
    10 => 'apellidoPaterno',
    11 => 'apellidoMaterno',
    12 => 'lada',
    13 => 'telefono',
    14 => 'celular',
    15 => 'codigo',
    16 => 'calle',
    17 => 'numero_ext',
    18 => 'numero_int',
    19 => 'suplente',
    20 => 'referencia',
    21 => 'nombreColonia',
    22 => 'tipo',
  ),
  'validation' => 
  array (
    'tipo' => 
    array (
      'label' => 'Tipo de dirección',
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'tipo',
    ),
    'nombre' => 
    array (
      'label' => 'Nombre',
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'nombre',
    ),
    'apellidoPaterno' => 
    array (
      'label' => 'apellido Paterno',
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'apellidoPaterno',
    ),
    'lada' => 
    array (
      'label' => 'Lada',
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'lada',
    ),
    'telefono' => 
    array (
      'label' => 'Teléfono',
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'telefono',
    ),
    'calle' => 
    array (
      'label' => 'Calle',
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'calle',
    ),
    'numero_ext' => 
    array (
      'label' => 'Número exterior',
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'numero_ext',
    ),
    'codigo' => 
    array (
      'label' => 'Código postal',
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'codigo',
    ),
    'estado_id' => 
    array (
      'label' => 'Estado',
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'estado_id',
    ),
    'municipio_id' => 
    array (
      'label' => 'Municipio',
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'municipio_id',
    ),
    'colonia_id' => 
    array (
      'label' => 'Colonia',
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'colonia_id',
    ),
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
      ),
    ),
    'rfc' => 
    array (
      'field' => 'rfc',
      'rules' => 
      array (
      ),
    ),
    'razon_social' => 
    array (
      'field' => 'razon_social',
      'rules' => 
      array (
      ),
    ),
    'usuario_id' => 
    array (
      'field' => 'usuario_id',
      'rules' => 
      array (
      ),
    ),
    'ciudad_id' => 
    array (
      'field' => 'ciudad_id',
      'rules' => 
      array (
      ),
    ),
    'alias' => 
    array (
      'field' => 'alias',
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
    'celular' => 
    array (
      'field' => 'celular',
      'rules' => 
      array (
      ),
    ),
    'numero_int' => 
    array (
      'field' => 'numero_int',
      'rules' => 
      array (
      ),
    ),
    'suplente' => 
    array (
      'field' => 'suplente',
      'rules' => 
      array (
      ),
    ),
    'referencia' => 
    array (
      'field' => 'referencia',
      'rules' => 
      array (
      ),
    ),
    'nombreColonia' => 
    array (
      'field' => 'nombreColonia',
      'rules' => 
      array (
      ),
    ),
    'estado' => 
    array (
      'field' => 'estado',
      'rules' => 
      array (
      ),
    ),
    'municipio' => 
    array (
      'field' => 'municipio',
      'rules' => 
      array (
      ),
    ),
    'ciudad' => 
    array (
      'field' => 'ciudad',
      'rules' => 
      array (
      ),
    ),
    'colonia' => 
    array (
      'field' => 'colonia',
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
  ),
  'has_one' => 
  array (
    'colonia' => 
    array (
      'class' => 'colonia',
      'join_table' => 'direcciones',
      'join_other_as' => 'tiendadireccion',
      'other_field' => 'tiendadireccion',
      'join_self_as' => 'tiendadireccion',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'estado' => 
    array (
      'class' => 'estado',
      'other_field' => 'tiendadireccion',
      'join_self_as' => 'tiendadireccion',
      'join_other_as' => 'estado',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'municipio' => 
    array (
      'class' => 'municipio',
      'other_field' => 'tiendadireccion',
      'join_self_as' => 'tiendadireccion',
      'join_other_as' => 'municipio',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'ciudad' => 
    array (
      'class' => 'ciudad',
      'other_field' => 'tiendadireccion',
      'join_self_as' => 'tiendadireccion',
      'join_other_as' => 'ciudad',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'usuario' => 
    array (
      'class' => 'usuario',
      'other_field' => 'tiendadireccion',
      'join_self_as' => 'tiendadireccion',
      'join_other_as' => 'usuario',
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