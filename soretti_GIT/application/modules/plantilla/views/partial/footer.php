<div class="row footer">
    <div class="col-xs-3 col-sm-3 col-md-3 tienda relative">
        <?php echo modules::run('menu/lista',4)  ?>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3 tienda">
        <?php echo modules::run('menu/lista',5)  ?>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3 tienda">
        <?php echo modules::run('menu/lista',6)  ?>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3 tienda">
        <div class="titulo-footer">Formas de pago</div>
        <div>
            <div class="sellos"><img src="<?php echo base_url('pub/theme/img/logo_open_pay.png')?>" alt="" class="img-responsive"/></div>
            <div class="sellos"><img src="<?php echo base_url('pub/theme/img/pago.png')?>" alt="" class="img-responsive"/></div>
            <div class="sellos last"><img src="<?php echo base_url('pub/theme/img/tiendas.png')?>" alt="" class="img-responsive"/></div>
        </div>
    </div>
</div>
<div class="row footer_boletin">
    <div class="col-md-3">
        <div class="telefono">
            <i class="fa fa-phone"></i> 55.20.11.55
        </div>
    </div>
    <div class="col-md-4 boletin">
        <div class="titulo">
            Recibe nuestro boletin
        </div>
    </div>
    <div class="col-md-5 boletin">
        <div class="form-group">
            <form action="" id="boletin">
                <label class="sr-only" for="">label</label>
                <input type="email" class="form-control" id="email_newslatter" name="email_newslatter" placeholder="Ingresa tu email">
                <input type="hidden" name="mnewsletterf" id="mnewsletterf">
                <input type="hidden" name="email_fieldf" id="email_fieldf">
                <button type="submit" class="btn btn-primary" id="suscribe_sendblaster">Suscribirse</button>
            </form>
        </div>
    </div>
</div>
<div class="row copy">
    <div class="col-md-12">
        <div class="text-center">Copyright &copy; 2015 <a href="<?php echo site_url() ?>">algaespirulina.mx</a> por <a href="http://paginasweb.mx">paginasweb.mx</a>  Todos los derechos reservados <img src="<?php echo base_url('pub/theme/img/ssl.png')?>" alt="" class="img-responsive" align="right"/></div>
    </div>
</div>


