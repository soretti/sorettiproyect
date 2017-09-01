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
                            <?php if($this->acceso->valida('pagina','editar')) {?>
                             <a class="btn btn-primary"  href="<?php echo base_url('modulo/columna/agregar') ?>"><i class="glyphicon glyphicon-plus icon-white"></i> Agregar</a>
                             <?php } ?>
                             <?php if($this->acceso->valida('pagina','eliminar')) {?>
                                <a class="btn btn-danger seleccionados" href="<?php echo base_url('modulo/columna/eliminar') ?>" ><i class="glyphicon glyphicon-trash icon-white"></i> Eliminar seleccionados</a>
                             <?php } ?>
                         </div>
                         
                         <div class="col-md-4" style="text-align:right">
                            <div class="input-group">
                              <input class="form-control" id="" name="buscar"  type="text" value="<?php echo $this->session->userdata('columna_buscar') ?>">
                              <span class="input-group-btn"> <input class="btn btn-default"  type="submit" name="action_buscar" value="Buscar"> </span>
                            </div>
                         </div>

</div>

            <div class="row">
                <div class="col-md-12">
                         <div class="table-responsive">
                            <table class="table table-bordered grid">   
                                        <?php
                                            $order=$this->session->userdata('columna_ordenar');
                                            $ico_order=($order[1]=='ASC') ? 'up' : 'down' ;
                                        ?>                                             
                                <thead>  
                                    <tr>                                     
                                        <th><input type="checkbox" class="checkall"></th>
                                        <th class="titulo_campos" campo="id">ID <?php if($order[0]=='id') echo "<i class='icon-chevron-$ico_order icon-white'></i>"; ?></th>
                                        <th class="titulo_campos" campo="titulo">Nombre <?php if($order[0]=='nombre') echo "<i class='icon-chevron-$ico_order icon-white'></i>"; ?></th>
                                        <th class="">ACCIONES</th>
                                    </tr>
                                </thead> 
                                <tbody>                                  
                                <?php foreach($columnas as $item) { ?> 
                                    <tr>
                                        <td nowrap><input type="checkbox" value="<?php echo $item->id; ?>"  name="post_ids[]"></td>
                                        <td nowrap><?php echo $item->id; ?></td>
                                        <td ><?php echo $item->nombre; ?></td>
                                        <td nowrap>
                                             <button class="btn seleccionar" type="button" value="<?php echo $item->id; ?>" titulo="<?php echo $item->nombre; ?>"   >Insertar</button>
                                             <?php if($this->acceso->valida('pagina','consultar')) {?>
                                            <a href="<?php echo base_url('modulo/columna/editar/'.$item->id); ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-edit"></i></a>
                                            <?php } ?>
                                             <?php if($this->acceso->valida('pagina','eliminar')) {?>
                                            <button class="btn btn-danger btn-sm action_row" value="basura" type="button" href="<?php echo base_url('modulo/columna/eliminar'); ?> " ><i class="glyphicon glyphicon-trash"></i></button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?> 
                                </tbody>                  
                            </table>
                            <?php echo $this->pagination->create_links(); ?>
                        </div>                
                </div>
            </div>
    </form>