<table style="width:100%; font-size:12px; font-family: Verdana; width: 600px;"  width="600" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td>
		<div style="margin-bottom:15px; text-align:center">
			<img src="<?php echo base_url("pub/theme/img/logo.jpg")?>" alt="">
		</div>
			<div style="margin-bottom:15px;">
				Estimado(a): <?php echo $usuario->nombre." ".$usuario->apellidoPaterno; ?>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<p>Nos da gusto saludarte nuevamente. Invita a tus  clientes, amigos y conocidos a comprar en nuestra tienda virtual <a href="http://www.algaespirulina.mx">www.algaespirulina.mx</a> Si en su compran usan tu cupón de descuento personal, tu obtienes comisiónes con estas compras</p>
				<table style="width:100%; font-size:12px; font-family: Verdana;" border="0" cellpadding="0" cellspacing="4">
					<tr>
						<td colspan="4">
							<img src="<?php echo base_url('pub/theme/img/pasos_cupones.jpg')?>" alt="">
						</td>
					</tr>
					<tr>
						<td style="width:25%" valign="top">
							<div style="text-align:center"><strong>Cupones</strong></div>
							<p style="text-align:center">Descarga tu planilla de cupones que se encuentra adjunta en este correo</p>
						</td>
						<td style="width:25%" valign="top">
							<div style="text-align:center"><strong> Distribuye tu cupón</strong></div>
							<p style="text-align:center">Reparte tu cupón a tus clientes, en tu pagina web, por correo electrónico o redes sociales	</p>
						</td>
						<td style="width:25%" valign="top">
				             <div style="text-align:center"><strong>Gana con tu cupón</strong></div>
							<p style="text-align:center">Si tus clientes compran directamente con tu cupón en de descuento en la tienda virtual www.algaespirulina.mx, tu obtienes importantes comisiones</p>
						</td>
						<td style="width:25%" valign="top">
			             	<div style="text-align:center"><strong> Recibe tus comisiones </strong></div>
							<p style="text-align:center">Si se generaron ventas con tus cupones, podras recibir las mismas</p>
						</td>
					</tr>
					<tr>
						<td colspan="4" style="padding-top:10px;">
							<small>Nota. para mayores detalles consulta con nuestros especialistas el tel 55201155</small></td>
					</tr>
				</table>
		</td>
	</tr>
	<tr>
		<td style="padding: 20 0 0 0;" align="center">
			<a href="https://www.facebook.com/algaespirulinamx/?ref=hl" target="_blank">
				<img src="https://www.algaespirulina.mx/pub/uploads/boletines/facebook29.png" alt="" >
			</a>&nbsp;&nbsp;
			<a href="https://twitter.com/espirulinamx" target="_blank" data-mce-href="https://twitter.com/espirulinamx">
				<img src="https://www.algaespirulina.mx/pub/uploads/boletines/twitter47.png" alt="">
			</a>
		</td>
	</tr>	
	<tr>
		<td>
			<p style="font-size:11px;">D.R., ©, SUPERFOODS, S.A. DE C.V. Queda prohibida la reproducción total o parcial, por cualquier medio o forma, sin la autorización previa, expresa y por escrito de su titular SUPERFOODS, S.A. DE C.V.</p>		
		</td>
	</tr>
	<tr>
		<td style="padding: 20 45 0 45; color: #333333; font-size:11px; font-family: Verdana;" align="left">
			Si deseas cancelar tu inscripción para recibir este correo has click en el siguiente link <a href="<?php echo base_url('tienda/cuenta/cancelar_boletin_cupones').'?cancel='.urlencode($this->encrypt->encode('byemail+'.$usuario->email,'byetonews'));   ?>">cancelar suscripción</a>.
			Por favor, visite nuestro <a style="color: #333333;" href="https://www.algaespirulina.mx/web/politica-de-privacidad.html">aviso de privacidad</a> &nbsp;para más información.
		</td>
	</tr>	
	<tr>
		<td>
			<table border="0" width="60%" cellspacing="0" cellpadding="0" align="center" class="mce-item-table" data-mce-selected="1">
				<tbody>
					<tr>
						<td style="font-size: 10px; font-family: Verdana;">
							<a style="color: #333333;" href="https://www.algaespirulina.mx/web/terminos-y-condiciones.html">TÉRMINOS Y CONDICIONES</a>&nbsp;|&nbsp;
						</td>
						<td style="font-size: 10px; font-family: Verdana; color: #333333;">
							<a style="color: #333333;" href="https://www.algaespirulina.mx/web/politica-de-privacidad.html">AVISO DE PRIVACIDAD</a>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
	<tr>
		<td style="height: 50px; text-align: center; padding: 20px; font-family: Verdana; font-size:11px;">
			Este mensaje se envió a <?php echo $usuario->email; ?>  por parte de www.algaespirulina.mx por formar parte de nuestros distribuidores | Todos los derechos reservados.	
		</td>
	</tr>
</table>
