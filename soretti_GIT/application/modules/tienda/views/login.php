<div class="row fila-top">
	<div class="col-md-12">
		<h1>INICIAR SESIÓN O CREAR UNA CUENTA</h1>
	</div>
</div>
<div class="row">
	<div class="col-md-12">

		<?php if($this->session->flashdata('mensaje')) {?>
			    <div class="alert alert-success">
			        <?php echo $this->session->flashdata('mensaje'); ?>
			    </div>
		<?php } ?>
		

		<?php if(count($usuario->error->all) || $usuario->not_found) {?>
		<div class="alert alert-danger">
			<?php echo ($usuario->not_found) ? $usuario->not_found : $this->lang->line('alert_error'); ?>
		</div>
		<?php } ?>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-6">
				<div class="cuadro">
					<div class="encabezado">Regístrate</div>
					<div class="beneficios-registro">
						Al registrarte con nosotros obtienes grandes beneficios
						
						<ul >
							<li>Compra de manera rápida</li>
							<li>Guarda diferentes direcciones</li>
							<li>Consulta el Status de tú pedido</li>
						</ul>
						
						<div class="text-right">
							<a href="<?php echo site_url("tienda/cuenta/registro") ?>?to=<?php echo $this->input->get('to') ?>" class="btn btn-primary">Crear una cuenta</a>
						</div>
					</div>
				</div>
			</div>
				<div class="col-md-6">
					<div class="cuadro">
						<div class="encabezado">Ya estoy registrado</div>
					<form action="" method="POST" id="form-tienda">
						<div class="form-group">
							<label for="">E-mail:<span class="required">* </span></label>
							<input type="text" name="email" class="form-control" value="<?php echo $usuario->email ?>">
							<span class="errores"><?php echo $usuario->error->email; ?></span>
						</div>
						<div class="form-group">
							<label for="">Password:<span class="required">* </span></label>
							<input type="password" name="password" class="form-control" value="">
							<span class="errores"><?php echo $usuario->error->password; ?></span>
						</div>
						<div class="text-right">
							<a href="<?php echo base_url('tienda/cuenta/recordarPassword'); ?>">¿Olvidaste tu contraseña?</a>
							<input type="email" name="tienda_email_field" value="" class="hide">
							<input type="hidden" name="tienda_registro" id="tienda_registro" value="">
							<button type="button" id="submit_tienda" class="btn btn-primary">Iniciar sesion</button>
						</div>
					</form>
				</div>
				</div>
		</div>
	</div>
	</div>