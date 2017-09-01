<style>


  table.grid{
    width: 100%;
  }

  table.grid td {
    border:1px solid #717171;
    font-size: 10px;
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
    width: 150px;
  }
  td.porcentaje{
    width: 50px;
  }

</style>

      <p style="text-align:center">
        <h1 style="padding:0; margin:0; ">Reporte de costos </h1>
        <div><img src="<?php echo base_url('pub/theme/img/logos.jpg')?>" alt="" width="405" height="73"> </div>
        <label>Fecha de inicio: <?php echo $this->dateutils->datees(strtotime($fecha_inicio),'C','c',''); ?>   - Fecha de fin: <?php echo $this->dateutils->datees(strtotime($fecha_fin),'C','c',''); ?>  </label>   
      </p>


        <table class="table table-bordered grid"  cellpadding="5" cellspacing="0">
          <thead>
            <tr>
              <td class="titulo_campos tipo_venta" campo="">Nombre del producto</td>
              <td class="titulo_campos" campo="">Número de ventas</td>
              <td class="titulo_campos porcentaje" campo="">%</td>
              <td class="titulo_campos" campo="">costo unitario</td>
              <td class="titulo_campos" campo="">Total</td>
              <td class="titulo_campos porcentaje" campo="">%</td>
            </tr>
          </thead>
          <tbody>
              <?php

              $i=0; foreach ($reporte as $item): 
              $i++;
              $class=(fmod($i, 2)) ? 'par' : 'impar';
              ?>
            <tr class="<?php echo $class; ?>">
              <td class="tipo_venta"><?php echo $item->nombre_producto; ?></td>
              <td ><?php echo $item->numero_ventas; ?></td>
              <td class="porcentaje"><small><?php echo number_format(($item->numero_ventas*100)/$totales->numero_ventas,1) ?> %</small></td>
              <td ><?php echo formato_precio($item->costo);   ?></td>
              <td ><?php echo formato_precio($item->total_costo);   ?></td>
              <td class="porcentaje"><small><?php echo number_format(($item->total_costo*100)/$totales->total_costo,1) ?> %</small></td>

            </tr>                
              <?php endforeach ?>
              <tr class="danger">
                <td>&nbsp;</td>
                <td><strong><?php echo $totales->numero_ventas ?></strong></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><strong><?php echo formato_precio($totales->total_costo); ?></strong></td>
                <td>&nbsp;</td>
              </tr>
          </tbody>
        </table>