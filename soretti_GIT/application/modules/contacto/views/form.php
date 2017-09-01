<form action="" method="post" id="myform">
            
            <?php if(count($contacto->error->all)) {?>
                <div class="alert alert-danger">
                  <?php echo $this->lang->line('alert_error'); ?>
                </div>
            <?php } ?>

            <?php if($this->session->flashdata('mensaje')) {?>
                <div class="alert alert-success">
                  <?php echo $this->session->flashdata('mensaje'); ?>
                </div>
            <?php } ?>

            <div class="row">
                <div class="col-md-12">
                    <legend><?php echo ($contacto->id) ? 'EDITAR CONTACTO' : 'AGREGAR CONTACTO'; ?></legend>
                    <div class="btn-toolbar">
                        <?php if($this->acceso->valida('contacto','editar')) {?>
                        <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/contacto/guardar/'.$contacto->id) ?>')">Guardar</button>
                        <?php } ?>
                        <a class="btn btn-default" href="<?php echo base_url('modulo/contacto/listar') ?>">Regresar</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <blockquote>
                        <small>Los campos marcados con (*) son requeridos</small>
                    </blockquote>
                    
                    <div class="row">
                      <div class="col-md-6">
                      <div class="form-group">
                            <label>Nombre: * </label>
                            <input type="text" name="nombre" value="<?php echo $contacto->nombre; ?>"  class="form-control">   
                            <?php echo $contacto->error->nombre; ?>           
                      </div>
                      </div>
                      <div class="col-md-6">
                      <div class="form-group"> 
                            <label>Apellidos: </label>
                            <input type="text" name="apellidos" value="<?php echo $contacto->apellidos; ?>"  class="form-control">   
                            <?php echo $contacto->error->apellidos; ?>           
                    </div>
                    </div>
                    </div>

                       <div class="form-group">
                          <label>Email: *</label>
                          <input type="text" name="email" value="<?php echo $contacto->email; ?>"  class="form-control">
                          <?php echo $contacto->error->email; ?>            
                        </div>
                        <div class="row">
                        <div class="col-md-2 col-xs-4">
                       <div class="form-group">
                          <label>Lada: </label>
                          <input type="text" name="lada" value="<?php echo $contacto->lada; ?>"  class="form-control">         
                        </div>
                      </div>
                        <div class="col-md-10 col-xs-8">
                       <div class="form-group">
                          <label>Teléfono: </label>
                          <input type="text" name="telefono" value="<?php echo $contacto->telefono; ?>"  class="form-control">             
                        </div>
                      </div>
                      </div>

                       <div class="form-group">
                          <label>País: </label>
                          <input type="text" name="pais" value="<?php echo $contacto->pais; ?>"  class="form-control">             
                        </div>

                       <div class="form-group">
                          <label>Estado: </label>
                          <input type="text" name="estado" value="<?php echo $contacto->estado; ?>"  class="form-control">             
                        </div>

                       <div class="form-group">
                          <label>Ciudad: </label>
                          <input type="text" name="ciudad" value="<?php echo $contacto->ciudad; ?>"  class="form-control">             
                        </div>
            </div>
        </div>
    </form>