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
        <a href="<?php echo  site_url('tienda/backend/reporte3/excel/')?>"  target="_blank" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-export" aria-hidden="true"></span></a>
        <a href="<?php echo  site_url('tienda/backend/reporte3/pdf/')?>"  target="_blank" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-export" aria-hidden="true"></span></a>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive">
        <table class="table table-bordered grid">
          <thead>
            <tr>
              <th class="titulo_campos" campo="">Tipo de venta</th>
              <th class="titulo_campos" campo="">Número de ventas</th>
              <th class="titulo_campos" campo="">Total de ventas</th>
              <th class="titulo_campos" campo="">%</th>
              <th class="titulo_campos" campo="">Flete</th>
              <th class="titulo_campos" campo="">Costo Flete</th>
              <th class="titulo_campos" campo="">Costo productos</th>
              <th class="titulo_campos" campo="">Comis/Met Pago</th>
              <th class="titulo_campos" campo="">Utilidad</th>
              <th class="titulo_campos" campo="">%</th>
              <!-- <th class="titulo_campos" campo="">U/V</th> -->
            </tr>
          </thead>
          <tbody>
              <?php foreach ($reporte as $item): ?>
            <tr>
              <td ><?php echo $item->tipo_venta; ?></td>
              <td ><?php echo $item->numero_ventas; ?></td>
              <td ><?php echo formato_precio($item->total_ventas);   ?></td>
              <td ><small><?php echo number_format(($item->total_ventas*100)/$totales->total_ventas,1);  ?>%</small></td>
              <td ><?php echo formato_precio($item->flete);   ?></td>
              <td ><?php echo formato_precio($item->costo_flete);   ?></td>
              <td ><?php echo formato_precio($item->costo);   ?></td>
              <td ><?php echo formato_precio($item->comisiones); ?></td>
              <td ><?php echo formato_precio($item->utilidad); ?></td>
              <td ><small><?php echo number_format(($item->utilidad*100)/$totales->utilidad,1);  ?>%</small></td>
              <!-- <td ><small><?php echo number_format(  ($item->utilidad*100)/$item->total_ventas,2    );  ?>%</small></td> -->
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
                <!-- <td>&nbsp;</td> -->
              </tr>
          </tbody>
        </table>
      </div>
      <div> <?php  echo $this->pagination->create_links();  ?> </div>
    </div>
  </div>
</form>