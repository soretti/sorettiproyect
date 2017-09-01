<div class="row">
	<div class="col-md-12">
		<h1>¿OLVIDASTE TU CONTRASEÑA?</h1>
		
		<form action="" method="POST" id="form-tienda">

			
			<?php if($mensaje) {?>
			<div class="alert alert-success">
				Se ha enviado un email con un link para resetear su contraseña
			</div>
			<?php } ?>
			<?php if(count($usuario->error->all) || $usuario->not_found) {?>
			<div class="alert alert-danger">
				<?php echo ($usuario->not_found) ? $usuario->not_found : $this->lang->line('alert_error'); ?>
			</div>
			<?php } ?>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						Por favor ingresa tu correo electrónico te enviaremos un correo con un link para que restablezcas tu contraseña.
					</div>
					<div class="form-group">
						<label for="">E-mail: <span class="required">* </span></label>
						<input type="text" name="email" class="form-control" value="<?php echo $this->input->post('email') ?>">
						<span class="errores"><?php echo $usuario->error->email; ?></span>
					</div>
					<div class="form-group">
						<a href="<?php echo base_url('tienda/cuenta/login'); ?>">« Regresar a Iniciar Sesión</a>
					</div>
					<div class="form-group">
						<input type="email" name="tienda_email_field" value="" class="hide">
						<input type="hidden" name="tienda_registro" id="tienda_registro" value="">
						<button type="button" id="submit_tienda" class="btn btn-primary">Enviar</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>