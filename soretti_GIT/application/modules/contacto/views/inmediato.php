<div class="modulo contacto-inmediato" id="contenedor-contactoinmediato">
	<div id="inner-contactoinmediato">

	 
			<div class="barra-azul text-center fila-top">
				<?php echo $this->lang->line('contactenos') ?>
			</div>
		 

		<?php if( validation_errors() ) {?>
		<div class="alert alert-danger">
			<?php echo $this->lang->line('alert_error'); ?>
		</div>
		<?php } ?>
		<?php if($enviado) {?>
		<div class="alert alert-success">
			<?php echo $enviado ?>
		</div>
		<?php } ?>
		<div class="form-group">

			<input type="text"  class="form-control" name="nombre" id="f_nombre" placeholder="<?php echo $this->lang->line('nombre') ?>" value="<?php echo $this->input->post('nombre'); ?>"/>
			<span class="errores"><?php echo form_error('nombre'); ?></span>
		</div>
		<div class="form-group">

			<input type="text" class="form-control hide" name="email_field"  value="" />
			<input type="text" class="form-control" placeholder="<?php echo $this->lang->line('correo') ?>" name="email" id="f_email" value="<?php echo $this->input->post('email'); ?>" />
			<span class="errores"><?php echo form_error('email'); ?></span>
		</div>
		<div class="form-group">

			<textarea name="texto" rows="9" class="form-control" placeholder="<?php echo $this->lang->line('mensaje') ?>" id="f_texto"><?php echo $this->input->post('texto'); ?></textarea>
			<span class="errores"><?php echo form_error('texto'); ?></span>
		</div>
		<div class="form-group form-buscar text-right">
			<button type="button" id="enviar-inmediato" class="btn btn-primary btn-naranja boton-style boton-go"><?php echo $this->lang->line('enviar-mensaje') ?></button>
		</div>

	</div>
</div>



