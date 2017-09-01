<div class="row carrusel modulo-galeria">
    <?php  if($this->acceso->valida('pagina','editar')) {?>
    <i class="tip-tools"></i>
    <div id="user-options">
        <a href="<?php echo base_url('modulo/galeria/editar/'.$pagina->id); ?>" class="editar"><span class="glyphicon glyphicon-th-list"></span></a>
        <a href="<?php echo base_url('modulo/pagina/editar/'.$pagina->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
    </div>
    <div class="editable"><div class="zona-editable"></div></div>
    <?php } ?>
    <section id="pinterest_grid">
        <?php foreach ($pagina->galeriaimagenes->get() as $post) {?>
        <article class="white-panel   ">
            <div class="col-md-12">
                <div class="item">
                    <a class="fancybox" rel="group" href="<?php echo $post->path ?>" title="<?php echo $post->{'description'.IDIOMA} ?>">
                        <img src="<?php echo base_url('pub/uploads/thumbs/'.name_image($post->path,'galeria','path',$pagina->galeriaimagenes->t_width,$pagina->galeriaimagenes->t_height) ) ?>" class="img-responsive" alt="Image">
                        <div class="title rovesa-style pie-title"><?php echo $post->{'title'.IDIOMA} ?></div>
                    </a>
                </div>
            </div>
        </article>
        <?php } ?>
    </section>
    <?php if(!$pagina->galeriaimagenes->result_count()) {?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning text-center">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                No se encontraron resultados en esta pagina
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="text-center">
        <?php echo $this->pagination->create_links(); ?>
    </div>
</div>