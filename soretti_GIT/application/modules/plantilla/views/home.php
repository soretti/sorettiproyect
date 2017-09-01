<!DOCTYPE html>
<html lang="es-mx">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $meta['titulo'] ?></title>
    <meta name="description" content="<?php echo $meta['descripcion']; ?>" />
    <meta name="keywords" content="<?php echo $meta['palabras_clave']; ?>" />
    <meta name="robots" content="index, follow" />

    <meta property="og:title" content="Soretti">
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?php echo site_url(); ?>">
    <meta property="og:image" content="<?php echo base_url('pub/theme/img/logo2.png'); ?>">

    <?php $this->load->view('plantilla/partial/scripts'); ?>

    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5321ee4f304ecf3b"></script>
    <script type="text/javascript" src="<?php echo base_url('pub/libraries/parallax.min.js') ?>"></script>


  </head>
  <body>
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
      <div class="container-fluid no-padding">
          <?php echo modules::run('slider'); ?>
      </div>

    <div class="text-center section-citillo">
      <?php echo modules::run('equipo'); ?>
    </div>

<div class="content-seccion3">
      <div class="container seccion3">
        <div class="row">
          <div class="col-md-9 quehacemos">
            <?php echo modules::run('quehacemos'); ?>
          </div>
          <div class="col-md-3">
           <?php echo modules::run('atributos'); ?>
          </div>          
        </div>
    </div>
</div>

    <div class="container section propuestas">
        <?php echo modules::run('servicios'); ?>
    </div>

    <div>
        <?php echo modules::run('slogan'); ?>
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
              <p class="text-left"> Copyright 2016 Soretti Todos los Derechos Reservados </p>
          </div>
        </div>
        </div>
      </div>
    </footer>   
  </body>
</html>


