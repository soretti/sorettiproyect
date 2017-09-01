<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$cache = array (
  'table' => 'bloquecontenidos',
  'fields' => 
  array (
    0 => 'id',
    1 => 'bloque_id',
    2 => 'titulo',
    3 => 'visible',
    4 => 'subtitulo',
    5 => 'texto',
    6 => 'imagen',
    7 => 'imagen2',
    8 => 'liga',
    9 => 'target',
    10 => 'is_enable',
    11 => 'sort',
    12 => 'fecha_creacion',
    13 => 'fecha_activacion',
    14 => 'fecha_desactivacion',
    15 => 'titulo_en',
    16 => 'subtitulo_en',
    17 => 'texto_en',
    18 => 'categoria_id',
    19 => 'titulo_imagen',
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
    'bloque_id' => 
    array (
      'field' => 'bloque_id',
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
    'visible' => 
    array (
      'field' => 'visible',
      'rules' => 
      array (
      ),
    ),
    'subtitulo' => 
    array (
      'field' => 'subtitulo',
      'rules' => 
      array (
      ),
    ),
    'texto' => 
    array (
      'field' => 'texto',
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
    'imagen2' => 
    array (
      'field' => 'imagen2',
      'rules' => 
      array (
      ),
    ),
    'liga' => 
    array (
      'field' => 'liga',
      'rules' => 
      array (
      ),
    ),
    'target' => 
    array (
      'field' => 'target',
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
    'sort' => 
    array (
      'field' => 'sort',
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
    'subtitulo_en' => 
    array (
      'field' => 'subtitulo_en',
      'rules' => 
      array (
      ),
    ),
    'texto_en' => 
    array (
      'field' => 'texto_en',
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
    'titulo_imagen' => 
    array (
      'field' => 'titulo_imagen',
      'rules' => 
      array (
      ),
    ),
    'bloque' => 
    array (
      'field' => 'bloque',
      'rules' => 
      array (
      ),
    ),
    'mapa' => 
    array (
      'field' => 'mapa',
      'rules' => 
      array (
      ),
    ),
  ),
  'has_one' => 
  array (
    'bloque' => 
    array (
      'class' => 'bloque',
      'other_field' => 'bloquecontenido',
      'join_self_as' => 'bloquecontenido',
      'join_other_as' => 'bloque',
      'join_table' => '',
      'reciprocal' => false,
      'auto_populate' => NULL,
      'cascade_delete' => true,
    ),
  ),
  'has_many' => 
  array (
    'mapa' => 
    array (
      'join_table' => 'mapas',
      'class' => 'mapa',
      'other_field' => 'bloquecontenido',
      'join_self_as' => 'bloquecontenido',
      'join_other_as' => 'mapa',
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