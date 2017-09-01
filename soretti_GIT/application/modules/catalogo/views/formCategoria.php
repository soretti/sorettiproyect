<script>
    jQuery(document).ready(function($) {
        
        $("input[name=promocion]").click(function(){  
                    if( $(this).is( ":checked" ) ){
                        $("#mostrar-precio").removeClass('hide');
                    }else{
                         $("#mostrar-precio").addClass('hide');
                    }
                });

    });
</script>
<div class="row">
        <div class="col-md-12">
            <?php if(count($menu->error->all) || count($boton->error->all)) {?>
            <div class="alert alert-danger">
              <?php echo $this->lang->line('alert_error'); ?>
            </div>
            <?php } ?>
            <?php if($this->session->flashdata('alert_save')) {?>
                <div class="alert alert-success">
                  <?php echo $this->session->flashdata('alert_save'); ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <form action="" method="post" id="menu">

                <legend>ORDENAR CATEGORIAS</legend>

                <div class="btn-toolbar form-group">
                    <?php  echo '<button class="btn btn-success" id="guardar-menu" type="submit" onclick="goto(\''.base_url('modulo/catalogo/catalogocategoria/guardar').'\',\'menu\')">Guardar</button>'; ?>
                </div>

                <blockquote>
                    <small>Arrastra los elementos para ordenarlos</small>
                </blockquote>

                <?php
                echo '<input type="hidden" id="nestable2-output" name="nestable2-output">';
                echo $menu->nestable_menu;
                ?>
            </form>
        </div>


        <div class="col-md-6">

            <legend><?php echo ($boton->id) ? 'EDITAR CATEGORÍA' : 'AGREGAR CATEGORÍA' ?></legend>

            <form action="" method="post" id="boton">

                <div class="btn-toolbar form-group">
                     <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/catalogo/catalogocategoria/guardar_link/'.$menu->id.'/'.$boton->id); ?>','boton')">Guardar</button>
                     <?php if($boton->id) {?>
                        <a class="btn btn-default" href="<?php echo base_url('modulo/catalogo/catalogocategoria/editar'); ?>">Cancelar</a>
                     <?php } ?>
                </div>

                <blockquote>
                    <small>Los campos marcados con (*) son requeridos</small>
                </blockquote>

                <div class="tabbable">
                        
                         <ul class="nav nav-tabs">
                            <li class="active"><a href="#1" data-toggle="tab">Español</a></li>
                            <?php if( in_array('en',$this->config->item('idiomas','proyecto')) ) {?>
                            <li><a href="#2" data-toggle="tab">Inglés</a></li>
                            <?php } ?>
                        </ul>

                         <div class="tab-content">
                             <div class="tab-pane active" id="1">

                                <div class="form-group">
                                    <label>Titulo *</label>
                                    <input type="text" name="titulo" id="input-titulo" value="<?php echo $boton->titulo ?>" class="form-control">
                                    <?php echo $boton->error->titulo; ?>
                                </div> 

                                <div class="form-group">
                                    <label>Porcentaje *</label>
                                    <input type="text" name="porcentaje" id="input-porcentaje" value="<?php echo $boton->porcentaje ?>" class="form-control">
                                    <?php echo $boton->error->porcentaje; ?>
                                </div>


                                <div class="form-group">
                                    <label>URL *</label>
                                    <input type="text" name="uri" id="input-uri" value="<?php echo $boton->uri ?>" class="form-control">
                                    <?php echo $boton->error->uri; ?>
                                </div>

                                <div class="form-group">
                                  <label>
                                    Imagen   &nbsp;<?php echo "(".$menu->lista_w."px ancho por ".$menu->lista_h."px de alto)"; ?>
                                    <small class="muted inline-block">&nbsp;Formatos: jpg, jpeg, gif, png</small>
                                  </label>
                                  <div class="input-group">
                                    <span class="input-group-addon"><a href="#" class="show_image_input"> <i class="glyphicon glyphicon-eye-open"></i></a> </span>
                                    <input class="form-control" type="text" value="<?php echo $boton->imagen ?>" name="imagen" modulo="cat_categoria" width="<?php echo $menu->lista_w ?>" height="<?php echo $menu->lista_h ?>">
                                    <span class="input-group-addon"><a href="<?php echo base_url('modulo/filemanager') ?>" class="filemanager popup"><small>Seleccionar archivo </small></a></span>
                                  </div>
                                  <?php echo $boton->error->imagen; ?>
                                </div>

                                <div class="form-group">
                                    <label>meta Titulo: </label>
                                    <input type="text" name="metatitulo" id="input-metatitulo" value="<?php echo $boton->metatitulo ?>" class="form-control">
                                    <?php echo $boton->error->titulo; ?>
                                </div>


                                <div class="form-group">
                                    <label>meta Descripción: </label>
                                    <textarea name="descripcion" id=""  rows="5" class="form-control"><?php echo $boton->descripcion ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label>meta Tags:</label><small class="muted"> 10 palabras separadas por (,)</small>
                                    <input type="text" name="palabras_clave" id="palabras_clave" value="<?php echo $boton->palabras_clave; ?>" class="form-control">
                                </div>

                             </div>

                             <div class="tab-pane" id="2">

                                     <div class="form-group">
                                        <label>Titulo *</label>
                                        <input type="text" name="titulo_en" id="input-titulo" value="<?php echo $boton->titulo_en ?>" class="form-control">
                                        <?php echo $boton->error->titulo_en; ?>
                                    </div>

                                    <h5 class="page-header"> Optimizacion SEO</h5>
                                    <div class="form-group">
                                        <label>meta Titulo </label>
                                        <input type="text" name="metatitulo_en" id="input-metatitulo-en" value="<?php echo $boton->metatitulo_en; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>meta Descripción <small class="muted"> 150 caracteres máximo </small></label>
                                        <textarea name="descripcion_en" class="form-control"><?php echo $boton->descripcion_en; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>meta Tags:</label><small class="muted"> *10 palabras separadas por (,)</small>
                                        <input type="text" name="palabras_clave_en" id="palabras_clave_en" value="<?php echo $boton->palabras_clave_en; ?>" class="form-control">
                                    </div>

                            </div>

                      </div>
                </div>

            </form>
    </div>


</div>
