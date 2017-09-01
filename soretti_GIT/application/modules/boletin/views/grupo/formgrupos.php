<form action="" method="post" id="myform">
  <div class="row">
    <div class="col-md-12">
      <?php if(count($grupo->error->all)) {?>
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
        <?php if($this->acceso->valida('boletin','editar')) {?>
        <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/boletin/grupos/guardar/'.$grupo->id) ?>')">Guardar</button>
        <?php } ?>
        <a class="btn btn-default" href="<?php echo base_url('modulo/boletin/grupos/listar') ?>">Regresar</a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tabbable">
        <ul class="nav nav-tabs" id="tabs_catalogo">
          <li class="active"><a href="#1" data-toggle="tab"> Grupos </a></li>

        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="1">
            <blockquote>
              <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>
            <div class="form-group">
              <label>Nombre: * </label>
              <input type="text" name="nombre" id="input-nombre" value="<?php echo $grupo->nombre; ?>" class="form-control">
              <?php echo $grupo->error->nombre; ?>
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>
</form>
