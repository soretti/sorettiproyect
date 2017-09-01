<form action="" method="post" id="myform">

            <div class="row">
                <div class="col-md-12">

                    <?php if(count($bloque->error->all)) {?>
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

                            <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/tienda/tipocambio/guardar') ?>')">Guardar</button>

                        <a class="btn btn-default" href="<?php echo base_url('modulo/tienda/tipocambio/listar') ?>">Regresar</a>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="tabbable">
                        <ul class="nav nav-tabs" id="tabs_articulo">
                          <li class="active"><a href="#1" data-toggle="tab"> Contenido </a></li>
                          <!-- <li><a href="#2" data-toggle="tab">Publicación</a></li> -->
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
                                <label>Precio: * </label>
                                <input type="text" name="tipocambio" value="<?php echo $bloque->tipocambio; ?>" class="form-control">
                                <?php echo $bloque->error->tipocambio; ?>
                        </div>

                    </div>



                    </div>

                        </div>


                        <div class="tab-pane" id="2">
                         <div class="form-group">
                                    <label> Fecha de creación: </label>
                                     <div class="edicion_fecha">
                                        <div class="input-group">
                                          <input class="form-control" type="text"  name="fecha_creacion" id="fecha_creacion" value="<?php echo $this->dateutils->format_date_time($bloque->fecha_creacion); ?>">
                                          <span class="input-group-addon"><a href=""   onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
                                        </div>
                                      </div>
                                 </div>

                                <div class="form-group">
                                    <label>Fecha de activación: </label>
                                     <div class="edicion_fecha">
                                        <div class="input-group">
                                          <input class="form-control" type="text"  name="fecha_activacion" id="fecha_activacion" value="<?php echo $this->dateutils->format_date_time($bloque->fecha_activacion); ?>">
                                          <span class="input-group-addon"><a href=""   onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
                                        </div>
                                     </div>
                                 </div>

                                <div class="form-group">
                                    <label>Fecha de desactivación: </label>
                                     <div class="edicion_fecha">
                                        <div class="input-group">
                                          <input class="form-control" type="text"  name="fecha_desactivacion" id="fecha_desactivacion" value="<?php echo $this->dateutils->format_date_time($bloque->fecha_desactivacion); ?>">
                                          <span class="input-group-addon"><a href=""  onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
                                        </div>
                                     </div>
                                 </div>

                                </div>
                    <div class="tab-pane" id="3">
                  <div class="row">

                    <div class="col-md-6">


                    </div>

                    </div>

                        </div>
                          </div>
                    </div>

            </div>
        </div>
    </form>
