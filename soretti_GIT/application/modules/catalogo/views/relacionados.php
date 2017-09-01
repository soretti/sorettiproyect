            <div class="col-md-12">
                <section id="pinterest_grid" class="lista-productos">
                    <?php foreach ($destacados as $i=>$destacado) {
                    $precio=$destacado->producto->precio(1,$destacado->producto, $destacado->combinacion);
                    $imagen=(isset($portadas[$destacado->producto_id])) ? name_image($portadas[$destacado->producto_id],'catalogo','cat_imagen',$imagenes->lista_w,$imagenes->lista_h) : 'thumb-default.jpg'; ?>
                    <article class="white-panel relative">
                        <div class="item">
                            <div class="imagen">
                                <a href="<?php echo url_idioma(site_url('catalogo/'.$destacado->producto_cat_categoria_uri."/".$destacado->producto_uri)); ?>">
                                    <img src="<?php echo  base_url('pub/uploads/thumbs/'.$imagen);  ?>" alt="<?php echo $destacado->producto_titulo ?>" class="img-responsive">
                                </a>
                                <?php if(!$destacado->producto->comprar_sin_stock) {?>
                                <div class="stock">Stock: <span><?php  echo $destacado->producto->stock($destacado->producto,$destacado->combinacion);  ?></span></div>
                                <?php } ?>
                            </div>
                            <div class="titulo-producto text-center">
                                <a href="<?php echo url_idioma(base_url('catalogo/'.$destacado->producto_cat_categoria_uri."/".$destacado->producto_uri.".html")); ?>"><h2><?php echo  ucfirst(strtolower (character_limiter($destacado->{'producto_titulo'.IDIOMA}, 90))); ?></h2></a>
                            </div>
                            <div class="precios <?php if($precio['precio_sin_promocion']) echo "promocion"; ?>">
                                <?php if($precio['precio_sin_promocion']) {?>
                                <span class="regular"><?php echo formato_precio($precio['precio_sin_promocion']); ?></span>
                                <?php } ?>
                                <span class="precio"><?php echo formato_precio($precio['precio']); ?></span>
                                <?php $data['planes_pagos'] =  $this->config->item('planes_pagos','proyecto');
                                $mensaje='';
                                if(is_array($data['planes_pagos'])) foreach ($data['planes_pagos'] as $key => $value) {
                                if($precio['precio']>=$value) $mensaje="<div class='meses-txt text-left'>".$key." pagos de: <span>".formato_precio($precio['precio']/$key)."</span></div>";
                                }
                                echo $mensaje;
                                ?>
                            </div>
                        </div>
                    </article>
                    <?php } ?>
                </section>
            </div>