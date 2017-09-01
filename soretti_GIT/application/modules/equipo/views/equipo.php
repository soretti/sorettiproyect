 <div class="relative equipo">
 
            <?php  if($this->acceso->valida('pagina','editar')) {?>
                <i class="tip-tools"></i>
                <div id="user-options">
                    <a href="<?php echo base_url('modulo/equipo/editar/'.$bloque->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
                </div>
                <div class="editable"><div class="zona-editable"></div></div>
            <?php } ?>


        <?php foreach ($equipo as $key=>$item) {?>
                <img src="<?php echo $item->imagen; ?>" alt="" class="img-responsive">
        <?php } ?>
    
</div>
