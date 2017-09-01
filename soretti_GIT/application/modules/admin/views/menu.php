<nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="menu-backend">
	<div class="navbar-inner">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle btn-navbar" data-toggle="collapse" data-target=".navbar-ex2-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="<?php echo base_url() ?>">Trahc tools</a>
	</div>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse nav-collapse navbar-ex2-collapse">

		<ul class="nav navbar-nav">
			<li>
				<a href="" class="brand" ><img src="<?php echo base_url('pub/libraries/trahctools/img/logob.png'); ?>" alt="Trahc tools"></a>
			</li>
			<li>
				<a href="<?php echo base_url() ?>">Frontend</a>
			</li>

			<?php if($this->acceso->valida('chat','editar') || $this->acceso->valida('chat','consultar') || $this->acceso->valida('chat','eliminar')) {?>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Live Chat <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo base_url('modulo/chat/panel') ?>">Panel</a></li>
					<li><a href="<?php echo base_url('modulo/chat/respuesta/listar') ?>">Respuestas rápidas</a></li>
					<li><a href="<?php echo base_url('modulo/chat/tipo/listar') ?>" id="generarSitemap">Clasificación de respuestas</a></li>
				</ul>
			</li>
			<?php } ?>

			<?php if($this->acceso->valida('pagina','editar') || $this->acceso->valida('pagina','consultar') || $this->acceso->valida('pagina','eliminar')) {?>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Páginas <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo base_url('modulo/pagina/listar') ?>">Listar</a></li>
					<li><a href="<?php echo base_url('modulo/pagina/agregar') ?>">Agregar</a></li>
					<li><a href="<?php echo base_url('modulo/pagina/sitemap') ?>" id="generarSitemap">Actualizar mapa del sitio</a></li>
				</ul>
			</li>
			<?php } ?>

			<?php if($this->acceso->valida('catalogo','editar') || $this->acceso->valida('catalogo','consultar') || $this->acceso->valida('catalogo','eliminar')) {?>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Catálogo <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo base_url('modulo/catalogo/listar') ?>">Productos</a></li>
					<li><a href="<?php echo base_url('modulo/catalogo/catalogocategoria/editar') ?>">Categorias</a></li>
					<li><a href="<?php echo base_url('modulo/catalogo/catalogomarca/listar') ?>">Marcas</a></li>

					<li><a href="<?php echo base_url('modulo/catalogo/catalogoatributo/listar') ?>">Atributos</a></li>
				</ul>
			</li>
			<?php } ?>

 

			<?php if(
					$this->acceso->valida('tienda','editar') || 
					$this->acceso->valida('tienda','consultar') || 
					$this->acceso->valida('tienda','eliminar') || 
					$this->acceso->valida('orders','eliminar') || 
					$this->acceso->valida('orders','eliminar') || 
					$this->acceso->valida('orders','eliminar') ||
					$this->acceso->valida('fletes','eliminar') || 
					$this->acceso->valida('fletes','eliminar') || 
					$this->acceso->valida('fletes','eliminar')
					) {?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Tienda <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<?php  if($this->acceso->valida('orders','editar') ||  $this->acceso->valida('orders','consultar') ||  $this->acceso->valida('orders','eliminar') ) {?>
						<li  class="dropdown-submenu">
							<a tabindex="-1" href="#">Ordenes</a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo base_url('modulo/tienda/backend/order/listar') ?>">Listar</a></li>
							</ul>
						</li>
						<?php } ?>

						<?php  if($this->acceso->valida('fletes','editar') ||  $this->acceso->valida('fletes','consultar') ||  $this->acceso->valida('fletes','eliminar') ) {?>

							<li><a href="<?php echo base_url('modulo/tienda/flete/listar') ?>">Paqueterias</a></li>
						<?php } ?>

						<?php  if($this->acceso->valida('tienda','editar') ||  $this->acceso->valida('tienda','consultar') ||  $this->acceso->valida('tienda','eliminar') ) {?>
							<li  class="dropdown-submenu">
								<a tabindex="-1" href="#">Reporte</a>
								<ul class="dropdown-menu">
									<li><a href="<?php echo base_url('tienda/backend/reporte1') ?>">Reporte de comisiones</a></li>
									<li><a href="<?php echo base_url('tienda/backend/reporte3') ?>">Reporte de ventas</a></li>
									<li><a href="<?php echo base_url('tienda/backend/reporte4') ?>">Reporte costo productos</a></li>
									<li><a href="<?php echo base_url('tienda/backend/reporte5') ?>">Reporte venta mostrador</a></li>
									<li><a href="<?php echo base_url('tienda/backend/reporte6') ?>">Reporte compra distribuidores</a></li>
								</ul>
							</li>
						<?php } ?>
						
						<?php  if($this->acceso->valida('tienda','editar') ||  $this->acceso->valida('tienda','consultar') ||  $this->acceso->valida('tienda','eliminar') ) {?>
						<li  class="dropdown-submenu">
							<a tabindex="-1" href="#">Usuarios</a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo base_url('modulo/tienda/backend/cuenta/listar') ?>">Listar</a></li>
							</ul>
						</li>
						<?php } ?>
						<?php  if($this->acceso->valida('tienda','editar') ||  $this->acceso->valida('tienda','consultar') ||  $this->acceso->valida('tienda','eliminar') ) {?>
							<li><a href="<?php echo base_url('modulo/tienda/cupon/listar') ?>">Cupones</a></li>
							<li><a href="<?php echo base_url('modulo/tienda/envio/mostrar') ?>">Configuración de envío</a></li>
						<?php } ?>
					</ul>
				</li>
			<?php } ?>

			<!--
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Columnas <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="<?php //echo base_url('modulo/columna/agregar') ?>">Agregar</a></li>
					<li><a href="<?php //echo base_url('modulo/columna/listar') ?>">Listar</a></li>
				</ul>
			</li> -->
			<?php if($this->acceso->valida('usuario','editar') || $this->acceso->valida('usuario','consultar') || $this->acceso->valida('usuario','eliminar')) {?>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuarios <b class="caret"></b> </a>
				<ul class="dropdown-menu" role="menu">
					<li  class="dropdown-submenu">
						<a tabindex="-1" href="#">Usuarios</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_url('modulo/usuario/agregar') ?>">Agregar</a></li>
							<li><a href="<?php echo base_url('modulo/usuario/lista') ?>">Listar</a></li>
						</ul>
					</li>
					<li  class="dropdown-submenu">
						<a tabindex="-1" href="#">Roles de usuarios</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_url('modulo/rol/agregar') ?>">Agregar</a></li>
							<li><a href="<?php echo base_url('modulo/rol/lista') ?>">Listar</a></li>
						</ul>
					</li>
				</ul>
			</li>
			<?php } ?>
			<?php if($this->acceso->valida('boletin','editar') || $this->acceso->valida('boletin','consultar') || $this->acceso->valida('boletin','eliminar')) {?>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Boletines <b class="caret"></b> </a>
				<ul class="dropdown-menu" role="menu">
					<li  class="dropdown-submenu">
						<a tabindex="-1" href="#">Suscriptores</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_url('modulo/boletin/boletinusuarios/agregar') ?>">Agregar</a></li>
							<li><a href="<?php echo base_url('modulo/boletin/boletinusuarios/lista') ?>">Listar</a></li>
						</ul>
					</li>
					<li  class="dropdown-submenu">
						<a tabindex="-1" href="#">Grupos</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_url('modulo/boletin/grupos/agregar') ?>">Agregar</a></li>
							<li><a href="<?php echo base_url('modulo/boletin/grupos/listar') ?>">Listar</a></li>
						</ul>
					</li>
					<li  class="dropdown-submenu">
						<a tabindex="-1" href="#">Newsletter</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_url('modulo/boletin/newsletter/agregar') ?>">Agregar</a></li>
							<li><a href="<?php echo base_url('modulo/boletin/newsletter/listar') ?>">Listar</a></li>
						</ul>
					</li>
					<li  class="dropdown-submenu">
						<a tabindex="-1" href="#">Templates</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_url('modulo/boletin/template/agregar') ?>">Agregar</a></li>
							<li><a href="<?php echo base_url('modulo/boletin/template/listar') ?>">Listar</a></li>
						</ul>
					</li>
					<li  class="dropdown-submenu">
						<a tabindex="-1" href="#">Cuentas</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo base_url('modulo/boletin/cuenta/agregar') ?>">Agregar</a></li>
							<li><a href="<?php echo base_url('modulo/boletin/cuenta/listar') ?>">Listar</a></li>
						</ul>
					</li>
				</ul>
			</li>
			<?php } ?>
<!-- 			<li>
				<a id="salircookie" href="<?php echo base_url('modulo/contacto/listar') ?>">Contactos</a>
			</li> -->
			<li>
				<a id="salircookie" href="<?php echo base_url('modulo/admin/cerrar_sesion') ?>">Salir</a>
			</li>
			<li>
				<div id="pad-lock" href="./index.html"></div>
			</li>
		</ul>
		<!-- <div id="pad-lock" href="./index.html"></div> -->
	</div>
</div>
</nav>
