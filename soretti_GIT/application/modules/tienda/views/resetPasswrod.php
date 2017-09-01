<div class="row">
	<div class="col-md-12">
		<h1>INGRESA TU NUEVA CONTRASEÑA</h1>
		<form action="" method="POST" id="form-tienda">
			<?php if(count($usuario->error->all)) {?>
				<div class="alert alert-danger">
					<?php echo $this->lang->line('alert_error'); ?>
				</div>
			<?php } ?>
			<div class="form-group">
				<label for="">Password:*</label>
				<input type="password" name="password" class="form-control">
				<?php echo $usuario->error->password; ?>
			</div>
			<div class="form-group">
				<label for="">Confirmar Password:*</label>
				<input type="password" name="confirmar" class="form-control">
				<?php echo $usuario->error->confirmar; ?>
			</div>
			<div class="form-group">
				<input type="email" name="tienda_email_field" value="" class="hide">
				<input type="hidden" name="tienda_registro" id="tienda_registro" value="">
				<button type="button" id="submit_tienda" class="btn btn-primary">Enviar</button>
			</div>
		</form>
	</div>
</div>