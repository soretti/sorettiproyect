<?php if($mostrar=='off'){ ?>
<script>
window.close();
window.opener.location.reload();
</script>
<?php } ?>
<form action="" method="post" id="myform">
  <!-- Inicio del Bloque -->
  <div class="row">
    <div class="col-md-12">
      <?php if(count($catalogo->error->all)) {?>
      <div class="alert alert-danger">
        <?php echo $this->lang->line('alert_error'); ?>
      </div>
      <?php } ?>
      <?php if($this->session->flashdata('mensaje')) { ?>
      <div class="alert alert-success">
        <?php echo $this->session->flashdata('mensaje'); ?>
      </div>
      <?php } ?>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-4 col-sm-4 col-md-4">
      <div class="form-group">
        <label>Atributo:  </label>
        <select class="form-control" name="atributos_valores" id="grupo-atributos">
          <?php foreach ($atributos as $value) { ?>
          <option value="<?php echo $value->id ?>" <?php if($value->nombre==$this->input->post('atributos_name'))echo "selected" ?>><?php echo $value->nombre; ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div id="contenedor-atributos">
      <!-- Aqui van los valores de los atributos -->
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4">
      <div class="form-group">
        <label></label>
        <button type="button" class="btn btn-default btn-block " onclick="add_attr();"><i class="glyphicon glyphicon-plus-sign"></i> Añadir</button>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-8 col-sm-8 col-md-8">
      <div class="form-group">
        <label>Atributo:  </label>
        <select multiple class="form-control atributos" name="combinaciones_op[]">
          <?php   foreach ($resultados as $key => $value) { ?>
          <option value="<?php echo $value->grupo_id; ?>" valor="<?php echo $value->id ?>"><?php echo $value->grupo_nombre.': '.$value->nombre; ?></option>
          <?php } ?>
        </select>
        <?php echo $catalogo->error->combinaciones; ?>
        <input type="hidden" name="combinaciones" id="arreglo" value="<?php  if ( isset($combinacion_produ) &&  (is_array($combinacion_produ)) )  echo (implode(",", $combinacion_produ)); ?>" nombre="prueba">
      </div>
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4">
      <div class="form-group">
        <label></label>
        <button type="button" class="btn btn-default btn-block" onclick="del_attr()"><i class="glyphicon glyphicon-minus-sign"></i> Borrar</button>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label>SKU:</label>
    <input type="text" name="SKU" id="input-SKU" value="<?php echo $catalogo->SKU; ?>" class="form-control">
    <?php echo $catalogo->error->SKU; ?>
  </div>

  <div class="form-group">
    <label>Establecer esta combinacion como predeterminada: </label>
    <input type="checkbox" name="default" value="1" id="default" <?php if($catalogo->default) echo "checked"; ?>>
  </div>


  <div class="form-group">
    <label>Peso: </label>
    <div class="input-group input-group">
      <span class="input-group-addon" id="sizing-addon1">Kg</span>
      <input type="text" name="peso" value="<?php echo $catalogo->peso; ?>" class="form-control">
    </div>
  </div>
  
  <?php if(!$producto_padre->comprar_sin_stock) {?>
  <div class="form-group">
    <label>Stock:</label><div class="row">
    <div class="col-sm-4">
      <input type="text" name="stock" id="input-stock" value="<?php echo $catalogo->stock; ?>" class="form-control">
    </div></div>
  </div>
  <?php } ?>
  <div class="form-group">
    <label>Costo:</label>
    <input type="text" name="costo" id="input-costo" value="<?php echo $nuevo_precio->costo; ?>" class="form-control"  onkeypress="return NumCheck(event, this);" >
  </div>
  <div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6">
      <div class="form-group">
        <label>Precio: *</label>
        <input type="text" name="precio" id="input-precio" value="<?php echo $nuevo_precio->precio; ?>" class="form-control" onkeypress="return NumCheck(event, this);">
      </div>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6">
      <div class="form-group">
        <label>Moneda:  </label> <?php  echo $producto_padre->cat_precio_moneda; ?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6">
      <div class="form-group">
        <label>Precio Mayoreo:</label>
        <input type="text" name="precio_mayoreo" id="input-precio_mayoreo" value="<?php echo $nuevo_precio->precio_mayoreo; ?>" class="form-control" onkeypress="return NumCheck(event, this);">
      </div>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6">
      <div class="form-group">
        <label>A partir de:</label>
        <input type="text" name="cantidad" id="input-cantidad" value="<?php echo $nuevo_precio->cantidad; ?>" class="form-control txtNumbers">
      </div>
    </div>
  </div>

  <?php  if($producto_padre->cat_precio_impuesto)  {?>
  <div class="form-group">
    <label>Impuesto:  </label>  <?php echo $producto_padre->cat_precio_impuesto." %"; ?>
  </div>
  <?php } ?>
  <div class="form-group">
    <label class="checkbox-inline">
      <input type="checkbox" name="promocion" value="1" <?php if(($this->input->post('promocion')==1) || ($nuevo_precio->promocion==1) || (($nuevo_precio->descuento_cantidad!=0) && ($nuevo_precio->descuento_cantidad!=''))) echo "checked"; ?> >Promoción
    </label>
  </div>
  <div class="row  <?php if(!isset($nuevo_precio->descuento_cantidad)) echo 'hide'; ?>" id="mostrar-precio">
    <div class="col-xs-12 col-sm-6 col-md-6">
      <div class="form-group">
        <label>Precio de promoción:</label>
        <input type="text" name="descuento_cantidad" id="input-descuento_cantidad" value="<?php echo $nuevo_precio->descuento_cantidad; ?>" class="form-control" onkeypress="return NumCheck(event, this);">
        <?php echo $nuevo_precio->error->descuento_cantidad; ?>
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6">
      <div class="form-group" style="padding:20px 0">
        <label class="radio-inline">
          <input type="radio" name="descuento_tipo" id="porcentaje1" value="porcentaje"  <?php if (isset($nuevo_precio->descuento_tipo) && $nuevo_precio->descuento_tipo=="porcentaje") echo "checked";?>>Porcentaje
        </label>
        <label class="radio-inline">
          <input type="radio" name="descuento_tipo" id="porcentaje2" value="cantidad" <?php if (isset($nuevo_precio->descuento_tipo) && $nuevo_precio->descuento_tipo=="cantidad") echo "checked";?>>Precio Final
        </label>
      </div>
    </div>
    <div>&nbsp;</div>
   <div class="col-md-12">
     <div class="form-group">
      <label>Fecha de activación: </label>
      <div class="edicion_fecha">
        <div class="input-group">
          <input class="form-control" type="text"  name="activacion_promocion" id="activacion_promocion" value="<?php echo $this->dateutils->format_date_time($nuevo_precio->activacion_promocion); ?>">
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
          <input class="form-control" type="text"  name="desactivacion_promocion" id="desactivacion_promocion" value="<?php echo $this->dateutils->format_date_time($nuevo_precio->desactivacion_promocion); ?>">
          <span class="input-group-addon"><a href=""  onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
        </div>
      </div>
    </div>
  </div>

  </div>




  <div class="row">
    <?php foreach ($imagenes as $key => $value) { ?>
    <div class="col-sm-3 col-md-3">
      <div class="row">
        <div class="col-sm-3 col-md-3" style="padding-left: 53px; padding-top: 20px;">
          <div class="form-group">
            <label class="checkbox-inline">
              <input type="checkbox" name="combinacion_imagenes[]" value="<?php echo $value->id; ?>"  <?php if(in_array($value->id, $id_imgs))  echo "checked"; ?>>
            </label>
          </div>
        </div>
        <div class="col-sm-9 col-md-9">
          <div class="form-group">
            <img width="130" src="<?php echo base_url( 'pub/uploads/thumbs/'.name_image($value->imagen,'catalogo','cat_imagen',$value->thumb_w,$value->thumb_h) ) ; ?>" alt="" class="img-responsive">
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
  <div class="btn-toolbar">
    <?php if($this->acceso->valida('catalogo','editar')) {?>
    <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/catalogo/guardar_combinacion/'.$idprodu.'/'.$idnuevo); ?>'),this.close();">Guardar</button>
    <?php } ?>
  </div>
  <!-- Fin del Bloque -->
</form>