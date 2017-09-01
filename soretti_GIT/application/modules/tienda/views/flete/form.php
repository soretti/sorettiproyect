<form action="" method="post" id="myform">
  <div class="row">
    <div class="col-md-12">
      <?php if(count($marca->error->all)) {?>
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
        <?php if($this->acceso->valida('fletes','editar')) {?>
        <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/tienda/flete/guardar/'.$marca->id) ?>')">Guardar</button>
        <?php } ?>
        <a class="btn btn-default" href="<?php echo base_url('modulo/tienda/flete/listar') ?>">Regresar</a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
            <blockquote>
              <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>
            <div class="form-group">
              <label>Titulo: * </label>
              <input type="text" name="titulo"  value="<?php echo $marca->titulo; ?>" class="form-control">
              <?php echo $marca->error->titulo; ?>
            </div>
            <div class="form-group">
              <label>URL: *</label>
              <input type="text" name="url" value="<?php echo $marca->url; ?>" class="form-control">
              <?php echo $marca->error->url; ?>
            </div>
            <div class="form-group">
              <label>
                Imagen   &nbsp;<?php echo "(".$marca->lista_w."px ancho por ".$marca->lista_h."px de alto)"; ?>
                <small class="muted inline-block">&nbsp;Formatos: jpg, jpeg, gif, png</small>
              </label>
              <div class="input-group">
                <span class="input-group-addon"><a href="#" class="show_image_input"> <i class="glyphicon glyphicon-eye-open"></i></a> </span>
                <input class="form-control" type="text" value="<?php echo $marca->imagen ?>" name="imagen" width="<?php echo $marca->lista_w; ?>" height="<?php echo $marca->lista_h; ?>">
                <span class="input-group-addon"><a href="<?php echo base_url('modulo/filemanager') ?>" class="filemanager popup"><small>Seleccionar archivo </small></a></span>
              </div>
              <?php echo $marca->error->imagen; ?>
            </div>            
      </div>
  </div>
</form>