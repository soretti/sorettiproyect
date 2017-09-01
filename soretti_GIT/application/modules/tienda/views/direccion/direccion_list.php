<div class="row">
<div class="col-md-12">

	<?php if($this->session->flashdata('mensaje')) {?>
		    <div class="alert alert-success">
		        <?php echo $this->session->flashdata('mensaje'); ?>
		    </div>
	<?php } ?>


	<div><h1>Mi Cuenta</h1>
		<div class="text-small form-group">Desde aquí puedes ver tus actividades recientes y actualizar la información de tu cuenta.</div>
		<div class="row">

			<div class="col-md-3">
				<?php $this->load->view("tienda/cuenta/menu"); ?>
			</div>

			<div class="col-md-9">
				<div class="encabezado"><?php echo $titulo; ?></div>
				<div class="text-right" style="margin-bottom:50px;">
                				<a href="<?php echo base_url('tienda/direccion/formulario') ?>" style="text-decoration:underline"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Agregar una nueva dirección</a>
            				</div>
				<div class="row" style="margin-bottom:25px;">
					<?php foreach ($direcciones as $key => $direccion): ?>
						<?php if(($key!=0) && ($key%2==0)): ?>
							</div>
							<div class="row" style="margin-bottom:25px;">
						<?php endif; ?>
						<div class="col-md-6">
							<p>
								
								<?php if($direccion->tipo==1) {?>
								   Nombre: <?php echo $direccion->nombre . ' ' . $direccion->apellidoPaterno. ' ' . $direccion->apellidoMaterno ?><br>
								<?php } ?>								
								<?php if($direccion->tipo==2) {?>
								   RFC: <?php echo $direccion->rfc; ?><br>
								   Nombre o Razon social: <?php echo $direccion->razon_social; ?><br>
								<?php } ?>
								
								Estado o distrito: <?php echo $direccion->estado->titulo; ?><br>
								Cd., mpio. o del.: <?php echo $direccion->municipio->titulo; ?><br>
								Colonia: <?php echo ($direccion->nombreColonia) ? $direccion->nombreColonia : $direccion->colonia->titulo; ?><br>
								Calle: <?php echo $direccion->calle; ?><br>
								No. exterior: <?php echo $direccion->numero_ext; ?><br>
								<?php if($direccion->numero_int): ?>No. interior: <?php echo $direccion->numero_int; ?><br><?php endif; ?>
								Código Postal: <?php echo $direccion->codigo; ?><br>
								<?php if($direccion->tipo==1) {?>
									Teléfono: <?php echo $direccion->lada; ?> <?php echo $direccion->telefono; ?><br>
									<?php if($direccion->celular): ?>Celular: <?php echo $direccion->celular; ?><br><?php endif; ?>
								<?php } ?>

							</p>

							<p>
								<a href="<?php echo base_url('tienda/direccion/formulario/'.$direccion->id) ?>">
									<span class="glyphicon glyphicon-pencil"></span>
									Modificar
								</a>&nbsp;
								<a href="<?php echo base_url('tienda/direccion/eliminar/'.$direccion->id) ?>">
									<span class="glyphicon glyphicon-trash"></span>
									Eliminar
								</a>
							</p>
						</div>
					<?php endforeach; ?>
							</div>

			</div>

		</div>
	</div>
</div>
</div>
