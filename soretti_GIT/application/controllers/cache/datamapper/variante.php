<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'cat_productos',
  'fields' => 
  array (
    0 => 'id',
    1 => 'producto_id',
    2 => 'titulo',
    3 => 'uri',
    4 => 'resumen',
    5 => 'descripcion',
    6 => 'hits',
    7 => 'metatitulo',
    8 => 'palabras_clave',
    9 => 'is_enable',
    10 => 'categoria_id',
    11 => 'categorias',
    12 => 'marca_id',
    13 => 'clave',
    14 => 'presentacion',
    15 => 'barrasindividual',
    16 => 'barraspresentacion',
    17 => 'fecha_creacion',
    18 => 'fecha_activacion',
    19 => 'fecha_desactivacion',
    20 => 'titulo_en',
    21 => 'resumen_en',
    22 => 'descripcion_en',
    23 => 'metatitulo_en',
    24 => 'palabras_clave_en',
    25 => 'combinaciones',
    26 => 'SKU',
    27 => 'combinacion_imagenes',
    28 => 'stock',
    29 => 'default',
    30 => 'comprar_sin_stock',
    31 => 'peso',
    32 => 'caracteristicas',
    33 => 'proveedor_id',
    34 => 'agotado',
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
    'producto_id' => 
    array (
      'field' => 'producto_id',
      'rules' => 
      array (
      ),
    ),
    'titulo' => 
    array (
      'field' => 'titulo',
      'rules' => 
      array (
      ),
    ),
    'uri' => 
    array (
      'field' => 'uri',
      'rules' => 
      array (
      ),
    ),
    'resumen' => 
    array (
      'field' => 'resumen',
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
    'hits' => 
    array (
      'field' => 'hits',
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
    'palabras_clave' => 
    array (
      'field' => 'palabras_clave',
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
    'categoria_id' => 
    array (
      'field' => 'categoria_id',
      'rules' => 
      array (
      ),
    ),
    'categorias' => 
    array (
      'field' => 'categorias',
      'rules' => 
      array (
      ),
    ),
    'marca_id' => 
    array (
      'field' => 'marca_id',
      'rules' => 
      array (
      ),
    ),
    'clave' => 
    array (
      'field' => 'clave',
      'rules' => 
      array (
      ),
    ),
    'presentacion' => 
    array (
      'field' => 'presentacion',
      'rules' => 
      array (
      ),
    ),
    'barrasindividual' => 
    array (
      'field' => 'barrasindividual',
      'rules' => 
      array (
      ),
    ),
    'barraspresentacion' => 
    array (
      'field' => 'barraspresentacion',
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
    'fecha_activacion' => 
    array (
      'field' => 'fecha_activacion',
      'rules' => 
      array (
      ),
    ),
    'fecha_desactivacion' => 
    array (
      'field' => 'fecha_desactivacion',
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
    'resumen_en' => 
    array (
      'field' => 'resumen_en',
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
    'metatitulo_en' => 
    array (
      'field' => 'metatitulo_en',
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
    'combinaciones' => 
    array (
      'field' => 'combinaciones',
      'rules' => 
      array (
      ),
    ),
    'SKU' => 
    array (
      'field' => 'SKU',
      'rules' => 
      array (
      ),
    ),
    'combinacion_imagenes' => 
    array (
      'field' => 'combinacion_imagenes',
      'rules' => 
      array (
      ),
    ),
    'stock' => 
    array (
      'field' => 'stock',
      'rules' => 
      array (
      ),
    ),
    'default' => 
    array (
      'field' => 'default',
      'rules' => 
      array (
      ),
    ),
    'comprar_sin_stock' => 
    array (
      'field' => 'comprar_sin_stock',
      'rules' => 
      array (
      ),
    ),
    'peso' => 
    array (
      'field' => 'peso',
      'rules' => 
      array (
      ),
    ),
    'caracteristicas' => 
    array (
      'field' => 'caracteristicas',
      'rules' => 
      array (
      ),
    ),
    'proveedor_id' => 
    array (
      'field' => 'proveedor_id',
      'rules' => 
      array (
      ),
    ),
    'agotado' => 
    array (
      'field' => 'agotado',
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
    'producto' => 
    array (
      'class' => 'producto',
      'other_field' => 'variante',
      'join_self_as' => 'variante',
      'join_other_as' => 'producto',
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