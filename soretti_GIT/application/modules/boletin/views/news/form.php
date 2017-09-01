<form action="" method="post" id="myform">
  <div class="row">
    <div class="col-md-12">
      <?php if(count($news->error->all)) {?>
      <div class="alert alert-danger">
        <?php echo $this->lang->line('alert_error'); ?>
      </div>
      <?php } ?>
      <?php if($this->session->flashdata('mensaje')) {?>
      <div class="alert alert-success">
        <?php echo $this->session->flashdata('mensaje'); ?>
      </div>
      <?php } ?>
      <div class="btn-toolbar">
        <?php if($this->acceso->valida('boletin','editar')) {?>
        <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/boletin/newsletter/guardar/'.$news->id) ?>')">Guardar</button>
        <?php } ?>
        <a class="btn btn-default" href="<?php echo base_url('modulo/boletin/newsletter/listar') ?>">Regresar</a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tabbable">
        <ul class="nav nav-tabs" id="tabs_catalogo">
          <li class="active"><a href="#1" data-toggle="tab"> Newsletter </a></li>

        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="1">
            <blockquote>
              <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>

            <?php if($news->id): ?>
            <div class="form-group">
              <label>Estatus: </label>
              <div>
              <a
              <?php
              if($news->status == 1){
                echo ' class="btn btn-success" ';
              }else{
                echo ' class="btn btn-default" ';
              }
              ?>
              href="<?php echo base_url('modulo/boletin/newsletter/cambiar_estatus/1/'.$news->id) ?>">
                <i class="glyphicon glyphicon-play"></i>
              </a>
              <a
              <?php
              if($news->status == 2){
                echo ' class="btn btn-warning" ';
              }else{
                echo ' class="btn btn-default" ';
              }
              ?>
              href="<?php echo base_url('modulo/boletin/newsletter/cambiar_estatus/2/'.$news->id) ?>">
                <i class="glyphicon glyphicon-stop"></i>
              </a>
            </div>
            </div>
          <?php endif; ?>

            <div class="form-group">
              <label>Enviar desde:  </label>
              <select class="form-control" name="cuentas_id">
                <?php foreach ($cuentas as $value) { ?>
                <option value="<?php echo $value->id; ?>" <?php if($value->id==$news->cuentas_id) echo 'selected' ?>><?php echo $value->email; ?></option>
                <?php } ?>
              </select>
            </div>

            <div class="form-group">
              <label>Asunto: * </label>
              <input type="text" name="asunto" id="input-asunto" value="<?php echo $news->asunto; ?>" class="form-control">
              <?php echo $news->error->asunto; ?>
            </div>
<div class="form-group"><label>Grupos: *</label>

            <?php //echo $news->fecha_envio . " = " .  strtotime($news->fecha_envio ) . ' < ' . date('Y-m-d H:i:s') . ' = ' . strtotime(date('Y-m-d H:i:s')); 
            if( strtotime(date('Y-m-d H:i:s')) < strtotime($news->fecha_envio) ): ?>
              <?php foreach($grupos as $grupo) {?>
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="grupos[]" value="<?php echo $grupo->id; ?>" <?php  if(in_array($grupo->id, explode(",",$news->grupos))) print("checked") ?>> <?php echo $grupo->nombre ?>
                </label>
              </div>
              <?php } ?>
              <?php echo $news->error->grupos; ?>                               
           
          <?php
          else: 
            echo "<br>";
            foreach($grupos as $grupo) {
              if(in_array($grupo->id, explode(",",$news->grupos))){
                echo $grupo->nombre . "<br>";
                echo "<input type='hidden' name='grupos[]' value='".$grupo->id."'>";
              }
            }
           endif;
           ?>
 </div>
            <div class="form-group">
              <label> Fecha de envio: </label>
              <div class="edicion_fecha">
                <?php if(strtotime(date('Y-m-d H:i:s')) < strtotime($news->fecha_envio )):  ?>
                <div class="input-group">
                  <input class="form-control" type="text"  name="fecha_envio" id="fecha_envio" value="<?php echo $this->dateutils->format_date_time($news->fecha_envio); ?>">
                  <span class="input-group-addon"><a href=""   onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
                </div>
                <?php else:  ?>
                <?php echo $this->dateutils->format_date_time($news->fecha_envio); ?>
                <?php endif;  ?>
              </div>
              <?php echo $news->error->fecha_envio; ?>
            </div>

            <div class="form-group">
              <label>Etiquetas: </label>

            <blockquote>
              <small>Haz click sobre las etiquetas para insertarlas en la plantilla</small>
            </blockquote>
                <a href="javascript:void(0);" onclick="tinyMCE.execCommand('mceInsertContent', false, '{empresa_nombre}');"><span class="label label-primary" style="font-size:12px">{empresa_nombre}</span></a>
                <a href="javascript:void(0);" onclick="tinyMCE.execCommand('mceInsertContent', false, '{empresa_url}');"><span class="label label-primary" style="font-size:12px">{empresa_url}</span></a>
                <a href="javascript:void(0);" onclick="tinyMCE.execCommand('mceInsertContent', false, '{empresa_direccion}');"><span class="label label-primary" style="font-size:12px">{empresa_direccion}</span></a>
                <a href="javascript:void(0);" onclick="tinyMCE.execCommand('mceInsertContent', false, '{empresa_email}');"><span class="label label-primary" style="font-size:12px">{empresa_email}</span></a>
                <a href="javascript:void(0);" onclick="tinyMCE.execCommand('mceInsertContent', false, '{empresa_telefono}');"><span class="label label-primary" style="font-size:12px">{empresa_telefono}</span></a>
                <a href="javascript:void(0);" onclick="tinyMCE.execCommand('mceInsertContent', false, '{empresa_politica_privacidad}');"><span class="label label-primary" style="font-size:12px">{empresa_politica_privacidad}</span></a>
                <a href="javascript:void(0);" onclick="tinyMCE.execCommand('mceInsertContent', false, '{cancelar_suscripcion}');"><span class="label label-primary" style="font-size:12px">{cancelar_suscripcion}</span></a>
                <a href="javascript:void(0);" onclick="tinyMCE.execCommand('mceInsertContent', false, '{usuario_nombre}');"><span class="label label-primary" style="font-size:12px">{usuario_nombre}</span></a>
                <a href="javascript:void(0);" onclick="tinyMCE.execCommand('mceInsertContent', false, '{usuario_email}');"><span class="label label-primary" style="font-size:12px">{usuario_email}</span></a>
            </div> 

            <div class="form-group">
              <label>Contenido </label>

              <textarea name="contenido" class="form-control html-editable-template"><?php echo $news->contenido; ?></textarea>
            </div> 

          </div>

        </div>
      </div>
    </div>
  </div>
</form>
