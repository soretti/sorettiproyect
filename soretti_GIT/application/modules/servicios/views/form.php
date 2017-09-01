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
                <button class="btn btn-primary" type="submit" onclick="goto('<?php echo base_url('modulo/servicios/guardar_bloque/'.$bloque->id.'/'.$bloques->id) ?>')">Guardar</button>
                <?php } ?>
                <a class="btn btn-default" href="<?php echo base_url('modulo/servicios/editar/'.$bloque->id) ?>">Regresar</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#1" data-toggle="tab">Contenido</a></li>
                    <li><a href="#2" data-toggle="tab">Publicación</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="1">
                        <blockquote>
                            <small>Los campos marcados con (*) son requeridos</small>
                        </blockquote>
                        
                        <div class="form-group">
                            <label>Titulo: * </label>
                            <input type="text" name="titulo" value="<?php echo $bloques->titulo; ?>" class="form-control">
                            <input type="hidden" name="bloque_id" value="<?php echo $bloque->id; ?>">
                            <?php echo $bloques->error->titulo; ?>
                        </div> 

                        <div class="form-group">
                            <label>subtitulo: * </label>
                            <input type="text" name="subtitulo" value="<?php echo $bloques->subtitulo; ?>" class="form-control">
                            <?php echo $bloques->error->subtitulo; ?>
                        </div>

                        <div class="form-group">
                            <label>Texto: * </label>
                            <textarea name="texto" class="form-control"><?php echo $bloques->texto; ?></textarea>
                            <?php echo $bloques->error->texto; ?>
                        </div>

<!--                         <div class="form-group">
                            <label>
                                Imagen &nbsp;<?php echo "({$bloques->img_width}px ancho por {$bloques->img_height}px de alto)"; ?>
                                <small class="muted inline-block">&nbsp;Formatos: jpg, jpeg, gif, png</small>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon"><a href="#" class="show_image_input"> <i class="glyphicon glyphicon-eye-open"></i></a> </span>
                                <input class="form-control" type="text" value="<?php echo $bloques->imagen ?>" modulo="bloque_imagen" name="imagen" width="{$bloques->img_width}" height="{$bloques->img_height}">
                                <span class="input-group-addon"><a href="<?php echo base_url('modulo/filemanager') ?>" class="filemanager popup"><small>Seleccionar archivo </small></a></span>
                            </div>
                            <?php echo $bloques->error->imagen; ?>
                        </div> -->

                         <div class="form-group ">
                            <label class="control-label">Liga:</label>
                            <div class="input-group col-md-6">
                                <input type="text" value="<?php echo $bloques->liga ?>" name="liga" class="form-control">
                                <span class="input-group-addon"><a href="<?php echo base_url('modulo/link/agregar') ?>" class="popup"><small>Asistente</small></a></span>
                            </div>
                             <?php echo $bloques->error->liga; ?>
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
                </div>
            </div>
            
        </div>
    </form>