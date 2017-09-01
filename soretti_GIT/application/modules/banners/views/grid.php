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
              <a class="btn btn-primary" href="<?php echo base_url('modulo/banners/agregar/'.$columna_id) ?>"><span class="glyphicon glyphicon-plus icon-white"></span> Agregar </a>
              <?php } ?>
              <?php if($this->acceso->valida('pagina','eliminar')) {?>
              <a class="btn btn-danger seleccionados" href="<?php echo base_url('modulo/banners/eliminar/') ?>"><i class="glyphicon glyphicon-trash icon-white"></i> Eliminar seleccionados</a>
              <?php } ?>
              <a class="btn btn-default" href="<?php echo base_url('modulo/columna/editar/'.$columna_id) ?>"> Regresar </a>

            </div>
            <div class="col-md-4" style="text-align:right">
              <div class="input-group">
                <input class="form-control" name="buscar"  type="text" value="<?php echo $this->session->userdata('banner_buscar') ?>">
                <span class="input-group-btn"><input class="btn btn-default"  type="submit" name="action_buscar" value="Buscar" ></span>
              </div>
            </div>
          </div>

            <div class="row">
                <div class="col-md-12">
                         <div class="table-responsive">
                            <table class="table table-bordered grid"> 
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="checkall"></th>
                                        <th class="titulo_campos" campo="id">ID <?php icon_order($this->session->userdata('banner_ordenar'),'id'); ?>  </th>
                                        <th class="titulo_campos" campo="titulo">TITULO <?php icon_order($this->session->userdata('banner_ordenar'),'titulo'); ?>  </th>
                                        <th class="titulo_campos" campo="imagen">IMAGEN <?php icon_order($this->session->userdata('banner_ordenar'),'imagen'); ?>  </th>
                                        <th class="titulo_campos" campo="liga">LIGA <?php icon_order($this->session->userdata('banner_ordenar'),'liga'); ?>  </th>
                                        <th class="">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($banner as $value) { ?>
                                    <tr>
                                        <td nowrap><input type="checkbox" value="<?php echo $value->id; ?>"  name="post_ids[]"></td>
                                        <td nowrap><?php echo $value->id; ?></td>
                                        <td nowrap><?php echo $value->titulo; ?></td>
                                        <td nowrap><?php echo $value->imagen; ?></td>
                                        <td nowrap><?php echo $value->liga; ?></td>
                                        <td nowrap>
                                            <a href="<?php echo base_url('modulo/banners/editar/'.$value->id.'/'.$columna_id); ?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-edit "></span></a>
                                             <?php if($this->acceso->valida('pagina','eliminar')) {?>
                                            <button class="btn btn-danger btn-sm  action_row" value="basura" type="button" href="<?php echo base_url('modulo/banners/eliminar/'.$columna_id); ?> " ><i class="glyphicon glyphicon-trash"></i></button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <div class="pagination pagination-right"> <?php echo $this->pagination->create_links(); ?> </div>
                        </div>
                </div>
            </div>
</form>
