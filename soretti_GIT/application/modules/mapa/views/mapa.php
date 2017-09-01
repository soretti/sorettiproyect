<div class="relative">
        <?php  if($this->acceso->valida('pagina','editar')) {?>
        <i class="tip-tools"></i>
        <div id="user-options">
            <a href="<?php echo base_url('modulo/mapa/editar/'.$bloque->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
        </div>
        <div class="editable"><div class="zona-editable"></div></div>
        <?php } ?>

        <?php foreach ($direcciones_mapa as $key=>$item) { $item->mapa->get(); ?>
        <h2><?php echo  $item->{'titulo'.IDIOMA}; ?></h2>
        <div class="texto"> <?php echo $item->{'texto'.IDIOMA} ?> </div>
        <div class="map-box" id="<?php echo $bloque->id."-mapa-".$key; ?>" coordenadas="<?php echo $item->mapa->coordenadas; ?>" texto='<?php echo $item->mapa->{'texto'.IDIOMA}; ?>'></div>
        <div class="boton-enlarge rovesa-style pie-title"><a class="fancybox-frame" href="<?php echo base_url('modulo/mapa/mostrar_mapa');  ?>" >+ Click to enlarge</a></div>
        <?php } ?>
</div>
