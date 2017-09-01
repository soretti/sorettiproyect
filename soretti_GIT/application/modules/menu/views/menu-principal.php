<div class="navbar-header" >
  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
  <span class="sr-only">Toggle navigation</span>
  <span class="icon-bar"></span>
  <span class="icon-bar"></span>
  <span class="icon-bar"></span>
  </button>
  <a class="menu-principal navbar-brand" href="<?php echo site_url(); ?>"><img src="<?php echo base_url('pub/theme/img/logo2.png'); ?>" class="img-responsive img-logo" alt="Soretti" title="Soretti" width="140"></a>
</div>
<div class="collapse navbar-collapse menu-principal relative" id="bs-example-navbar-collapse-2">
    <?php  if($this->acceso->valida('pagina','editar')) {?>
        <i class="tip-tools"></i>
        <div id="user-options">
            <a href="<?php echo base_url('modulo/menu/editar/'.$menu->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
        </div>
        <div class="editable"><div class="zona-editable"></div></div>
    <?php } ?>

    <?php echo $menu_categorias ?>

   
      
   

    <!-- <form class="navbar-form navbar-right" role="search" id="form-login" >
        <div class="form-group">
          <span>Iniciar Sesión</span>
        </div>
        <div class="form-group">
            <input type="text" class="form-control input-sm" name="username" placeholder="Correo electrónico" pb-role="username">
        </div>
        <div class="form-group">
            <input type="text" class="form-control input-sm" name="password" placeholder="Contraseña" pb-role="password">
        </div>
        <button type="submit" class="btn btn-default" pb-role="submit">ENTRAR</button>
        <div class="form-group">
          <span class="recuperar_contrasena"> <a href="#">Recuperar<br>Contraseña</a> </span>
        </div>
    </form> -->
          
  

</div>