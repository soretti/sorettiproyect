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
      <div class="col-md-8">
        <?php if($this->acceso->valida('tienda','editar')) {?>
        <a class="btn btn-primary"  href="<?php echo base_url('modulo/tienda/cupon/agregar/') ?>"><i class="glyphicon glyphicon-plus icon-white"></i> Agregar</a>
        <?php } ?>
        <?php if($this->acceso->valida('tienda','eliminar')) {?>
        <a class="btn btn-danger seleccionados" href="<?php echo base_url('modulo/tienda/cupon/eliminar') ?>" ><i class="glyphicon glyphicon-trash icon-white"></i> Eliminar seleccionados</a>
        <a class="btn btn-success seleccionados" href="<?php echo base_url('modulo/tienda/cupon/activar') ?>" ><i class="glyphicon glyphicon-ok icon-white"></i> Activar </a>
        <?php } ?>
      </div>
      <div class="col-md-4" style="text-align:right">
        <div class="input-group">
           <input class="form-control" id="" name="buscar"  type="text" value="<?php echo $this->session->userdata('cupon_buscar') ?>">
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
                <th class="titulo_campos" campo="id">ID <?php icon_order($this->session->userdata('cupon_ordenar'),'id'); ?></th>
                <th class="titulo_campos" campo="titulo">CUPON <?php icon_order($this->session->userdata('cupon_ordenar'),'cupon'); ?></th>  
                <th class="titulo_campos" campo="tipo_descuento">DESCUENTO <?php icon_order($this->session->userdata('cupon_ordenar'),'tipo_descuento'); ?></th>  
                <th class="titulo_campos" campo="canjeado">CANJEADO <?php icon_order($this->session->userdata('cupon_ordenar'),'canjeado'); ?></th>  
                <th class="titulo_campos" campo="is_enable">ACTIVO <?php icon_order($this->session->userdata('cupon_ordenar'),'is_enable'); ?></th>  
                <th class="">ACCIONES</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($marcas as $marca) { ?>
              <tr>
                <td nowrap><input type="checkbox" value="<?php echo $marca->id; ?>"  name="post_ids[]"></td>
                <td nowrap><?php echo $marca->id; ?></td>
                <td><?php echo $marca->cupon; ?></td>
                <td><?php echo $marca->descuento; echo ($marca->tipo_descuento=='porcentaje') ? "%" : "$" ?></td>
                <td><?php echo $marca->canjeado;  ?></td>
                <td><?php if($marca->is_enable) {?><span class="label label-success">Si</span><?php } else {?> <span class="label label-danger">No</span><?php } ?></td>
                 
                <td nowrap>
                  <?php if(!$marca->usuario->count()) {?>
                    <button class="btn  btn-default btn-sm seleccionar" type="button" value="" titulo="<?php echo $marca->cupon; ?>" uri="<?php echo $marca->id; ?>" > Insertar </button>
                  <?php } ?>

                  <?php if($this->acceso->valida('tienda','consultar')) {?>
                  <a href="<?php echo base_url('modulo/tienda/cupon/editar/'.$marca->id); ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-edit"></i></a>
                  <?php } ?>
                  <?php if($this->acceso->valida('tienda','eliminar')) {?>
                  <button class="btn btn-danger btn-sm  action_row" value="basura" type="button" href="<?php echo base_url('modulo/tienda/cupon/eliminar/'); ?> " ><i class="glyphicon glyphicon-trash"></i></button>
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
