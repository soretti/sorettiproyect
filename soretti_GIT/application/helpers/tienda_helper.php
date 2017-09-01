<?php

function is_logged_in() {

	$ci = & get_instance();


	$user_id = $ci->session->userdata('usuario_id');

	if($user_id=="" || !$user_id ) {
		return false;
	}

	return true;
}

function identificar($redirect='') {

	if(!is_logged_in()) {
		if($redirect) $redirect="?to=$redirect";
		header("location:".site_url('tienda/cuenta/login').$redirect);
	}
}

function precioVenta($precioProduco,$cuponDescuento,$mayoreoDescuento){



            if($cuponDescuento>0){
                    $descuentocupon=(($precioProduco*$cuponDescuento)/100);
            }else{
                    $descuentocupon=0;
            }
            $precioventa=$precioProduco-$descuentocupon;

            if($mayoreoDescuento>0){
                    $descuentomayoreo=(($precioventa*$mayoreoDescuento)/100);
            }else{
                    $descuentomayoreo=0;
            }
            $precioventa=$precioventa-$descuentomayoreo;

            return $precioventa;
}

function precioDistribuidor($precioProduco,$descuentoDistribuidor){


            if($descuentoDistribuidor){
                $precioProduco=( $precioProduco-(($precioProduco*$descuentoDistribuidor)/100) );
            }

            return $precioProduco;
}
