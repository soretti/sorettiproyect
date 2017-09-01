<ul class="nav nav-pills nav-stacked">
	<li <?php if($titulo=='Mi Cuenta' || $titulo=='Modificar Cuenta'){ ?> class="active" <?php } ?> ><a href="<?php echo base_url('tienda/cuenta/micuenta') ?>" >Mi cuenta</a></li>
	<li class="<?php echo($this->uri->segment(2)=='order')?'active':'' ?>"><a href="<?php echo base_url('tienda/order/listar') ?>">Mis órdenes</a></li>
	<li <?php if($titulo=='Mis direcciones' || $titulo=='Modificar Dirección' || $titulo=='Crear Dirección'){ ?> class="active" <?php } ?> ><a href="<?php echo base_url('tienda/direccion/listar') ?>">Mis direcciones</a></li>
	<li <?php if($titulo=='Newsletter'){ ?> class="active" <?php } ?>  ><a href="<?php echo base_url('tienda/cuenta/editargrupo'); ?>">Newsletter</a></li>
</ul>
