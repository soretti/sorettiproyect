
<div class="section-frase frase-parallax relative parallax-window"   data-parallax="scroll" data-image-src="<?php echo $articulo->footer_imagen ?>">
  <h2><?php echo $articulo->footer_titulo ?></h2>
  <h3><?php echo $articulo->footer_subtitulo ?></h3>
     <?php if($articulo->footer_liga){ ?>
        <div class="slider-botones text-center">
          <a href="<?php echo url_idioma($articulo->footer_liga) ?>" target="<?php echo $articulo->footer_target; ?>" class="cotizar"> ver más >> </a>
        </div>
    <?php } ?>
</div>


