<div class="row">
    <div class="col-md-12 relative">
        <?php  if($this->acceso->valida('pagina','editar')) { ?>
        <i class="tip-tools"></i>
        <div id="user-options">
            <a href="<?php echo base_url('modulo/blog/listar/'.$pagina->id); ?>" class="editar"><span class="glyphicon glyphicon-th-list"></span></a>
            <a href="<?php echo base_url('modulo/pagina/editar/'.$pagina->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
        </div>
        <div class="editable"><div class="zona-editable"></div></div>
        <?php } ?>
        <?php  if($this->uri->segment(3)=='categoria') {?>
<!--         <ol class="breadcrumb">
            <li>
                <a href="<?php echo site_url(); ?>"><span class="glyphicon glyphicon-home"></span></a>
            </li>
            <li>
                <a href="<?php echo site_url('blog/'.$pagina->uri); ?>">blog</a>
            </li>
            <li class="active"><?php echo $categoria->titulo ?>
            </li>
        </ol> -->
        <?php }else{?>
        <h1 class="text-center"><?php echo $pagina->{'titulo'.IDIOMA}; ?></h1>
        <div class="resumen-pagina"><?php echo $pagina->{'contenido'.IDIOMA}; ?></div>
        <?php } ?>
    </div>
    <section id="pinterest_grid" class="blog">
        <?php foreach ($pagina->articulo->get() as $key => $post) { ?>
        <?php $imagen=($post->resumen_imagen) ? $post->resumen_imagen  : base_url('pub/uploads/thumbs/thumb-default.jpg'); ?>
        <article class="white-panel">
            <div class="col-md-12">
                <a href="<?php echo url_idioma(base_url('blog/'.$pagina->uri."/".$post->uri.".html")); ?>"><h2 class="fondo"><?php echo $post->{'titulo'.IDIOMA} ?></h2></a> 
                <div class="extra"> 
                    <?php  if($pagina->c_fecha) {?>
                    <time datetime="<?php echo $post->fecha_creacion; ?>">
                     <?php if(IDIOMA)  $fidioma=substr(IDIOMA,1); else $fidioma='es';  echo $this->dateutils->{'date'.$fidioma}(strtotime($post->fecha_creacion),'c','c');  ?>
                    </time>
                    <?php } ?>
                </div>
                <a href="<?php echo url_idioma(base_url('blog/'.$pagina->uri."/".$post->uri.".html")); ?>">
                    <img class="img-responsive" src="<?php echo $imagen ?>" alt="<?php echo $post->titulo; ?>">
                </a>
                <p class=""> <a href="<?php echo url_idioma(base_url('blog/'.$pagina->uri."/".$post->uri.".html")); ?>"><?php echo character_limiter($post->{'resumen'.IDIOMA}, 120); ?> </a></p>
            </div>
        </article>
        <?php } ?>
    </section>
</div>
<div class="row">
    <div class="col-md-12">
    <nav class="paginador"><?php echo $this->pagination->create_links(); ?></nav>
</div>
</div>