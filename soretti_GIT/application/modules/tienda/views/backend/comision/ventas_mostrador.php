<style>
  tr.danger td{
    background-color: #FDDFDF !important;
  }
</style>
<form action="" method="post" id="myform">
  <input type="hidden" name="ordenar" id="ordenar" value="">
  <div class="row">
  </div>
  <div class="row">
    <div class="col-md-5">
      <label>Fecha de inicio: </label>
      <div class="edicion_fecha">
        <div class="input-group">
          <input class="form-control" type="text"  name="fecha_ini" id="fecha_ini_reporte" value="<?php echo $fecha_inicio ?>">
          <span class="input-group-addon"><a href=""   onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <label>Fecha de fin: </label>
      <div class="edicion_fecha">
        <div class="input-group">
          <input class="form-control" type="text"  name="fecha_fin" id="fecha_fin_reporte" value="<?php echo $fecha_fin ?>">
          <span class="input-group-addon"><a href=""  onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
        </div>
      </div>
    </div>
    <div class="col-md-2">
         <div>&nbsp;</div>
        <input type="submit" value="Filtrar" class="btn btn-sm btn-primary">
        <a href="<?php echo  site_url('tienda/backend/reporte5/excel/')?>"  target="_blank" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-export" aria-hidden="true"></span></a>
        <a href="<?php echo  site_url('tienda/backend/reporte5/pdf/')?>"  target="_blank" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-export" aria-hidden="true"></span></a>

    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
            <div class="text-center">
        <h3>Ventas no facturadas</h3>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered grid">
          <thead>
            <tr>
              <th class="titulo_campos" campo="">Producto</th>
              <th class="titulo_campos" campo="">Cantidad</th>
              <th class="titulo_campos" campo="">Precio mostrador</th>
              <th class="titulo_campos" campo="">Importe</th>
            </tr>
          </thead>
          <tbody>
              <?php 
                $total_ventas=0;
                $total_numero_ventas=0;
                foreach ($reporte as $item):
                  $total_numero_ventas+=$item->numero_ventas;
                  $total_ventas+=$item->subtotal;
              ?>
              <tr>
                <td ><?php echo $item->nombre_producto; ?></td>
                <td ><?php echo $item->numero_ventas; ?></td>
                <td ><?php echo formato_precio($item->precio);   ?></td>
                <td ><?php echo formato_precio($item->subtotal);   ?></td>
              </tr>                
              <?php endforeach ?>
              <tr class="danger">
                <td class="text-right" colspan="3">Subtotal</td>
                <td ><?php echo formato_precio($total_ventas);   ?></td>
              </tr>  
              <tr class="danger">
                <td class="text-right" colspan="3">Descuentos/Cupones/Mayoreo</td>
                <td > - <?php echo formato_precio($descuentos->precio);   ?></td>
              </tr>  
              <tr class="danger">
                <td class="text-right" colspan="3">Fletes</td>
                <td ><?php echo formato_precio($flete->precio);   ?></td>
              </tr>    
              <tr class="danger">
                <td class="text-right" colspan="3">Fletes IVA</td>
                <td ><?php echo formato_precio($flete_iva->precio);   ?></td>
              </tr>      
              <tr class="danger">
                <td class="text-right" colspan="3">Total</td>
               <td ><?php $total_ventas_no_facturadas=(($total_ventas+$flete->precio+$flete_iva->precio)-$descuentos->precio); echo formato_precio($total_ventas_no_facturadas);   ?></td>
              </tr>                     
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="text-center">
        <h3>Ventas facturadas</h3>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered grid">
          <thead>
            <tr>
              <th class="titulo_campos" campo="">Producto</th>
              <th class="titulo_campos" campo="">Cantidad</th>
              <th class="titulo_campos" campo="">Precio mostrador</th>
              <th class="titulo_campos" campo="">Importe</th>
            </tr>
          </thead>
          <tbody>
              <?php 
                $total_ventas=0;
                $total_numero_ventas=0;
                foreach ($reporte_facturado as $item):
                  $total_numero_ventas+=$item->numero_ventas;
                  $total_ventas+=$item->subtotal;
              ?>
              <tr>
                <td ><?php echo $item->nombre_producto; ?></td>
                <td ><?php echo $item->numero_ventas; ?></td>
                <td ><?php echo formato_precio($item->precio);   ?></td>
                <td ><?php echo formato_precio($item->subtotal);   ?></td>
              </tr>                
              <?php endforeach ?>
              <tr class="danger">
                <td class="text-right" colspan="3">Subtotal</td>
                <td ><?php echo formato_precio($total_ventas);   ?></td>
              </tr>  
              <tr class="danger">
                <td class="text-right" colspan="3">Descuentos/Cupones/Mayoreo</td>
                <td > - <?php echo formato_precio($descuentos_facturado->precio);   ?></td>
              </tr>  
              <tr class="danger">
                <td class="text-right" colspan="3">Fletes</td>
                <td ><?php echo formato_precio($flete_facturado->precio);   ?></td>
              </tr>    
              <tr class="danger">
                <td class="text-right" colspan="3">Fletes IVA</td>
                <td ><?php echo formato_precio($flete_iva_facturado->precio);   ?></td>
              </tr>      
              <tr class="danger">
                <td class="text-right" colspan="3">Total</td>
                <td ><?php $total_ventas_facturadas=(($total_ventas+$flete_facturado->precio+$flete_iva_facturado->precio)-$descuentos_facturado->precio); echo formato_precio($total_ventas_facturadas);   ?></td>
              </tr>                     
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
       <p class="text-right bg-success" style="padding:10px;">Total de ventas: <strong><?php echo formato_precio($total_ventas_facturadas+$total_ventas_no_facturadas);   ?></strong></p>
    </div>
  </div>
</form>