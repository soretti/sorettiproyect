<script>
jQuery(document).ready(function($) {
  $("input[name='categorias[]']").click(function(){
      if( $(this).is(':checked') ){
          $(this).parent().find('li > input').each(function(index, el) {
            $(this).prop( "checked", true );
          });
      }else{
           $(this).parent().find('li > input').each(function(index, el) {
            $(this).prop( "checked", false );
          });  
      }
  });
});
</script>
<form action="" method="post" id="myform">
  <div class="row">
    <div class="col-md-12">
      <?php if(count($precios->error->all)) {?>
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
        <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/catalogo/guardar_lote/'); ?>')">Guardar</button>
        <?php } ?>
        <a class="btn btn-default" href="<?php echo base_url('modulo/catalogo/listar/') ?>">Regresar</a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tabbable">
        <ul class="nav nav-tabs" id="tabs_catalogo">
          <li class="active"><a href="#1" data-toggle="tab"> Contenido </a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="1">

            <div class="form-group">
                  <label>Categorias: </label>
                  <div class="scroll-categorias" >
                    <?php echo $menu_categorias_multiple ?>
                  </div>
            </div>

            <div class="row" id="mostrar-precio">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Precio de promoción:</label>
                  <input type="text" name="descuento_cantidad" id="input-descuento_cantidad" value="<?php echo $precios->descuento_cantidad; ?>" class="form-control" onkeypress="return NumCheck(event, this);">
                  <?php echo $precios->error->descuento_cantidad; ?>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="radio-inline">
                    % Porcentaje
                  </label>

                </div>
              </div>

            <div class="col-md-12">
             <div class="form-group">
              <label>Fecha de activación: </label>
              <div class="edicion_fecha">
                <div class="input-group">
                  <input class="form-control" type="text"  name="activacion_promocion" id="activacion_promocion" value="<?php echo $this->dateutils->format_date_time($precios->activacion_promocion); ?>">
                  <span class="input-group-addon"><a href=""   onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
                </div>
              </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
              <label>Fecha de desactivación: </label>
              <div class="edicion_fecha">
                <div class="input-group">
                  <input class="form-control" type="text"  name="desactivacion_promocion" id="desactivacion_promocion" value="<?php echo $this->dateutils->format_date_time($precios->desactivacion_promocion); ?>">
                  <span class="input-group-addon"><a href=""  onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
                </div>
              </div>
            </div>

            </div>

          </div>

          </div>

        </div>
      </div>
    </div>
  </div>
</form>
