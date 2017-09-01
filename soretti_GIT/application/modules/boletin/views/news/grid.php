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
    <div class="col-md-8">
      <?php if($this->acceso->valida('boletin','editar')) {?>
      <a class="btn btn-primary"  href="<?php echo base_url('modulo/boletin/newsletter/agregar') ?>"><i class="glyphicon glyphicon-plus icon-white"></i> Agregar</a>
      <?php } ?>
      <?php if($this->acceso->valida('boletin','eliminar')) {?>
      <a class="btn btn-danger seleccionados" href="<?php echo base_url('modulo/boletin/newsletter/eliminar') ?>" ><i class="glyphicon glyphicon-trash icon-white"></i> Eliminar seleccionados</a>
      <?php } ?>
      <a class="btn btn-success" href="<?php echo base_url('modulo/boletin/newsletter/listar') ?>" ><i class="glyphicon glyphicon-refresh icon-white"></i> Actualizar página</a>
    </div>
    <div class="col-md-4" style="text-align:right">
      <div class="input-group">
        <input class="form-control" id="" name="buscar"  type="text" value="<?php echo $this->session->userdata('news_buscar') ?>">
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
              <th class="titulo_campos" campo="id">Id <?php icon_order($this->session->userdata('news_ordenar'),'id'); ?></th>
              <th class="titulo_campos" campo="asunto">Asunto <?php icon_order($this->session->userdata('news_ordenar'),'asunto'); ?></th>
              <th class="titulo_campos" campo="fecha_envio">Fecha de envio<?php icon_order($this->session->userdata('news_ordenar'),'fecha_envio'); ?></th>
              <!-- Situación de los Boletines -->
              <th class="titulo_campos" campo="status">Estado<?php icon_order($this->session->userdata('news_ordenar'),'status'); ?></th>
              <th  campo="fecha_envio">Total</th>
              <th  campo="fecha_envio">Enviados</th>
              <!-- <th class="titulo_campos" campo="fecha_envio">Rebotados<?php icon_order($this->session->userdata('news_ordenar'),'fecha_envio'); ?></th> -->
              <th  campo="fecha_envio">Unsusbscribers</th>
              <!-- <th class="titulo_campos" campo="fecha_envio">Vistos<?php icon_order($this->session->userdata('news_ordenar'),'fecha_envio'); ?></th> -->
              <!-- Fin situación de los Boletines -->
              <th class="">Progreso</th>
              <th class="">ACCIONES</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach($news as $key => $new) {
            $status="";
            $progreso="";
            $porcentaje="";


                if($new->enviados!=0){
                  $porcentaje= round((($new->enviados*100)/$new->total),2);
                }else{
                  $porcentaje=0;
                }
                if(($new->status==1) &&(strtotime($new->fecha_envio) > strtotime(date('Y-m-d H:i:s')))) { //Estado: Cargado
                $status= '<span style="color: rgb(77, 144, 254); cursor: pointer;" class="glyphicon glyphicon-time" data-toggle="tooltip" data-placement="top" title="Cargado"></span>';
                $progreso=  'class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="'.$porcentaje.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$porcentaje.'%"';
                }
                if(($new->status==1) && (strtotime($new->fecha_envio)<=strtotime(date('Y-m-d H:i:s')))){ //Estado: Proceso
                $status= '<span style="color: rgb(250, 145, 0); cursor: pointer;" class="glyphicon glyphicon-play" data-toggle="tooltip" data-placement="top" title="Proceso"></span>';
                $progreso=  'class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="'.$porcentaje.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$porcentaje.'%"';
                }
                if($new->status==3) { //Estado: Completado
                $status= '<span data-original-title="Completado" style="color: rgb(0, 151, 86); cursor: pointer;" class="glyphicon glyphicon-ok" data-toggle="tooltip" data-placement="top" title=""></span>';
                $progreso= 'class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'.$porcentaje.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$porcentaje.'%"';
                }
                if($new->status==2) { //Estado: Detenido
                $status='<span data-original-title="Detenido" style="color: rgb(218, 70, 49); cursor: pointer;" class="glyphicon glyphicon-pause" data-toggle="tooltip" data-placement="top" title=""></span>';
                $progreso='class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="'.$porcentaje.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$porcentaje.'%"';
                }
                // if($key==4) { //Estado: Detenido
                //   $status='<span data-original-title="Pendiente" style="color: rgb(77, 187, 219); cursor: pointer;" class="glyphicon glyphicon-pause" data-toggle="tooltip" data-placement="top" title=""></span>';
                //   $progreso='class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100" style="width: 72%;"';
                // }
                ?>
                <tr>
                  <td nowrap><input type="checkbox" value="<?php echo $new->id; ?>"  name="post_ids[]"></td>
                  <td nowrap><?php echo $new->id; ?></td>
                  <td ><a href="<?php echo base_url('modulo/boletin/newsletter/editar/'.$new->id); ?>"><?php echo $new->asunto; ?></a></td>
                  <td ><?php echo $this->dateutils->datees(strtotime($new->fecha_envio),'C','c','m'); ?></td>
                  <td align="center"><?php echo $status; ?></td>
                  <td align="center"><?php echo $new->total; ?></td>
                  <td align="center"><span class="text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Enviados" style="cursor: pointer;"><?php echo $new->enviados; ?></span><br><span class="text-warning" data-toggle="tooltip" data-placement="top" title="" data-original-title="No han sido enviados" style="cursor: pointer;"><?php echo $new->noenviados; ?></span></td>
                  <!-- <td align="center"><?php echo $new->rechazados; ?></td> -->
                  <td align="center"><?php echo $new->unsuscribed; ?></td>
                  <!-- <td align="center"><?php echo $new->vistos; ?></td> -->
                  <td nowrap>
                    <div class="progress active" style="background-color:#999999; background-image:none; color:#FFFFFF;"><div <?php echo $progreso; ?>><?php echo $porcentaje.'%'; ?></div></div>
                  </td>
                  <td nowrap>
                    <?php if($this->acceso->valida('boletin','consultar')) {?>
                    <a href="<?php echo base_url('modulo/boletin/newsletter/editar/'.$new->id); ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-edit"></i></a>
                    <?php } ?>
                    <?php if($this->acceso->valida('boletin','eliminar')) {?>
                    <button class="btn btn-danger btn-sm  action_row" value="basura" type="button" href="<?php echo base_url('modulo/boletin/newsletter/eliminar/'); ?> " ><i class="glyphicon glyphicon-trash"></i></button>
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
