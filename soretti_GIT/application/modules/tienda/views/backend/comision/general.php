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
        <a href="<?php echo  site_url('tienda/backend/reporte1/excel/')?>"  target="_blank" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-export" aria-hidden="true"></span></a>

    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive">
        <table class="table table-bordered grid">
          <thead>
            <tr>
              <th class="titulo_campos" campo="">ID</th>
              <th class="titulo_campos" campo="">Distribuidor</th>
              <th class="titulo_campos" campo="">Tipo</th>
              <th class="titulo_campos" campo="">Compras/directas</th>
              <th class="titulo_campos" campo="">Ventas/cupon</th>
              <th class="titulo_campos" campo="">Comision</th>
              <th class="titulo_campos" campo="">Ventas/subdistribuidores</th>
              <th class="titulo_campos" campo="">Comision</th>
              <th class="titulo_campos" campo="">Comision/total</th>
              <th class="titulo_campos" campo="">Detalles</th>
            </tr>
          </thead>
          <tbody>
              <?php foreach ($reporte as $item): ?>
            <tr>
              <td ><?php echo $item->distribuidor_id; ?></td>
              <td ><?php echo $item->distribuidor_nombre; ?></td>
              <td ><?php echo $item->distribuidor_tipo; ?></td>
              <td ><?php echo formato_precio($item->compras_directas); ?></td>
              <td ><?php echo formato_precio($item->compras_cupon); ?></td>
              <td ><?php echo formato_precio($item->comision_cupones); ?></td>              
              <td ><?php echo formato_precio($item->compras_subordinadas); ?></td>
              <td ><?php echo formato_precio($item->comision_subordinadas); ?></td>              
              <td ><?php echo formato_precio($item->comision_total); ?></td>
              <td ><a href="<?php echo base_url('tienda/backend/reporte2/index/'.$item->distribuidor_id)?>" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a></td>
            </tr>                
              <?php endforeach ?>
              <tr class="danger">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><strong><?php echo formato_precio($totales->comision_cupones); ?></strong></td>
                <td>&nbsp;</td>
                <td><strong><?php echo formato_precio($totales->comision_subordinadas); ?></strong></td>
                <td><strong><?php echo formato_precio($totales->comision_total); ?></strong></td>
                <td>&nbsp;</td>
              </tr>
          </tbody>
        </table>
      </div>
      <div> <?php  echo $this->pagination->create_links();  ?> </div>
    </div>
  </div>
</form>