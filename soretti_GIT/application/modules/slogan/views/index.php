
<div class="section-frase frase-parallax relative parallax-window" style="background: url(<?php echo $slogan->imagen ?>)no-repeat center center fixed;" >
    <?php  if($this->acceso->valida('pagina','editar')) {?>
    <i class="tip-tools"></i>
    <div id="user-options">
        <a href="<?php echo base_url('modulo/slogan/editar/'.$bloque->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
    </div>
    <div class="editable"><div class="zona-editable"></div></div>
    <?php } ?>
  <h2 class="wow fadeInDown animated"><?php echo $slogan->titulo ?></h2>
  <h3><?php echo $slogan->subtitulo ?></h3>
     <?php if($slogan->liga){ ?>
        <div class="btn-section-frase text-center">
          <a href="<?php echo url_idioma($slogan->liga) ?>" target="<?php echo $slogan->target; ?>" class="cotizar"> ver más >> </a>
        </div>
    <?php } ?>
</div>


