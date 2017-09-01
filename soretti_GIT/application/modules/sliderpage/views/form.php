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
                            <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/sliderpage/guardar_bloque/'.$bloque->id.'/'.$id_page.'/'.$bloques->id) ?>')">Guardar</button>
                        <?php } ?>
                        <a class="btn btn-default" href="<?php echo base_url('modulo/sliderpage/editar/'.$bloque->id.'/'.$id_page) ?>">Regresar</a>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="tabbable">
                        <ul class="nav nav-tabs" id="tabs_articulo">
                          <li class="active"><a href="#1" data-toggle="tab"> Contenido </a></li>
                          <li><a href="#2" data-toggle="tab">Publicación</a></li>
                          <?php if(in_array('en',$this->config->item('idiomas','proyecto'))) {?><li><a href="#3" data-toggle="tab">Inglés</a></li><?php } ?>
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

                    <div class="col-md-6">

                      <!-- <div class="checkbox">
                        <label>
                          <input name="visible_titulo" type="checkbox" value="1" <?php //echo($bloques->visible_titulo==1) ? 'checked' : 'unchecked'; ?> > Mostrar título en slider
                        </label>
                      </div> -->

                    </div>

                    </div>
                       


                       <div class="form-group">
                           <label>Descripción: </label>
                           <textarea name="texto" class="form-control html-editable"> <?php echo $bloques->texto; ?></textarea>
                           <?php echo $bloques->error->texto; ?>
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                              <label>
                                <input name="visible_titulo" type="checkbox" value="1" <?php echo($bloques->visible_titulo==1) ? 'checked' : 'unchecked'; ?> > <strong>Mostrar descripción en slider</strong> 
                              </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>
                                Imagen: * </label>&nbsp;<?php echo "({$bloques->image_w}px ancho por {$bloques->image_h}px de alto)"; ?>
                                <small class="muted inline-block">&nbsp;Formatos: jpg, jpeg, gif, png</small>

                            <div class="input-group col-md-6">
                                <span class="input-group-addon"><a href="#" class="show_image_input"> <i class="glyphicon glyphicon-eye-open"></i></a> </span>
                                <input class="form-control" type="text" value="<?php echo $bloques->imagen ?>" name="imagen" width="<?php echo $bloques->image_w ?>" height="<?php echo $bloques->image_h ?>">
                                <span class="input-group-addon"><a href="<?php echo base_url('modulo/filemanager') ?>" class="filemanager popup"><small>Seleccionar archivo </small></a></span>
                            </div>
                            <?php echo $bloques->error->imagen; ?>
                        </div>

                        <div class="form-group">
                            <label><span>Mostrar slider:</span></label>
                            <span class="inline-block"><input type="radio" name="visible" value="0" <?php if($bloques->visible=='0') print("checked") ?>>&nbsp;si&nbsp;<input type="radio" name="visible" value="1" <?php if($bloques->visible=='1') print("checked") ?>>&nbsp;no&nbsp;</span>
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
