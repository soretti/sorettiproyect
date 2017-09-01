<div class="col-md-12 newsletter">
  <a href="" class="btn btnnaranaja" data-toggle="modal" data-target="#myModal2" style="z-index: 9;">Suscribirse al Newsletter</a>
  <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog item-panel morado">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Suscribirse al Newsletter</h4>
        </div>
        <div class="modal-body" id="formulario-newsletter">
           <div id="formulario-newsletter-inner">
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

          <form action="<?php echo base_url('modulo/boletin/boletinusuarios/guardarsuscriptor') ?>" method="post" id="myform">
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
              <input type="text" class="form-control hide" name="email_field"  value="" />
              <input type="text" name="email" value="<?php echo $usuario->email ?>" class="form-control">
              <?php echo $usuario->error->email; ?>                      
            </div>

            <div class="form-group">
              <label>Temas de interés: *</label> 

              <?php foreach($grupos as $grupo) {?>
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="grupos[]" value="<?php echo $grupo->id; ?>" <?php  if(in_array($grupo->id, explode(",",$usuario->grupos))) print("checked") ?>> <?php echo $grupo->nombre ?>
                </label>
              </div>
              <?php } ?>
              <?php echo $usuario->error->grupos; ?>                               
            </div>
            <input type="hidden" name="mnewsletter" id="mnewsletter" value="">
           <div class="form-group">
          <input type="checkbox"  name="privacidad" value="1" id="privacidad" <?php if($this->input->post('privacidad')==1) echo "checked"; ?> >  He leído y acepto la nota informativa sobre el  <a href="<?php echo site_url('modulo/pagina/blank/politica-de-privacidad'); ?>" class="fancybox-frame">aviso de privacidad. </a>
                                    
        </div><?php echo $usuario->error->privacidad; ?>            
          </form>


             </div>
          </div>

        </div>
         

        <div class="modal-footer">
          
          <button type="button" class="boton" data-dismiss="modal">Cancelar</button>
          <button class="boton" type="submit" id="suscribirse">Suscribirse</button>
        </div>
      </div>
    </div>
  </div>
</div>