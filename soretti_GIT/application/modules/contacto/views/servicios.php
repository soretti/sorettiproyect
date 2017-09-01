<div class="panel-body formulario-contenido">

	<div class="formulario-datos-contacto">DATOS DE CONTACTO</div>

	<form>
	  <div class="form-group"> 
	    <input type="text" class="form-control" name="nombre" id="f_nombre" value="<?php echo $this->input->post('nombre'); ?>" placeholder="Nombre Completo *">
	  </div>
	  <div class="form-group"> 
	    <input type="text" class="form-control" name="apellido_paterno" id="f_paterno" value="<?php echo $this->input->post('apellido_paterno'); ?>" placeholder="Apellido Paterno *">
	  </div>
	  <div class="form-group"> 
	    <input type="text" class="form-control" name="apellido_materno" id="f_materno" value="<?php echo $this->input->post('apellido_materno'); ?>" placeholder="Apellido Materno *">
	  </div>
	  <div class="form-group"> 
	    <input type="text" class="form-control" name="telefono" id="f_telefono" value="<?php echo $this->input->post('telefono'); ?>" placeholder="Teléfono Fijo / Extensión *">
	  </div>
	  <div class="form-group"> 
	    <input type="text" class="form-control" name="celular" id="f_celular" value="<?php echo $this->input->post('celular'); ?>" placeholder="Teléfono Celular">
	  </div>
	  <div class="form-group"> 

		<input type="text" class="form-control hide" name="email_field"  value="" />

	    <input type="email" class="form-control" name="email" id="f_email" <?php echo $this->input->post('email'); ?>" placeholder="Correo Empresarial *">
        <span class="errores"><!-- <?php //echo form_error('email'); ?></span> -->

	  </div>
	  <div class="form-group"> 
	    <input type="text" class="form-control" name="confirmar_email" value="<?php echo $this->input->post('confirmar_email'); ?>" placeholder="Confirmar Correo Empresarial *">
	    <span class="errores"><!-- <?php //echo form_error('confirmar_email'); ?></span> -->

	  </div>
	  <div class="form-group"> 
	    <input type="text" class="form-control" name="puesto" id="f_puesto" value="<?php echo $this->input->post('puesto'); ?>" placeholder="Puesto o Cargo en la Empresa *">
	  </div>


	  <div class="formulario-datos-empresa">DATOS DE LA EMPRESA</div>
	  <div class="form-group"> 
	    <input type="text" class="form-control" name="razon_social" id="f_social" value="<?php echo $this->input->post('razon_social'); ?>" placeholder="Razón Social de la Empresa *">
	  </div>
	  <div class="form-group"> 
	    <input type="text" class="form-control" name="giro_empresa" id="f_ giroempresa" value="<?php echo $this->input->post('giro_empresa'); ?>" placeholder="Giro o Sector de la Empresa *">
	  </div>
	  <div class="form-group"> 
	    <input type="text" class="form-control" name="pais" id="f_pais" value="<?php echo $this->input->post('pais'); ?>" placeholder="País *">
	  </div>
	  <div class="form-group"> 
	    <input type="text" class="form-control" name="estado" id="f_estado" value="<?php echo $this->input->post('estado'); ?>" placeholder="Estado *">
	  </div>
	  <div class="form-group"> 
	    <input type="text" class="form-control" name="municipio" id="f_municipio" value="<?php echo $this->input->post('municipio'); ?>" placeholder="Municipio *">
	  </div>
	  <div class="form-group"> 
	    <input type="text" class="form-control" name="cp" id="f_cp" value="<?php echo $this->input->post('cp'); ?>" placeholder="Código Postal *">
	  </div>


	  <div class="checkbox">
	    <label>
		<input type="checkbox"  name="privacidad" value="1" id="" <?php if($this->input->post('privacidad')==1) echo "checked"; ?> > Confirmo que he leído la declaración de  <a href="<?php echo site_url('modulo/pagina/blank/politica-de-privacidad'); ?>" class="fancybox-frame">privacidad</a> y estoy de acuerdo con ella.
                            <!-- <span class="errores"><?php //echo form_error('privacidad'); ?></span> -->
	    </label>
	  </div>

	  <div class="formulario-button">
	  	<button type="button" class="btn btn-primary">Enviar</button>
	  </div>
	  
	  
	</form>

</div>
