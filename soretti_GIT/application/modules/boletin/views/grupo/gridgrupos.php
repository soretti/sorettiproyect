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
        <?php if($this->acceso->valida('boletin','editar')) {?>
        <a class="btn btn-primary"  href="<?php echo base_url('modulo/boletin/grupos/agregar') ?>"><i class="glyphicon glyphicon-plus icon-white"></i> Agregar</a>
        <?php } ?>
        <?php if($this->acceso->valida('boletin','eliminar')) {?>
        <a class="btn btn-danger seleccionados" href="<?php echo base_url('modulo/boletin/grupos/eliminar') ?>" ><i class="glyphicon glyphicon-trash icon-white"></i> Eliminar seleccionados</a>
        <?php } ?>
      </div>
      <div class="col-md-4" style="text-align:right">
        <div class="input-group">
           <input class="form-control" id="" name="buscar"  type="text" value="<?php echo $this->session->userdata('grupos_buscar') ?>">
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
                <th class="titulo_campos" campo="id">ID <?php icon_order($this->session->userdata('grupos_ordenar'),'id'); ?></th>
                <th class="titulo_campos" campo="nombre">NOMBRE <?php icon_order($this->session->userdata('grupos_ordenar'),'nombre'); ?></th>
                <th class="">ACCIONES</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($grupos as $grupo) { ?>
              <tr>
                <td nowrap><input type="checkbox" value="<?php echo $grupo->id; ?>"  name="post_ids[]"></td>
                <td nowrap><?php echo $grupo->id; ?></td>
                <td ><?php echo $grupo->nombre; ?></td>


                <td nowrap>
                  <?php
                    if(!$grupo->tipo) $grupo->tipo='grupos';
                  ?>



                 <!--  <a href="<?php //echo base_url('modulo/blog/listar/'.$categoria->id); ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon glyphicon-th-list"></i></a> -->


                  <?php if($this->acceso->valida('boletin','consultar')) {?>
                  <a href="<?php echo base_url('modulo/boletin/grupos/editar/'.$grupo->id); ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-edit"></i></a>
                  <?php } ?>
                  <?php if($this->acceso->valida('boletin','eliminar')) {?>
                  <button class="btn btn-danger btn-sm  action_row" value="basura" type="button" href="<?php echo base_url('modulo/boletin/grupos/eliminar'); ?> " ><i class="glyphicon glyphicon-trash"></i></button>
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
