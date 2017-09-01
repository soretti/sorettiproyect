       <form action="" method="post" id="myform">
            
            <div class="row">
                <div class="col-md-12">

                    <?php if(count($imagenes->error->all)) {?>
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
                        <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/galeria/guardar_imagen/'.$galeria.'/'.$imagenes->id) ?>')">Guardar</button>
                        <?php } ?>
                        <a class="btn btn-default" href="<?php echo base_url('modulo/galeria/editar/'.$galeria) ?>">Regresar</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <blockquote>
                        <small>Los campos marcados con (*) son requeridos</small>
                    </blockquote>
 
                    <div class="form-group">
                        <label>Titulo: </label>
                        <input type="text" name="title" value="<?php echo $imagenes->title; ?>"  class="form-control">
                        <input type="hidden" name="pagina_id" value="<?php echo $galeria; ?>">
                        <?php echo $imagenes->error->title; ?>            
                    </div>
                    
                    <div class="form-group">
                        <label>Titulo | Inglés: </label>
                        <input type="text" name="title_en" value="<?php echo $imagenes->title_en; ?>"  class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Descripción </label>
                       <textarea name="description"  class="form-control"><?php echo $imagenes->description; ?></textarea>
                        <?php echo $imagenes->error->description; ?>
                    </div>
 


                    <div class="form-group">
                        <label>Descripción | Inglés: </label>
                       <textarea name="description_en"  class="form-control"><?php echo $imagenes->description_en; ?></textarea>
                    </div>

                    <div class="form-group">
                    <label>
                        Imagen *&nbsp;<?php echo "({$imagenes->width}px ancho por {$imagenes->height}px de alto)"; ?>
                        <small class="muted inline-block">&nbsp;Formatos: jpg, jpeg, gif, png</small>
                    </label>

                    <div class="input-group">
                        <span class="input-group-addon"><a href="#" class="show_image_input"> <i class="glyphicon glyphicon-eye-open"></i></a> </span>
                        <input class="form-control" type="text" value="<?php echo $imagenes->path ?>" name="path" modulo='galeria' galeria="1"  width="<?php echo $imagenes->width ?>" height="<?php echo $imagenes->height ?>" >
                        <span class="input-group-addon"><a href="<?php echo base_url('modulo/filemanager') ?>" class="filemanager popup"><small>Seleccionar archivo </small></a></span>
                    </div>
                    <?php echo $imagenes->error->path; ?>
                </div>


            </div>
        </div>
    </form>