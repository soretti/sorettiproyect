<div class="row">
	<div class="col-md-12">
		<a name="editar"></a>
		<form action="<?php echo current_url(); ?>"   id="form-editar" method="post" enctype="multipart/form-data">
		<?php if(count($usuario->error->all)): ?>
		<div class="alert alert-danger">
			<?php echo $this->lang->line('alert_error'); ?>
		</div>
		<?php endif ?>
		<?php if($usuario->valid): ?>
		<div class="alert alert-success">
			<?php echo $this->lang->line('alert_save'); ?>
		</div>
		<?php endif ?>
		<div><h1>Mi cuenta</h1>
			<div class="text-small form-group">Desde aquí puedes ver tus actividades recientes y actualizar la información de tu cuenta.</div>
			<div class="row">
				<div class="col-md-3">
					<?php $this->load->view("tienda/cuenta/menu"); ?>
				</div>
				<div class="col-md-9">
					<div class="encabezado"><?php echo $titulo; ?></div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-4">
								<label for="">Nombre / Razón social:*</label>
								<input type="text"  class="form-control input-sm" name="nombre" id="f_nombre" value="<?php echo $usuario->nombre; ?>"/>
								<span class="errores"><?php echo $usuario->error->nombre; ?></span>
							</div>
							<?php if($usuario->tipo=='moral') {?>
							<div class="col-md-4">
								<label for="">RFC: *</label>
								<input type="text"  class="form-control input-sm" name="rfc" value="<?php echo $usuario->rfc; ?>"/>
								<span class="errores"><?php echo $usuario->error->rfc; ?></span>
							</div>
							<?php } else { ?>
							<div class="col-md-4">
								<label for="">Apellido Paterno: *</label>
								<input type="text"  class="form-control input-sm" name="apellidoPaterno" id="f_apellidoPaterno" value="<?php echo $usuario->apellidoPaterno; ?>"/>
								<span class="errores"><?php echo $usuario->error->apellidoPaterno; ?></span>
							</div>
							<div class="col-md-4">
								<label for="">Apellido Materno:</label>
								<input type="text"  class="form-control input-sm" name="apellidoMaterno" id="f_apellidoMaterno" value="<?php echo $usuario->apellidoMaterno; ?>"/>
								<span class="errores"><?php echo $usuario->error->apellidoMaterno; ?></span>
							</div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label for="">E-mail:*  </label>
						<input type="text" class="form-control hide" name="email_field"  value="" />
						<input type="text" class="form-control input-sm" name="email" id="f_email" value="<?php echo $usuario->email; ?>" />
						<span class="errores"><?php  echo $usuario->error->email ?></span>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-xs-3"><label for="">Lada:  *</label><input type="text" class="form-control input-sm" name="lada" id="f_lada" value="<?php echo $usuario->lada; ?>" /></div>
							<div class="col-xs-9"><label for="">Teléfono:  *</label><input type="text" class="form-control input-sm" name="telefono" id="f_telefono" value="<?php echo $usuario->telefono; ?>" /></div>
						</div>
					</div>
					<?php if($usuario->descuento_id) {?>
			          <div class="form-group">
			            <label for="">Identificación: <small class="text-muted">IFE, PASAPORTE en formato jpg o pdf</small></label> <?php if($usuario->identificacion) {?> <a href="<?php echo base_url('tienda/cuenta/documentos/identificacion'); ?>" target="_blank"> ver documento... </a> <?php } ?>
			            <?php if(!$usuario->identificacion) {?>
			            	<input type="file" name="identificacion" id="" class="form-control">
			            <?php } ?>
			            <span class="error"><?php echo $usuario->error->identificacion ?></span>
			          </div>
			          <div class="form-group">
			            <label for="">Comprobante de domicilio: <small class="text-muted">Recibo de teléfono, agua o luz no mayor a 3 meses formato jpg o pdf</small> </label> <?php if($usuario->comprobante_domicilio) {?> <a href="<?php echo base_url('tienda/cuenta/documentos/identificacion'); ?>" target="_blank"> ver documento... </a> <?php } ?>
			             <?php if(!$usuario->comprobante_domicilio) {?>
			             	<input type="file" name="comprobante_domicilio" id="" class="form-control">
			             <?php } ?>
			            <span class="error"><?php echo $usuario->error->comprobante_domicilio ?></span>
			          </div>
					<div class="form-group">
						<span class="text-muted">
							Datos  bancarios para realizar el deposito de las comisiones generadas por las ventas
						</span>
					</div>
					<div class="form-group">
						<label for="">Banco: <small class="text-muted">Nombre del banco</small></label>
						<input type="text" class="form-control input-sm" name="banco"   value="<?php echo $usuario->banco; ?>" />
					</div>
					<div class="form-group">
						<label for="">CLABE: <small class="text-muted">Ingresar la clabe interbancaria</small></label>
						<input type="text" class="form-control input-sm" name="clabe"   value="<?php echo $usuario->clabe; ?>" />
					</div>
					<?php } ?>
					<div class="form-group">
						<input type="checkbox"  name="pass" value="1" id="" <?php if($this->input->post('pass')==1) echo "checked"; ?> > Cambiar contraseña
					</div>
					<div class="<?php if(!$this->input->post('pass')) echo 'hide'; ?>" id="cambiar-contrasena">
						<div class="form-group">
							<label for="">Password:*</label>
							<input type="password" name="password" class="form-control">
							<span class="errores"><?php echo $usuario->error->password; ?></span>
						</div>
						<div class="form-group">
							<label for="">Confirmar Password:*</label>
							<input type="password" name="confirmar" class="form-control">
							<span class="errores"><?php echo $usuario->error->confirmar; ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div><a href="<?php echo base_url('tienda/cuenta/micuenta'); ?>"><< Regresar</a></div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<button type="submit" name="guardar" value="guardar" class="btn btn-primary">Guardar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>