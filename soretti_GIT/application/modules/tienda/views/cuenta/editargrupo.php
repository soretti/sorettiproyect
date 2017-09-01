<div class="row">
	<div class="col-md-12">
		<a name="grupo"></a>
		<form action="<?php echo current_url(); ?>" method="POST" id="form-grupo">

			<div><h1>Mi cuenta</h1>
				<div class="text-small form-group">Desde aquí puedes ver tus actividades recientes y actualizar la información de tu cuenta.</div>
				<div class="row">
					<div class="col-md-3">
						<?php $this->load->view("tienda/cuenta/menu"); ?>
					</div>

					<div class="col-md-9">
						<div class="encabezado"><?php echo $titulo; ?></div>
						<div class="row">
							<div class="col-md-12">
								<div>
									<label><medium>Estoy interesado en recibir Promociones:&nbsp;</medium></label>
									<label class="radio-inline">
										<input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" <?php if($boletin_usuario->unsuscribed==0) echo 'checked'; ?>> Si
									</label>
									<label class="radio-inline">
										<input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" <?php if($boletin_usuario->unsuscribed==1) echo 'checked'; ?>> No
									</label>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">

								<div class="grupos-interes  <?php if($boletin_usuario->unsuscribed) echo'hide' ?> " >


									<?php  if(count($grupos)>0){ ?>
										<label><small>Temas de interés: *</small></label>
										<div>Seleccionar todos <input type="checkbox" name="marcarTodo" id="marcarTodo" ?></div>
										<?php	foreach ($grupos as $grupo) { ?>
										<div class="checkbox">
											<label>
												<input type="checkbox" class="grupos" name="grupos[]" value="<?php echo $grupo->id; ?>" <?php if(in_array ($grupo->id, explode(",", $boletin_usuario->grupos))) print("checked"); ?>> <?php echo $grupo->nombre ?>
											</label>
										</div>
										<?php } ?>
										<span class="errores"><?php echo $boletin_usuario->error->grupos; ?></span>
									<?php } ?>

								</div>

							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div><a href="<?php echo base_url('tienda/cuenta/micuenta'); ?>"><< Regresar</a></div>
							</div>
							<div class="col-md-6">
								<div class="form-group ">
									<input type="submit" value="Enviar" name="guardar" class="btn btn-primary">
								</div>
							</div>

						</div>

					</div>
				</div>

			</div>

		</form>
	</div>
</div>
