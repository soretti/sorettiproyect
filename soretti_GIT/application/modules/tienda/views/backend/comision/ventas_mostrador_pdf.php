<style>


  table.grid{
    width: 100%;
  }

  table.grid td {
    border:1px solid #717171;
    font-size: 9px;
  }
    td.titulo_campos{
    background-color: #D7D7D7;
    text-align: center;
  }

  tr.par{
    background-color: #F2F2F2;
  }
  tr.impar{
    /*background-color: #FFCFCF;*/
  }
  tr.danger{
    background-color: #FFC8C8;
  }
  
  td.tipo_venta{
    width: 170px;
  }
  td.porcentaje{
    width: 50px;
  }

</style> 
      <p style="text-align:center">
         <h1 style="padding:0; margin:0; ">Reporte de ventas al mostrador</h1>
         <div><img src="<?php echo base_url('pub/theme/img/logos.jpg')?>" alt="" width="405" height="73"></div>
         <label>Fecha de inicio: <?php echo $this->dateutils->datees(strtotime($fecha_inicio),'C','c',''); ?>   - Fecha de fin: <?php echo $this->dateutils->datees(strtotime($fecha_fin),'C','c',''); ?>  </label>
      </p> 

         <h3>Ventas no facturadas</h3>

        <table class="table table-bordered grid" cellpadding="4" cellspacing="0">
          <thead>
            <tr>
              <td class="titulo_campos tipo_venta" campo="">Producto</td>
              <td class="titulo_campos porcentaje" campo="">Cantidad</td>
              <td class="titulo_campos" campo="">Precio mostrador</td>
              <td class="titulo_campos" campo="">Importe</td>
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
                <td class="tipo_venta"><?php echo $item->nombre_producto; ?></td>
                <td class="porcentaje"><?php echo $item->numero_ventas; ?></td>
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

      <br pagebreak="true"/>

        <h3>Ventas facturadas</h3>
    
        <table class="table table-bordered grid" cellpadding="5" cellspacing="0">
          <thead>
            <tr>
              <td class="titulo_campos tipo_venta" campo="">Producto</td>
              <td class="titulo_campos porcentaje" campo="">Cantidad</td>
              <td class="titulo_campos" campo="">Precio mostrador</td>
              <td class="titulo_campos" campo="">Importe</td>
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
                <td class="tipo_venta"><?php echo $item->nombre_producto; ?></td>
                <td class="porcentaje"><?php echo $item->numero_ventas; ?></td>
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
      
       <p class="text-right bg-success" style="padding:10px; text-align:right">Total de ventas: <strong><?php echo formato_precio($total_ventas_facturadas+$total_ventas_no_facturadas);   ?></strong></p>
