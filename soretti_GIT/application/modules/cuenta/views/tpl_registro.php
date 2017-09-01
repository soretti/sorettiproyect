<div style="margin-bottom:15px;">
	<img src="<?php echo base_url("pub/theme/img/logo.jpg")?>" alt="">
</div>
<div style="font-size:12px; margin-bottom:15px;">
	Hola <?php echo $_POST['nombre']; ?> <?php echo $this->input->post('apellidoPaterno'); $this->input->post('apellidoMaterno'); ?>
</div>
<div>
	<strong>Detalles de tu cuenta</strong>
</div>
<table style="width:100%">
	<tr>
		<td>
			Nombre: <?php echo $_POST['nombre']; ?><br>
			Apellidos: <?php echo $this->input->post('apellidoPaterno'); $this->input->post('apellidoMaterno'); ?>
		</td>
	</tr>
	<tr>
		<td colspan="2">E-mail: <?php echo $_POST['email']; ?></td>
	</tr>
	<tr>
		<td>Telefono : <?php echo $_POST['lada']; ?> <?php echo $_POST['telefono']; ?> </td>
 
	</tr>
</table>

 
<div><p><strong>Consejos de Seguridad:</strong></p></div>

Mantén los datos de tu cuenta en lugar seguro.<br>
No des los detalles de tu cuenta a nadie.<br>
Cambia tu contraseña regularmente.<br>
Si sospechas que alguien esta usando ilegalmente tu cuenta, avísanos inmediatamente.<br>
 
<p>Ahora podrás guardar y consultar tus pedidos en nuestra web: <a href="<?php echo site_url() ?>"><?php echo site_url() ?></a></p>