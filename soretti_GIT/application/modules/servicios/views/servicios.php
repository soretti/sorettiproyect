<div class="row">
  <div class="col-md-12">
    <div class="section-frase1 text-left">
        <?php  if($this->acceso->valida('pagina','editar')) {?>
            <i class="tip-tools"></i>
            <div id="user-options">
                <a href="<?php echo base_url('modulo/servicios/editar/'.$bloque->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
            </div>
            <div class="editable"><div class="zona-editable"></div></div>
        <?php } ?>        
      <h2 class="wow fadeInLeftBig animated" ><?php echo $bloque->titulo; ?></h2>
    </div>
  </div>
</div>
<div class="row">




  <?php foreach ($servicios as $i=>$servicio) {?>
    <div class="col-md-3 col-sm-6 wow fadeInUp animated">
        <div class="content-propuestas cuadro<?php echo $i; ?>">
            <div class="section-contenido">
                <div ><?php echo $servicio->subtitulo ?></div>
                <h2>
                  <?php echo $servicio->titulo ?>
                </h2>
                <?php echo $servicio->texto ?>
             <?php if($servicio->liga){ ?>
                <div class="botones">
                  <a href="<?php echo url_idioma($servicio->liga) ?>" target="<?php echo $servicio->target; ?>" class="cotizar"> ver más >> </a>
                </div>
            <?php } ?>
            </div>                    
        </div>
    </div>
  <?php } ?>



</div>