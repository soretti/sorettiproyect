
<?php  if($this->acceso->valida('pagina','editar')) {?>
    <i class="tip-tools"></i>
    <div id="user-options">
        <a href="<?php echo base_url('modulo/menu/editar/'.$menu->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
    </div>
    <div class="editable"><div class="zona-editable"></div></div>
<?php } ?>

    <div class="titulo titulo-menu-general titulo-footer"><?php echo $menu->{'titulo'.IDIOMA}; ?></div>

    <ul class="menu-lateral-derecho">
	<?php foreach ($menu as $key => $menu): ?>
		<li><a href="<?php echo url_idioma($menu->boton->link) ?>" target="<?php echo $menu->boton->target ?>"><?php echo $menu->boton->{'titulo'.IDIOMA} ?></a></li>
	<?php endforeach; ?>
	</ul>