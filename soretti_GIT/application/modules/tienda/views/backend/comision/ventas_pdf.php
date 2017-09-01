<style>
  table.grid td {
    border:1px solid #717171;
    font-size: 10px;
  }
  td.titulo_campos{
    background-color: #D7D7D7;
    text-align: center;
  }
  td.tipo_venta{
    width: 150px;
  }
  td.porcentaje{
    width: 50px;
  }
  tr.danger{
    background-color: #FFCFCF;
  }
  tr.par{
    background-color: #F2F2F2;
  }
  tr.impar{
    /*background-color: #FFCFCF;*/
  }
</style>

      <p style="text-align:center"> 
        <h1 style="padding:0; margin:0; ">Reporte de ventas </h1>
        <div><img src="<?php echo base_url('pub/theme/img/logos.jpg')?>" alt="" width="405" height="73"></div>
      <label>Fecha de inicio: <?php echo $this->dateutils->datees(strtotime($fecha_inicio),'C','c',''); ?>   - Fecha de fin: <?php echo $this->dateutils->datees(strtotime($fecha_fin),'C','c',''); ?>  </label>
       </p>
      
      <table class="table table-bordered grid" cellpadding="5" cellspacing="0">
            <tr>
              <td class="titulo_campos tipo_venta">Tipo de venta</td>
              <td class="titulo_campos">Número de ventas</td>
              <td class="titulo_campos">Total de ventas</td>
              <td class="titulo_campos porcentaje">%</td>
              <td class="titulo_campos">Flete</td>
              <td class="titulo_campos">Costo Flete</td>
              <td class="titulo_campos">Costo productos</td>
              <td class="titulo_campos">Comis/Met Pago</td>
              <td class="titulo_campos">Utilidad</td>
              <td class="titulo_campos porcentaje">%</td>
            </tr>

              <?php 

              $i=1; foreach ($reporte as $item): 
              $i++;
              $class=(fmod($i, 2)) ? 'par' : 'impar';
              ?>
            <tr class="<?php echo $class; ?>">
              <td class="tipo_venta"><?php echo $item->tipo_venta; ?></td>
              <td ><?php echo $item->numero_ventas; ?></td>
              <td ><?php echo formato_precio($item->total_ventas);   ?></td>
              <td class="porcentaje"><small><?php echo number_format(($item->total_ventas*100)/$totales->total_ventas,1);  ?>%</small></td>
              <td ><?php echo formato_precio($item->flete);   ?></td>
              <td ><?php echo formato_precio($item->costo_flete);   ?></td>
              <td ><?php echo formato_precio($item->costo);   ?></td>
              <td ><?php echo formato_precio($item->comisiones); ?></td>
              <td ><?php echo formato_precio($item->utilidad); ?></td>
              <td class="porcentaje"><small><?php echo number_format(($item->utilidad*100)/$totales->utilidad,1);  ?>%</small></td>
            </tr>                
              <?php endforeach ?>
              <tr class="danger">
                <td>&nbsp;</td>
                <td><strong><?php echo $totales->numero_ventas ?></strong></td>
                <td><strong><?php echo formato_precio($totales->total_ventas); ?></strong></td>
                <td>&nbsp;</td>
                <td><strong><?php echo formato_precio($totales->total_flete); ?></strong></td>
                <td><strong><?php echo formato_precio($totales->total_costo_flete); ?></strong></td>
                <td><strong><?php echo formato_precio($totales->total_costo); ?></strong></td>
                <td><strong><?php echo formato_precio($totales->total_comisiones); ?></strong></td>
                <td><strong><?php echo formato_precio($totales->utilidad); ?></strong></td>
                <td>&nbsp;</td>
              </tr>
            </table>
