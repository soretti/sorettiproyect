<form action="" method="post" id="myform">
        <input type="hidden" name="ordenar" id="ordenar" value="">
         <div class="row">
            <div class="col-md-12">
                <?php if($this->session->flashdata('mensaje')) {?>
                    <div class="alert alert-success">
                      <?php echo $this->session->flashdata('mensaje'); ?>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                     <div class="grid_acciones form-group">
                        <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/galeria/guardar_orden') ?>')">Guardar</button>
                        <?php if($this->acceso->valida('pagina','editar')) {?>
                         <a class="btn btn-default"  href="<?php echo base_url('modulo/galeria/agregar') ?>">Agregar</a>
                         <?php } ?>
                     </div>

                  <blockquote>
                      <small>Arrastra los elementos para ordenarlos</small>
                  </blockquote>

                    <div id="contenedor_galeria">
                     <?php foreach ($galeria as $value) {?>
                        <div class="form-group">
                             <div class="input-group">
                              <span class="input-group-addon"><a href="<?php  ?>" class="remove_imagenes"> <i class="glyphicon glyphicon-trash"></i></a> </span>
                              <input class="trip form-control" type="hidden" value="<?php echo $value->id ?>" name="slide[]">
                              <div   class="form-control titulo"> <?php echo $value->title ?> </div>
                              <span class="input-group-addon"><a href="<?php echo base_url('modulo/galeria/editar/'.$value->id) ?>" class="filemanager"> Editar </a></span>
                            </div>
                        </div>
                    <?php } ?>
                    </div>              
            </div>
        </div>
</form>