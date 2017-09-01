<!DOCTYPE html>
<html lang="es-mx">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo base_url('pub/theme/img/favicon.ico') ?>" type="image/x-icon" />
    <title><?php echo $meta['titulo'] ?></title>
    <meta name="description" content="<?php echo $meta['descripcion']; ?>" />
    <meta name="keywords" content="<?php echo $meta['palabras_clave']; ?>" />
    <meta property="og:url" content="<?php echo current_url(); ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="<?php echo $meta['titulo'] ?>" />
    <meta property="og:description" content="<?php echo $meta['descripcion']; ?>" />
    <meta name="robots" content="index, follow" />
    <?php if($this->uri->segment(1)=='blog' && isset($post) && isset($post->resumen_imagen)) {?>
    <meta property="og:image"  content="<?php echo $post->resumen_imagen; ?>" />
    <?php } ?>
    <?php if($this->uri->segment(1)=='catalogo' && isset($producto)  && isset($imagenes) ) {?>
    <meta property="og:image"  content="<?php echo base_url('pub/uploads/thumbs/'.name_image($producto->cat_imagen->imagen,'catalogo','cat_imagen',$producto->cat_imagen->lista_w,$producto->cat_imagen->lista_h)) ?>" />
    <?php } ?>
    <?php $this->load->view('plantilla/partial/scripts'); ?>
  </head>
  <body id="contenido">
    <?php echo modules::run('admin/menu'); ?>
    <header>
      <div class="container-fluid header">
        <nav class="navbar navbar-default navbar-fixed-top" id="menu-principal">
          <div class="container">
            <?php echo modules::run('menu'); ?>
          </div>
        </nav>
      </div>
    </header>
    <section>
      <?php //if(isset($pagina->imagen)){?>
   <!--  <div>
      <img src="<?php //echo $pagina->imagen?>" alt="" class="img-responsive"> 
    </div> -->
      <?php //} ?>
      <div class="container section">
        <?php echo $this->layout_content; ?>
      </div>
    </section>
    
    <footer class="clearfix">
<div class="footer-gris">
  
      <div class="container">
 
                <?php echo modules::run('textos',18); ?>       
 
      </div>
</div>
      <div class="footer contenedor">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <p class="text-left"> Copyright 2016 SorettiTodos los Derechos Reservados </p>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </body>
</html>