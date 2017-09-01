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
                        <?php if($this->acceso->valida('pagina','editar')) {?>
                        <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/'.$this->uri->segment(2).'/guardar/'.$bloque->id) ?>')">Guardar</button>
                        <?php } ?>

                        <?php if( $tipoBloque->configuracion['max-items'] > $bloque->bloquecontenidos->where('is_enable',1)->count() ||  $tipoBloque->configuracion['max-items']==0   ) {
                                if($bloque->id!=6){?>
                                <a class="btn btn-primary" href="<?php echo base_url('modulo/'.$this->uri->segment(2).'/agregar_bloque/'.$bloque->id.'/'.$categoria_id) ?>">Agregar</a>
                        <?php } } ?>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <blockquote>
                        <small>Los campos marcados con (*) son requeridos</small>
                    </blockquote>

                    <div class="form-group">
	                        <label>Titulo: *  </label>
	                        <input type="text" name="titulo" value="<?php echo $bloque->titulo; ?>"  class="form-control">
                            <?php echo $bloque->error->titulo ?>
                    </div>
                     <?php if($bloque->id) {?>


                        <blockquote>
                            <small>Arrastra los elementos para ordenarlos</small>
                        </blockquote>

                        <div id="contenedor_galeria row" class="<?php if($tipoBloque->configuracion['sortable']==1) echo "sortable" ?>">
                         <?php foreach ($bloques as $value) {?>
                                <div class="form-group">
                                     <div class="input-group col-md-6">
                                      <span class="input-group-addon"><a href="" class="remove_imagenes"><span class="glyphicon glyphicon-trash "></a> </span>
                                      <input class="trip" type="hidden" value="<?php echo $value->id ?>" name="slide[]">
                                      <div class="form-control titulo"> <?php echo $value->titulo ?> </div>
                                      <span class="input-group-addon"><a href="<?php echo base_url('modulo/'.$this->uri->segment(2).'/editar_bloque/'.$bloque->id.'/'.$value->id) ?>" class="filemanager"> <i class="glyphicon glyphicon-edit "></i></a></span>
                                    </div>
                                </div>
                        <?php } ?>
                        </div>

                    <?php } ?>
            </div>
        </div>
    </form>
