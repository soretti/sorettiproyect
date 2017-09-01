<div class="fila-top">
    <div class="barra-azul text-left">Lo mas vendido</div>
<div class="carrusel relative lista-productos">


    <?php  if($this->acceso->valida('catalogo','editar')) { ?>
    <i class="tip-tools"></i>
    <div id="user-options">
        <a href="<?php echo base_url('modulo/catalogo/catalogodestacados/editar/lomasvendido'); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
    </div>
    <div class="editable"><div class="zona-editable"></div></div>
    <?php } ?>
    <div class="box">
        <div class="owl-carousel-productos">
            <?php foreach ($destacados as $i=>$destacado) {
            $precio=$destacado->precio(1,$destacado, $destacado->combinacion);
            $imagen=(isset($portadas[$destacado->id])) ? name_image($portadas[$destacado->id],'catalogo','cat_imagen',$imagenes->lista_w,$imagenes->lista_h) : 'thumb-default.jpg'; ?>
            <div class="item">
                <div class="imagen">
                    <a href="<?php echo url_idioma(site_url('catalogo/'.$destacado->cat_categoria_uri."/".$destacado->uri)); ?>">
                        <img src="<?php echo  base_url('pub/uploads/thumbs/'.$imagen);  ?>" alt="" class="img-responsive">
                    </a>
                    <div class="stock">Stock: <span><?php  echo $destacado->stock($destacado,$destacado->combinacion);  ?></span></div>
                </div>

                <div class="titulo-producto text-center">
                    <a href="<?php echo url_idioma(base_url('catalogo/'.$destacado->cat_categoria_uri."/".$destacado->uri.".html")); ?>"><?php echo  ucfirst(strtolower (character_limiter($destacado->{'titulo'.IDIOMA}, 45))); ?></a>
                </div>
                <div class="precios <?php if($precio['precio_sin_promocion']) echo "promocion"; ?>">
                    <?php if($precio['precio_sin_promocion']) {?>
                        <span class="regular"><?php echo formato_precio($precio['precio_sin_promocion']); ?></span>
                    <?php } ?>
                    <span class="precio"><?php echo formato_precio($precio['precio']); ?></span>
                    <?php $data['planes_pagos'] =  $this->config->item('planes_pagos','proyecto');
                                $mensaje='';
                                foreach ($data['planes_pagos'] as $key => $value) {
                                   if($precio['precio']>=$value) $mensaje="<div class='meses-txt text-left'>".$key." pagos de: <span>".formato_precio($precio['precio']/$key)."</span></div>";
                                }
                                echo $mensaje;
                  ?>
                </div>

            </div>
            <?php } ?>
        </div>
    </div>
</div>
</div>
