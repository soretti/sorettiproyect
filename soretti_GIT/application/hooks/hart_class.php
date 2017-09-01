<?php 
class Hart_class
{

	function enconstruccion(){
	$CI =& get_instance();
		$proyecto=$CI->config->item('proyecto');
		if(isset($proyecto['enconstruccion']) && $proyecto['enconstruccion']==1 && !$CI->session->userdata('avances') && $CI->uri->segment(3)!='notificaciones')
		{
			echo modules::run('enconstruccion'); die();
		}
	}

	function idioma(){

		$CI =& get_instance();
		$proyecto=$CI->config->item('proyecto');
		$CI->config->set_item('idioma',$CI->config->item('language'));
		$idioma='';
		$uri_idioma=$CI->uri->segment(1);
		if(!$uri_idioma) $uri_idioma='es';

		if( isset($proyecto['idiomas']) && is_array($proyecto['idiomas'])  && in_array($uri_idioma, $proyecto['idiomas'])  ){
			$idioma="_".$uri_idioma;
			if($uri_idioma=='en')
				$CI->config->set_item('idioma','english');
		}
		if(!$idioma){
			$CI->config->set_item('idioma','spanish');
		}


		$CI->lang->is_loaded = array();
		$CI->lang->language = array();	 	
		$CI->lang->load('site', $CI->config->item('idioma') );
		$CI->lang->load('alerts', $CI->config->item('idioma'));
		$CI->lang->load('datamapper', $CI->config->item('idioma'));
		$CI->lang->load('form_validation', $CI->config->item('idioma'));

		define('IDIOMA', $idioma );
	}
	function tipocambio(){

		$CI =& get_instance();
		$query = $CI->db->get('tipo_cambio',1)->row();

		if(isset($query->tipocambio)) define('DOLAR',$query->tipocambio);
	}
}
 ?>