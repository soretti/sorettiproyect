<form action="" method="post" id="myform">
  <div class="row">
    <div class="col-md-12">
      <?php if(count($rol->error->all)) {?>
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
        <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/rol/guardar/'.$rol->id) ?>')">Guardar</button>
        <a class="btn btn-default" href="<?php echo base_url('modulo/rol/lista') ?>">Regresar</a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <blockquote>
        <small>Los campos marcados con (*) son requeridos</small>
      </blockquote>
      <div class="form-group">
        <label>Nombre *</label>
        <input type="text" name="nombre" value="<?php echo $rol->nombre ?>" class="form-control">
        <?php echo $rol->error->nombre; ?>
      </div>
      <div class="form-group">
        <label>Descripcion: </label>
        <textarea name="descripcion" id="" cols="30" rows="5" class="form-control"><?php echo $rol->descripcion ?></textarea>
        <?php echo $rol->error->descripcion; ?>
      </div>
    </div>
    <div class="col-md-6">
      <blockquote>
        <small>Seleccionar los permisos con los que contara el rol de usuario</small>
      </blockquote>
      <?php $i=0; foreach($permisos as $permiso) {
        if($permiso->id!=11  && $permiso->id!=18 && $permiso->id!=35)  continue; ?>
      <div class="permisos">
        <label><strong><?php echo $permiso->titulo; ?></strong></label>
        <?php $configuracion=json_decode($permiso->configuracion,true); ?>
        <?php foreach ($configuracion as $key => $value){ ?>
        <input type="checkbox" name="permiso_id[<?php echo $permiso->id; ?>][<?php echo $value; ?>]" value="1" <?php if(isset($acl[$permiso->id][$value]) && $acl[$permiso->id][$value]==1) echo "checked"; ?>> <?php echo $value; ?>
        <?php } ?>
      </div>
      <?php $i++;} ?>
    </div>
  </div>
</form>