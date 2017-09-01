<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBqU6AYBdOl9IEs1N3i6IfoR-EQDrtC6BE&sensor=false"></script>
<script src="<?php echo base_url('pub/libraries/trahctools/js/direccion_editar.js');  ?>"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    initialize_map();
    });
});
</script>
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
                <button class="btn btn-primary" type="submit" onclick="goto('<?php echo base_url('modulo/mapa/guardar_bloque/'.$bloque->id.'/'.$bloques->id) ?>')">Guardar</button>
                <?php } ?>
                <a class="btn btn-default" href="<?php echo base_url('modulo/mapa/editar/'.$bloque->id) ?>">Regresar</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#1" data-toggle="tab">Contenido</a></li>
                    <li><a href="#3" data-toggle="tab">Mapa</a></li>
                    <li><a href="#2" data-toggle="tab">Publicación</a></li>
                    <li><a href="#4" data-toggle="tab">Inglés</a></li>
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
                            <label>Texto: * </label>
                            <textarea name="texto" class="form-control html-editable"><?php echo $bloques->texto; ?></textarea>
                            <?php echo $bloques->error->texto; ?>
                        </div>
                    </div>
                    <div class="tab-pane" id="3">
                        <?php $bloques->mapa->get();?>
                        <div class="form-group">
                            <div id="mapCanvas" style="width:100%; height:250px;"></div>
                            <label for=""> <i>Haga click y arrastre el marcador.</i></label>
                        </div>
                        <div id="form-group">
                            <label>Texto:</label>
                            <textarea name="texto_mapa" class="form-control" rows="5"><?php echo $bloques->mapa->texto ?></textarea>
                            <input type="hidden" name="coordenadas" id="info" value="<?php echo ($bloques->mapa->coordenadas) ? $bloques->mapa->coordenadas : '19.349918,-99.162421'; ?>">
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

                    <div class="tab-pane" id="4">

                        <div class="form-group">
                            <label>Titulo:  </label>
                            <input type="text" name="titulo_en" value="<?php echo $bloques->titulo_en; ?>" class="form-control">
                            <?php echo $bloques->error->titulo_en; ?>
                        </div>

                        <div id="form-group">
                            <label>Texto del Mapa:</label>
                            <textarea name="textomapa_en" class="form-control" rows="5"><?php echo $bloques->mapa->texto_en ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Texto:  </label>
                            <textarea name="texto_en" class="form-control html-editable"><?php echo $bloques->texto_en; ?></textarea>
                            <?php echo $bloques->error->texto_en; ?>
                        </div>



                    </div>



                </div>
            </div>

        </div>
    </form>
