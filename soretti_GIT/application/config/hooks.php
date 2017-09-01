<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */


$hook['pre_controller'][] = array(
                                'class'    => 'hart_class',
                                'function' => 'idioma',
                                'filename' => 'hart_class.php',
                                'filepath' => 'hooks',
                                'params'   => array()
                                );

$hook['pre_controller'][] = array(
                                'class'    => 'hart_class',
                                'function' => 'enconstruccion',
                                'filename' => 'hart_class.php',
                                'filepath' => 'hooks',
                                'params'   => array()
                                );

$hook['pre_controller'][] = array(
                                'class'    => 'hart_class',
                                'function' => 'tipocambio',
                                'filename' => 'hart_class.php',
                                'filepath' => 'hooks',
                                'params'   => array()
                                );




