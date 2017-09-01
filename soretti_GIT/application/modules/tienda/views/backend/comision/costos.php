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
        <a href="<?php echo  site_url('tienda/backend/reporte4/excel/')?>"  target="_blank" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-export" aria-hidden="true"></span></a>
        <a href="<?php echo  site_url('tienda/backend/reporte4/pdf/')?>"  target="_blank" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-export" aria-hidden="true"></span></a>

    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive">
        <table class="table table-bordered grid">
          <thead>
            <tr>
              <th class="titulo_campos" campo="">Nombre del producto</th>
              <th class="titulo_campos" campo="">Número de ventas</th>
              <th class="titulo_campos" campo="">%</th>
              <th class="titulo_campos" campo="">costo unitario</th>
              <th class="titulo_campos" campo="">Total</th>
              <th class="titulo_campos" campo="">%</th>
            </tr>
          </thead>
          <tbody>
              <?php foreach ($reporte as $item): ?>
            <tr>
              <td ><?php echo $item->nombre_producto; ?></td>
              <td ><?php echo $item->numero_ventas; ?></td>
              <td ><small><?php echo number_format(($item->numero_ventas*100)/$totales->numero_ventas,1) ?> %</small></td>
              <td ><?php echo formato_precio($item->costo);   ?></td>
              <td ><?php echo formato_precio($item->total_costo);   ?></td>
              <td ><small><?php echo number_format(($item->total_costo*100)/$totales->total_costo,1) ?> %</small></td>

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
      </div>
      <div> <?php  echo $this->pagination->create_links();  ?> </div>
    </div>
  </div>
</form>