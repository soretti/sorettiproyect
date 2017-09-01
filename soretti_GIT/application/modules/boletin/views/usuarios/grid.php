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
      <?php if($this->acceso->valida('boletin','editar')) {?>
      <a class="btn btn-primary" href="<?php echo base_url('modulo/boletin/boletinusuarios/agregar') ?>"><span class="glyphicon glyphicon-plus icon-white"></span> Agregar </a>
      <?php } ?>
      <?php if($this->acceso->valida('boletin','eliminar')) {?>
      <a class="btn btn-danger seleccionados" href="<?php echo base_url('modulo/boletin/boletinusuarios/eliminar') ?>"><i class="glyphicon glyphicon-trash icon-white"></i> Eliminar seleccionados</a>
      <?php } ?>
    </div>
    <div class="col-md-4" style="text-align:right">
      <div class="input-group">
        <input class="form-control" name="buscar"  type="text" value="<?php echo $this->session->userdata('boletinusuarios_buscar') ?>">
        <span class="input-group-btn"><input class="btn btn-default"  type="submit" name="action_buscar" value="Buscar" ></span>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive">
        <table class="table table-bordered table-striped  grid">
          <thead>
            <tr>
              <th><input type="checkbox" class="checkall"></th>
              <th class="titulo_campos" campo="id">ID  <?php icon_order($this->session->userdata('boletinusuarios_ordenar'),'id'); ?> </th>
              <th class="titulo_campos" campo="nombre">NOMBRE <?php icon_order($this->session->userdata('boletinusuarios_ordenar'),'nombre'); ?></th>
              <th class="titulo_campos" campo="apellidoPaterno">APELLIDO PATERNO <?php icon_order($this->session->userdata('boletinusuarios_ordenar'),'apellidoPaterno'); ?> </th>
              <th class="titulo_campos" campo="apellidoMaterno">APELLIDO MATERNO <?php icon_order($this->session->userdata('boletinusuarios_ordenar'),'apellidoMaterno'); ?> </th>
              <th class="titulo_campos" campo="email">EMAIL <?php icon_order($this->session->userdata('boletinusuarios_ordenar'),'email'); ?></th>
              <th campo="grupos">GRUPOS <?php icon_order($this->session->userdata('boletinusuarios_ordenar'),'grupos'); ?></th>
              <th class="titulo_campos" campo="unsuscribed">INSCRITO <?php icon_order($this->session->userdata('boletinusuarios_ordenar'),'unsuscribed'); ?></th>
              <th class="">ACCIONES</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($usuarios as $usuario) { ?>
            <tr>
              <td><input type="checkbox" value="<?php echo $usuario->id; ?>"  name="post_ids[]"></td>
              <td><?php echo $usuario->id; ?></td>
              <td><?php echo $usuario->nombre; ?></td>
              <td><?php echo $usuario->apellidoPaterno; ?></td>
              <td><?php echo $usuario->apellidoMaterno; ?></td>
              <td><?php echo $usuario->email; ?></td>
              <td><?php echo $usuario->grupos; ?></td>
              <td>
                <?php if($usuario->unsuscribed){ ?>
                  <button type="button" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <?php }else{ ?>
                <button type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
                <?php } ?>
              </td>
              <td nowrap>
                <a href="<?php echo base_url('modulo/boletin/boletinusuarios/editar/'.$usuario->id); ?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-edit "></span></a>
                <?php if($this->acceso->valida('boletin','eliminar')) {?>
                <button class="btn btn-danger btn-sm  action_row" value="basura" type="button" href="<?php echo base_url('modulo/boletin/boletinusuarios/eliminar'); ?> " ><span class="glyphicon glyphicon-trash "></span></button>
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