<form action="" method="post" id="myform">
	<div class="row">
		 <div class="col-md-12">
		 	  <?php if(count($usuario->error->all)) {?>
            <div class="alert alert-danger">
              <?php echo $this->lang->line('alert_error'); ?>
            </div>
            <?php } ?>
            <?php if($this->session->flashdata('mensaje')) {?>
                <div class="alert alert-success">
                  <?php echo $this->session->flashdata('mensaje'); ?>
                </div>
            <?php } ?>

            <div class="btn-toolbar">
                 

                <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/boletin/boletinusuarios/guardar/'.$usuario->id) ?>')">Guardar</button>
                <a class="btn btn-default" href="<?php echo base_url('modulo/boletin/boletinusuarios/lista') ?>">Regresar</a>
                
            </div>

             <div class="row line">
             	<div class="col-md-4">
             		<div class="form-group">
             			<label>Nombre *</label>
	                    <input type="text" name="nombre" value="<?php echo $usuario->nombre ?>" class="form-control">
	                    <?php echo $usuario->error->nombre; ?>
             		</div>
             	</div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Apellido Paterno: </label>
                        <input type="text" name="apellidoPaterno" value="<?php echo $usuario->apellidoPaterno ?>" class="form-control">
                        <?php echo $usuario->error->apellidoPaterno; ?>                 
                    </div>
                </div>
             	<div class="col-md-4">
	                <div class="form-group">
	                    <label>Apellido Materno: </label>
	                    <input type="text" name="apellidoMaterno" value="<?php echo $usuario->apellidoMaterno ?>" class="form-control">
	                    <?php echo $usuario->error->apellidoMaterno; ?>                 
	                </div>
                </div>
             </div>
              <div class="form-group">
                <label>Email *</label>
                <input type="text" name="email" value="<?php echo $usuario->email ?>" class="form-control">
                <?php echo $usuario->error->email; ?>                      
            </div>

            <div class="form-group">
                <label>Grupos: *</label> 
                    <?php foreach($grupos as $grupo) {?>
                    <div class="checkbox">
				    <label>
				      <input type="checkbox" name="grupos[]" value="<?php echo $grupo->id; ?>" <?php  if(in_array($grupo->id, explode(",",$usuario->grupos))) print("checked") ?>> <?php echo $grupo->nombre ?>
				    </label>
				  </div>
                    <?php } ?>
                  <?php echo $usuario->error->grupos_id; ?>                               
            </div>
		 </div>
	</div>
</form>