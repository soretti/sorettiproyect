<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$proyecto['email_contacto'] = 'prospectos@soretti.mx';
$proyecto['email_producto'] = 'gsbarreiro@gmail.com';
$proyecto['dominio'] = 'http://www.soretti.com.mx';
$proyecto['empresa'] = 'Soretti';
$proyecto['titulo'] = 'Soretti';
$proyecto['telefonos'] = '49.43.86.61';
$proyecto['catalogo'] = 0;
$proyecto['tienda'] = 0;
$proyecto['boletin'] = 0;
$proyecto['chat'] = 0;
$proyecto['enconstruccion'] = 0;
$proyecto['fecha_liberacion'] = '2017-01-28';
$proyecto['usuario'] = 'soretti';
$proyecto['password'] = 'avances';
$proyecto['idiomas'] = array('');
$proyecto['buscador']=array('catalogo'=>0,'contenido'=>1);

$proyecto['boletin']=array(
'empresa_nombre'=>'Soretti',
'empresa_url'=>'<a href="http://www.soretti.com"> Cancelar suscripción </a>',
'empresa_direccion'=>'',
'empresa_email'=>'gsbarreiro@gmail.com',
'empresa_telefono'=>'',
'cancelar_suscripcion'=>'<a href="http://www.soretti.com.mx/modulo/boletin/newsletter/unsuscribe.html?unsuscribe={unsuscribe}"> Cancelar suscripción </a>',
'empresa_politica_privacidad'=>'<a href="http://www.soretti.com.mx/web/politica-de-privacidad.html" style="color:#FFFFFF"> Aviso de privacidad </a>'
);

$proyecto['send_mail']=array(
	'smtp_host'=>'mail.soretti.mx',
	'smtp_user'=>'gsalgado@soretti.mx',
	'alias'=>'Soretti',
	//'smtp_pass'=>'gy@q123-90',
	'smtp_pass'=>'newsletter123',
	'smtp_port'=>25
);

$proyecto['send_mail_tienda']=array(
	'smtp_host'=>'',
	'smtp_user'=>'',
	'alias'=>'',
	'smtp_pass'=>'',
	'smtp_port'=>''
);

$proyecto['status_tienda']=array(
	1=>'En espera de pago',
	2=>'Pagado aceptado',
	3=>'En proceso de preparación',
	4=>'Enviando',
	5=>'Entregado',
	6=>'cancelado'
);

$proyecto['metodos_pago']=array(
	1=>'Tarjeta de crédito o débito',
	2=>'Tiendas de conveniencia',
	3=>'Transferencia electrónica SPEI',
	4=>'Deposito o Transferencia Bancaria',
	5=>'PayPal'
);

$proyecto['metodos_entrega']=array(
	// 1=>'Recoger en tienda I',
	// 2=>'Recoger en tienda II',
	3=>'Paqueteria'
);

// $proyecto['planes_pagos']=array(
// 	3=>'300',
// 	6=>'600',
// 	9=>'900',
// 	12=>'1200'
// );

$proyecto['send_blaster']=array(
	'suscribe_email'=>'prueba@prueba.com',
	'estatus'=>FALSE
);



/*Production*/
$proyecto['openpay']=array(
	'openpay_id'=>'',
	'openpay_llave_privada'=>'',
	'openpay_llave_publica'=>'',
	'openpay_url'=>'https://api.openpay.mx/v1',
	'ProductionMode'=>TRUE
);

/*Promociones en la compra general - solo aplica para cliente final*/
$proyecto['promociones']=array(
		'recurrente'=>array('porcentaje'=>3),
		'promocion1'=>array('porcentaje'=>6,'monto_minimo'=>2500),
		'promocion2'=>array('porcentaje'=>9,'monto_minimo'=>5000)
);


$config['proyecto'] = $proyecto;