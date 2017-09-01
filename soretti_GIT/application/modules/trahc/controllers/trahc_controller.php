<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 
   class Trahc_controller extends CI_Controller {

	function __construct()
	{
 		 parent::__construct();
 		 $this->load->helper('file');
	}
 
	public function crud($modulo,$table)
	{
		

		mkdir (APPPATH."modules/".$modulo);
		mkdir (APPPATH."modules/".$modulo."/controllers");
		mkdir (APPPATH."modules/".$modulo."/models");
		mkdir (APPPATH."modules/".$modulo."/views");
		
		$set_post='';
		$string_model = read_file(APPPATH."modules/trahc/models/clonmodel.php");
		$string_model=str_replace('{{table}}',$table,$string_model);
		$string_model=str_replace('{{nombre_modelo}}',ucfirst($modulo),$string_model);

		$fields = $this->db->list_fields($table);


		if(!file_exists(APPPATH."modules/".$modulo."/models/".$modulo.".php"))
		{
			write_file(APPPATH."modules/".$modulo."/models/".$modulo.".php", $string_model);
		}



		//Controllador
		$nombre_controlador=$modulo."_controller";
		$string_controller = read_file(APPPATH."modules/trahc/controllers/clonecontroller.php");
		$string_controller=str_replace('{{table}}',$table,$string_controller);
		$string_controller=str_replace('{{nombre_modelo}}',ucfirst($modulo),$string_controller);
		$string_controller=str_replace('{{object_modelo}}',strtolower($modulo),$string_controller);
		$string_controller=str_replace('{{nombre_controller}}',ucfirst($modulo),$string_controller);
		$string_controller=str_replace('{{permiso_controller}}',strtolower($modulo),$string_controller);
 
 		$list_fields='';
 		$like_fields='';
 		foreach ($fields as $field)
		{
		    if($field!='id' && $field!='is_enable' && $field!='sort'){ 
		    	$like_fields.=' \''.$field.'\' => $like_text,';
		    	$list_fields.=' \''.$field.'\',';
		    }
		}
		$like_fields=substr($like_fields,0,-1);
		$list_fields=substr($list_fields,0,-1);

		$string_controller=str_replace('{{list_fields}}',$list_fields,$string_controller);
		$string_controller=str_replace('{{like_fields}}',$like_fields,$string_controller);

		if(!file_exists(APPPATH."modules/".$modulo."/controllers/".$nombre_controlador.".php"))
		{
			write_file(APPPATH."modules/".$modulo."/controllers/".$nombre_controlador.".php", $string_controller);
		}

		//Generando vista form
		$string_form = read_file(APPPATH."modules/trahc/views/clone_form.php");
		$string_form=str_replace('{{permiso_controller}}',strtolower($modulo),$string_form);
		$string_form=str_replace('{{object_modelo}}',strtolower($modulo),$string_form);

		$form='';
 

		foreach ($fields as $field)
		{
		    if($field!='id' && $field!='is_enable' && $field!='sort'){
		    	$form.='<div class="form-group">
	                        <label>'.ucfirst($field).': </label>
	                        <input type="text" name="'.$field.'" value="<?php echo $'.strtolower($modulo).'->'.$field.'; ?>">             
                        </div>

                       ';
		     }
		}
		$string_form=str_replace('{{form}}',$form,$string_form);

		if(!file_exists(APPPATH."modules/".$modulo."/views/form.php"))
		{
			write_file(APPPATH."modules/".$modulo."/views/form.php", $string_form);
		} 

		//Generando vista grid
		$string_form = read_file(APPPATH."modules/trahc/views/clone_grid.php");
		$string_form=str_replace('{{permiso_controller}}',strtolower($nombre_controlador),$string_form);


		$encabezados='';
		$campos='';
		foreach ($fields as $field)
		{
		    if($field!='id'  && $field!='is_enable' && $field!='sort'){
		    	$encabezados.='<th class="titulo_campos" campo="'.$field.'">'.strtoupper($field).' <?php if($order[0]=="'.$field.'") echo "<i class=\'icon-chevron-$ico_order icon-white\'></i>"; ?></th>
		    			';
		     }
		}
		foreach ($fields as $field)
		{
		    if($field!='id'  && $field!='is_enable' && $field!='sort'){
		    	$campos.='<td nowrap><?php echo $item->'.$field.'; ?></td>
		    			 ';
		     }
		}
		$string_form=str_replace('{{encabezados}}',$encabezados,$string_form);
		$string_form=str_replace('{{campos}}',$campos,$string_form);
		$string_form=str_replace('{{object_modelo}}',strtolower($modulo),$string_form);



		if(!file_exists(APPPATH."modules/".$modulo."/views/grid.php"))
		{
			write_file(APPPATH."modules/".$modulo."/views/grid.php", $string_form);
		}

	}
}