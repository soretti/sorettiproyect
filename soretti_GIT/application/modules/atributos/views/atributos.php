<div class="relative " >  
    <?php  if($this->acceso->valida('pagina','editar')) {?>
        <i class="tip-tools"></i>
        <div id="user-options">
            <a href="<?php echo base_url('modulo/atributos/editar/'.$bloque->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
        </div>
        <div class="editable"><div class="zona-editable"></div></div>
    <?php } ?>
    <div class="section-quehacemos">
              <h2><?php echo $atributos->titulo; ?></h2>
              <div class="section-contenido"><?php echo $atributos->texto; ?></div>
             <?php if($atributos->liga){ ?>
                <div class="section-quehacemos-liga">
                  <a href="<?php echo url_idioma($atributos->liga) ?>" target="<?php echo $atributos->target; ?>" class="cotizar"> ver más >> </a>
                </div>
            <?php } ?>
    </div>
</div>
