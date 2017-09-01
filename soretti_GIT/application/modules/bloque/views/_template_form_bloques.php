<form action="" method="post" id="myform">
            
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
 
            <div class="row">
                <div class="col-md-12">
                    <legend><?php echo $this->titulo; ?></legend>
                    <div class="btn-toolbar">
                        <?php if($this->acceso->valida('bloque','editar')) {?>
                        <button class="btn btn-primary" type="submit" onclick="goto('<?php echo base_url('modulo/bloque/'.$this->uri->segment(3).'/guardar_bloque/'.$bloque->id.'/'.$bloques->id) ?>')">Guardar</button>
                        <?php } ?>
                        <a class="btn btn-inverse" href="<?php echo base_url('modulo/bloque/'.$this->uri->segment(3).'/editar/'.$bloque->id) ?>">Regresar</a>
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
                            <input type="text" name="titulo" value="<?php echo $bloques->titulo; ?>">
                            <input type="hidden" name="bloque_id" value="<?php echo $bloque->id; ?>">
                            <?php echo $bloques->error->titulo; ?>            
                    </div>
      
                    <div class="form-group">
                            <label>Subtitulo: </label>
                            <input type="text" name="subtitulo" value="<?php echo $bloques->subtitulo; ?>">
                            <?php echo $bloques->error->Subtitulo; ?>            
                    </div>

                    <div class="form-group">
                        <label>Descripción: </label>
                       <textarea name="descripcion"><?php echo $bloques->descripcion; ?></textarea>
                        <?php echo $bloques->error->descripcion; ?>
                    </div>
       
                        <div class="form-group">
                            <label>
                                Imagen &nbsp;<?php echo "(px ancho por px de alto)"; ?>
                                <small class="muted inline-block">&nbsp;Formatos: jpg, jpeg, gif, png</small>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon"><a href="#" class="show_image_input"> <i class="icon-eye-open"></i></a> </span>
                                <input class="span3" type="text" value="<?php echo $bloques->imagen ?>" name="imagen" width="" height="">
                                <span class="input-group-addon"><a href="<?php echo base_url('modulo/filemanager') ?>" class="filemanager popup"><small>Seleccionar archivo </small></a></span>
                            </div>
                            <?php echo $bloques->error->imagen; ?>
                        </div>
 

                         <div class="form-group">
                            <label class="control-label">Liga:</label>
                            <div class="input-group">
                                <input type="text" value="<?php echo $bloques->liga ?>" name="liga" class="span3">
                                <span class="input-group-addon"><a href="<?php echo base_url('modulo/link/agregar') ?>" class="popup"><small>Asistente</small></a></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><span>Abrir liga en:</span>
                                <span class="inline-block"><input type="radio" name="target" value="_self" <?php if($bloques->target=='_self') print("checked") ?>>&nbsp;la misma ventana&nbsp;<input type="radio" name="target" value="_blank" <?php if($bloques->target=='_blank') print("checked") ?>>&nbsp;una ventana nueva&nbsp;</span>
                            </label>
                        </div>
  


            </div>
        </div>
    </form>