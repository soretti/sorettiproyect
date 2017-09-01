<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'paginas',
  'fields' => 
  array (
    0 => 'id',
    1 => 'usuario_id',
    2 => 'fecha_creacion',
    3 => 'fecha_activacion',
    4 => 'fecha_desactivacion',
    5 => 'titulo',
    6 => 'metatitulo',
    7 => 'uri',
    8 => 'contenido',
    9 => 'datos',
    10 => 'hits',
    11 => 'palabras_clave',
    12 => 'descripcion',
    13 => 'plantilla',
    14 => 'tipo',
    15 => 'is_enable',
    16 => 'c_fecha',
    17 => 'c_usuario',
    18 => 'c_comentarios',
    19 => 'c_compartir',
    20 => 'c_contacto',
    21 => 'titulo_en',
    22 => 'contenido_en',
    23 => 'metatitulo_en',
    24 => 'descripcion_en',
    25 => 'palabras_clave_en',
    26 => 'c_categorias',
    27 => 'c_archivo',
    28 => 'c_ultimos_post',
  ),
  'validation' => 
  array (
    'titulo' => 
    array (
      'rules' => 
      array (
        0 => 'required',
        1 => 'unique',
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
    'id' => 
    array (
      'field' => 'id',
      'rules' => 
      array (
        0 => 'integer',
      ),
    ),
    'usuario_id' => 
    array (
      'field' => 'usuario_id',
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
    'contenido' => 
    array (
      'field' => 'contenido',
      'rules' => 
      array (
      ),
    ),
    'datos' => 
    array (
      'field' => 'datos',
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
    'palabras_clave' => 
    array (
      'field' => 'palabras_clave',
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
    'plantilla' => 
    array (
      'field' => 'plantilla',
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
    'is_enable' => 
    array (
      'field' => 'is_enable',
      'rules' => 
      array (
      ),
    ),
    'c_fecha' => 
    array (
      'field' => 'c_fecha',
      'rules' => 
      array (
      ),
    ),
    'c_usuario' => 
    array (
      'field' => 'c_usuario',
      'rules' => 
      array (
      ),
    ),
    'c_comentarios' => 
    array (
      'field' => 'c_comentarios',
      'rules' => 
      array (
      ),
    ),
    'c_compartir' => 
    array (
      'field' => 'c_compartir',
      'rules' => 
      array (
      ),
    ),
    'c_contacto' => 
    array (
      'field' => 'c_contacto',
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
    'contenido_en' => 
    array (
      'field' => 'contenido_en',
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
    'c_categorias' => 
    array (
      'field' => 'c_categorias',
      'rules' => 
      array (
      ),
    ),
    'c_archivo' => 
    array (
      'field' => 'c_archivo',
      'rules' => 
      array (
      ),
    ),
    'c_ultimos_post' => 
    array (
      'field' => 'c_ultimos_post',
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
    'articulo' => 
    array (
      'field' => 'articulo',
      'rules' => 
      array (
      ),
    ),
    'blog_categoria' => 
    array (
      'field' => 'blog_categoria',
      'rules' => 
      array (
      ),
    ),
    'galeriaimagenes' => 
    array (
      'field' => 'galeriaimagenes',
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
      'other_field' => 'pagina',
      'join_self_as' => 'pagina',
      'join_other_as' => 'usuario',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
  ),
  'has_many' => 
  array (
    'galeriaimagenes' => 
    array (
      'class' => 'galeriaimagenes',
      'other_field' => 'pagina',
      'join_self_as' => 'pagina',
      'join_other_as' => 'galeriaimagenes',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'articulo' => 
    array (
      'class' => 'articulo',
      'other_field' => 'pagina',
      'join_self_as' => 'pagina',
      'join_other_as' => 'articulo',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'blog_categoria' => 
    array (
      'class' => 'blog_categoria',
      'other_field' => 'pagina',
      'join_self_as' => 'pagina',
      'join_other_as' => 'blog_categoria',
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