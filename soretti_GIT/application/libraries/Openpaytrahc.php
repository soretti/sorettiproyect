<?php

Class Openpaytrahc{
 

	function string_to_openpay($string){
		$string=str_replace("á","a",$string);
		$string=str_replace("é","e",$string);
		$string=str_replace("í","i",$string);
		$string=str_replace("ó","o",$string);
		$string=str_replace("ú","u",$string);
		$string=str_replace("ñ","n",$string);

		$string=str_replace("Á","A",$string);
		$string=str_replace("É","E",$string);
		$string=str_replace("Í","I",$string);
		$string=str_replace("Ó","O",$string);
		$string=str_replace("Ú","U",$string);
		$string=str_replace("Ñ","N",$string);
		return $string;
	}

	function hook(){
 		$CI=& get_instance();
 		$CI->load->model('tienda/order');

	    $body = file_get_contents('php://input');
		$response = json_decode($body);

		if ($response->type == 'charge.succeeded' && ($response->transaction->method == 'store' || $response->transaction->method == 'bank_account' || $response->transaction->method == 'card')) {
			$CI->order->where('id',$response->transaction->order_id)->get();
			// $CI->order->datos_banco=json_decode($CI->order->datos_banco,true);
			$CI->order->estatus=2;
			$CI->order->pago_fecha=date('Y-m-d H:i:s');
			$CI->order->pago_referencia=$response->transaction->authorization;
			//$CI->order->datos_banco=json_encode($CI->order->datos_banco,true);
			//$CI->order->datos_banco['referencia']=$event_json->transaction->authorization;
			$CI->order->save();
			modules::run('tienda/checkout/_enviar_mail',$CI->order->id);
		}
	}

	function tiendas_de_conveniencia($order){

			$CI=& get_instance();

			$fecha_limite_pago=addfecha(date('Y-m-d H:i:s'),3);
			list($fecha,$hora)=explode(" ",$fecha_limite_pago);

			require_once(APPPATH."libraries/openpay/Openpay.php");
			Openpay::setProductionMode(true);

			$configOpenpay=$CI->config->item('openpay','proyecto');

			$openpay = Openpay::getInstance($configOpenpay['openpay_id'],$configOpenpay['openpay_llave_privada']);

			$usuario=json_decode($order->datos_usuario);
			$envio=json_decode($order->datos_envio);
			$pago=json_decode($order->datos_pago);

			$customer = array( 
			'name' => $this->string_to_openpay($usuario->nombre), 
			'last_name' => $this->string_to_openpay($usuario->apellidoPaterno." ".$usuario->apellidoMaterno), 
			'phone_number' => $usuario->lada." ".  $usuario->telefono,
			'email' => $this->string_to_openpay($usuario->email), 
				'address' => array( 
				'line1' => 'Calle: '.$this->string_to_openpay($envio->calle), 
				'line2' => 'Colonia: '.$this->string_to_openpay($envio->colonia), 
				'line3' => 'Numero: '.$this->string_to_openpay($envio->numero_ext), 
				'state' => $this->string_to_openpay($envio->estado), 
				'city' => $this->string_to_openpay($envio->municipio), 
				'postal_code' => $envio->codigo, 
				'country_code' => 'MX' 
				) 
			);
		
			$chargeData = array(
		    'method' => 'store',
		    'amount' => number_format($pago->total, 2, '.', '') ,
		    'order_id' => $order->id,
		    'description' => 'Cargo a tienda',
		    'customer' => $customer
		    );

			try {
			  $charge = $openpay->charges->create($chargeData);
			  $order->datos_banco=json_encode(array('barcode_url'=>$charge->payment_method->barcode_url, 'reference'=>$charge->payment_method->reference));
			  $order->save();

			} catch (OpenpayApiTransactionError $e) {

			  $data_c['error']='ERROR en la transacción: ' . $e->getMessage();
			  ob_start();
			  echo "<pre>";
			  print_r($e->getMessage());
			  $html_email=ob_get_contents();
			  ob_clean();
			  mail('ob@paginasweb.mx','respuesta',$html_email);
			}

	}

	function cargo_banco($order){

			$CI=& get_instance();

			$fecha_limite_pago=addfecha(date('Y-m-d H:i:s'),3);
			list($fecha,$hora)=explode(" ",$fecha_limite_pago);

			require_once(APPPATH."libraries/openpay/Openpay.php");
			Openpay::setProductionMode(true);

			$configOpenpay=$CI->config->item('openpay','proyecto');

			$openpay = Openpay::getInstance($configOpenpay['openpay_id'],$configOpenpay['openpay_llave_privada']);

			$usuario=json_decode($order->datos_usuario);
			$envio=json_decode($order->datos_envio);
			$pago=json_decode($order->datos_pago);

			$customer = array( 
			'name' => $this->string_to_openpay($usuario->nombre), 
			'last_name' => $this->string_to_openpay($usuario->apellidoPaterno." ".$usuario->apellidoMaterno), 
			'phone_number' => $usuario->lada." ".  $usuario->telefono,
			'email' => $this->string_to_openpay($usuario->email), 
				'address' => array( 
				'line1' => 'Calle: '.$this->string_to_openpay($envio->calle), 
				'line2' => 'Colonia: '.$this->string_to_openpay($envio->colonia), 
				'line3' => 'Numero: '.$this->string_to_openpay($envio->numero_ext), 
				'state' => $this->string_to_openpay($envio->estado), 
				'city' => $this->string_to_openpay($envio->municipio), 
				'postal_code' => $envio->codigo, 
				'country_code' => 'MX' 
				) 
			);
		
			$chargeData = array(
		    'method' => 'bank_account',
		    'amount' => number_format($pago->total, 2, '.', '') ,
		    'description' => 'Cargo con banco',
		    'order_id' => $order->id,
		    'customer' => $customer
		    );

			try {
			  $charge = $openpay->charges->create($chargeData);
			  $order->datos_banco=json_encode(array('clabe'=>$charge->payment_method->clabe, 'name'=>$charge->payment_method->name));
			  $order->save();

			} catch (OpenpayApiTransactionError $e) {

			  $data_c['error']='ERROR en la transacción: ' . $e->getMessage();
			  ob_start();
			  echo "<pre>";
			  print_r($e->getMessage());
			  $html_email=ob_get_contents();
			  ob_clean();
			  mail('ob@paginasweb.mx','respuesta',$html_email);

			}

	}
	function tarjeta_credito($order){

			$CI=& get_instance();

			$fecha_limite_pago=addfecha(date('Y-m-d H:i:s'),3);
			list($fecha,$hora)=explode(" ",$fecha_limite_pago);

			require_once(APPPATH."libraries/openpay/Openpay.php");
			Openpay::setProductionMode(true);

			$configOpenpay=$CI->config->item('openpay','proyecto');

			$openpay = Openpay::getInstance($configOpenpay['openpay_id'],$configOpenpay['openpay_llave_privada']);

			$usuario=json_decode($order->datos_usuario);
			$envio=json_decode($order->datos_envio);
			$pago=json_decode($order->datos_pago);

			$customer = array( 
			'name' => $this->string_to_openpay($usuario->nombre), 
			'last_name' => $this->string_to_openpay($usuario->apellidoPaterno." ".$usuario->apellidoMaterno), 
			'phone_number' => $usuario->lada." ".  $usuario->telefono,
			'email' => $this->string_to_openpay($usuario->email), 
				'address' => array( 
				'line1' => 'Calle: '.$this->string_to_openpay($envio->calle), 
				'line2' => 'Colonia: '.$this->string_to_openpay($envio->colonia), 
				'line3' => 'Numero: '.$this->string_to_openpay($envio->numero_ext), 
				'state' => $this->string_to_openpay($envio->estado), 
				'city' => $this->string_to_openpay($envio->municipio), 
				'postal_code' => $envio->codigo, 
				'country_code' => 'MX' 
				) 
			);
		
			 $chargeData = array(
			    'method' => 'card',
			    'source_id' => $_POST["token_id"],
			    'amount' => number_format($pago->total, 2, '.', '') ,
			    'order_id' => $order->id,
			    'description' => "Compra tienda online Orden #".$order->id,
			    'device_session_id' => $_POST["deviceIdHiddenFieldName"],
			    'customer' => $customer
			);
 

			try {
			  $charge = $openpay->charges->create($chargeData);
			  $order->datos_banco=json_encode( array('referencia'=>$charge->authorization) );
			  $order->estatus=2;
			  $order->save();
			} catch (OpenpayApiTransactionError $e) {
			    $error='ERROR en la transaccion:  Los datos que ingresaste son incorrectos, la  operacion fue declinada';
			    return array('error'=>$error);

			} catch (OpenpayApiRequestError $e) {
			    $error='ERROR en la transaccion:  Los datos que ingresaste son incorrectos, la  operacion fue declinada';
			     return array('error'=>$error);

			} catch (OpenpayApiConnectionError $e) {
			    $error='ERROR en la transaccion:  Los datos que ingresaste son incorrectos, la  operacion fue declinada';
			     return array('error'=>$error);

			} catch (OpenpayApiAuthError $e) {
			    $error='ERROR en la transaccion:  Los datos que ingresaste son incorrectos, la  operacion fue declinada';
			     return array('error'=>$error);

			} catch (OpenpayApiError $e) {
			    $error='ERROR en la transaccion:  Los datos que ingresaste son incorrectos, la  operacion fue declinada';
			     return array('error'=>$error);

			} catch (Exception $e) {
			    $error='ERROR en la transaccion:  Los datos que ingresaste son incorrectos, la  operacion fue declinada';
			     return array('error'=>$error);
			}

	}

}



?>