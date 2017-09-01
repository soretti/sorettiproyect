<form action="" method="post" id="myform" enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-12">
      <?php if(isset($error) && $error) {?>
      <div class="alert alert-danger">
        <?php echo $error; ?>
      </div>
      <?php } ?>
      <?php if($this->session->flashdata('mensaje')) {?>
      <div class="alert alert-success">
        <?php echo $this->session->flashdata('mensaje'); ?>
      </div>
      <?php } ?>
      <div class="btn-toolbar">
        <?php if($this->acceso->valida('catalogo','editar')) {?>
        <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/catalogo/importar') ?>')">Importar</button>
        <?php } ?>
        <a class="btn btn-default" href="<?php echo base_url('modulo/catalogo/listar') ?>">Regresar</a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
            <blockquote>
              <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>
            <div class="form-group">
              <label>Subir archivo: * </label>
               <input type="file" name="archivo" id="">
               <input type="hidden" name="importar" value="1">
            </div>           
    </div>
  </div>
</form>