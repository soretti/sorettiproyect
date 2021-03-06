<form action="" method="post" id="myform">
  <div class="row">
    <div class="col-md-12">
      <?php if(count($bloques->error->all)) {?>
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
        <?php if($this->acceso->valida('pagina','editar')) {?>
        <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/carrusel/guardar_bloque/'.$bloque->id.'/'.$bloques->id) ?>')">Guardar</button>
        <?php } ?>
        <a class="btn btn-default" href="<?php echo base_url('modulo/carrusel/editar/'.$bloque->id) ?>">Regresar</a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tabbable">
        <ul class="nav nav-tabs" id="tabs_articulo">
          <li class="active"><a href="#1" data-toggle="tab"> Contenido </a></li>
          <li><a href="#2" data-toggle="tab">Publicación</a></li>
          <?php if(in_array('en',$this->config->item('idiomas','proyecto'))) {?> <li><a href="#3" data-toggle="tab">Inglés</a></li> <?php } ?>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="1">
            <blockquote>
              <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Titulo: * </label>
                  <input type="text" name="titulo" value="<?php echo $bloques->titulo; ?>" class="form-control">
                  <input type="hidden" name="bloque_id" value="<?php echo $bloque->id; ?>">
                  <?php echo $bloques->error->titulo; ?>
                </div>
              </div>
              <!--<div class="col-md-6">
                <div class="checkbox">
                  <label>
                    <input name="visible" type="checkbox" value="1" <?php //echo($bloques->visible==1) ? 'checked' : 'unchecked'; ?> > Mostrar título en slider
                  </label>
                </div>
              </div>
              -->
            </div>
            <!-- <div class="form-group">
              <label>Descripción: </label>
              <textarea name="texto" class="form-control"> <?php echo $bloques->texto; ?></textarea>
              <?php //echo $bloques->error->texto; ?>
            </div> -->
            <div class="form-group">
              <label>
              Imagen: * </label>&nbsp;<?php echo "({$bloques->img_width}px ancho por {$bloques->img_height}px de alto)"; ?>
              <small class="muted inline-block">&nbsp;Formatos: jpg, jpeg, gif, png</small>
              <div class="input-group col-md-6">
                <span class="input-group-addon"><a href="#" class="show_image_input"> <i class="glyphicon glyphicon-eye-open"></i></a> </span>
                <input class="form-control" type="text" value="<?php echo $bloques->imagen ?>" name="imagen" width="<?php echo $bloques->img_width; ?>" height="<?php echo $bloques->img_height; ?>">
                <span class="input-group-addon"><a href="<?php echo base_url('modulo/filemanager') ?>" class="filemanager popup"><small>Seleccionar archivo </small></a></span>
              </div>
              <?php echo $bloques->error->imagen; ?>
            </div>
            <div class="form-group ">
              <label class="control-label">Liga:</label>
              <div class="input-group col-md-6">
                <input type="text" value="<?php echo $bloques->liga ?>" name="liga" class="form-control">
                <span class="input-group-addon"><a href="<?php echo base_url('modulo/link/agregar') ?>" class="popup"><small>Asistente</small></a></span>
              </div>
            </div>
            <div class="form-group">
              <label><span>Abrir liga en:</span></label>
              <span class="inline-block"><input type="radio" name="target" value="_self" <?php if($bloques->target=='_self') print("checked") ?>>&nbsp;la misma ventana&nbsp;<input type="radio" name="target" value="_blank" <?php if($bloques->target=='_blank') print("checked") ?>>&nbsp;una ventana nueva&nbsp;</span>
            </div>
          </div>
          <div class="tab-pane" id="2">
            <div class="form-group">
              <label> Fecha de creación: </label>
              <div class="edicion_fecha">
                <div class="input-group">
                  <input class="form-control" type="text"  name="fecha_creacion" id="fecha_creacion" value="<?php echo $this->dateutils->format_date_time($bloques->fecha_creacion); ?>">
                  <span class="input-group-addon"><a href=""   onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Fecha de activación: </label>
              <div class="edicion_fecha">
                <div class="input-group">
                  <input class="form-control" type="text"  name="fecha_activacion" id="fecha_activacion" value="<?php echo $this->dateutils->format_date_time($bloques->fecha_activacion); ?>">
                  <span class="input-group-addon"><a href=""   onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Fecha de desactivación: </label>
              <div class="edicion_fecha">
                <div class="input-group">
                  <input class="form-control" type="text"  name="fecha_desactivacion" id="fecha_desactivacion" value="<?php echo $this->dateutils->format_date_time($bloques->fecha_desactivacion); ?>">
                  <span class="input-group-addon"><a href=""  onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="3">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Titulo:  </label>
                  <input type="text" name="titulo_en" value="<?php echo $bloques->titulo_en; ?>" class="form-control">
                  <?php echo $bloques->error->titulo_en; ?>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Descripción: </label>
              <textarea name="texto_en" class="form-control"> <?php echo $bloques->texto_en; ?></textarea>
              <?php echo $bloques->error->texto_en; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>