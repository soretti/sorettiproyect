<div class="widget ultimas-publicaciones fila-top">
<!--     <div class="barra-azul text-center fila-top categorias ">
        <?php echo $pagina->titulo ?>
    </div> -->
    <ul class="nav nav-pills nav-stacked">
        <?php foreach ($listado as $i=>$post) {?>
        <li>
            <div class="wrapper">
                <?php $imagen=($post->resumen_imagen) ? $post->resumen_imagen  : base_url('pub/uploads/thumbs/thumb-default.jpg'); ?>
                
                <div class="wrapper">
                    
                    <div class="extra"> 
                        <?php  if($pagina->c_fecha) {?>
                         <?php if(IDIOMA)  $fidioma=substr(IDIOMA,1); else $fidioma='es';  echo $this->dateutils->{'date'.$fidioma}(strtotime($post->fecha_creacion),'c','c');  ?>
                        <?php } ?>
                    </div>
                    <div class="imagen relative">
                        <div class="titulo_last_post">
                            <a href="<?php echo url_idioma(site_url('blog/'.$blog->uri."/".$post->uri)); ?>"><h3><?php  echo $post->titulo; ?></h3></a>
                        </div>
                        <a href="<?php echo url_idioma(site_url('blog/'.$blog->uri."/".$post->uri)); ?>">
                            <img src="<?php echo $imagen ?>" class="img-responsive" alt="<?php echo $post->titulo; ?>" longdesc="#ultimos_post_<?php echo $post->id?>" >
                        </a>
<!--                         <p>
                        <a href="<?php echo url_idioma(site_url('blog/'.$blog->uri."/".$post->uri)); ?>" id="ultimos_post_<?php echo $post->id?>">
                            <?php echo character_limiter($post->{'resumen'.IDIOMA}, 70); ?>
                        </a>
                        </p> -->
                    </div>
                </div>

            </div>
        </li>
        <?php } ?>
    </ul>
</div>