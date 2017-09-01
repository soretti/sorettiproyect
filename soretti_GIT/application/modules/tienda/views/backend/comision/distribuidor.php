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
        <a href="<?php echo  site_url('tienda/backend/reporte2/excel/'.$this->uri->segment(5))?>"  target="_blank" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-export" aria-hidden="true"></span></a>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
        <a href="<?php echo base_url('tienda/backend/reporte1'); ?>">Regresasr a reporte general</a>
    </div>
  </div>  
  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive">
        <table class="table table-bordered grid">
          <thead>
            <tr>
              <th class="titulo_campos" campo="">N° Orden</th>
              <th class="titulo_campos" campo="">Fecha</th>
              <th class="titulo_campos" campo="">Cupón</th>
              <th class="titulo_campos" campo="">Total</th>
              <th class="titulo_campos" campo="">Comisión</th>
              <th class="titulo_campos" campo="">Detalles</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($reporte as $item): ?>
            <tr>
              <td ><?php echo $item->order_id; ?></td>
              <td ><?php echo $item->fecha; ?></td>
              <td ><?php echo $item->cupon; ?></td>
              <td ><?php echo formato_precio($item->total_compra); ?></td>
              <td ><?php echo formato_precio($item->comision); ?></td>
              <td ><a href="<?php echo site_url('modulo/tienda/backend/comision/listar/'.$item->order_id.'/'.$this->uri->segment(5));?>" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a></td>
            </tr>
          <?php endforeach ?>
           <tr class="danger">
             <td>&nbsp;</td>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
             <td><strong><?php echo formato_precio($totales->total_compra); ?></strong></td>
             <td><strong><?php echo formato_precio($totales->total_comision); ?></strong></td>
             <td>&nbsp;</td>
           </tr>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</form>