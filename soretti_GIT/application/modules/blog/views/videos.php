<div class="row">
  <div class="col-md-12">
    <div class="carrusel-tipo2-wrapper ultimos_videos">
      <div class="figura videos"></div>
      <h2><?php echo $this->lang->line('videos') ?></h2>
      <div class="carrusel-tipo2">
        <div class="owl-carousel carrusel carousel2">
           <?php foreach ($listadovideos as $i=>$post) {
                    $imagen=($post->resumen_imagen) ? $post->resumen_imagen  : base_url('pub/uploads/thumbs/thumb-default.jpg'); 
            ?>
          <div class="item relative">
            <?php  if($this->acceso->valida('pagina','editar')) { ?>
            <i class="tip-tools"></i>
            <div id="user-options">
              <a href="<?php echo base_url('modulo/blog/editar/'.$post->pagina_id."/".$post->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
            </div>
            <div class="editable"><div class="zona-editable"></div></div>
            <?php } ?>


            <div class="inner item-video">
              <a href="<?php echo url_idioma(base_url('blog/'.$videos->uri."/".$post->uri.".html")); ?>">
                <img class="play" src="<?php echo base_url('pub/theme/img/play.png') ?>">
                <img class="img-responsive img-hover" src="<?php echo $imagen ?>">
              </a>
              <h4><a href="<?php echo url_idioma(base_url('blog/'.$videos->uri."/".$post->uri.".html")); ?>"><?php echo $post->{'titulo'.IDIOMA}; ?></a></h4>
              <div><?php echo character_limiter($post->{'resumen'.IDIOMA},70); ?></div>
            </div>
          </div>
          <?php } ?>
         </div>
      </div>
    </div>
  </div>
</div>