<div class="row">
	<div class="col-md-12">
		<a name="tienda"></a><form action="" method="POST" id="form-tienda">

		<h1>Crear una cuenta</h1>
		<div class="text-small form-group">Ingresa la siguiente información para crear tu cuenta</div>

		<?php if(count($usuario->error->all)) { ?>
		<div class="alert alert-danger">
			<?php echo $this->lang->line('alert_error'); ?>
		</div>
		<?php } ?>
		<div class="form-group">
			<div class="row">
				<div class="col-md-4">
					<label for="">Nombre:<span class="required">* </span></label>
					<input type="text"  class="form-control input-sm" name="nombre" id="f_nombre" value="<?php echo $this->input->post('nombre'); ?>"/>
					<span class="errores"><?php echo $usuario->error->nombre; ?></span>
				</div>
				<div class="col-md-4">
					<label for="">Apellido paterno:<span class="required">* </span></label>
					<input type="text"  class="form-control input-sm" name="apellidoPaterno" id="f_apellidoPaterno" value="<?php echo $this->input->post('apellidoPaterno'); ?>"/>
					<span class="errores"><?php echo $usuario->error->apellidoPaterno; ?></span>
				</div>
				<div class="col-md-4">
					<label for="">Apellido materno:</label>
					<input type="text"  class="form-control input-sm" name="apellidoMaterno" id="f_apellidoMaterno" value="<?php echo $this->input->post('apellidoMaterno'); ?>"/>
					<span class="errores"><?php echo $usuario->error->apellidoMaterno; ?></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="">E-mail:<span class="required">* </span>   <small class="text-muted">(Email para crear una cuenta en algaespirulina.mx)</small></label>
			<input type="text" class="form-control hide" name="email_field"  value="" />
			<input type="text" class="form-control input-sm" name="email" id="f_email" value="<?php echo $this->input->post('email'); ?>" />
			<span class="errores"><?php  echo $usuario->error->email ?></span>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-xs-3">
					<label for="">Lada:  <span class="required">* </span></label>
					<input type="text" class="form-control input-sm" name="lada" id="f_lada" value="<?php echo $this->input->post('lada'); ?>" />
					<span class="errores"><?php  echo $usuario->error->lada ?></span>
				</div>
				<div class="col-xs-9">
					<label for="">Teléfono:  <span class="required">* </span></label>
					<input type="text" class="form-control input-sm" name="telefono" id="f_telefono" value="<?php echo $this->input->post('telefono'); ?>" />
					<span class="errores"><?php  echo $usuario->error->telefono ?></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="">Password:<span class="required">* </span> <small class="text-muted">(Cree una contraseña para ingresar a su cuenta en algaespirulina.mx 5 caracteres mínimo )</small></label>
			<input type="password" name="password" class="form-control" value="<?php echo $this->input->post('password'); ?>">
			<span class="errores"><?php echo $usuario->error->password; ?></span>
		</div>
		<div class="form-group">
			<label for="">Confirmar Password:<span class="required">* </span> </label>
			<input type="password" name="confirmar" class="form-control" value="<?php echo $this->input->post('confirmar'); ?>">
			<span class="errores"><?php echo $usuario->error->confirmar; ?></span>
		</div>
		<div>
			<input type="checkbox"  name="boletin" value="1" id="" <?php if($this->input->post('boletin')==1) echo "checked"; ?> > Suscribirse a nuestro newsletter
			<div class="form-group <?php if(!$this->input->post('boletin')) echo "hide" ?>" id="temas-de-interes">
				<label><small>Temas de interés: <span class="required">* </span></small></label>
				<?php foreach($grupos as $grupo) { ?>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="grupos[]" value="<?php echo $grupo->id; ?>" <?php  if(is_array($this->input->post('grupos')) && in_array($grupo->id,$this->input->post('grupos'))) print("checked") ?>> <?php echo $grupo->nombre ?>
					</label>
				</div>
				<?php } ?>
				<span class="errores"><?php echo $usuario->error->grupos; ?></span>
			</div>
		</div>
		<p>
			<input type="checkbox"  name="privacidad" value="1" id="" <?php if($this->input->post('privacidad')==1) echo "checked"; ?> >  He leído y acepto la nota informativa sobre el  <a href="<?php echo site_url('modulo/pagina/blank/politica-de-privacidad'); ?>" class="fancybox-frame">aviso de privacidad. </a>
			<br><span class="errores"><?php echo $usuario->error->privacidad; ?></span>
		</p>

		<div class="form-group">
			<input type="email" name="tienda_email_field" value="" class="hide">
			<input type="hidden" name="tienda_registro" id="tienda_registro" value="">
			<button type="button" id="submit_tienda" class="btn btn-primary">Registrarme</button>
		</div>
	</form>
</div>
</div>
