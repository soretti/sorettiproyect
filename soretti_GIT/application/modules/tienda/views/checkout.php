<div class="row checkout">

        <div class="row">
            <div class="col-md-12"> <h1>Checkout</h1> </div>
        </div>
       
           
    <div class="col-md-9">
        <div class="row fila">
            <div class="col-md-12">

                <div id="acordion1" class="acordion">
                    <?php echo modules::run('tienda/checkout/envio') ?>
                    <?php echo modules::run('tienda/checkout/extras') ?>
                    <?php echo modules::run('tienda/checkout/factura') ?>
                    <?php echo modules::run('tienda/checkout/pago') ?>
                    <?php echo modules::run('tienda/checkout/resumen') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 resumen">
        <div class="barra-azul text-center fila-top categorias ">
            Progreso de tu compra
            <i class="fa fa-bars"></i>
        </div>
        <?php echo modules::run('tienda/checkout/envio_resumen') ?>
        <?php echo modules::run('tienda/checkout/extras_resumen') ?>
        <?php echo modules::run('tienda/checkout/factura_resumen') ?>
        <?php echo modules::run('tienda/checkout/pago_resumen') ?>
    </div>
</div>
</div>