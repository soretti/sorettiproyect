<div>
	<strong>MÉTODO DE PAGO</strong>
	<div><?php echo $metodos_de_pago[$pago->metodo_pago]; ?></div>
</div>
<br>
<?php if($banco && $pago->metodo_pago==1) {?>
<strong>AUTORIZACIÓN ID: </strong><?php echo $banco->referencia; ?>
<?php } ?>
<?php if($pago->metodo_pago==4) {?>
<div><strong>PROCEDIMIENTO DE PAGO</strong></div>
Te recordamos que tienes tres días hábiles para realizar tu depósito a partir del <?php echo $this->dateutils->datees(strtotime($order->fecha_creacion),'c','c');  ?>, de lo contrario no podremos garantizar la existencia de la mercancía. Puedes hacer el depósito a la siguiente cuenta bancaria, poniendo como referencia tu número de orden
<br><br>
- Banco: BANCOMER<br>
- A nombre de: SUPER FOODS Y ESPIRULINA SA DE CV <br>
- Cuenta:  0100459062 SUC. 3482<br>
- Cuenta clabe:  012180001004590627<br>
- Número de referencia: <?php echo $order->id; ?>
<br><br>
<p>Cuando el depósito esté hecho, favor de enviar copia del comprobante a <a href="mailto:<?php echo $email ?>" style="color:#28639F"><?php echo $email ?></a></p>
<br>
<?php } ?>
<?php if($pago->metodo_pago==2) {?>
<table border="0" cellpadding="0" cellspacing="0" style="margin-bottom:15px; width:100%">
	<tr>
		<td width="50%" valign="top">
			<div><strong>Fecha limite de pago:</strong> <?php echo $this->dateutils->datees(strtotime(addfecha($order->fecha_creacion,2)),'c','c');  ?></div>
			<div><strong>Servicio a pagar:</strong>  <img src="<?php echo base_url('pub/theme/img/openpay/paynet.jpg'); ?>" alt="">  </div>
			<div><img src="<?php echo $banco->barcode_url ?>" alt=""></div>
			<div><small><?php echo $banco->reference ?></small></div>
			<div><small>En caso de que el escáner no sea capaz de leer el código de barras, escribir la referencia tal como se muestra</small></div>
		</td>
		<td width="50%" valign="top">
			<strong>Total a pagar:</strong>  <span style="font-weigth:bold; font-size:24px;"><?php echo formato_precio($pago->total); ?> MXN</span>  <br> +8 pesos por comisión
		</td>
	</tr>
</table>


<div class="col1">
	<strong>Como realizar el pago</strong>
	<ol>
		<li>Acude a cualquier tienda afiliada</li>
		<li>Entrega al cajero el código de barras y menciona que realizarás un pago de servicio Paynet</li>
		<li>Realizar el pago en efectivo por <?php echo formato_precio($pago->total); ?>  MXN (más $8 pesos por comisión)</li>
		<li>Conserva el ticket para cualquier aclaración</li>
	</ol>
</div>
<div class="col1">
	<strong>Instrucciones para el cajero</strong>
	<ol>
		<li>Ingresar al menú de Pago de Servicios</li>
		<li>Seleccionar Paynet</li>
		<li>Escanear el código de barras o ingresar el núm. de referencia</li>
		<li>Ingresa la cantidad total a pagar</li>
		<li>Cobrar al cliente el monto total más la comisión de $8 pesos</li>
		<li>Confirmar la transacción y entregar el ticket al cliente</li>
	</ol>
</div>
<div class="logos-tiendas">
	<div>
		<img src="<?php echo base_url('pub/theme/img/openpay/tiendas.gif'); ?>" alt="" align="left" style="max-width:60%; margin-right:10px">
		<small>¿Quieres pagar en otras tiendas? <br>  <a href="http://www.openpay.mx/tiendas">visita: www.openpay.mx/tiendas</a></small>
	</div>
</div>
<div style="display:table; width:100%; margin-top:20px">
	<small>Si tienes dudas comunicate a ALGA ESPIRULINA al teléfono 5520 1155, 5520 1136 o al correo <a href="mailto:hola@espirulina360.com">hola@espirulina360.com</a></small>
</div>
<br>
<?php } ?>
<?php if($pago->metodo_pago==3) {?>
<table border="0" cellpadding="0" cellspacing="0" style="margin-bottom:15px; width:100%">
	<tr>
		<td width="100%" valign="top">
			<div><strong>Fecha limite de pago:</strong> <?php echo $this->dateutils->datees(strtotime(addfecha($order->fecha_creacion,2)),'c','c');  ?></div>
			<div><strong>Nombre del banco:</strong> SIST TRANSF Y PAGOS (STP)</div>
			<div><strong>CLABE:</strong> <?php echo $banco->clabe ?></div>
			<div><strong>Referencia numérica:</strong> <?php echo $banco->name ?></div>
			<div><strong>Concepto de pago:</strong> <?php echo $banco->name ?></div>
		</td>
	</tr>
</table>

<div class="logos-tiendas">
	<div>
		<small>Bancos participantes <br>  <a href="http://www.openpay.mx/bancos.html">visita: www.openpay.mx/bancos.html</a></small>
	</div>
</div>
<div style="display:table; width:100%; margin-top:20px">
	<small>Si tienes dudas comunicate a ALGA ESPIRULINA al teléfono 5520 1155, 5520 1136 o al correo <a href="mailto:hola@espirulina360.com">hola@espirulina360.com</a></small>
</div>
<br>
<?php } ?>
<?php if($pago->metodo_pago==5) {?>
<table border="0" cellpadding="0" cellspacing="0" style="margin-bottom:15px; width:100%">
	<tr>
		<td width="100%" valign="top">
			<div><strong>Fecha limite de pago:</strong> <?php echo $this->dateutils->datees(strtotime(addfecha($order->fecha_creacion,2)),'c','c');  ?></div>
		</td>
	</tr>
</table>
<br>
<?php } ?>