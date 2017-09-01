<style>
  .grid .label{
     font-size: 85% !important;
  }
  .grid .label .glyphicon{
      padding-right: 5px;
  }
</style>
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
      <div class="col-md-3">
        <div>&nbsp;</div>
        <?php if($this->acceso->valida('orders','eliminar')) {?>
          <a class="btn btn-danger seleccionados" href="<?php echo base_url('modulo/tienda/backend/order/eliminar') ?>" ><i class="glyphicon glyphicon-trash icon-white"></i> Seleccionados</a>
        <?php } ?>
        <a href="<?php echo  site_url('modulo/tienda/backend/order/excel/')?>"  target="_blank" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-export" aria-hidden="true"></span></a>
      </div>
    <div class="col-md-3">
      <label>Fecha de inicio: </label>
      <div class="edicion_fecha">
        <div class="input-group">
          <input class="form-control" type="text"  name="fecha_ini" id="fecha_ini_reporte" value="<?php echo $fecha_inicio ?>">
          <span class="input-group-addon"><a href=""   onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <label>Fecha de fin: </label>
      <div class="edicion_fecha">
        <div class="input-group">
          <input class="form-control" type="text"  name="fecha_fin" id="fecha_fin_reporte" value="<?php echo $fecha_fin ?>">
          <span class="input-group-addon"><a href=""  onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
        </div>
      </div>
    </div>


      <div class="col-md-3" style="text-align:right">
         <label><input type="checkbox" name="activar_busqueda_fecha" id="activar_busqueda_fecha" value="1" <?php if($this->session->userdata('busqueda_x_fecha_pago')==1) echo "checked"; ?> > Activar busqueda por fecha de pago</label>
        <div class="input-group">
           <input class="form-control" id="" name="buscar"  type="text" value="<?php echo $this->session->userdata('order_buscar') ?>">
           <span class="input-group-btn"><input class="btn btn-default"  type="submit" name="action_buscar" value="Buscar" ></span>
        </div>
      </div>
 </div>
  <div class="row">
      <div class="col-md-12">  
        <div class="table-responsive">
          <table class="table table-bordered grid">
            <thead>
              <tr>
                <th><input type="checkbox" class="checkall"></th>
                <th class="titulo_campos" campo="id">ID <?php icon_order($this->session->userdata('order_ordenar'),'id'); ?></th>
                <th class="titulo_campos" campo="usuario">USUARIO <?php icon_order($this->session->userdata('order_ordenar'),'usuario'); ?></th>
                <th class="titulo_campos" campo="fecha_creacion">FECHA CREACIÓN <?php icon_order($this->session->userdata('order_ordenar'),'fecha_creacion'); ?></th>
                <th class="titulo_campos" campo="pago_fecha">FECHA PAGO <?php icon_order($this->session->userdata('order_ordenar'),'pago_fecha'); ?></th>
                <th class="titulo_campos">GUIA</th>
                <th class="titulo_campos" campo="pago_verificado_fecha">PAGO VERIFICADO <?php icon_order($this->session->userdata('order_ordenar'),'pago_verificado_fecha'); ?></th>
                <th class="titulo_campos" campo="pago_verificado">OK <?php icon_order($this->session->userdata('order_ordenar'),'pago_verificado'); ?></th>
                <th class="titulo_campos" campo="estatus">ESTATUS <?php icon_order($this->session->userdata('order_ordenar'),'estatus'); ?></th>
                <th >IMPORTE</th>
                <th class="">ACCIONES</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $status=array();
              $status[1]='warning';
              $status[2]='primary';
              $status[3]='info';
              $status[4]='info';
              $status[5]='success';
              $status[6]='danger';

              foreach($orders as $order) {
              $datos_pago=json_decode($order->datos_pago);
              $datos_envio=json_decode($order->datos_envio);
              ?>
              <tr>
                <td nowrap><input type="checkbox" value="<?php echo $order->id; ?>"  name="post_ids[]"></td>
                <td nowrap><?php echo $order->id; ?></td>
                <td nowrap>
                   <?php echo $order->usuario_nombre." ".$order->usuario_apellidoPaterno." ".$order->usuario_apellidoMaterno;
                    if($order->numero_compra){
                      echo "<br>{$datos_envio->nombre} {$datos_envio->apellidoPaterno} {$datos_envio->apellidoMaterno}";
                      echo "<br><strong>#{$order->numero_compra}</strong>";
                    }?>
              </td>
                <td><small><?php echo $this->dateutils->datees(strtotime($order->fecha_creacion),'C','c','m'); ?></small></td>
                <td><small><?php if($order->pago_fecha!='0000-00-00 00:00:00') echo $this->dateutils->datees(strtotime($order->pago_fecha),'C','c','m'); ?></small></td>
                <td><small><?php echo $order->numero_guia?></small></td>
                <td><small><?php if($order->pago_verificado_fecha!='0000-00-00 00:00:00')echo $this->dateutils->datees(strtotime($order->pago_verificado_fecha),'C','c','m'); ?></small></td>
                <td nowrap>
                  
                  <span class="label label-<?php echo ($order->pago_verificado==1) ? "success" : "warning"; ?>"><?php echo ($order->pago_verificado==1) ? "Si" : "No"; ?></span>
                </td>
                <td>
                  <span class="label label-<?php echo $status[$order->estatus]?>">
                    <?php if($order->estatus==1) echo '<span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span>'; ?>
                    <?php if($order->estatus==2) echo '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'; ?>
                    <?php if($order->estatus==4) echo '<span class="glyphicon glyphicon-send" aria-hidden="true"></span>'; ?>
                    <?php if($order->estatus==6) echo '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>'; ?>
                    <?php if($order->estatus==5) echo '<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>'; ?>
                   <?php echo $status_tienda[$order->estatus]; ?>
                 </span>
                </td>
                <td><?php echo formato_precio($datos_pago->total); ?></td>
                <td nowrap>
                  
                  <?php if($this->acceso->valida('orders','consultar')) {?>
                  <a href="<?php echo base_url('modulo/tienda/backend/order/editar/'.$order->id); ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-edit"></i></a>
                  <?php } ?>
                  <?php if($this->acceso->valida('orders','eliminar')) {?>
                  <button class="btn btn-danger btn-sm  action_row" value="basura" type="button" href="<?php echo base_url('modulo/tienda/backend/order/eliminar'); ?> " ><i class="glyphicon glyphicon-trash"></i></button>
                  <?php } ?>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
         <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
  </div>
</form>