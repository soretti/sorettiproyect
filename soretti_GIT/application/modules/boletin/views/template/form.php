 
<form action="" method="post" id="myform">
  <div class="row">
    <div class="col-md-12">
      <?php if(count($template->error->all)) {?>
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
        <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/boletin/template/guardar/'.$template->id) ?>')">Guardar</button>
        <?php } ?>
        <a class="btn btn-default" href="<?php echo base_url('modulo/boletin/template/listar') ?>">Regresar</a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
            <blockquote>
              <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>
            <div class="form-group">
              <label>Titulo: * </label>
              <input type="text" name="titulo" id="input-titulo" value="<?php echo $template->titulo; ?>" class="form-control">
              <?php echo $template->error->titulo; ?>
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

              <textarea name="contenido" class="form-control html-editable-template"><?php echo $template->contenido; ?></textarea>
            </div>          
    </div>
  </div>
</form>