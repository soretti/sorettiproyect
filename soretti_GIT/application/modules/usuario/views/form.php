
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
                <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/usuario/guardar/'.$usuario->id) ?>')">Guardar</button>
                <a class="btn btn-default" href="<?php echo base_url('modulo/usuario/lista') ?>">Regresar</a>
                <?php if($usuario->id) {?>
                <button class="btn btn-default" type="button" name="cambiar password" onclick="$('#password').val(''); $('#confirmar_pass').show();  $('#confirmar_pass').attr('disabled',false); $('#cambiar_password').val('1'); $('#password').attr('disabled',false); "> Modificar password </button>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <blockquote>
                <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>

             <div class="form-group">
                <label>Perfil: *</label> 
                 <select name="rol_id" class=" form-control">
                    <option value="">Selecciona una opción</option>
                    <?php foreach($roles as $rol) {?>
                    <option value="<?php echo $rol->id; ?>" <?php  if($usuario->rol_id==$rol->id) print("selected") ?>><?php echo $rol->nombre ?></option>
                    <?php } ?>
                 </select>
                  <?php echo $usuario->error->rol_id; ?>                               
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
                        <label>Apellido paterno: </label>
                        <input type="text" name="apellidoPaterno" value="<?php echo $usuario->apellidoPaterno ?>" class="form-control">                     
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Apellido materno: </label>
                        <input type="text" name="apellidoMaterno" value="<?php echo $usuario->apellidoMaterno ?>" class="form-control">                     
                    </div>
                </div>
            </div>
        
            <div class="form-group">
                <label>Email *</label>
                <input type="text" name="email" value="<?php echo $usuario->email ?>" class="form-control">
                <?php echo $usuario->error->email; ?>                      
            </div>
                
            <div class="form-group">
                <label>Password *</label>
                <input type="password" name="password" id="password" value="<?php echo $usuario->password ?>" <?php  if($usuario->id &&  !$this->input->post('cambiar_password') ) echo "disabled='true' "?>  class="form-control">
                <?php echo $usuario->error->password; ?>
                <input type="hidden" name="cambiar_password" id="cambiar_password" value="<?php echo $this->input->post('cambiar_password') ?>">                    
            </div>                    
            
            <div class="form-group" id="confirmar_pass" <?php  if($usuario->id &&  !$this->input->post('cambiar_password') ) echo "style='display:none' "?>> 
                <label>Confirmar password *</label>
                <input type="password" name="confirmar" id="confirmar" value="<?php echo $this->input->post('confirmar') ?>" class="form-control">
                <?php echo $usuario->error->confirmar; ?>
            </div>
 



    </div>
</div>
</form>