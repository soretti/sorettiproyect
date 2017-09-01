<div class="<?php if(!$nombre){ ?>box-cuenta<?php } ?> text-right">
<?php if($usuario_id): ?>
	<div>Bienvenido(a) <?php echo $nombre ?> </div>  <a href="<?php echo site_url('tienda/cuenta/micuenta') ?>">Mi cuenta</a> | <a href="<?php echo site_url('tienda/cuenta/logout') ?>">Logout</a>
<?php else: ?>
	<a href="<?php echo site_url('tienda/cuenta/registro') ?>" class="registro"><i class="fa fa-user"></i> Registro</a>
	<a href="<?php echo site_url('tienda/cuenta/login') ?>" class="login"><i class="fa fa-unlock-alt"></i> Login</a>
<?php endif; ?>
</div>
