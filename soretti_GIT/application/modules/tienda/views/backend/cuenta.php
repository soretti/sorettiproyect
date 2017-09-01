<script>

$(document).ready(function(){
$(".grid_seleccionar").click(function()
{
group = $(this).parent();
});
$(".popup, .grid_seleccionar").popupWindow({width:800,scrollbars:1,resizable:1,centerScreen:1});
});
</script>
<form action="" method="post" id="myform" enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-12">
      <?php if($this->session->flashdata('mensaje')) {?>
      <div class="alert alert-success">
        <?php echo $this->session->flashdata('mensaje'); ?>
      </div>
      <?php } ?>
      <div class="btn-toolbar">
        <?php if($this->acceso->valida('tienda','editar')) {?>
        <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/tienda/backend/cuenta/guardardescuento/'.$cuenta->id) ?>')">Guardar</button>
        <?php } ?>
        <a class="btn btn-warning" href="<?php echo base_url('modulo/tienda/backend/cuenta/login_with/'.$cuenta->id) ?>">Ingresar a la tienda con esta cuenta</a>
        <a class="btn btn-default" href="<?php echo base_url('modulo/tienda/backend/cuenta/listar') ?>">Regresar</a>
      </div>
    </div>
  </div>
  <div class="tabbable">
    <ul class="nav nav-tabs" id="tabs_catalogo">
      <li class="active"><a href="#1" data-toggle="tab">Información básica</a></li>
      <li><a href="#2" data-toggle="tab">Direcciones</a></li>
      <li><a href="#4" data-toggle="tab">Newsletter</a></li>
      <?php if($cuenta->descuento_id) {?>
        <li><a href="#5" data-toggle="tab">Subdistribuidores</a></li>
      <?php } ?>
    </ul>
    <div class="tab-content" style="padding:20px">
      <div class="tab-pane active" id="1">
        <?php
        if($cuenta->tipo=='moral') {?>
        <label for="">Razón social:</label> <?php echo $cuenta->nombre  ?>
        <?php } else{ ?>
        <label for="">Nombre:</label> <?php echo $cuenta->nombre. ' ' . $cuenta->apellidoPaterno. ' ' . $cuenta->apellidoMaterno; ?>
        <?php } ?>
        <br>
        <label for="">Email:</label>  <a href="mailto:<?php echo $cuenta->email ?>"><?php echo $cuenta->email ?></a><br>
        <label for="">Teléfono:</label> <?php echo $cuenta->lada."-".$cuenta->telefono ?><br>
 
          <div class="form-group">
            <label for="">Identificación: <small class="text-muted">IFE, PASAPORTE en formato jpg o pdf</small></label> <?php if($cuenta->identificacion) {?> <a href="<?php echo base_url('modulo/tienda/backend/cuenta/documentos/'.$cuenta->id."/".'identificacion'); ?>" target="_blank"> ver documento... </a> <?php } ?>
            <input type="file" name="identificacion" id="" class="form-control">
            <span class="error"><?php echo $cuenta->error->identificacion ?></span>
          </div>
          <div class="form-group">
            <label for="">Comprobante de domicilio: <small class="text-muted">Recibo de teléfono, agua o luz no mayor a 3 meses formato jpg o pdf</small> </label> <?php if($cuenta->comprobante_domicilio) {?> <a href="<?php echo base_url('modulo/tienda/backend/cuenta/documentos/'.$cuenta->id."/".'comprobante_domicilio'); ?>" target="_blank"> ver documento... </a> <?php } ?>
            <input type="file" name="comprobante_domicilio" id="" class="form-control">
            <span class="error"><?php echo $cuenta->error->comprobante_domicilio ?></span>
          </div>
        <div class="form-group">
          <label for="">Banco: </label>
          <input type="text" name="banco" id="" class="form-control" value="<?php echo $cuenta->banco ?>">
        </div>
        <div class="form-group">
         <span class="text-muted">
            Datos  bancarios para realizar el deposito de las comisiones generadas por las ventas
         </span>
        </div>
        <div class="form-group">
          <label for="">Cuenta CLABE: </label>
          <input type="text" name="clabe" id="" class="form-control" value="<?php echo $cuenta->clabe ?>">
        </div>
        <div class="form-group">
          <label for="">Descuento:</label>
          <select class="form-control" name="descuento_id" id="descuento_id">
            <option value="">Seleccione una opción</option>
            <?php foreach ($descuento as $key => $value) { ?>
            <option value="<?php echo $value->id; ?>" <?php if($cuenta->descuento_id==$value->id) echo "selected"; ?>><?php echo $value->titulo.' - '.$value->porcentaje.'%';  ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label>Cupon: </label>
          <input type="hidden" name="cupon_id" value="<?php echo $cuenta->cupon_id ?>" class="form-control uri-input">
          <span class="titulo"> <?php echo $cuenta->cupon->cupon; ?></span> <a href="<?php echo base_url('modulo/tienda/cupon/listar') ?>" class="grid_seleccionar"> Seleccionar </a>
        </div>
      </div>
      <div class="tab-pane" id="2">
        <?php foreach ($cuenta->tiendadireccion as $key => $direccion): ?>
        <div class="col-md-4 col-sm-6">
          <p><strong><?php echo $direccion->alias ?></strong></p>
          <p>
            Nombre: <?php echo $direccion->nombre . ' ' . $direccion->apellidoPaterno. ' ' . $direccion->apellidoMaterno ?><br>
            Estado/Distrito: <?php echo $direccion->estado->titulo ?><br>
            Cd., mpio. o del.: <?php echo $direccion->municipio->titulo ?><br>
            Colonia: <?php echo $direccion->colonia->titulo ?><br>
            Calle: <?php echo $direccion->calle ?><br>
            No. exterior: <?php echo $direccion->numero_ext ?><br>
            No. interior: <?php echo $direccion->numero_int ?><br>
            Código Postal: <?php echo $direccion->codigo ?><br>
            Teléfono: <?php echo $direccion->lada ?> <?php echo $direccion->telefono ?><br>
            Celular: <?php echo $direccion->celular ?><br>
          </p>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="tab-pane" id="4">
        <p><?php echo $newsletter->email ?></p>
        <p>
          <!-- Nombre: <?php echo $newsletter->nombre ?> <?php echo $newsletter->apellidoPaterno ?> <?php echo $newsletter->apellidoMaterno ?><br> -->
          Inscrito: <?php if($newsletter->unsuscribe): ?> NO <?php else: ?> SI <?php endif; ?><br>
          Temas de interés:<br>
          
          <?php foreach ($grupos as $key => $grupo) : ?>
          <?php echo $grupo->nombre ?><br>
          <?php endforeach ?>
        </p>
      </div>
      <?php if($cuenta->descuento_id) {?>
      <div class="tab-pane" id="5">
        <div class="form-group">
          <a class="btn btn-primary admin-fancybox" href="<?php echo site_url('modulo/tienda/backend/cuenta/listar') ?>">Agregar Usuarios</a>
        </div>
        <ul class="list-group" id="lista-subordinados">
          <?php foreach ($subordinados as $subordinado) { ?>
          <li class="list-group-item"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span><input type="hidden" name="subordinados[]" value="<?php echo $subordinado->id ?>" > <?php echo $subordinado->nombre." ".$subordinado->apellidoPaterno ?></li>
          <? } ?>
        </ul>
      </div>
      <?php } ?>
    </div>
  </div>
</form>
<script>
$( "#lista-subordinados" ).delegate( ".glyphicon-trash", "click", function() {
$(this).parent().remove();
});
</script>