<!-- Post Content -->
<div class="contenido-html">
    <div class="relative">
        <?php  if($this->acceso->valida('pagina','editar')) {?>
        <i class="tip-tools"></i>
        <div id="user-options">
            <a href="<?php echo base_url('modulo/blog/editar/'.$pagina->id."/".$post->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
        </div>
        <div class="editable"><div class="zona-editable"></div></div>
        <?php } ?>
<!--         <div>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo site_url(); ?>"><span class="glyphicon glyphicon-home"></span></a>
                </li>
                <li>
                    <a href="<?php echo site_url('blog/'.$pagina->uri); ?>">blog</a>
                </li>
                <?php if($post->categoria_id) {?>
                <li class="active"> <a href="<?php echo site_url('blog/'.$pagina->uri."/categoria/".$post->blog_categoria_uri); ?>"><?php echo $post->blog_categoria_titulo ?></a>  </li>
                <?php }?>
            </ol>
        </div> -->
        <div>
            <?php  if($pagina->c_fecha) {?>
            <div class="text-right fecha"> <?php if(IDIOMA)  $fidioma=substr(IDIOMA,1); else $fidioma='es';  echo $this->dateutils->{'date'.$fidioma}(strtotime($post->fecha_creacion),'c','c');  ?> </div>
            <?php } ?>
            <?php  if($pagina->c_usuario) {?>
            <div class="text-right"> <?php echo $this->lang->line('autor') ?>: <?php echo $post->usuario_nombre ?> </div>
            <?php } ?>
            <?php if($pagina->c_compartir) {?>
            <div class="text-right clearfix">
                <div class="addthis_sharing_toolbox"></div>
            </div>
            <?php } ?>
            
        </div>
        <h1 class="head1"><?php echo $post->{'titulo'.IDIOMA} ?></h1>
        <div> <?php echo $post->{'contenido'.IDIOMA}; ?> </div>
    </div>
    <?php if($pagina->c_comentarios) {?>
    <h3 class="page-header"><?php echo $this->lang->line('comentarios') ?>:</h3>
    <div class="fb-comments" data-href="<?php echo current_url(); ?>" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
    <?php } ?>
</div>