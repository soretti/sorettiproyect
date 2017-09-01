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
                
                        <div class="col-md-8 grid_acciones">
                            <?php if($this->acceso->valida('contacto','editar')) {?>
                             <a class="btn btn-primary"  href="<?php echo base_url('modulo/contacto/agregar') ?>"><i class="glyphicon glyphicon-plus icon-white"></i> Agregar</a>
                             <?php } ?>
                             <?php if($this->acceso->valida('contacto','eliminar')) {?>
                                <a class="btn btn-danger seleccionados" href="<?php echo base_url('modulo/contacto/eliminar') ?>" ><i class="glyphicon glyphicon-trash icon-white"></i> Eliminar seleccionados</a>
                             <?php } ?>
                                <a class="btn btn-default" href="<?php echo base_url('modulo/contacto/exportar') ?>" ><i class="glyphicon glyphicon glyphicon-export icon-white"></i> Exportar</a>

                         </div>
                         
                         <div class="col-md-4" style="text-align:right">
                            <div class="input-group">
                              <input class="form-control" id="" name="buscar"  type="text" value="<?php echo $this->session->userdata('contacto_buscar') ?>">
                              <span class="input-group-btn"><input class="btn btn-default"  type="submit" name="action_buscar" value="Buscar"></span>
                            </div>
                         </div>
            </div>
            <div class="row">
                <div class="col-md-12">                          
                         <div class="table-responsive">
                            <table class="table table-bordered grid">   
                                        <?php
                                            $order=$this->session->userdata('contacto_ordenar');
                                            $ico_order=($order[1]=='ASC') ? 'up' : 'down' ;
                                        ?>                                             
                                <thead>  
                                    <tr>                                     
                                        <th><input type="checkbox" class="checkall"></th>
                                        <th class="titulo_campos" campo="nombre">NOMBRE <?php if($order[0]=="nombre") echo "<i class='icon-chevron-$ico_order icon-white'></i>"; ?></th>
                                        <th class="titulo_campos" campo="apellidos">APELLIDOS <?php if($order[0]=="apellidos") echo "<i class='icon-chevron-$ico_order icon-white'></i>"; ?></th>
                                        <th class="titulo_campos" campo="email">EMAIL <?php if($order[0]=="email") echo "<i class='icon-chevron-$ico_order icon-white'></i>"; ?></th>
                                        <th class="titulo_campos" campo="lada">LADA <?php if($order[0]=="lada") echo "<i class='icon-chevron-$ico_order icon-white'></i>"; ?></th>
                                        <th class="titulo_campos" campo="telefono">TELÉFONO <?php if($order[0]=="telefono") echo "<i class='icon-chevron-$ico_order icon-white'></i>"; ?></th>
                                        <th class="titulo_campos" campo="pais">PAÍS <?php if($order[0]=="pais") echo "<i class='icon-chevron-$ico_order icon-white'></i>"; ?></th>
                                        <th class="titulo_campos" campo="estado">ESTADO <?php if($order[0]=="estado") echo "<i class='icon-chevron-$ico_order icon-white'></i>"; ?></th>
                                        <th class="titulo_campos" campo="ciudad">CIUDAD <?php if($order[0]=="ciudad") echo "<i class='icon-chevron-$ico_order icon-white'></i>"; ?></th>
                                        <th class="">ACCIONES</th>
                                    </tr>
                                </thead> 
                                <tbody>                                  
                                <?php foreach($contacto as $item) { ?> 
                                    <tr>
                                        <td nowrap><input type="checkbox" value="<?php echo $item->id; ?>"  name="post_ids[]"></td>
                                        <td nowrap><?php echo $item->nombre; ?></td>
                                        <td nowrap><?php echo $item->apellidos; ?></td>
                                         <td nowrap><?php echo $item->email; ?></td>
                                         <td nowrap><?php echo $item->lada; ?></td>
                                         <td nowrap><?php echo $item->telefono; ?></td>
                                         <td nowrap><?php echo $item->pais; ?></td>
                                         <td nowrap><?php echo $item->estado; ?></td>
                                         <td nowrap><?php echo $item->ciudad; ?></td>
                         
                                        <td nowrap>
                                             <?php if($this->acceso->valida('contacto','consultar')) {?>
                                            <a href="<?php echo base_url('modulo/contacto/editar/'.$item->id); ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-edit"></i></a>
                                            <?php } ?>
                                            <button class="btn btn-danger btn-sm action_row" value="basura" type="button" href="<?php echo base_url('modulo/contacto/eliminar'); ?> " ><i class="glyphicon glyphicon-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php } ?> 
                                </tbody>                  
                            </table>
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                        </fieldset>                 
                </div>
            </div>
    </form>