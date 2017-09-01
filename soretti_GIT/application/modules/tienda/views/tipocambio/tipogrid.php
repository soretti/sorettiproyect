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

                <th class="titulo_campos" campo="id">ID <?php icon_order($this->session->userdata('grupos_ordenar'),'id'); ?></th>
                <th class="titulo_campos" campo="tipocambio">PRECIO <?php icon_order($this->session->userdata('grupos_ordenar'),'tipocambio'); ?></th>
                <th class="titulo_campos" campo="fecha_creacion">FECHA DE CREACION <?php icon_order($this->session->userdata('grupos_ordenar'),'fecha_creacion'); ?></th>
                <th class="">ACCIONES</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($bloque as $value) { ?>
              <tr>

                <td nowrap><?php echo $value->id; ?></td>
                <td ><?php echo '$ '.$value->tipocambio; ?></td>
                <td ><?php $fechat = explode(' ', $value->fecha_creacion);
                                       $fechas=explode('-',  $fechat[0]);
                                        if($fechas[1]=='01') $fechas[1]='ENERO';
                                        if($fechas[1]=='02') $fechas[1]='FEBRERO';
                                        if($fechas[1]=='03') $fechas[1]='MARZO';
                                        if($fechas[1]=='04') $fechas[1]='ABRIL';
                                        if($fechas[1]=='05') $fechas[1]='MAYO';
                                        if($fechas[1]=='06') $fechas[1]='JUNIO';
                                        if($fechas[1]=='07') $fechas[1]='JULIO';
                                        if($fechas[1]=='08') $fechas[1]='AGOSTO';
                                        if($fechas[1]=='09') $fechas[1]='SEPTIEMBRE';
                                        if($fechas[1]=='10') $fechas[1]='OCTUBRE';
                                        if($fechas[1]=='11') $fechas[1]='NOVIEMBRE';
                                        if($fechas[1]=='12') $fechas[1]='DICIEMBRE';

                                        echo $fechas[2].'-'.$fechas[1].'-'.$fechas[0].'  '.$fechat[1]; ?>
                </td>
                <td nowrap>
                  <?php
                    if(!$value->tipo) $value->tipo='grupos';
                  ?>

                  <a href="<?php echo base_url('modulo/tienda/tipocambio/editar'); ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-edit"></i></a>

                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

        </div>
    </div>
  </div>
</form>
