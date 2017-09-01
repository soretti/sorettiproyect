        <form action="" method="post" id="myform">
            <input type="hidden" name="ordenar" id="ordenar" value="">
             <div class="row">
                <div class="col-md-12">

                    <?php if($this->session->flashdata('mensaje')) {?>
                        <div class="alert alert-success">
                          <?php echo $this->session->flashdata('mensaje'); ?>
                        </div>
                    <?php } ?>

                    <legend><?php echo $this->titulo; ?></legend>
                </div>
            </div>
            <div class="row-fluid">
                <div class="col-md-12">

                         <div class="span6 grid_acciones">
                            <?php if($this->acceso->valida('pagina','editar')) {?>
                             <a class="btn btn-primary"  href="<?php echo base_url('modulo/bloque/agregar') ?>"><i class="glyphicon glyphicon-plus icon-white"></i> Agregar</a>
                             <?php } ?>
                             <?php if($this->acceso->valida('pagina','eliminar')) {?>
                                <a class="btn btn-danger seleccionados" href="<?php echo base_url('modulo/bloque/eliminar') ?>" ><i class="glyphicon glyphicon-trash icon-white"></i> Eliminar seleccionados</a>
                             <?php } ?>
                         </div>

                         <div class="span6" style="text-align:right">
                            <div class="input-append">
                              <input class="" id="" name="buscar"  type="text" value="<?php echo $this->session->userdata('bloque_buscar') ?>">
                              <input class="btn"  type="submit" name="action_buscar" value="Buscar">
                            </div>
                         </div>

                        <fieldset>
                         <div class="table-responsive">
                            <table class="table table-bordered grid">
                                        <?php
                                            $order=$this->session->userdata('bloque_ordenar');
                                            $ico_order=($order[1]=='ASC') ? 'up' : 'down' ;
                                        ?>
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="checkall"></th>
                                        <th class="titulo_campos" campo="titulo">TITULO <?php if($order[0]=="titulo") echo "<i class='icon-chevron-$ico_order icon-white'></i>"; ?></th>

                                        <th class="">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($bloque as $item) { ?>
                                    <tr>
                                        <td nowrap><input type="checkbox" value="<?php echo $item->id; ?>"  name="post_ids[]"></td>
                                        <td nowrap><?php echo $item->titulo; ?></td>
                                        <td nowrap>
                                             <?php if($this->acceso->valida('pagina','consultar')) {?>
                                            <!-- <a href="<?php echo base_url('modulo/bloque/editar/'.$item->id); ?>" class="btn"><i class="glyphicon glyphicon-edit"></i></a> -->
                                            <?php } ?>
                                            <button class="btn action_row" value="basura" type="button" href="<?php echo base_url('modulo/bloque/eliminar'); ?> " ><i class="glyphicon glyphicon-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <div class="pagination pagination-right"> <?php echo $this->pagination->create_links(); ?> </div>
                        </div>
                        </fieldset>
                </div>
            </div>
    </form>
