
        <?php  if($this->acceso->valida('pagina','editar')) {?>
            <i class="tip-tools"></i>
            <div id="user-options">
                <a href="<?php echo base_url('modulo/menu/editar/'.$menu->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
            </div>
            <div class="editable"><div class="zona-editable"></div></div>
        <?php } ?>

            <h3><?php echo $menu->{'titulo'.IDIOMA}; ?></h3>
            <?php echo $menu_categorias;?>

