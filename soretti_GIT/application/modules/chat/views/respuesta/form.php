<form action="" method="post" id="myform">
  <div class="row">
    <div class="col-md-12">
      <?php if(count($categoria->error->all)) {?>
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
        <?php if($this->acceso->valida('chat','editar')) {?>
        <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/chat/respuesta/guardar/'.$categoria->id) ?>')">Guardar</button>
        <?php } ?>
        <a class="btn btn-default" href="<?php echo base_url('modulo/chat/respuesta/listar') ?>">Regresar</a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
            <blockquote>
              <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>
            <div class="form-group">
              <label>Titulo: </label>
              <input type="text" name="titulo"  value="<?php echo $categoria->titulo; ?>" class="form-control">
              <?php echo $categoria->error->titulo; ?>

            </div>             
            <div class="form-group">
              <label>Respuesta: * </label>
              <textarea name="respuesta" class="form-control" rows="10"><?php echo $categoria->respuesta; ?></textarea>
              <?php echo $categoria->error->respuesta; ?>
            </div>
            <div class="form-group">
              <label>Clasificación: * </label>
              <select name="tipo_id" id="" class="form-control">
                <option value="">Seleccíona una opción</option>
                <?php foreach ($tipos as $tipo) {?>
                <option value="<?php echo $tipo->id ?>" <?php if($categoria->tipo_id==$tipo->id) echo "selected"; ?> ><?php echo $tipo->titulo ?></option>
                <?php } ?>
              </select>
              <?php echo $categoria->error->tipo_id; ?>
            </div>
            <div class="form-group">
              <label>Snipet </label>
              <input type="text" name="snipet"  value="<?php echo $categoria->snipet; ?>" class="form-control">
            </div>         
    </div>
  </div>
</form>