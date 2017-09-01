<form action="" method="post" id="myform">
  <input type="hidden" name="ordenar" id="ordenar" value="">
  <div class="row">
    <div class="col-md-12">
      <?php if($this->session->flashdata('mensaje')) {?>
      <div class="alert alert-success">
        <?php echo $this->session->flashdata('mensaje'); ?>
      </div>
      <?php } ?>
    </div>
  </div>
  <div class="row">
      <div class="col-md-12">
       <a href="<?php echo base_url('tienda/backend/reporte2/index/'.$usuario_id) ?>">Regresar</a>
      </div>
 </div>
  <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-bordered grid">
            <thead>
              <tr>
                <th><input type="checkbox" class="checkall"></th>
                <th class="titulo_campos" campo="id">Número de orden <?php icon_order($this->session->userdata('order_ordenar'),'id'); ?></th>
                <th class="titulo_campos" campo="">Producto</th>
                <th class="titulo_campos" campo="cantidad">Cantidad <?php icon_order($this->session->userdata('order_ordenar'),'cantidad'); ?></th>
                <th class="titulo_campos" campo="precio">Precio al distribuidor <?php icon_order($this->session->userdata('order_ordenar'),'precio'); ?></th>
                <th class="titulo_campos" campo="">Precio de venta</th>
                <th class="titulo_campos" campo="">Comision Generada</th>
                <th class="titulo_campos" campo="">Comision</th>
              </tr>
            </thead>
            <tbody>

               <?php foreach ($order->item->get() as $key => $item): ?>

              <tr>
                <td nowrap><input type="checkbox" value="<?php echo $order->id; ?>"  name="post_ids[]"></td>
                <td nowrap><?php echo $order->id; ?></td><!-- Numero de orden -->


                    <td nowrap>
                      <?php echo  $item->titulo ?><!-- Título -->
                    </td>
                    <td nowrap><?php $cantidad=$item->cantidad; echo $cantidad; ?></td><!-- Cantidad -->
                    <td nowrap><?php echo formato_precio($item->preciodistribuidor); ?></td><!-- Precio al distribuidor -->
                    <td nowrap><?php
                           $precioventa=precioVenta($item->precio,$order->cuponPorcentaje,$order->mayoreoPorcentaje);;
                            echo formato_precio($precioventa);
                    ?></td>

                <td nowrap><?php $comision=$precioventa-$item->preciodistribuidor;  echo formato_precio($comision); ?></td>
                <td nowrap><?php  $comisiongral=$comision*$cantidad; echo formato_precio($comisiongral); ?></td>
              </tr>

               <?php endforeach; ?>

            </tbody>
          </table>
         <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
  </div>
</form>
