 <div class="relative navegacion">
        <?php  if($this->acceso->valida('pagina','editar')) {?>
            <i class="tip-tools"></i>
            <div id="user-options">
                <a href="<?php echo base_url('modulo/textos/editar_bloque/'.$bloque->id."/".$textos->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
            </div>
            <div class="editable"><div class="zona-editable"></div></div>
        <?php } ?>
        <span class="textos-texto"><?php  echo $textos->{'texto'.IDIOMA}; ?> </span>
   </div>
