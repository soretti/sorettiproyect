<?php

class Cat_categoria extends DataMapper
{
    public $lista_w=300;
    public $lista_h=221;

	public $table='categorias';
    public $prefix = "cat_";
    public $primary_selected;
    public $multiple_selected=array();

	public $error_prefix = '<div class="error">';
    public $error_suffix = '</div>';
    public $success;
    
    
    public $has_one = array(
        'padre' => array(
        	'class' => 'cat_categoria',
            'other_field' => 'related_link',
            'join_self_as'=>'padre'
        )
	);

	public $has_many = array(
        'related_link' => array(
            'class' => 'cat_categoria',
            'other_field' => 'padre'
         ),'producto'=>array('class' => 'producto' ,'join_table'=>'cat_productos','join_self_as'=>'categoria')
	);

    function __construct($id=0){
		parent::__construct($id);
	}

	public $validation = array(
		'titulo' => array('rules' => array('required')),
        'uri' => array('rules' => array('uri','required','unique')),
        'activacion_promocion' => array('rules' => array('date')),
        'desactivacion_promocion' => array('rules' => array('date')),
	);

    function _date($field)
    {
        $fecha=explode(" ",$this->{$field});
        if(count($fecha)<2)
        {
            return FALSE;
        }
        if( strstr($fecha[0], '/') )
        {
            list($day,$month,$year)=explode("/",$fecha[0]);
            $this->{$field}= $year."-".$month."-".$day." ".$fecha[1].":00";
        }
        return TRUE;
    }
    
	function _uri($field)
	{
		$this->{$field}=url_title($this->{$field});
		return TRUE;
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
            if($menu->padre_id == $padre && $menu->id != $padre){
                $html .= "<li class='dd-item' data-id='".$menu->id."'>";
                $html .= "<div class='action-menu'><a class='btn' href='".base_url("modulo/catalogo/catalogocategoria/editar/".$menu->id)."'><i class='glyphicon glyphicon-edit'></i></a>";
                $html .= "<a class='btn' href='".base_url("modulo/catalogo/catalogocategoria/eliminar_link/".$menu->id)."'><i class='glyphicon glyphicon-remove'></i></a>";
                $html .= "<a class='btn seleccionar' value='".$menu->id."' titulo='".$menu->titulo."' uri='".base_url("catalogo/".$menu->uri)."'><i class='glyphicon glyphicon-ok'></i></a>";
                if($menu->porcentaje) $html .= " <span class='porcentaje'> + ".$menu->porcentaje."% </span>";
                $html .= "</div>";
                $html .= "<div class='dd-handle'>".$menu->titulo." </div>";
                $html .= $this->_nestable_menu($menu->id);
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

                $boton = new cat_categoria($value);
                $padre = new cat_categoria($parent_id);
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

            }
            if(array_key_exists('children', $arr_orden_links[$i])){
                $this->recorre($link_id,$arr_orden_links[$i]['children'],$arr_orden_links[$i]['id']);
            }
        }
    }



    function get_menu_categorias3($multiple=0){

        return $this->_get_menu_categorias3($padre=0,$i=1,$multiple);
    }

    function _get_menu_categorias3($padre=0,$i=1,$multiple=0)
    {
        $CI =& get_instance();
        $html = "<ul>";
        foreach ($this as $key => $menu)
        {
            if($menu->padre_id == $padre && $menu->id != $padre){
                $selected='';

                $submenus=$this->_get_menu_categorias3($menu->id,++$i,$multiple);

                $html .= "<li>";
          

                if($multiple){
                    if( in_array($menu->id, $this->multiple_selected)) $selected='checked'; 
                    $html .= "<input type='checkbox' name='categorias[]' value='{$menu->id}' $selected id='opt{$menu->id}' > <label for='opt{$menu->id}' class='label-categorias $selected'>{$menu->titulo}</label>";
                }
                else{
                    if($menu->id==$this->primary_selected) $selected='checked';                    
                     $html .= "<input type='radio' name='categoria_id' value='{$menu->id}'  $selected id='opt{$menu->id}' > <label for='opt{$menu->id}' class='label-categorias $selected'>{$menu->titulo}</label>";
                }

                $html .= $submenus;
                $html .= "</li>";
            }
        }
        $html .= "</ul>";
        if(!strstr($html,'<li')) return false;
        return $html;
    }

    function get_menu_categorias(){

        return $this->_get_menu_categorias();
    }

    function _get_menu_categorias($padre=0,$i=1)
    {
        $CI =& get_instance();
        $html = "<ul";
        if($i==1 && ( !$this->profundidad || $this->profundidad > 1 ) ) $html .= " class='nav navbar-nav' ";
        if($i==2) $html .= ' class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu" ';
        if($i>2) $html .= ' class="dropdown-menu" ';
        $html .= ">";
        foreach ($this as $key => $menu)
        {
            if($menu->padre_id == $padre && $menu->id != $padre){
                $sub='';
                $caret='';
                $niveles='';
                $sub_class='';
                $active='';

                $submenus=$this->_get_menu_categorias($menu->id,++$i);
                if($submenus){
                    if($padre==0){
                        $sub='data-toggle="dropdown" ' ;
                        $sub_class='dropdown-toggle ' ;
                        $caret='<b class="caret"></b>';
                    }
                    if($i>2) $niveles='dropdown-submenu ';
                } 
                $txt_len=strlen(uri_string());
                $array_uri=explode("/",uri_string());

                if($CI->uri->segment(3)==$menu->uri){
                    $active='isExpanded';
                }

                // if($array_uri[0]=='categoria' && isset($array_uri[1])){
                //     if(substr(str_replace(".html","", $menu->link),-strlen($array_uri[1]))==$array_uri[1]){
                //         $active='isExpanded active';
                //     }
                // }

                if($key == 0){
                    $html .= "<li class='".$active."' >";
                }else{
                    $html .= "<li class='".$active."' >";
                } 

                $html .= "<a href='".base_url('catalogo/'.$menu->uri)."' target='_self' >{$menu->titulo}</a>";
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
            if($menu->padre_id == $padre && $menu->id != $padre){
                $html .= "<li>";
                $html .= "<a href='{$menu->link}' target='{$menu->target}'>{$menu->titulo}<b></b></a>";
                $html .= $this->_get_menu_categorias2($menu->id,++$i);
                $html .= "</li>";
            }
        }
        $html .= "</ul>";
        return $html;
    }



 function get_menu_categorias4(){

        return $this->_get_menu_categorias4();
    }

    function _get_menu_categorias4($padre=0,$i=1)
    {
        $CI =& get_instance();
        $html = "<ul";
        if($i==1 && ( !$this->profundidad || $this->profundidad > 1 ) ) $html .= " class='nav navbar-nav' ";
        if($i==2) $html .= ' class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu" ';
        if($i>2) $html .= ' class="dropdown-menu" ';
        $html .= ">";
        foreach ($this as $key => $menu)
        {
            if($menu->padre_id == $padre && $menu->id != $padre){
                $sub='';
                $caret='';
                $niveles='';
                $sub_class='';
                $active='';

                $submenus=$this->_get_menu_categorias4($menu->id,++$i);
                if($submenus){
                    if($padre==0){
                        $sub='data-toggle="dropdown" ' ;
                        $sub_class='dropdown-toggle ' ;
                        $caret='<b class="caret"></b>';
                    }
                    if($i>2) $niveles='dropdown-submenu ';
                } 
                $txt_len=strlen(uri_string());
                $array_uri=explode("/",uri_string());

                if($CI->uri->segment(3)==$menu->uri){
                    $active='isExpanded';
                }

                // if($array_uri[0]=='categoria' && isset($array_uri[1])){
                //     if(substr(str_replace(".html","", $menu->link),-strlen($array_uri[1]))==$array_uri[1]){
                //         $active='isExpanded active';
                //     }
                // }

                if($key == 0){
                    $html .= "<li  class=' $active $niveles'  id='first'>";
                }else{
                    $html .= "<li class=' $active $niveles' >";
                } 

                $html .= "<a href='".url_idioma(base_url('catalogo/'.$menu->uri.".html"))."' target='_self' class='$sub_class' $sub  >".$menu->{'titulo'.IDIOMA}."</a>";
                $html .= $submenus;
                $html .= "</li>";
            }
        }
        $html .= "</ul>";
        if(!strstr($html,'<li')) return false;
        return $html;
    }




}
