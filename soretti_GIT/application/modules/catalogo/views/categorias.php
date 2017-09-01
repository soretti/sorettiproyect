<?php echo $breadcrumb; ?>

<div class="row">
  <div class="col-md-12">
    <h1> Categorias:  <?php echo $titulo ?></h1>
  </div>
</div>

<div class="row relative">
  <div class="col-md-12">
    <section id="pinterest_grid" class="lista-productos">
      <?php foreach ($categorias as $categoria) {?>
      <article class="white-panel relative">
        <!-- <div class="col-md-4 col-xs-12"> -->

          <?php   if($this->acceso->valida('catalogo','editar')) {?>
          <i class="tip-tools"></i>
          <div id="user-options">
            <a href="<?php echo base_url('modulo/catalogo/catalogocategoria/editar/'.$categoria->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
          </div>
          <div class="editable"><div class="zona-editable"></div></div>
          <?php } ?>
          <div class="item">
            <?php  if($categoria->imagen) { ?>
          <div class="imagen">

            <a href="<?php echo url_idioma(base_url('catalogo/'.$categoria->uri.'.html'));  ?>"><img src="<?php echo $categoria->imagen; ?>" alt="" class="img-responsive"></a>
          </div>
            <?php }else{
            $img = new  cat_imagen();
            $img->include_related('producto',array('id','categoria_id'));
            $img->where_related_producto('categoria_id',$categoria->id)->limit(1)->get(); ?>
            <div class="imagen">
            <a href="<?php echo url_idioma(base_url('catalogo/'.$categoria->uri.'.html'));  ?>"><img src="<?php echo $img->imagen; ?>" alt="" class="img-responsive img-catalogo"></a>
            </div>
            <?php } ?>
            <a href="<?php echo url_idioma(base_url('catalogo/'.$categoria->uri.'.html'));  ?>">
            <div class="titulo-producto text-center"><?php echo  $categoria->{'titulo'.IDIOMA}; ?></div></a>
          </div>

        <!--  </div> -->
      </article>
      <?php } ?>
    </div>
  </div>
</div>
