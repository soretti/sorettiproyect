<script>
  jQuery(document).ready(function($) {
      $("#generarCupon").click(function(){ 
          $.ajax({
            url: base_url+'/modulo/tienda/cupon/generar_cupon',
            type: 'GET'
          })
          .done(function(data) {
             $("#input_cupon").val(data);
          });
          
      });
  });
</script>
<form action="" method="post" id="myform">
  <div class="row">
    <div class="col-md-12">
      <?php if(count($cupon->error->all)) {?>
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
        <?php if($this->acceso->valida('tienda','editar')) {?>
        <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/tienda/cupon/guardar/'.$cupon->id) ?>')">Guardar</button>
        <?php } ?>
        <a class="btn btn-default" href="<?php echo base_url('modulo/tienda/cupon/listar') ?>">Regresar</a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <blockquote>
        <small>Los campos marcados con (*) son requeridos</small>
      </blockquote>
      <div class="form-group">
        <label>Cupon: * </label>
        <div class="row">
          <div class="col-md-6">
            <div class="input-group">
              <input type="text" name="cupon"  value="<?php echo $cupon->cupon; ?>" id="input_cupon" class="form-control">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button" id="generarCupon">Generar!</button>
              </span>
            </div>
          </div>
        </div>
        <?php echo $cupon->error->cupon; ?>
      </div>
      <div class="form-group">
        <label>Descuento: * </label>
        <div class="row">
          <div class="col-md-6">
            <div class="input-group">
              <input type="text" name="descuento"  value="<?php echo $cupon->descuento; ?>" class="form-control">
                <span class="input-group-addon">
                  <input type="radio" name="tipo_descuento" id="tipo_descuento1" value="porcentaje" <?php if($cupon->tipo_descuento=='porcentaje') echo "checked" ?>> <label for="tipo_descuento1">%</label>
                 </span>
                <span class="input-group-addon">
                  <input type="radio" name="tipo_descuento" id="tipo_descuento2" value="cantidad" <?php if($cupon->tipo_descuento=='cantidad') echo "checked" ?>> <label for="tipo_descuento2">$</label>
                 </span>
            </div>
            <div><?php echo $cupon->error->descuento; ?></div>
            <div><?php echo $cupon->error->tipo_descuento; ?></div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Fecha de activación: </label>
              <div class="edicion_fecha">
                <div class="input-group">
                  <input class="form-control" type="text"  name="fecha_activacion" id="fecha_activacion" value="<?php  if($cupon->fecha_activacion!='0000-00-00 00:00:00') echo $this->dateutils->format_date_time($cupon->fecha_activacion); ?>">
                  <span class="input-group-addon"><a href=""   onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Fecha de desactivación: </label>
              <div class="edicion_fecha">
                <div class="input-group">
                  <input class="form-control" type="text"  name="fecha_desactivacion" id="fecha_desactivacion" value="<?php if($cupon->fecha_desactivacion!='0000-00-00 00:00:00') echo $this->dateutils->format_date_time($cupon->fecha_desactivacion); ?>">
                  <span class="input-group-addon"><a href=""  onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <input type="radio" name="uso" id="unico" value="unico" <?php if($cupon->uso=='unico') echo "checked" ?>> <label for="unico">Compra unica</label>
        <input type="radio" name="uso" id="recurrente" value="recurrente" <?php if($cupon->uso=='recurrente') echo "checked" ?>> <label for="recurrente">Compra recurrente</label>
      </div>
      <div class="form-group">
        <div class="row">
          <div class="col-md-6">
            <label>Compra minima: </label>
            <div class="input-group">
              <input type="text" name="compra_minima"  value="<?php echo (!$cupon->compra_minima) ? '' : $cupon->compra_minima; ?>" class="form-control">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">$</button>
              </span>
            </div>
            <?php echo $cupon->error->compra_minima; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>