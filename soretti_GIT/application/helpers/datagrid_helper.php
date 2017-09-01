<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

	/*
		@$key nombre de la variable que mantendra la session
	*/
	function filter_columns($key,$allow){
			$CI =& get_instance();
			/*Filtros de busqueda*/
			$filters=array();
			if($CI->input->post('filter')){
				foreach ( $CI->input->post('filter') as $field=>$value) if(in_array($field, $allow) && isset($value))  {
					if($value!=null)$filters[$field]=$value;
				}
			 	$CI->session->set_userdata($key,$filters);
			}
			$filters=array();
			if($CI->session->userdata($key)){
				foreach ($CI->session->userdata($key) as $field => $value) if(in_array($field, $allow)  && isset($value)){
					$field_array=explode("-",$field);    
				    if(isset($field_array[1])) $field=$field_array[0].".".$field_array[1];
					if($value!=null)$filters[$field]=$value;	
				}
			}
			return $filters;
	}

	/*
	 @ $allow campos permitidos para ordenar la tabla 
	*/
	function order_columns($allow){
			$CI =& get_instance();
			$order=($CI->input->get('order') && in_array($CI->input->get('order'), $allow)) ? $CI->input->get('order') : current($allow);
			$direction=($CI->input->get('direction') && (strtolower($CI->input->get('direction'))=='asc' || strtolower($CI->input->get('direction'))=='desc' ) ) ? $CI->input->get('direction') : 'asc';
			$field_array=explode("-",$order);    
			if(isset($field_array[1])) $order=$field_array[0].".".$field_array[1];
			return array($order,$direction);
	}
	
	function pagination(){
			$CI =& get_instance();
			$byPage=($CI->input->get('byPage') && is_numeric($CI->input->get('byPage')) && $CI->input->get('byPage') <= 30)  ? $CI->input->get('byPage') : 10;
			$pagina=($CI->input->get('pagina') && is_numeric($CI->input->get('pagina')) && $CI->input->get('pagina')>0) ? $CI->input->get('pagina')-1 : 0;
        	$offset=($pagina*$byPage);
        	return array($byPage,$offset);
	}

		function find_matches($array, $value) {
		    $found = array();
		    array_walk_recursive($array,
		        function ($item, $key) use ($value, &$found) {
		            if ($value === $key) {
		                $found[] = $item;
		            }
		        }
		    );
		    return $found;
		}

