<form action="" method="post" id="myform">
    <div class="row">
        <div class="col-md-12">
             <?php if(count($cuenta->error->all)) {?>
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
                <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/boletin/cuenta/guardar/'.$cuenta->id) ?>')">Guardar</button>
                <a class="btn btn-default" href="<?php echo base_url('modulo/boletin/cuenta/listar') ?>">Regresar</a>
                <?php if($cuenta->id) {?>
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
                    <label>Alias *</label>
                    <input type="text" name="alias" value="<?php echo $cuenta->alias ?>" class="form-control">
                    <?php echo $cuenta->error->alias; ?>                      
                </div> 
 
                <div class="form-group">
                    <label>Host *</label>
                    <input type="text" name="host" value="<?php echo $cuenta->host ?>" class="form-control">
                    <?php echo $cuenta->error->host; ?>                      
                </div>
 
                <div class="form-group">
                    <label>Puerto *</label>
                    <input type="text" name="puerto" value="<?php echo $cuenta->puerto ?>" class="form-control">
                    <?php echo $cuenta->error->puerto; ?>                      
                </div>

        
            <div class="form-group">
                <label>Email *</label>
                <input type="text" name="email" value="<?php echo $cuenta->email ?>" class="form-control">
                <?php echo $cuenta->error->email; ?>                      
            </div>
            

            <div class="form-group">
                <label>Password *</label>
                <input type="password" name="password" id="password" value="<?php echo $cuenta->password ?>" <?php  if($cuenta->id &&  !$this->input->post('cambiar_password') ) echo "disabled='true' "?>  class="form-control">
                <?php echo $cuenta->error->password; ?>
                <input type="hidden" name="cambiar_password" id="cambiar_password" value="<?php echo $this->input->post('cambiar_password') ?>">                    
            </div>                    
            

            <div class="form-group" id="confirmar_pass" <?php  if($cuenta->id &&  !$this->input->post('cambiar_password') ) echo "style='display:none' "?>> 
                <label>Confirmar password *</label>
                <input type="password" name="confirmar" id="confirmar" value="<?php echo $this->input->post('confirmar') ?>" class="form-control">
                <?php echo $cuenta->error->confirmar; ?>
             </div>
    </div>
</div>
</form>