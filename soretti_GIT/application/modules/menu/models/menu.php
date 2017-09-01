<?php
class Menu extends DataMapper
{
	public $table='menus';
	public $error_prefix = '<div class="error">';
    public $error_suffix = '</div>';
    public $nestable_menu;
    public $arr_orden_links;
    public $success;

    public $has_many = array(
		'boton'
	);
	public $validation = array(
		'titulo' => array('rules' => array('required'))
	);

    function __construct($id=0){
		parent::__construct($id);
	}

	function nestable_menu()
	{
		$html  = '<div class="dd" id="nestable2">';
		$html .= $this->_nestable_menu();
		$html .= '</div>';

		$this->nestable_menu = $html;
	}
	function _nestable_menu($padre=0)
	{
		$html = "<ol class='dd-list'>";
		foreach ($this as $menu)
		{
			if($menu->boton->padre_id == $padre && $menu->boton->id != $padre){
				$html .= "<li class='dd-item' data-id='".$menu->boton->id."'>";
				$html .= "<div class='action-menu'><a class='btn' href='".base_url("modulo/menu/editar/".$menu->id."/".$menu->boton->id)."'><i class='glyphicon glyphicon-edit'></i></a>";
				$html .= "<a class='btn' href='".base_url("modulo/menu/eliminar_link/".$menu->boton->id)."'><i class='glyphicon glyphicon-remove'></i></a>";
				$html .= "</div>";
				$html .= "<div class='dd-handle'>".$menu->boton->titulo."</div>";
				$html .= $this->_nestable_menu($menu->boton->id);
				$html .= "</li>";
			}
		}
		$html .= "</ol>";
		return $html;
	}
	function ordenar_links()
	{
		$this->guardar_orden_links($this->arr_orden_links);
	}
	function guardar_orden_links($matriz, $posicion=0, $parent_id=0, $last_id=0)
	{
 		if (is_array($matriz)) foreach($matriz as $key=>$value){

 			if (is_array($value)){//si es un array sigo recorriendo

 				if($key == "children"){
 					$parent_id = $last_id;
 				}
 				if(is_numeric($key)){
 					$posicion = $key;
 				}
 				$this->guardar_orden_links($value, $posicion, $parent_id, $last_id);
		    }else{
		    	$last_id = $value;

		    	$boton = new Boton($value);
		    	$padre = new Boton($parent_id);
		    	$boton->posicion = $posicion;
				$boton->save(array('padre' => $padre));
		    }
		}
	}
	function recorre($link_id,$arr_orden_links,$padre_id=0)
	{
		for ($i=0; $i<sizeof($arr_orden_links); $i++)
		{
			if($arr_orden_links[$i]['id'] == $link_id){

				echo $padre_id;
				//return $padre_id;
			}
			if(array_key_exists('children', $arr_orden_links[$i])){
				$this->recorre($link_id,$arr_orden_links[$i]['children'],$arr_orden_links[$i]['id']);
			}
		}
	}
 
	function get_menu_categorias(){ 

		return $this->_get_menu_categorias();
	}

	function get_menu_principal(){
		return $this->_get_menu_principal();
	}

	function _get_menu_principal($padre=0,$i=1)
	{
		$html = "<ul";
		if($i==1 && ( !$this->profundidad || $this->profundidad > 0 ) ) $html .= " nav navbar-nav active' ";
		if($i==2) $html .= ' class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu" ';
		if($i>2) $html .= ' class="dropdown-menu" ';
		$html .= ">";
		foreach ($this as $key => $menu)
		{ 
			if($menu->boton->padre_id == $padre && $menu->boton->id != $padre){
				$sub='';
				$caret='';
				$niveles='';
				$sub_class='';
				$active='';

				$submenus=$this->_get_menu_principal($menu->boton->id,++$i);
				if($submenus){
					if($padre==0){
						$sub='data-toggle="dropdown" ' ;
						$sub_class='dropdown-toggle' ;
						$caret='<span class="caret"></span>';
					}
					if($i>2) $niveles='dropdown-submenu ';
				}

				$txt_len=strlen(uri_string());
				$array_uri=explode("/",uri_string());

				$link_menu=str_replace(".html",'',$menu->boton->link); 
				if(substr($link_menu,-$txt_len)==uri_string() && $menu->boton->link){
					$active='active';
				}elseif( !uri_string() && $menu->boton->link==site_url() ){
					$active='active';
				}



				if($array_uri[0]=='resultados' && isset($array_uri[1])){
					if(substr(str_replace(".html","", $menu->boton->link),-strlen($array_uri[1]))==$array_uri[1]){
						$active='active';
					}
				}

				$html .= "<li  class='$color'>";

				if($i==1){
					$html .= "<a href='".url_idioma($menu->boton->link)."' target='{$menu->boton->target}'  class='$sub_class' $sub ><span class='nivel1'>".$menu->boton->{'titulo'.IDIOMA}." </span>$caret<span class='nivel2'>".$menu->boton->{'titulo2'.IDIOMA}."</span></a>";
				}
				if($i>1){
					$html .= "<a href='".url_idioma($menu->boton->link)."' target='{$menu->boton->target}'  class='$sub_class' $sub >".$menu->boton->{'titulo'.IDIOMA}." $caret </a>";
				}
				$html .= $submenus;
				$html .= "</li>";
			}
		}
		$html .= "</ul>";
		if(!strstr($html,'<li')) return false;
		return $html;
	}


	function _get_menu_categorias($padre=0,$i=1,$color=null)
	{
		$html = "<ul";
		if($i==1 && ( !$this->profundidad || $this->profundidad > 0 ) ) $html .= " class='nav navbar-nav active' ";
		if($i==2) $html .= ' class="dropdown-menu multi-level  role="menu" aria-labelledby="dropdownMenu" ';
		if($i>2) $html .= ' class="dropdown-menu wow bounceIn '.$color.'" data-wow-duration="0.4s" ';
		$html .= ">";
		$result_count = $this->result_count();
		foreach ($this as $key => $menu)
		{
			if($padre==0){
				switch ($i) {
				    case 1:
				    	$color="";
				        break;
				}
			}

			if($menu->boton->padre_id == $padre && $menu->boton->id != $padre){
				$sub='';
				$caret='';
				$niveles='';
				$sub_class='';
				$active='';
				$type_menu='';
				$data_menu='';


				$submenus=$this->_get_menu_categorias($menu->boton->id,++$i,$color);
				if($submenus){
					if($padre==0){
						$sub='data-toggle="dropdown" ' ;
						$sub_class='dropdown-toggle ' ;
						$caret='<span class="caret"></span>';
					}
					if($i>2) $niveles='dropdown-submenu ';
				}

				if($padre==0){
					$data_menu='';
					$type_menu='';
				}

				$txt_len=strlen(uri_string());
				$array_uri=explode("/",uri_string()); 
 
				$link_menu=str_replace(".html",'',$menu->boton->link); 
				if(substr($link_menu,-$txt_len)==uri_string() && $menu->boton->link){
					$active='active';
				}elseif( !uri_string() && $menu->boton->link == site_url() ){
					$active='active';
				}

				if($array_uri[0]=='resultados' && isset($array_uri[1])){
					if(substr(str_replace(".html","", $menu->boton->link),-strlen($array_uri[1]))==$array_uri[1]){
						$active='active';
					}
				}

				$html .= "<li  class='$color $active'>";

				$html .= "<a href='".url_idioma($menu->boton->link)."' target='{$menu->boton->target}'  class='$sub_class $type_menu' $data_menu $sub >";

				$html .= $menu->boton->{'titulo'.IDIOMA};


				$html .= "$caret</a>";
				$html .= $submenus;
				$html .= "</li>";
			}
		}
		$html .= "</ul>";
		if(!strstr($html,'<li')) return false;
		return $html;
	}


	function get_menu_categorias2(){

		return $this->_get_menu_categorias2();
	}
	function _get_menu_categorias2($padre=0,$i=1)
	{
		$html = "<ul ";
		if($i==1){
			$html .= "class='nav'";
		}
		$html .= ">";
		foreach ($this as $key => $menu)
		{
			if($menu->boton->padre_id == $padre && $menu->boton->id != $padre){
				$html .= "<li>";
				$html .= "<a href='{$menu->boton->link}' target='{$menu->boton->target}'>{$menu->boton->titulo}<b></b></a>";
				$html .= $this->_get_menu_categorias2($menu->boton->id,++$i);
				$html .= "</li>";
			}
		}
		$html .= "</ul>";
		return $html;
	}
}
