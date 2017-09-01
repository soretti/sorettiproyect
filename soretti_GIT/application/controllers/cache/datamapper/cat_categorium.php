<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'cat_categorias',
  'fields' => 
  array (
    0 => 'id',
    1 => 'padre_id',
    2 => 'titulo',
    3 => 'metatitulo',
    4 => 'posicion',
    5 => 'uri',
    6 => 'descripcion',
    7 => 'palabras_clave',
    8 => 'imagen',
    9 => 'banner',
    10 => 'fondo',
    11 => 'titulo_en',
    12 => 'metatitulo_en',
    13 => 'descripcion_en',
    14 => 'palabras_clave_en',
    15 => 'is_enable',
    16 => 'porcentaje',
    17 => 'promocion',
    18 => 'porcentaje_promocion',
    19 => 'activacion_promocion',
    20 => 'desactivacion_promocion',
  ),
  'validation' => 
  array (
    'titulo' => 
    array (
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'titulo',
    ),
    'uri' => 
    array (
      'rules' => 
      array (
        0 => 'uri',
        1 => 'required',
        2 => 'unique',
      ),
      'field' => 'uri',
    ),
    'activacion_promocion' => 
    array (
      'rules' => 
      array (
        0 => 'date',
      ),
      'field' => 'activacion_promocion',
    ),
    'desactivacion_promocion' => 
    array (
      'rules' => 
      array (
        0 => 'date',
      ),
      'field' => 'desactivacion_promocion',
    ),
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
      ),
    ),
    'padre_id' => 
    array (
      'field' => 'padre_id',
      'rules' => 
      array (
      ),
    ),
    'metatitulo' => 
    array (
      'field' => 'metatitulo',
      'rules' => 
      array (
      ),
    ),
    'posicion' => 
    array (
      'field' => 'posicion',
      'rules' => 
      array (
      ),
    ),
    'descripcion' => 
    array (
      'field' => 'descripcion',
      'rules' => 
      array (
      ),
    ),
    'palabras_clave' => 
    array (
      'field' => 'palabras_clave',
      'rules' => 
      array (
      ),
    ),
    'imagen' => 
    array (
      'field' => 'imagen',
      'rules' => 
      array (
      ),
    ),
    'banner' => 
    array (
      'field' => 'banner',
      'rules' => 
      array (
      ),
    ),
    'fondo' => 
    array (
      'field' => 'fondo',
      'rules' => 
      array (
      ),
    ),
    'titulo_en' => 
    array (
      'field' => 'titulo_en',
      'rules' => 
      array (
      ),
    ),
    'metatitulo_en' => 
    array (
      'field' => 'metatitulo_en',
      'rules' => 
      array (
      ),
    ),
    'descripcion_en' => 
    array (
      'field' => 'descripcion_en',
      'rules' => 
      array (
      ),
    ),
    'palabras_clave_en' => 
    array (
      'field' => 'palabras_clave_en',
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
    'porcentaje' => 
    array (
      'field' => 'porcentaje',
      'rules' => 
      array (
      ),
    ),
    'promocion' => 
    array (
      'field' => 'promocion',
      'rules' => 
      array (
      ),
    ),
    'porcentaje_promocion' => 
    array (
      'field' => 'porcentaje_promocion',
      'rules' => 
      array (
      ),
    ),
    'padre' => 
    array (
      'field' => 'padre',
      'rules' => 
      array (
      ),
    ),
    'related_link' => 
    array (
      'field' => 'related_link',
      'rules' => 
      array (
      ),
    ),
    'producto' => 
    array (
      'field' => 'producto',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
    'padre' => 
    array (
      'class' => 'cat_categoria',
      'other_field' => 'related_link',
      'join_self_as' => 'padre',
      'join_other_as' => 'padre',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
  ),
  'has_many' => 
  array (
    'related_link' => 
    array (
      'class' => 'cat_categoria',
      'other_field' => 'padre',
      'join_self_as' => 'padre',
      'join_other_as' => 'related_link',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'producto' => 
    array (
      'class' => 'producto',
      'join_table' => 'cat_productos',
      'join_self_as' => 'categoria',
      'other_field' => 'cat_categorium',
      'join_other_as' => 'producto',
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