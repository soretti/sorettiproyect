
        <form action="" method="post" id="myform">

    <div class="row">
        <div class="col-md-12">
             <?php if(count($banner->error->all)) {?>
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
                <?php $id_banner=($banner->id) ? $banner->id : "0"; ?>
                <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/banners/guardar/'.$id_banner.'/'.$columna->id) ?>')">Guardar</button>
                <a class="btn btn-default" href="<?php echo base_url('modulo/banners/listar/'. $columna->id) ?>">Regresar</a>
            </div>
        </div>
    </div>
            <div class="row">
                <div class="col-md-12">

                    <blockquote>
                        <small>Los campos marcados con (*) son requeridos</small>
                    </blockquote>

                    <div class="form-group">
                        <label>Título: *</label>
                        <input type="text" name="titulo" value="<?php echo $banner->titulo ?>" id="titulo" class="form-control">
                        <?php echo $banner->error->titulo; ?>
                    </div>

                <div class="form-group">
                    <label>
                         Imagen *&nbsp;<?php echo "({$columna->width}px ancho por libre de alto)"; ?>
                        <small class="muted inline-block">&nbsp;Formatos: jpg, jpeg, gif, png</small>
                    </label>
                    <div class="input-group">
                       <span class="input-group-addon"><a href="#" class="show_image_input"> <i class="glyphicon glyphicon-eye-open"></i></a> </span>
                        <input class="form-control" type="text" value="<?php echo $banner->imagen ?>" name="imagen" modulo="banner" width="<?php echo $columna->width ?>" height="<?php echo $columna->height ?>">
                        <span class="input-group-addon"><a href="<?php echo base_url('modulo/filemanager') ?>" class="filemanager popup"><small>Seleccionar archivo </small></a></span>
                    </div>
                    <?php echo $banner->error->imagen; ?>
                </div>

                    <div class="form-group">
                        <label>Título de la imagen: *</label>
                        <input type="text" name="titulo_imagen" value="<?php echo $banner->titulo_imagen ?>" id="titulo_imagen" class="form-control">
                        <?php echo $banner->error->titulo_imagen; ?>
                    </div>

                         <div class="form-group">
                            <label class="control-label">Liga:</label>
                            <div class="input-group">
                                <input type="text" value="<?php echo $banner->liga ?>" name="liga" class="form-control">
                                <span class="input-group-addon"><a href="<?php echo base_url('modulo/link/agregar') ?>" class="popup"><small>Asistente</small></a></span>
                            </div>
                        </div> 


                    <div class="form-group">
                        <label><span>Abrir liga en:&nbsp;</span>
                            <span class="inline-block"><input type="radio" name="target" value="_self" <?php if($banner->target=='_self') print("checked") ?>>&nbsp;la misma ventana&nbsp;<input type="radio" name="target" value="_blank" <?php if($banner->target=='_blank') print("checked") ?>>&nbsp;una ventana nueva&nbsp;</span>
                        </label>
                    </div>
            </div>
        </div>
    </form>