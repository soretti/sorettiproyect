<?php

class Producto extends DataMapper
{

	function __construct($id=null)
	{
		parent::__construct($id);
                            $this->load->helper('url');
                            $this->load->helper('captcha');
                            @session_start();
	}


	 public $table = "productos";
	 public $prefix = "cat_";
	 public $has_many= array('cat_imagen','destacado','vendido','variante','relacionado');
	 public $has_one= array(
        'proveedor',
	 	'cat_precio',
	 	'cat_marca'=>array('class' => 'cat_marca','join_table'=>'cat_marcas','join_other_as'=>'marca'),
	 	'cat_categoria'=>array('class' => 'cat_categoria','join_table'=>'cat_categorias','join_other_as'=>'categoria')
	 );

	 public $validation = array(
	 	'titulo' => array('label' => 'título','rules' => array('required','strip_tags','min_length' => 3)),
		'uri' => array('label' => 'uri','rules' => array('required','uri','unique','min_length' => 3)),
		'categoria_id' => array('label' => 'Categoría principal','rules' => array('required')),
		'fecha_creacion' => array('rules' => array('date')),
		'fecha_activacion' => array('rules' => array('date')),
		'fecha_desactivacion' => array('rules' => array('date')),
		'SKU' => array('rules' => array('required','unique'))

	);

    /*
	$producto_padre y combinacion incluir simpre la relacion de cat_precio
    */
    function precio($cantidad,$producto_padre,$combinacion=null){
               $ci =& get_instance();
                $this->load->model('catalogo/descuento');
                $this->load->model('usuario/usuario');

    	$porcentaje=0;
    	$precio_sin_promocion=0;

    	/*Porcentaje de descuento de la categoria*/
    	if($producto_padre->cat_categoria->porcentaje){
    		$porcentaje=$producto_padre->cat_categoria->porcentaje;
    	}else{
    		$porcentaje=$producto_padre->cat_categoria->porcentaje;
    		if(!$porcentaje) $porcentaje=$producto_padre->cat_categoria->padre->porcentaje;
    		if(!$porcentaje) $porcentaje=$producto_padre->cat_categoria->padre->padre->porcentaje;
    	}


    	if(isset($combinacion->cat_precio_precio) && $combinacion->cat_precio_precio )
    		$precio=$combinacion->cat_precio_precio;
    	else
    		$precio=$producto_padre->cat_precio->precio;



    	if(is_object($combinacion)){
    		if($combinacion->cat_precio_promocion){
    		    $precio_sin_promocion=$precio;
    			$precio=($combinacion->cat_precio_descuento_tipo=='cantidad') ? $combinacion->cat_precio_descuento_cantidad :  ( $precio - ( $precio * $combinacion->cat_precio_descuento_cantidad) / 100 );
    		}
    		if($combinacion->cat_precio_precio_mayoreo && $combinacion->cat_precio_cantidad && $cantidad>=$combinacion->cat_precio_cantidad ){
    			$precio = $combinacion->cat_precio_precio_mayoreo;
    		}
    	}else{
    		if($producto_padre->cat_precio->promocion){
                $is_active_promotion=1;
                $current = strtotime(date("Y-m-d H:i:s"));
                $ini = strtotime($producto_padre->cat_precio->activacion_promocion);
                $fin = strtotime($producto_padre->cat_precio->desactivacion_promocion);

                // if($producto_padre->cat_precio->activacion_promocion!='0000-00-00 00:00:00'  &&  $producto_padre->cat_precio->descactivacion_promocion!='0000-00-00 00:00:00' ){
                //     if($current < $ini || $current > $fin) $is_active_promotion=0;
                // }else
                if($producto_padre->cat_precio->activacion_promocion!='0000-00-00 00:00:00'){
                    if( $current < $ini ) $is_active_promotion=0;
                }
                if($producto_padre->cat_precio->desactivacion_promocion!='0000-00-00 00:00:00'){
                    if( $current > $fin ) $is_active_promotion=0;
                }

                if($is_active_promotion){
    			 $precio_sin_promocion=$precio;
    			 $precio=($producto_padre->cat_precio->descuento_tipo=='cantidad') ? $producto_padre->cat_precio->descuento_cantidad :  ( $precio - ( $precio * $producto_padre->cat_precio->descuento_cantidad) / 100 );
    		    }
            }
    		if($producto_padre->cat_precio->precio_mayoreo && $producto_padre->cat_precio->cantidad && $cantidad>=$producto_padre->cat_precio->cantidad ){
    			$precio = $producto_padre->cat_precio->precio_mayoreo;
    		}
    	}



    	if($producto_padre->cat_precio->impuesto){

    		$precio_sin_promocion = $precio_sin_promocion + ( ($producto_padre->cat_precio->impuesto *  $precio_sin_promocion)/100 );
    		$precio = $precio + ( ($producto_padre->cat_precio->impuesto *  $precio)/100 );
    	}


    	if($producto_padre->cat_precio->moneda=='dolar'){
    		$precio_sin_promocion = $precio_sin_promocion * DOLAR;
    		$precio = $precio * DOLAR;
    	}

    	if($porcentaje){
    		$precio_sin_promocion=(($porcentaje*$precio_sin_promocion)/100)+$precio_sin_promocion;
    		$precio=(($porcentaje*$precio)/100)+$precio;
    	}

        if($ci ->session->userdata('usuario_id')){ //Sacar precio con descuentos segun el usuario.
                $usuario = new Usuario();
                $usuario->include_related('descuento')->where('id', $ci ->session->userdata('usuario_id'))->get();
                if($precio_sin_promocion) $final_precio=$precio_sin_promocion; else  $final_precio=$precio; 
                if($usuario->descuento_id) $precio = ($final_precio-($final_precio*($usuario->descuento->porcentaje/100)));
        }

    	return array('precio'=>$precio,'precio_sin_promocion'=>$precio_sin_promocion);
    }

    function stock($producto_padre,$combinacion=''){

    	if(isset($combinacion) && $combinacion->stock)
    		$stock=$combinacion->stock;
    	else
    		$stock=$producto_padre->stock;
    	return $stock;
    }

    function weight($producto_padre,$combinacion=''){

    	if(isset($combinacion->peso) && $combinacion->peso)
    		$peso=$combinacion->peso;
    	else
    		$peso=$producto_padre->peso;

    	return $peso;
    }


	 function _uri($field)
	{
		$this->{$field}=url_title($this->{$field});
		return TRUE;
	}

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

	function is_active()
	{
		$this->where("fecha_activacion <= '".date('Y-m-d H:i:s')."'",null);
	        	$this->where("if(fecha_desactivacion='0000-00-00 00:00:00',1,  if(fecha_desactivacion >= '".date('Y-m-d H:i:s')."',1,0) )",null);
	        	$this->where('is_enable',1);
	        	return $this;
	}

}
