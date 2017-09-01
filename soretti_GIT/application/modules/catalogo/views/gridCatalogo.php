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
        <?php if($this->acceso->valida('catalogo','editar')) {?>
        <a class="btn btn-primary"  href="<?php echo base_url('modulo/catalogo/agregar/') ?>"><i class="glyphicon glyphicon-plus icon-white"></i> Agregar</a>
        <?php } ?>
        <?php if($this->acceso->valida('catalogo','eliminar')) {?>
        <a class="btn btn-danger seleccionados" href="<?php echo base_url('modulo/catalogo/eliminar') ?>" ><i class="glyphicon glyphicon-trash icon-white"></i> Eliminar seleccionados</a>
        <?php } ?>
        <a class="btn btn-warning"  href="<?php echo base_url('modulo/catalogo/lote/') ?>"><i class="glyphicon glyphicon-sort-by-attributes icon-white"></i> Promociones por lote</a>
 

      </div>
      <div class="col-md-4" style="text-align:right">
        <div class="input-group">
           <input class="form-control" id="" name="buscar"  type="text" value="<?php echo $this->session->userdata('pagina_buscar') ?>">
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
                <th class="titulo_campos" campo="id">ID <?php icon_order($this->session->userdata('catalogo_ordenar'),'id'); ?></th>
                <th class="titulo_campos" campo="SKU">SKU <?php icon_order($this->session->userdata('catalogo_ordenar'),'SkU'); ?></th>
                <th class="titulo_campos" campo="titulo">TITULO <?php icon_order($this->session->userdata('catalogo_ordenar'),'titulo'); ?></th>
                <th class="titulo_campos" campo="categoria">CATEGORIA <?php icon_order($this->session->userdata('catalogo_ordenar'),'categoria'); ?></th>
                <th class="titulo_campos" campo="promocion">PROMOCIÓN <?php icon_order($this->session->userdata('catalogo_ordenar'),'promocion'); ?></th>
                <th class="titulo_campos" campo="agotado">AGOTADO <?php icon_order($this->session->userdata('catalogo_ordenar'),'agotado'); ?></th>
                <th class="">ACCIONES</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($catalogo as $cat) { ?>
              <tr>
                <td nowrap><input type="checkbox" value="<?php echo $cat->id; ?>"  name="post_ids[]"></td>
                <td nowrap><?php echo $cat->id; ?></td>
                <td><?php echo $cat->SKU ?></td>
                <td><?php echo $cat->titulo; ?></td>
                <td><?php echo $cat->cat_categoria_titulo; ?></td>
                <td> <?php if($cat->cat_precio_promocion) {?><span class="label label-success">Si</span><?php } else {?> <span class="label label-danger">No</span><?php } ?></td>
                <td> <?php if($cat->agotado) {?><span class="label label-success">Si</span><?php } else {?> <span class="label label-danger">No</span><?php } ?></td>
                <td nowrap>
                  <button class="btn  btn-default btn-sm seleccionar" type="button" value="<?php echo $cat->id; ?>" titulo="<?php echo $cat->titulo; ?>" uri="<?php echo base_url('producto/'.$cat->uri.".html"); ?>" > Insertar </button>
                  <?php if($this->acceso->valida('catalogo','consultar')) {?>
                  <a href="<?php echo base_url('modulo/catalogo/editar/'.$cat->id); ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-edit"></i></a>
                  <?php } ?>
                  <?php if($this->acceso->valida('catalogo','eliminar')) {?>
                  <button class="btn btn-danger btn-sm  action_row" value="basura" type="button" href="<?php echo base_url('modulo/catalogo/eliminar/'); ?> " ><i class="glyphicon glyphicon-trash"></i></button>
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
