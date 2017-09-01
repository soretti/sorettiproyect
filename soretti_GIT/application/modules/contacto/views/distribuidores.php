<div class="relative">
  <?php  if($this->acceso->valida('pagina','editar')) {?>
  <i class="tip-tools"></i>
  <div id="user-options">
    <a href="<?php echo base_url('modulo/pagina/editar/'.$pagina->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
  </div>
  <div class="editable"><div class="zona-editable"></div></div>
  <?php } ?>
  <div class="contenido-default">
    <h1><?php echo $pagina->titulo ?></h1>
    <?php if($pagina->{'contenido'.IDIOMA}) { ?>
    <div>
      <?php echo $pagina->{'contenido'.IDIOMA} ?>
    </div>
    <?php } ?>
  </div>
</div>
<a name="tienda"></a><form action="<?php echo current_url()."#contacto"; ?>" method="POST" enctype="multipart/form-data" id="form-tienda">
<div class="modulo contacto-inmediato" id="contenedor-contacto">
  <div id="inner-contacto">
    <div class="contenido">
      <?php if( validation_errors() || $error || count($usuario->error->all) ) {?>
      <div class="alert alert-danger">
        <?php echo $this->lang->line('alert_error'); ?>
      </div>
      <?php } ?>
      <?php if($enviado) {?>
      <div class="alert alert-success">
        Nos da mucho gusto que quiera formar parte de nuestro equipo, en breve nos pondremos en contacto usted para validar los datos enviados y activar su cuenta como distribuidor,
        una vez activada su cuenta recibirá un correo con los precios y políticas  comerciales para distribuidores.  
      </div>
      <?php } ?>
      <?php if(!$enviado){ ?>
      <div class="panel panel-success">
        <div class="panel-heading">
          <h3 class="panel-title inline">Datos de la cuenta <small>(Ingresar datos completos)</small> </h3>
        </div>
        <div class="panel-body">
        <div class="row">
          <div class="col-md-12">
             <div class="form-group">
              <div>
                <label for="">Tipo Persona :<span class="required">* </span></label>
              </div>
              <input type="radio" name="tipo" id="fisica" value="fisica" <?php if($usuario->tipo=='fisica') echo "checked" ?>> <label for="fisica">Fisica</label>
              <input type="radio" name="tipo" id="moral" value="moral" <?php if($usuario->tipo=='moral') echo "checked" ?>> <label for="moral">Moral</label>
            <span class="errores"><?php echo $usuario->error->tipo; ?></span>
          </div>
          </div>
        </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <label for=""><span id="txt-nombre">Nombre:</span><span class="required">* </span></label>
                <input type="text"  class="form-control input-sm" name="nombre" id="f_nombre" value="<?php echo $this->input->post('nombre'); ?>"/>
                <span class="errores"><?php echo $usuario->error->nombre; ?></span>
              </div>

              <div class="col-md-4 <?php if($usuario->tipo=='fisica') echo "hide" ?>" id="container-rfc">
                <label for="">RFC: <span class="required">* </span></label>
                <input type="text" name="rfc" class="form-control" value="<?php echo $this->input->post('rfc'); ?>">
                <span class="errores"><?php echo $usuario->error->rfc; ?></span>  
              </div>

              <div class="col-md-4 apellidos <?php if($usuario->tipo=='moral') echo "hide" ?>">
                <label for="">Apellido paterno: <span class="required">* </span></label>
                <input type="text"  class="form-control input-sm" name="apellidoPaterno" id="f_apellidoPaterno" value="<?php echo $this->input->post('apellidoPaterno'); ?>"/>
                <span class="errores"><?php echo $usuario->error->apellidoPaterno; ?></span>
              </div>
              <div class="col-md-4 apellidos <?php if($usuario->tipo=='moral') echo "hide" ?>">
                <label for="">Apellido materno:</label>
                <input type="text"  class="form-control input-sm" name="apellidoMaterno" id="f_apellidoMaterno" value="<?php echo $this->input->post('apellidoMaterno'); ?>"/>
                <span class="errores"><?php echo $usuario->error->apellidoMaterno; ?></span>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-xs-3">
                <label for="">Lada:  <span class="required">* </span></label><input type="text" class="form-control input-sm" name="lada" id="f_lada" value="<?php echo $this->input->post('lada'); ?>" />
                 <span class="errores"><?php  echo $usuario->error->lada ?></span>
              </div>
              <div class="col-xs-9">
                <label for="">Teléfono:  <span class="required">* </span></label>
                <input type="text" class="form-control input-sm" name="telefono" id="f_telefono" value="<?php echo $this->input->post('telefono'); ?>" />
                 <span class="errores"><?php  echo $usuario->error->telefono ?></span>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="">Identificación Oficial: <span class="required">* </span> <small class="text-muted">(IFE, Pasaporte)</small> </label>
            <input type="file" name="identificacion" class="form-control">
            <span class="errores"><?php echo $usuario->error->identificacion; ?></span>  
          </div>

          <div class="form-group">
            <label for="">Comprobante de domicilio: <span class="required">* </span> <small class="text-muted">Recibo de teléfono, agua o luz máximo 3 meses antigüedad</small> </label>
            <input type="file" name="comprobante_domicilio" class="form-control">
            <span class="errores"><?php echo $usuario->error->comprobante_domicilio; ?></span>  
          </div>


          <div class="form-group">
            <label for="">E-mail:<span class="required">* </span>  <small class="text-muted">(Email para crear una cuenta en algaespirulina.mx)</small> </label>
            <input type="text" class="form-control hide" name="email_field"  value="" />
            <input type="text" class="form-control input-sm" name="email" id="f_email" value="<?php echo $this->input->post('email'); ?>" />
            <span class="errores"><?php  echo $usuario->error->email ?></span>
          </div>
          
          <div class="form-group">
            <label for="">Contraseña:<span class="required">* </span> <small class="text-muted">(Cree una contraseña para ingresar a su cuenta en algaespirulina.mx 5 caracteres mínimo )</small> </label>
            <input type="password" name="password" class="form-control" value="<?php echo $this->input->post('password'); ?>">
            <span class="errores"><?php echo $usuario->error->password; ?></span>
          </div>

          <div class="form-group">
            <label for="">Confirmar Contraseña:<span class="required">* </span></label>
            <input type="password" name="confirmar" class="form-control" value="<?php echo $this->input->post('confirmar'); ?>">
            <span class="errores"><?php echo $usuario->error->confirmar; ?></span>
          </div>
        </div>
      </div>
    </div>
    <input type="checkbox"  name="privacidad" value="1" id="" <?php if($this->input->post('privacidad')==1) echo "checked"; ?> >  He leído y acepto la nota informativa sobre el  <a href="<?php echo site_url('modulo/pagina/blank/politica-de-privacidad'); ?>" class="fancybox-frame">aviso de privacidad. </a>
     <div>
        <span class="errores"><?php echo $usuario->error->privacidad; ?></span>
     </div>
    <div class="form-group form-buscar text-right">
      <input type="email" name="tienda_email_field" value="" class="hide">
      <input type="hidden" name="tienda_registro" id="tienda_registro" value="">
      <button type="button" id="submit_tienda" class="btn btn-primary">Registrarme</button>
    </div>
    <?php } ?>
  </div>
</div>
</div>
</form>
<script>
  jQuery(document).ready(function($) {
    $("#fisica, #moral").click(function(event) { 
         if($(this).val()=='moral'){ 
            $("#txt-nombre").text('Razón Social');
            $(".apellidos").addClass('hide');
            $("#container-rfc").removeClass('hide');
         }else{
            $("#txt-nombre").text('Nombre');
            $(".apellidos").removeClass('hide');
            $("#container-rfc").addClass('hide');

         }
    });
  });
</script>