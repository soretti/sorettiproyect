<form action="" method="post" id="myform">
  <div class="row">
    <div class="col-md-12">
      <?php if(count($articulo->error->all)) {?>
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
        <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/blog/guardar/'.$pagina_id.'/'.$articulo->id) ?>')">Guardar</button>
        <?php } ?>
        <a class="btn btn-default" href="<?php echo base_url('modulo/blog/listar/'.$pagina_id) ?>">Regresar</a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tabbable">
        <ul class="nav nav-tabs" id="tabs_articulo">
          <li class="active"><a href="#1" data-toggle="tab"> Contenido </a></li>
          <li><a href="#5" data-toggle="tab"> Pie de pagina </a></li>
          <li><a href="#2" data-toggle="tab">Optimización SEO </a></li>
          <li><a href="#3" data-toggle="tab">Publicación</a></li>
          <?php if(in_array('en',$this->config->item('idiomas','proyecto'))) {?><li><a href="#4" data-toggle="tab">Inglés</a></li><?php } ?>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="1">
            <blockquote>
              <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>
            <div class="form-group">
              <label>Titulo: * </label>
              <input type="text" name="titulo" id="input-titulo" value="<?php echo $articulo->titulo; ?>" class="form-control">
              <?php echo $articulo->error->titulo; ?>
            </div>
            <div class="form-group">
              <label>Uri: *</label>
              <input type="text" name="uri" id="input-uri" value="<?php echo $articulo->uri; ?>" class="form-control">
              <?php echo $articulo->error->uri; ?>
            </div>
            
            <?php if($pagina->c_categorias) {?>
            <div class="form-group">
                <label>Categoría: </label>
                <select name="categoria_id" id="" class="form-control">
                  <option value="">Seleccione una opción</option>
                  <?php foreach ($categorias as $categoria) {?>
                  <option value="<?php echo $categoria->id ?>" <?php if($articulo->categoria_id==$categoria->id) echo "selected"; ?>><?php echo $categoria->titulo ?></option>
                  <?php } ?>
                </select>
              </div>
            <?php } ?>

            <div class="form-group">
              <label>Resumen: </label>
              <textarea name="resumen" id=""  rows="5" class="form-control"><?php echo $articulo->resumen; ?></textarea>
            </div>
            <div class="form-group">
              <label>
                Imagen   &nbsp;<?php echo "(373px ancho por 245px de alto)"; ?>
                <small class="muted inline-block">&nbsp;Formatos: jpg, jpeg, gif, png</small>
              </label>
              <div class="input-group">
                <span class="input-group-addon"><a href="#" class="show_image_input"> <i class="glyphicon glyphicon-eye-open"></i></a> </span>
                <input class="form-control" type="text" value="<?php echo $articulo->resumen_imagen ?>" name="resumen_imagen" width="373" height="245">
                <span class="input-group-addon"><a href="<?php echo base_url('modulo/filemanager') ?>" class="filemanager popup"><small>Seleccionar archivo </small></a></span>
              </div>
              <?php echo $articulo->error->imagen; ?>
            </div>
            <div class="form-group">
              <label>Contenido: </label>
              <textarea name="contenido" id="" cols="30" rows="10" class="html-editable"><?php echo $articulo->contenido; ?></textarea>
            </div>
          </div>
          <div class="tab-pane" id="2">
            <div class="form-group">
              <label>meta Titulo *</label>
              <input type="text" name="metatitulo" id="input-metatitulo" value="<?php echo $articulo->metatitulo; ?>" class="form-control">
            </div>
            <div class="form-group">
              <label>Tags:</label>
              <input type="text" name="palabras_clave" id="palabras_clave" value="<?php echo $articulo->palabras_clave; ?>" class="form-control">
            </div>
          </div>
          <div class="tab-pane" id="3">
            <div class="form-group">
              <label> Fecha de creación: </label>
              <div class="edicion_fecha">
                <div class="input-group">
                  <input class="form-control" type="text"  name="fecha_creacion" id="fecha_creacion" value="<?php echo $this->dateutils->format_date_time($articulo->fecha_creacion); ?>">
                  <span class="input-group-addon"><a href=""   onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Fecha de activación: </label>
              <div class="edicion_fecha">
                <div class="input-group">
                  <input class="form-control" type="text"  name="fecha_activacion" id="fecha_activacion" value="<?php echo $this->dateutils->format_date_time($articulo->fecha_activacion); ?>">
                  <span class="input-group-addon"><a href=""   onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Fecha de desactivación: </label>
              <div class="edicion_fecha">
                <div class="input-group">
                  <input class="form-control" type="text"  name="fecha_desactivacion" id="fecha_desactivacion" value="<?php echo $this->dateutils->format_date_time($articulo->fecha_desactivacion); ?>">
                  <span class="input-group-addon"><a href=""  onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="4">
            <div class="form-group" style="margin-top:10px;">
              <a  href="#" class="btn btn-default" id="copy-content"> Copiar el contenido en español </a>
            </div>
            <div class="form-group">
              <label>Titulo: </label>
              <input type="text" name="titulo_en" id="input-titulo-en" value="<?php echo $articulo->titulo_en; ?>" class="form-control">
              <?php echo $articulo->error->titulo_en; ?>
            </div>
            <div class="form-group">
              <label>Resumen: </label>
              <textarea name="resumen_en" id=""  rows="5" class="form-control"><?php echo $articulo->resumen_en; ?></textarea>
            </div>
            <div class="form-group">
              <label>Contenido: </label>
              <textarea name="contenido_en" id="" cols="30" rows="10" class="html-editable"><?php echo $articulo->contenido_en; ?></textarea>
            </div>
            <div class="form-group">
              <label>meta Titulo *</label>
              <input type="text" name="metatitulo_en" id="input-metatitulo-en" value="<?php echo $articulo->metatitulo_en; ?>" class="form-control">
            </div>
            <div class="form-group">
              <label>Tags:</label>
              <input type="text" name="palabras_clave_en" id="palabras_clave_en" value="<?php echo $articulo->palabras_clave_en; ?>" class="form-control">
            </div>
          </div>


          <div class="tab-pane" id="5">
            <blockquote>
              <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>
            
            <div class="form-group">
              <label>Titulo: * </label>
              <input type="text" name="footer_titulo" value="<?php echo $articulo->footer_titulo; ?>" class="form-control">
            </div>

            <div class="form-group">
              <label>Subtitulo: * </label>
              <input type="text" name="footer_subtitulo" value="<?php echo $articulo->footer_subtitulo; ?>" class="form-control">
            </div>

            <div class="form-group">
              <label>
                Imagen   &nbsp;<?php echo "(1920px ancho por 650px de alto)"; ?>
                <small class="muted inline-block">&nbsp;Formatos: jpg, jpeg, gif, png</small>
              </label>
              <div class="input-group">
                <span class="input-group-addon"><a href="#" class="show_image_input"> <i class="glyphicon glyphicon-eye-open"></i></a> </span>
                <input class="form-control" type="text" value="<?php echo $articulo->footer_imagen ?>" name="footer_imagen" width="1920" height="650">
                <span class="input-group-addon"><a href="<?php echo base_url('modulo/filemanager') ?>" class="filemanager popup"><small>Seleccionar archivo </small></a></span>
              </div>
              <?php echo $articulo->error->footer_imagen; ?>
            </div>

            <div class="form-group ">
                <label class="control-label">Liga:</label>
                <div class="input-group col-md-6">
                    <input type="text" value="<?php echo $articulo->footer_liga ?>" name="footer_liga" class="form-control">
                    <span class="input-group-addon"><a href="<?php echo base_url('modulo/link/agregar') ?>" class="popup"><small>Asistente</small></a></span>
                </div>
                 <?php echo $articulo->error->footer_liga; ?>
            </div>

            <div class="form-group">
                <label><span>Abrir liga en:</span></label>
                <span class="inline-block"><input type="radio" name="footer_target" value="_self" <?php if($articulo->footer_target=='_self') print("checked") ?>>&nbsp;la misma ventana&nbsp;<input type="radio" name="footer_target" value="_blank" <?php if($articulo->footer_target=='_blank') print("checked") ?>>&nbsp;una ventana nueva&nbsp;</span>
            </div>  

          </div>


        </div>
      </div>
    </div>
  </div>
</form>
