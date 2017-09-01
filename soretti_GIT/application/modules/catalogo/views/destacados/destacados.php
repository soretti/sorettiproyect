 
        <div class="row">
          <div class="section-catalogo">
            <div class="section-frase1"><h2>ALGUNO DE NUESTROS TRABAJOS</h2></div>
            <div class="carrusel relative lista-productos">

                <?php  if($this->acceso->valida('catalogo','editar')) { ?>
                    <i class="tip-tools"></i>
                    <div id="user-options">
                        <a href="<?php echo base_url('modulo/catalogo/catalogodestacados/editar/recomienda'); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
                    </div>
                    <div class="editable"><div class="zona-editable"></div></div>
                <?php } ?>

                <?php foreach ($destacados as $i=>$destacado) {
                    $precio=$destacado->producto->precio(1,$destacado->producto, $destacado->combinacion);
                    $imagen=(isset($portadas[$destacado->producto_id])) ? name_image($portadas[$destacado->producto_id],'catalogo','cat_imagen',$imagenes->lista_w,$imagenes->lista_h) : 'thumb-default.jpg'; ?>


                            <div class="col-md-4 col-sm-4">
                              <div class="view view-third">

                                <a href="<?php echo url_idioma(site_url('catalogo/'.$destacado->producto_cat_categoria_uri."/".$destacado->producto_uri)); ?>">
                                    <img src="<?php echo base_url('pub/uploads/thumbs/'.$imagen); ?>" alt="<?php echo $destacado->producto_titulo ?>" title="<?php echo $destacado->producto_titulo ?>" class="img-responsive">
                                </a>

                                <div class="mask">
                                  <h2><?php echo $destacado->producto_titulo; ?></h2>
                                  <p><?php echo $destacado->producto_resumen; ?></p>
                                  <a href="<?php echo url_idioma(site_url('catalogo/'.$destacado->producto_cat_categoria_uri."/".$destacado->producto_uri)); ?>" class="info">Ver más</a>
                                </div>
                              </div>
                            </div>

                <?php } ?>
           
          </div>
        </div>
        </div>
        <div class="row media-fila">
          <div class="col-md-12">
            <div id="section-catalogo-button" imgUno="<?php echo base_url('pub/theme/img/briefcase13ini.png'); ?>" imgDos="<?php echo base_url('pub/theme/img/briefcase13fin.png'); ?>" ><img src="<?php echo base_url('pub/theme/img/briefcase13ini.png'); ?>" alt="portafolio diseño de paginas web" title="portafolio diseño de paginas web"><a href="http://paginasweb.mx/catalogo/portafolio.html">VER MAS PROYECTOS</a></div>
          </div>
        </div>