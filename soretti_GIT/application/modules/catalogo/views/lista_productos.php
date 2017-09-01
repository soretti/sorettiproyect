<div class="row">
  <?php if(!$productos->result_count() ) {?>
  <div class="col-md-12">
    <div class="alert alert-warning">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <?php  echo $this->lang->line('sin_resultados'); ?>
    </div>
  </div>
  <?php } ?>
  <div class="col-md-12">
    <section id="pinterest_grid" class="lista-productos">
      <?php foreach ($productos as $producto) {
      $precio=$producto->precio(1,$producto,$producto->combinacion);
      ?>
      <article class="white-panel relative">
        <?php  if($this->acceso->valida('catalogo','editar')) {?>
        <i class="tip-tools"></i>
        <div id="user-options">
          <a href="<?php echo site_url('modulo/catalogo/editar/'.$producto->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
        </div>
        <div class="editable"><div class="zona-editable"></div></div>
        <?php } ?>
        <?php
        $imagen=(isset($portadas[$producto->id])) ? name_image($portadas[$producto->id],'catalogo','cat_imagen',620,412) : 'thumb-default.jpg';
        if(!$imagen) $imagen='thumb-default.jpg';
        ?>
        <div class="item">
          <div class="imagen">
            <a href="<?php echo url_idioma(site_url('catalogo/'.$producto->cat_categoria_uri.'/'.$producto->uri)) ?>">
              <img src="<?php echo  base_url('pub/uploads/thumbs/'.$imagen);  ?>" alt="<?php echo $producto->titulo ?>" class="img-responsive img-catalogo">
            </a>
            <?php //if(!$producto->comprar_sin_stock) {?>
           <!--  <div class="stock">Stock: <span><?php echo $producto->stock($producto,$producto->combinacion); ?></span></div> -->
            <?php //} ?>

              <?php //if($producto->agotado) {?>
               <!--  <div class="agotado"></div> -->
              <?php //} ?>
          </div>

          <div class="titulo-producto text-center">
            <a href="<?php echo url_idioma(site_url('catalogo/'.$producto->cat_categoria_uri.'/'.$producto->uri)) ?>">
            <h2><?php echo  ucfirst(strtolower(character_limiter($producto->{'titulo'.IDIOMA},90))); ?></h2>
          </a>
          </div>
          
           <?php if(!$producto->agotado) {?>
          <form method="post" action="<?php echo url_idioma(site_url('catalogo/'.$producto->cat_categoria_uri.'/'.$producto->uri)) ?>">
               <input type="hidden" name="producto_id" id="producto_id" value="<?php echo (isset($producto->combinacion)) ? $producto->combinacion->id : $producto->id; ?>">
               <input name="cantidad" type="hidden" value="1" />
               <button type="submit" class="btn btn-success" id="comprarahora" >VER MÁS</button>
           </form>
          <?php } ?>
        </div>
      </article>
      <?php } ?>
    </section>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <nav class="paginador text-right">
      <?php echo $this->pagination->create_links(); ?>
    </nav>
  </div>
</div>
