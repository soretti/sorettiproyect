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
        <?php if($this->acceso->valida('catalogo','editar')) {?>
        <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/catalogo/catalogomarca/guardar/'.$marca->id) ?>')">Guardar</button>
        <?php } ?>
        <a class="btn btn-default" href="<?php echo base_url('modulo/catalogo/catalogomarca/listar') ?>">Regresar</a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tabbable">
        <ul class="nav nav-tabs" id="tabs_catalogo">
          <li class="active"><a href="#1" data-toggle="tab"> Contenido </a></li>
          <li><a href="#2" data-toggle="tab">Optimización SEO</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="1">
            <blockquote>
              <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>
            <div class="form-group">
              <label>Titulo: * </label>
              <input type="text" name="titulo" id="input-titulo" value="<?php echo $marca->titulo; ?>" class="form-control">
              <?php echo $marca->error->titulo; ?>
            </div>
            <div class="form-group">
              <label>Uri: *</label>
              <input type="text" name="uri" id="input-uri" value="<?php echo $marca->uri; ?>" class="form-control">
              <?php echo $marca->error->uri; ?>
            </div>
            <div class="form-group">
              <label>Descripción </label>
              <textarea name="descripcion" class="form-control"><?php echo $marca->descripcion; ?></textarea>
            </div>
            <div class="form-group">
              <label>Descripción Inglés </label>
              <textarea name="descripcion_en" class="form-control"><?php echo $marca->descripcion_en; ?></textarea>
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
          <div class="tab-pane" id="2">
            <blockquote>
              <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>
            <div class="form-group">
              <label>meta Titulo</label>
              <input type="text" name="metatitulo" id="input-metatitulo" value="<?php echo $marca->metatitulo; ?>" class="form-control">
            </div>
            <div class="form-group">
              <label>meta Tags:</label><small class="muted"> *10 palabras separadas por (,)</small>
              <input type="text" name="palabras_clave" id="palabras_clave" value="<?php echo $marca->palabras_clave; ?>" class="form-control">
            </div>
            <div class="form-group">
              <label>meta Tags Inglés:</label><small class="muted"> *10 palabras separadas por (,)</small>
              <input type="text" name="palabras_clave_en" id="palabras_clave_en" value="<?php echo $marca->palabras_clave_en; ?>" class="form-control">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>