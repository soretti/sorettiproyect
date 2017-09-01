<form action="" method="post" id="myform">

            <div class="row">
                <div class="col-md-12">

                    <?php if(count($categoria->error->all)) {?>
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
                            <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/blog/blogcategorias/guardar/'.$pagina_id.'/'.$categoria->id) ?>')">Guardar</button>
                        <?php } ?>
                        <a class="btn btn-default" href="<?php echo base_url('modulo/blog/blogcategorias/listar/'.$pagina_id) ?>">Regresar</a>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">

              <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#1" data-toggle="tab">Contenido</a></li>
                    <li><a href="#2" data-toggle="tab">Inglés</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="1">

                    <blockquote>
                        <small>Los campos marcados con (*) son requeridos</small>
                    </blockquote>
                    
                    <div class="form-group">
                            <label>Titulo: * </label>
                            <input type="text" name="titulo" id="input-titulo" value="<?php echo $categoria->titulo; ?>" class="form-control">
                            <?php echo $categoria->error->titulo; ?>
                    </div>
                    <div class="form-group">
                            <label>URI: * </label>
                            <input type="text" name="uri" id="input-uri" value="<?php echo $categoria->uri; ?>" class="form-control">
                            <?php echo $categoria->error->uri; ?>
                    </div>
                    <div class="form-group">
                            <label>meta Titulo:  </label>
                            <input type="text" name="metatitulo" id="input-metatitulo" value="<?php echo $categoria->metatitulo; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>meta Descripción: </label>
                        <textarea name="descripcion" id=""  rows="5" class="form-control"><?php echo $categoria->descripcion ?></textarea> 
                    </div>

                    <div class="form-group">
                        <label>meta Tags:</label><small class="muted"> 10 palabras separadas por (,)</small>
                        <input type="text" name="palabras_clave" id="palabras_clave" value="<?php echo $categoria->palabras_clave; ?>" class="form-control">
                    </div>
                   </div>
                    <div class="tab-pane" id="2">

                    <div class="form-group">
                            <label>Titulo: </label>
                            <input type="text" name="titulo_en" id="input-titulo-en" value="<?php echo $categoria->titulo_en; ?>" class="form-control">
                            <?php echo $categoria->error->titulo_en; ?>
                    </div>
                    <div class="form-group">
                            <label>meta Titulo:  </label>
                            <input type="text" name="metatitulo_en" id="input-metatitulo-en" value="<?php echo $categoria->metatitulo_en; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>meta Descripción: </label>
                        <textarea name="descripcion_en" id=""  rows="5" class="form-control"><?php echo $categoria->descripcion_en ?></textarea> 
                    </div>
                    <div class="form-group">
                        <label>meta Tags:</label><small class="muted"> 10 palabras separadas por (,)</small>
                        <input type="text" name="palabras_clave_en" id="palabras_clave_en" value="<?php echo $categoria->palabras_clave_en; ?>" class="form-control">
                    </div>
                   </div>
                </div>
               </div>
            </div>
        </div>
    </form>
