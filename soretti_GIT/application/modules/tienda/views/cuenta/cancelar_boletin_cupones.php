<div class="row">
	<div class="col-md-12">
		<?php if($this->session->flashdata('mensaje')) {?>
			    <div class="alert alert-success">
			        <?php echo $this->session->flashdata('mensaje'); ?>
			    </div>
		<?php } ?>
		<div>
			<h1><?php echo $titulo; ?></h1>

			
			<div class="row">


				<div class="col-md-12">
					<div>
						<p>Tu suscripción al boletín de cupones de ALGA ESPIRULINA ha sido cancelada.</p>
						<p>Para cualquier aclaración o información adicional escribenos  al siguiente correo: <?php echo safe_mailto('hola@algaespirulina.mx') ?></p>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>



