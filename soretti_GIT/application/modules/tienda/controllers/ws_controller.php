<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ws_controller extends MX_Controller {

	public function __construct()
	{
		parent::__construct();

	}

	public function calculo($cp){
			require_once(APPPATH.'libraries/lib/nusoap'.EXT);
			$client=new nusoap_client('http://www.sistemasaplicados.com.mx/webservice/servidor.php?wsdl',TRUE);

			$client->setCredentials("36547","36547veganet","basic");
			$result="";
			$partidas=array();

			/// Consulta de precio por codigo postal
			try{
				 foreach ($this->cart->contents() as $items):

				  	$partidas[] =   array(array('articulo'=>$items['sku'],'cantidad'=>$items['qty']));

				 endforeach;

				$result=$client->call('CalculoPaqueteria',array('partidas'=>$partidas,'cp' => $cp));

				//return $result;
				echo $result;

			}catch (SoapFault $err){
				//echo "Se produjo un error, No se pudo recuperar la informacion. <br/> $err<hr/>";
				//return false;
				echo 'false';
			}
	}
}
