<div class="row fila-top">
    <div class="col-md-3">
        <div class="logo">
            <a href="<?php echo site_url(); ?>"><img src="<?php echo base_url('pub/theme/img/logo.jpg')?>" alt="" class="img-responsive img-logo"></a>
        </div>
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-4">
                <div class="compra_en_linea">
                    <a href="<?php echo site_url('catalogo/alga-espirulina')?>"><img src="<?php echo base_url('pub/theme/img/boton_tienda.jpg')?>" alt="" >                  </a>
                </div>
            </div>
            <div class="col-md-8">
                        <div class="header">
                            <div class="text-right social">
                                <span>Síguenos en: </span>
                                <a href="https://twitter.com/espirulinamx" target="_blank"><i class="fa fa-twitter"></i></a>
                                <a href="https://www.facebook.com/algaespirulinamx" target="_blank"><i class="fa fa-facebook"></i></a>
                                <i class="pleca"></i>
                                <span><i class="fa fa-phone"></i></span>
                                <span><small>(55) 5520 1155,  (55) 5520 1136</small></span>
                            </div>
                            <div class="row pleca-cuenta"> 
                                <div class="col-md-6">
                                    <?php echo modules::run('tienda/menutienda/mostrar') ?>
                                </div>
                                <div class="col-md-6 text-right">
                                    <div class="input-group carrito-resumen">
                                        <span class="input-group-btn">
                                            <a class="btn btn-default" href="<?php echo base_url('tienda/carrito/mostrar')  ?>"><i class="fa fa-shopping-cart"></i></a>
                                        </span>
                                        <div class="form-control"><span id="shop-items"> <?php echo $this->cart->total_items(); ?> </span> productos(s) <span id="shop-total"><?php echo formato_precio($this->cart->total()); ?></span> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div>
</div>
