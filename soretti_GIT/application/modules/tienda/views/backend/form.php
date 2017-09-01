<form action="" method="post" id="myform">
    <div class="row">
        <div class="col-md-12">
    
             <?php if(count($usuario->error->all)>0 || count($error)>0) {?>
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
                <button class="btn btn-success" type="submit" name="guardar" value="1">Guardar</button>
                <a class="btn btn-default" href="<?php echo base_url('modulo/tienda/backend/cuenta/listar') ?>">Regresar</a>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <blockquote>
                <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>


        <div class="row">
          <div class="col-md-12">
             <div class="form-group">
              <div>
                <label for="">Tipo Persona<span class="required">* </span></label>
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
            <label for="">Tipo distribuidor:<span class="required">* </span>  <small class="text-muted">(Asignar un descuento de distribuidor)</small> </label>
            <select name="descuento_id" id="" class="form-control" onchange="if($(this).val()!='') $('#codigo_cupon').removeClass('hide'); else $('#codigo_cupon').addClass('hide');  ">
                <option value="">Selecciona una opcion</option>
                <?php foreach ($descuentos as $descuento) {?>
                <option value="<?php echo $descuento->id ?>" <?php if($descuento->id==$usuario->descuento_id) echo "selected"; ?> > <?php echo $descuento->titulo; ?> </option>
                <?php } ?>
            </select>
          </div>

          <div class="form-group <?php if(! $usuario->descuento_id) echo "hide" ?>" id="codigo_cupon">
            <label for="">Código de cupón:<span class="required">* </span> </label>
            <input type="text" class="form-control input-sm" name="cupon" id="f_cupon" value="<?php echo $this->input->post('cupon'); ?>" />
            <span class="error"><?php if(isset($error[3])) echo $error[3]; ?></span>
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