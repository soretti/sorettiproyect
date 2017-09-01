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
      <div class="col-md-12">  
        <div class="table-responsive">
          <table class="table table-bordered grid">
            <thead>
              <tr>
                <th class="titulo_campos" campo="id">ID <?php icon_order($this->session->userdata('reporte6_ordenar'),'id'); ?></th>
                <th class="titulo_campos">Distribuidor</th>
                <th class="titulo_campos" campo="descuento">Tipo <?php icon_order($this->session->userdata('reporte6_ordenar'),'descuento'); ?></th>
                <th class="titulo_campos">Teléfono</th>
                <th class="titulo_campos">Email</th>
                <th class="titulo_campos" campo="fecha_registro">Registro <?php icon_order($this->session->userdata('reporte6_ordenar'),'fecha_registro'); ?></th>
                <th class="titulo_campos" campo="ultima_compra">Fecha U/C <?php icon_order($this->session->userdata('reporte6_ordenar'),'ultima_compra'); ?></th>
                <th class="titulo_campos" campo="ultima_compra_dias">Dias U/C <?php icon_order($this->session->userdata('reporte6_ordenar'),'ultima_compra_dias'); ?></th>
                <th class="titulo_campos" campo="numero_compras">N° compras <?php icon_order($this->session->userdata('reporte6_ordenar'),'numero_compras'); ?></th>
                <th class="titulo_campos" campo="total_compras">Total compras <?php icon_order($this->session->userdata('reporte6_ordenar'),'total_compras'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($distribuidores as $distribuidor) {
                $this->db->select("CONCAT((usuarios.nombre),(' '),(usuarios.apellidoPaterno)) as nombre");
                $this->db->where(array('subordinado_id'=>$distribuidor->id))->from('subordinados');
                $this->db->join('usuarios','usuarios.id=subordinados.usuario_id');
                $top=$this->db->get()->row();
              ?>
              <tr>
                <td nowrap><?php echo $distribuidor->id; ?></td>
                <td ><?php if(isset($top->nombre)) echo "<strong>{$top->nombre} <span class='glyphicon glyphicon-chevron-down'></span></strong><br>";  echo $distribuidor->nombre." ".$distribuidor->apellidoPaterno; ?></td>
                <td nowrap><?php echo $distribuidor->tipodistribuidor; ?></td>
                <td nowrap><?php echo $distribuidor->telefono; ?></td>
                <td nowrap><?php echo $distribuidor->email; ?></td>
                <td > <small><?php if($distribuidor->fecha_creacion!='0000-00-00 00:00:00' && $distribuidor->fecha_creacion) echo $this->dateutils->datees(strtotime($distribuidor->fecha_creacion),'C','c',''); ?></small></td>
                <td > <small><?php if($distribuidor->pago_fecha!='0000-00-00 00:00:00' && $distribuidor->pago_fecha) echo $this->dateutils->datees(strtotime($distribuidor->pago_fecha),'C','c',''); ?></small></td>
                <td nowrap class="text-center"><?php echo $distribuidor->ultima_compra; ?></td>
                <td nowrap class="text-center"><?php echo $distribuidor->numero_orders; ?></td>
                <td nowrap><?php echo formato_precio($distribuidor->total_compras); ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
         <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
  </div>
</form>