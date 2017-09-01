<div class="relative" style="display:inline-block">

        <?php  if($this->acceso->valida('pagina','editar')) {?>
            <i class="tip-tools"></i>
            <div id="user-options">
                <a href="<?php echo base_url('modulo/menu/editar/'.$menu->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
            </div>
            <div class="editable"><div class="zona-editable"></div></div>
        <?php } ?>

    <?php $last=$menu->result_count()-1; foreach ($menu as $key => $menu): ?>
		<a href="<?php echo url_idioma($menu->boton->link) ?>" target="<?php echo $menu->boton->target ?>"><?php echo $menu->boton->{'titulo'.IDIOMA} ?></a> <?php if($key!=$last) echo " | "; ?>
	<?php endforeach; ?>
</div>