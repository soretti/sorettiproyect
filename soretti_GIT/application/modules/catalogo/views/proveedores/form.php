<form action="" method="post" id="myform">
  <div class="row">
    <div class="col-md-12">
      <?php if(count($proveedor->error->all)) {?>
      <div class="alert alert-danger">
        <?php echo $this->lang->line('alert_error'); ?>
      </div>
      <?php } ?>
      <?php if($this->session->flashdata('mensaje')) {?>
      <div class="alert alert-success">
        <?php echo $this->session->flashdata('mensaje'); ?>
      </div>
      <?php } ?>
      <div class="btn-toolbar">
        <?php if($this->acceso->valida('catalogo','editar')) {?>
        <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/catalogo/proveedor/guardar/'.$proveedor->id) ?>')">Guardar</button>
        <?php } ?>
        <a class="btn btn-default" href="<?php echo base_url('modulo/catalogo/proveedor/listar') ?>">Regresar</a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
            <blockquote>
              <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>
            <div class="form-group">
              <label>Titulo: * </label>
              <input type="text" name="titulo" id="input-titulo" value="<?php echo $proveedor->titulo; ?>" class="form-control">
              <?php echo $proveedor->error->titulo; ?>
            </div>

            <div class="form-group">
              <label>Descripción </label>
              <textarea name="descripcion" class="form-control"><?php echo $proveedor->descripcion; ?></textarea>
            </div>
  </div>
</form>