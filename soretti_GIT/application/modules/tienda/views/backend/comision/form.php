<form action="" method="post" id="myform">
  <div class="row">
    <div class="col-md-12">
      <?php if(count($order->error->all)) {?>
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
        <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/tienda/backend/order/guardar/'.$order->id) ?>')">Guardar</button>
        <?php } ?>
        <a class="btn btn-default" href="<?php echo base_url('modulo/tienda/backend/order/listar') ?>">Regresar</a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <blockquote>
        <small>Los campos marcados con (*) son requeridos</small>
      </blockquote>
      <div class="form-group">
        <div><label>Usuario: </label> <?php echo $order->usuario_nombre." ".$order->usuario_apellidoPaterno." ".$order->usuario_apellidoMaterno ?></div>
        <div><label>Número de orden: </label> <?php echo $order->id; ?></div>
        <div><label>Fecha: </label> <?php  echo $this->dateutils->datees(strtotime($order->fecha_creacion),'c','c');  ?></div>
      </div>
      <div class="form-group form-inline">
        <input type="checkbox" name="enviarEmail" id="enviarEmail" value="1"> <label for="enviarEmail"> Enviar correo al cliente al guardar la orden de compra </label>
      </div>
      <div class="form-group <?php if(!$this->input->post('enviarEmail')) echo "hide" ?>" id="mensajeText-box">
        <label for="">Mensaje adicional:</label>
         <textarea name="mensajeText" id="mensajeText" cols="30"  class="form-control"><?php echo nl2br($this->input->post('mensajeText')) ?></textarea>
      </div>
      <div class="form-group">
        <label for="">STATUS DE LA ORDEN:</label>
        <select name="estatus" id="" class="form-control" onchange=" if( ($(this).val()*1)>=3 ) $('#paqueteria-row').removeClass('hide'); else $('#paqueteria-row').addClass('hide'); ">
          <option value="">Selecciona una opción</option>
          <?php foreach ($status_tienda as $indice=>$status): ?>
          <option value="<?php echo $indice ?>" <?php if($order->estatus==$indice) echo "selected" ?> ><?php echo $status  ?></option>
          <?php endforeach ?>
        </select>
        <?php echo $order->error->estatus; ?>
      </div>
      <div class="form-group <?php if($order->estatus<3) echo "hide" ?>" id="paqueteria-row">
        <div class="row">
          <div class="col-md-6">
            
        <label for="">Paquetería:</label>
          <select name="flete_id" id="" class="form-control">
          <option value="">Seleccione una poción</option>
          <?php foreach ($fletes as $flete) {?>
            <option value="<?php echo $flete->id ?>" <?php if($flete->id==$order->flete_id) echo "selected" ?>><?php echo $flete->titulo ?></option>
          <?php } ?>
        </select>

          </div>
          <div class="col-md-6">
                  <label for="">Número de guia:</label>
                  <input type="text" name="numero_guia" id="" class="form-control" value="<?php echo $order->numero_guia ?>"> 
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <?php $envio=json_decode($order->datos_envio); ?>
          <div><strong>DIRECCIÓN DE ENTREGA</strong></div>
          <p>
            <div class="txt-direccion">Nombre: <?php echo $envio->nombre ?> <?php echo $envio->apellidoPaterno ?> <?php echo $envio->apellidoMaterno ?></div>
            <div class="txt-direccion">Calle: <?php echo $envio->calle ?></div>
            <div class="txt-direccion">Número exterior: <?php echo $envio->numero_ext ?></div>
            <div class="txt-direccion">Número interior: <?php echo $envio->numero_int ?></div>
            <div class="txt-direccion">Colonia: <?php echo $envio->colonia ?></div>
            <div class="txt-direccion">CP: <?php echo $envio->codigo ?></div>
            <div class="txt-direccion">Municipio: <?php echo $envio->municipio ?></div>
            <div class="txt-direccion">Estado: <?php echo $envio->estado ?></div>
            <div class="txt-direccion">Teléfono: <?php echo $envio->telefono ?></div>
            <div class="txt-direccion">Celular: <?php echo $envio->celular ?></div>
            <div><a href="">+ Editar</a></div>
          </p>
          </div>
          <div class="col-md-6">
            <?php $factura=json_decode($order->datos_factura); ?>
            <div><strong>DATOS DE FACTURACIÓN</strong></div>
            <?php if($factura->codigo): ?>
            <p style="margin-bottom:30px">
              <div class="txt-direccion">Calle: <?php echo $factura->calle ?></div>
              <div class="txt-direccion">Número exterior: <?php echo $factura->numero_ext ?></div>
              <div class="txt-direccion">Número interior: <?php echo $factura->numero_int ?></div>
              <div class="txt-direccion">Colonia: <?php echo $factura->colonia ?></div>
              <div class="txt-direccion">CP: <?php echo $factura->codigo ?></div>
              <div class="txt-direccion">Municipio: <?php echo $factura->municipio ?></div>
              <div class="txt-direccion">Estado: <?php echo $factura->estado ?></div></p>
              <?php else: ?>
              N/A
              <?php endif; ?>
            </div>
          </div>
          <?php $pago=json_decode($order->datos_pago); ?>
          <div style="margin-bottom:30px" class="table-responsive">
            <table class="carrito table table-bordered" id="tbl_carrito" >
              <tr>
                <th>sku</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
              </tr>
              <?php foreach ($order->item->get() as $key => $item): ?>
              <tr>
                <td><?php echo $item->SKU ?></td>
                <td>
                  <?php if(isset($item->imagen)){ ?>
                  <img src="<?php echo base_url('pub/uploads/thumbs/'.name_image($item->imagen,'catalogo','cat_imagen',100,100)); ?>" alt="" class="thumb pull-left">
                  <?php } ?>
                  <?php echo $item->titulo ?>
                  <?php if($item->options) {?>
                  <div>
                    <?php foreach (json_decode($item->options,true) as $i => $value): ?>
                    <p> <small><?php echo $i.':'.$value ?></small> </p>
                    <?php endforeach; ?>
                  </div>
                  <?php } ?>
                </td>
                <td><?php echo $item->cantidad ?></td>
                <td><?php echo formato_precio($item->precio) ?></td>
                <td class="subtotal"><?php echo formato_precio($item->precio * $item->cantidad) ?></td>
              </tr>
              <?php endforeach; ?>
            </table>
          </div>
          <div class="row fila-top">
            <div class="col-lg-4">
              &nbsp;
            </div>
            <div class="col-lg-8">
              <div class="cuadro wrapper">
                <table class="pull-right total-compra">
                  <tr>
                    <td class="text-left">Subtotal</td>
                    <td class="text-right importe"><strong><?php echo formato_precio($pago->subtotal) ?></strong></td>
                  </tr>
                  <tr>
                    <td class="text-left">
                      <div>Flete</div>
                      <?php $this->load->view('order/entrega',array('envio'=>$envio,'email'=>$email)); ?>
                    </td>
                    <td class="text-right importe">
                      <strong><?php echo formato_precio($pago->flete);   ?></strong>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left total importe">TOTAL</td>
                    <td class="text-right "><span class="importe total"><strong><?php echo formato_precio( $pago->total ); ?></strong></span> <div class="small"> iva incluido</div></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <div class="form-group text-right">
            <?php $this->load->view('tienda/order/metodo_de_pago',array('pago'=>$pago,'banco'=>$banco)); ?>
          </div>
        </div>
      </div>
    </form>
    <script>
      jQuery(document).ready(function($){

      $("#enviarEmail").click(function(){
             if($(this).is(":checked")){
                $("#mensajeText-box").removeClass('hide');
             }else{
               $("#mensajeText-box").addClass('hide');
             }
      });



      });
    </script>