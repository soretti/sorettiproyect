<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'blog_articulos',
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
    10 => 'palabras_clave',
    11 => 'resumen',
    12 => 'resumen_imagen',
    13 => 'pie',
    14 => 'perfil',
    15 => 'is_enable',
    16 => 'pagina_id',
    17 => 'categoria_id',
    18 => 'hits',
    19 => 'titulo_en',
    20 => 'metatitulo_en',
    21 => 'contenido_en',
    22 => 'datos_en',
    23 => 'palabras_clave_en',
    24 => 'resumen_en',
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
    'pagina_id' => 
    array (
      'rules' => 
      array (
        0 => 'required',
      ),
      'field' => 'pagina_id',
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
    'palabras_clave' => 
    array (
      'field' => 'palabras_clave',
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
    'resumen_imagen' => 
    array (
      'field' => 'resumen_imagen',
      'rules' => 
      array (
      ),
    ),
    'pie' => 
    array (
      'field' => 'pie',
      'rules' => 
      array (
      ),
    ),
    'perfil' => 
    array (
      'field' => 'perfil',
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
    'hits' => 
    array (
      'field' => 'hits',
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
    'contenido_en' => 
    array (
      'field' => 'contenido_en',
      'rules' => 
      array (
      ),
    ),
    'datos_en' => 
    array (
      'field' => 'datos_en',
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
    'resumen_en' => 
    array (
      'field' => 'resumen_en',
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
    'blog_categoria' => 
    array (
      'field' => 'blog_categoria',
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
    'blog_categoria' => 
    array (
      'class' => 'blog_categoria',
      'join_table' => 'blog_categorias',
      'other_field' => 'categoria',
      'join_other_as' => 'categoria',
      'join_self_as' => 'categoria',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'pagina' => 
    array (
      'class' => 'pagina',
      'other_field' => 'articulo',
      'join_self_as' => 'articulo',
      'join_other_as' => 'pagina',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
    'usuario' => 
    array (
      'class' => 'usuario',
      'other_field' => 'articulo',
      'join_self_as' => 'articulo',
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