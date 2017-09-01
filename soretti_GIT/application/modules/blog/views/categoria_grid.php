        <form action="" method="post" id="myform">
            <div class="row">
                <div class="col-md-12">

                    <?php if($this->session->flashdata('mensaje')) {?>
                        <div class="alert alert-success">
                          <?php echo $this->session->flashdata('mensaje'); ?>
                        </div>
                    <?php } ?>

                    <div class="btn-toolbar">
                        <?php if($this->acceso->valida('pagina','editar')) {?>
                        <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/blog/blogcategorias/guardar_orden/'.$pagina_id) ?>')">Guardar</button>
                        <?php } ?>

                          <a class="btn btn-primary" href="<?php echo base_url('modulo/blog/blogcategorias/agregar/'.$pagina_id) ?>">Agregar</a>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                     <?php if($categorias->result_count()) {?>


                        <blockquote>
                            <small>Arrastra los elementos para ordenarlos</small>
                        </blockquote>

                        <div id="contenedor_galeria" class="sortable">
                         <?php foreach ($categorias as $value) {?>
                                <div class="form-group">
                                     <div class="input-group col-md-6">
                                      <span class="input-group-addon"><a href="" class="remove_imagenes"><span class="glyphicon glyphicon-trash "></a> </span>
                                      <input class="trip" type="hidden" value="<?php echo $value->id ?>" name="categorias[]">
                                      <div class="form-control titulo"> <?php echo $value->titulo ?> </div>
                                      <span class="input-group-addon"><a href="<?php echo base_url('modulo/blog/blogcategorias/editar/'.$pagina_id.'/'.$value->id.'') ?>" class="filemanager"> <i class="glyphicon glyphicon-edit "></i></a></span>
                                    </div>
                                </div>
                        <?php } ?>
                        </div>

                    <?php } ?>
            </div>
        </div>
    </form>
