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
    'titulo' => 
    array (
      'label' => 'título',
      'rules' => 
      array (
        0 => 'required',
        1 => 'strip_tags',
        'min_length' => 3,
      ),
      'field' => 'titulo',
    ),
    'uri' => 
    array (
      'label' => 'uri',
      'rules' => 
      array (
        0 => 'required',
        1 => 'uri',
        2 => 'unique',
        'min_length' => 3,
      ),
      'field' => 'uri',
    ),
    'categoria_id' => 
    array (
      'label' => 'Categoría principal',
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'categoria_id',
    ),
    'fecha_creacion' => 
    array (
      'rules' => 
      array (
        0 => 'date',
      ),
      'field' => 'fecha_creacion',
    ),
    'fecha_activacion' => 
    array (
      'rules' => 
      array (
        0 => 'date',
      ),
      'field' => 'fecha_activacion',
    ),
    'fecha_desactivacion' => 
    array (
      'rules' => 
      array (
        0 => 'date',
      ),
      'field' => 'fecha_desactivacion',
    ),
    'SKU' => 
    array (
      'rules' => 
      array (
        0 => 'required',
        1 => 'unique',
      ),
      'field' => 'SKU',
    ),
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
    'proveedor' => 
    array (
      'field' => 'proveedor',
      'rules' => 
      array (
      ),
    ),
    'cat_precio' => 
    array (
      'field' => 'cat_precio',
      'rules' => 
      array (
      ),
    ),
    'cat_marca' => 
    array (
      'field' => 'cat_marca',
      'rules' => 
      array (
      ),
    ),
    'cat_categoria' => 
    array (
      'field' => 'cat_categoria',
      'rules' => 
      array (
      ),
    ),
    'cat_imagen' => 
    array (
      'field' => 'cat_imagen',
      'rules' => 
      array (
      ),
    ),
    'destacado' => 
    array (
      'field' => 'destacado',
      'rules' => 
      array (
      ),
    ),
    'vendido' => 
    array (
      'field' => 'vendido',
      'rules' => 
      array (
      ),
    ),
    'variante' => 
    array (
      'field' => 'variante',
      'rules' => 
      array (
      ),
    ),
    'relacionado' => 
    array (
      'field' => 'relacionado',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
    'cat_marca' => 
    array (
      'class' => 'cat_marca',
      'join_table' => 'cat_marcas',
      'join_other_as' => 'marca',
      'other_field' => 'producto',
      'join_self_as' => 'producto',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'cat_categoria' => 
    array (
      'class' => 'cat_categoria',
      'join_table' => 'cat_categorias',
      'join_other_as' => 'categoria',
      'other_field' => 'producto',
      'join_self_as' => 'producto',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'proveedor' => 
    array (
      'class' => 'proveedor',
      'other_field' => 'producto',
      'join_self_as' => 'producto',
      'join_other_as' => 'proveedor',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'cat_precio' => 
    array (
      'class' => 'cat_precio',
      'other_field' => 'producto',
      'join_self_as' => 'producto',
      'join_other_as' => 'cat_precio',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
  ),
  'has_many' => 
  array (
    'cat_imagen' => 
    array (
      'class' => 'cat_imagen',
      'other_field' => 'producto',
      'join_self_as' => 'producto',
      'join_other_as' => 'cat_imagen',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'destacado' => 
    array (
      'class' => 'destacado',
      'other_field' => 'producto',
      'join_self_as' => 'producto',
      'join_other_as' => 'destacado',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'vendido' => 
    array (
      'class' => 'vendido',
      'other_field' => 'producto',
      'join_self_as' => 'producto',
      'join_other_as' => 'vendido',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'variante' => 
    array (
      'class' => 'variante',
      'other_field' => 'producto',
      'join_self_as' => 'producto',
      'join_other_as' => 'variante',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'relacionado' => 
    array (
      'class' => 'relacionado',
      'other_field' => 'producto',
      'join_self_as' => 'producto',
      'join_other_as' => 'relacionado',
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