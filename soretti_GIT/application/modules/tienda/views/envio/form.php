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

                            <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/tienda/envio/guardar_configuracion') ?>')">Guardar</button>

                        <!-- <a class="btn btn-default" href="<?php //echo base_url('modulo/tienda/configuracion/listar') ?>">Regresar</a> -->
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="tabbable">
                        <ul class="nav nav-tabs" id="tabs_articulo">
                          <li class="active"><a href="#1" data-toggle="tab"> Contenido </a></li>

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
                                     <input type="checkbox"  name="gratis" value="1" id="gratis" <?php if($bloque->gratis==1) echo "checked"; ?> onclick="adicionar();" > Envío Gratis
                      </div>


                      <div class="modulo-config">

                                    <div class="row">
                                            <div class="col-md-6">
                                                     <div class="form-group">
                                                              <input type="checkbox"  name="gratisop" value="1" id="gratisop" <?php if($bloque->gratisop==1) echo "checked"; ?> class="opciones"  > Envío Gratis a partir de:
                                                              <input type="hidden" name="gratisop2" value="<?php if($bloque->gratisop==1) echo 1; ?>" >
                                                      </div>
                                            </div>
                                            <div class="col-md-6">
                                                    <div class="form-group">
                                                            <input class="form-control opciones" type="text"  name="gratis_cantidad" id="gratis_cantidad" value="<?php echo $bloque->gratis_cantidad; ?>">
                                                            <input type="hidden" name="gratis_cantidad2" value="<?php echo $bloque->gratis_cantidad; ?>">
                                                            <?php echo $bloque->error->gratis_cantidad; ?>
                                                    </div>
                                            </div>
                                    </div>

                                    <div class="row">
                                            <div class="col-md-6">
                                                     <div class="form-group">
                                                              <input type="checkbox"  name="tarifaop" value="1" id="tarifaop" <?php if($bloque->tarifaop==1) echo "checked"; ?> class="opciones" > Tarifa fija:
                                                              <input type="hidden" name="tarifaop2" value="<?php if($bloque->tarifaop==1) echo 1; ?>" >
                                                      </div>
                                            </div>
                                            <div class="col-md-6">
                                                    <div class="form-group">
                                                            <input class="form-control opciones" type="text"  name="tarifa" id="tarifa" value="<?php echo $bloque->tarifa; ?>">
                                                            <input type="hidden" name="tarifa2" value="<?php echo $bloque->tarifa; ?>">
                                                            <?php echo $bloque->error->tarifa; ?>
                                                    </div>
                                            </div>
                                    </div>

                      </div>


                    </div>
                    </div>

                        </div>


                        <div class="tab-pane" id="2">


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
