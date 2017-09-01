<script>
  jQuery(document).ready(function($) {
      $("#usarCupon").click(function(){
          $.ajax({
            url: base_url+'tienda/carrito/checarcupon',
            data: {cupon: $('#recipient-name').val()},
            type: 'POST',
            dataType:'json'
          })
            .done(function(data) {

              if(data.valido==1){
                   location.reload();
              }else if(data.valido==2){
                  alert("El monto mínimo para usar este cupón debe ser de:  "+data.monto);
              }else if(data.valido==3){
                  alert('Este cupón ya fué utilizado, intenta con otro');
              }else{
                  alert("Código de cupón inválido");
              }
          });

      });
  });

</script>
<h1>Carrito de compras</h1>
<div id="carrito">
  <div id="tabla-carrito">
    <img src="<?php echo base_url("pub/theme/img/loader.gif"); ?>" alt="" class="loader hide">
    <div class="table-responsive fila-top" >
      <?php if($this->session->flashdata('carrito_mensaje')) {?>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $this->session->flashdata('carrito_mensaje'); ?>
      </div>
      <?php } ?>
      <?php if($this->session->flashdata('carrito_danger')) {?>
      <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $this->session->flashdata('carrito_danger'); ?>
      </div>
      <?php } ?>
      <?php if(!$this->cart->total_items()) {?>
      <div class="carrito-vacio">
        <i class="fa fa-shopping-cart"></i>
        <h4 class="titulo">TU CARRITO DE COMPRAS ESTÁ VACÍO</h4>
        <div>Da clic <a href="<?php echo base_url(); ?>">aquí</a> para regresar al catálogo.</div>
      </div>
      <?php  }else{ ?>
      <form action="" method="POST">
      <div class="row">
        <div class="col-md-6">
              <a href="<?php echo site_url('catalogo/alga-espirulina'); //echo site_url($this->session->flashdata('seguir_comprando')); ?>" class="btn btn-primary">Seguir comprando</a>
        </div>
        <div class="col-md-6">
           <div class="pull-right form-group">
            <button type="submit" value="1" name="carritoUpdate" class="btn btn-primary">Actualizar carrito de compras <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
           </div>
        </div>
      </div>

      <table class="carrito" id="tbl_carrito">
        <tr>
          <th>SKU</th>
          <th>Nombre</th>
          <th width="150">Cantidad</th>
          <th>Precio</th>
          <th>Subtotal</th>
          <th>&nbsp;</th>
        </tr>
        <?php foreach ($this->cart->contents() as $items): ?>
        <tr>
          <td><?php echo $items['sku']; ?></td>
          <td>
            <?php if($items['imagen']) {?>
            <img src="<?php echo base_url('pub/uploads/thumbs/'.name_image($items['imagen'],'catalogo','cat_imagen',100,100)); ?>" alt="" class="thumb pull-left">
            <?php } ?>
            <?php echo $items['name']; ?>
            <?php if($items['options']!=''): ?>
            <div>
              <?php foreach ($items['options'] as $key => $value): ?>
              <?php echo $key.':'.$value ?><br>
              <?php endforeach; ?>
            </div>
            <?php endif; ?>
          </td>
          <td>
            <div class="input-group  input-group-sm qty-ctrl">
              <?php $restar = $items['qty']-1; ?>
             <span class="input-group-btn" >
                <a ruta="<?php echo base_url('tienda/carrito/actualizar/' . $items['rowid'] . '/' . $restar) ?>" class=" btn btn-default btn-sm"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></a>
              </span>
              <input type="text" class="form-control text-center" name="items[<?php echo $items['rowid']; ?>]" value="<?php echo $items['qty']; ?>">
              <?php $sumar = $items['qty']+1; ?>
              <span class="input-group-btn" >
                <a ruta="<?php echo base_url('tienda/carrito/actualizar/' . $items['rowid'] . '/' . $sumar) ?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
              </span>
            </div>
          </td>
          <td class="text-right"><?php echo formato_precio($items['price']); ?></td>
          <td class="text-right subtotal" cantidad="<?php echo $items['price']*$items['qty'] ?>"><?php echo formato_precio($items['price']*$items['qty']); ?></td>
          <td class="text-center">
            <a href="<?php echo base_url('tienda/carrito/actualizar/'.$items['rowid']) ?>" class="glyphicon glyphicon-trash"></a>
          </td>
        </tr>
        <?php endforeach; ?>
      </table>
    </form>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <?php if($this->session->flashdata('error_cp')) {?>
    <div class="alert alert-warning">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <?php echo $this->session->flashdata('error_cp'); ?>
    </div>
    <?php } ?>

    <?php if(!$this->session->userdata('cp')) {?>
    <div class="panel panel-default fila-top">
      <div class="panel-heading">
        <h3 class="panel-title text-right"><strong>Ingresa tu código postal para calcular los gastos de envío</strong></h3>
      </div>
      <div class="panel-body form-inline text-right">
        <form action="" method="post">
          <div class="form-group">
            <label for="">Código postal: </label>
            <input type="text" class="form-control" id="input_cp" name="cp" placeholder="" value="<?php echo $this->session->userdata('cp'); ?>">
            <input type="submit" name="calcularenvio" value="Calcular" class="btn btn-primary" id="btn_calcular_flete">
          </div>
        </form>
      </div>
    </div>
    <?php } ?>
  </div>
</div>
<div class="row"> 
  <div class="col-md-offset-4 col-md-8 text-right" >
    <div class="cuadro wrapper">
      <table class="total pull-right total-compra">
        <tr>
          <td class="text-right">Subtotal:</td>
          <td class="text-right importe" id="subtotal"><?php echo formato_precio( $this->cart->total() ); ?></td>
        </tr>


        <?php
        $usar_cupon=0;
        if(!$this->session->userdata('usuario_id')) $usar_cupon=1;
        elseif(isset($datos['usuario_tienda']) && !$datos['usuario_tienda']->descuento_id) $usar_cupon=1;
        if($usar_cupon==1){ ?>
        <tr>

            <td class="text-right"  <?php if(!$datos['cantidadcupon']) echo "colspan='2'; " ?> >

                    <?php if(!$datos['cantidadcupon']){ ?>
                           <div class="panel panel-default panel-cupon">
                              <div class="panel-heading">
                                <h3 class="panel-title"><strong>Agregar cupón de descuento</strong></h3>
                              </div>
                              <div class="panel-body form-inline text-right">
                                  <div class="form-group">
                                    <input type="text" name="cupon" class="form-control" id="recipient-name">
                                    <button type="button" class="btn btn-primary" id="usarCupon">Usar cupón</button>
                                  </div>
                              </div>
                          </div>

                    <?php }else{ ?>
                          <a href="<?php echo current_url().'?remove-cupon=1' ?>"><small>Quitar cupón</small></a>
                    <?php } ?>

 

            </td>
            <?php if($datos['cantidadcupon']){ ?>
                    <td class="text-right importe"><?php  echo '-'.formato_precio($datos['cantidadcupon']);  ?></td>
            <?php } ?>

        </tr>

        <?php } ?>
      <?php if(is_array($promocion)){ ?>
      <tr>
        <td class="text-right">Descuento <?php if($promocion['porcentaje']==6) echo "Medio Mayoreo"; if($promocion['porcentaje']==9) echo "Mayoreo" ?></td>
        <td class="text-right importe" ><?php  echo '-'.formato_precio( $promocion['importe_descuento'] );  ?></td>
      </tr>
      <?php } ?>

        <tr>
          <td>
            <div class="text-right" >
              <?php if( ($flete['precio'] || ($flete['gratis']==1)) && ($flete['cp']!='')) { ?>
              <div><a href="<?php echo current_url().'?remove-cp=1' ?>"><small>Quitar código postal (<?php echo $flete['cp']; ?>)</small></a></div>
              <?php echo $this->load->view('carrito/flete',null,true); ?>
              <?php } else {?>
              <small> Ingresa tu código postal para calcular los gastos de envío:</small>
              <?php } ?>
            </div>
          </td>
          <?php if( ($flete['precio'] ||($flete['gratis']==1))&&($flete['cp']!='')) {?>
          <td class="text-right importe" cantidad="<?php echo $flete['precio']; ?>">
            <?php echo formato_precio($flete['precio'] ); ?>
          </td>
          <?php } ?>
        </tr>
        <tr>
          <td class="text-right total"><label for="">Total: </label></td>
          <td class="text-right">
            <span class="importe total"><?php echo formato_precio($total); ?></span>
            <!-- <div class="small">iva incluido</div></td> -->
          </tr>
          <tr>
            <td colspan="2" class="text-right"> <a href="<?php echo site_url('tienda/checkout/mostrar') ?>" class="btn btn-lg btn-primary">Finalizar Compra</a></td>
          </tr>
        </table>
      </div>
    </div>
    <?php } ?>
  </div>
  <script>
  $("body").delegate('.qty-ctrl a','click',function(){
  window.location.replace($(this).attr('ruta')); return false;
  });
  $("#btn_calcular_flete").click(function(){
  if(!$("#input_cp").val()){
  alert('El campo código postal es requerido');
  return false;
  }
  });
  </script>
