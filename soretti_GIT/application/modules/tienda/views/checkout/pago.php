<div class="acc_item pagos<?php if($this->session->userdata('checkout_paso') && $this->session->userdata('checkout_paso') == 4): ?> activo <?php endif; ?>">
    <div class="acc_pestana">

        4. Información de pago
    </div>

    <?php if($this->session->userdata('checkout_paso') && $this->session->userdata('checkout_paso') == 4): ?>

    <div class="acc_body col-md-12">

        <form method="post" action="<?php echo base_url('tienda/checkout/mostrar') ?>">
            <?php if($error) {?>
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                     <?php echo $error; ?>
                </div>
            <?php } ?>

            <?php foreach ($metodos_de_pago as $indice=>$metodo_pago){
                   if($indice==3 || $indice==5)  continue;?>
            <div class="form-group">
                <div class="radio">
                    <label>
                        <input type="radio" name="metodo_pago" value="<?php echo $indice ?>" 
                            <?php if($this->input->post("metodo_pago")==$indice ){ echo "checked"; } ?>>  <?php echo $metodo_pago ?>
                        <?php if($indice==1) {?>
                            <div><img src="<?php echo base_url('pub/theme/img/openpay/cards1.png') ?>" alt=""></div>
                            <div><img src="<?php echo base_url('pub/theme/img/openpay/cards2.png') ?>" alt=""></div>
                        <?php } ?>
                        <?php if($indice==2) {?>
                            <div><img src="<?php echo base_url('pub/theme/img/openpay/tiendas.gif') ?>" alt=""></div>
                        <?php } ?>
                    </label>

                </div>
            </div>
            <?php } ?>

            <div style="border-top:1px solid #D9D9D9; margin:30px 0;"></div>

            <div class="row">
                <div class="col-md-6">
                    <a style="text-decoration:underline" href="<?php echo base_url('tienda/checkout/regresar/3') ?>">< Regresar</a>
                </div>
                <div class="col-md-6" style="text-align:right">
                    <input type="submit" class="btn btn-primary" name="guardar_pago" value="Continuar">
                </div>
            </div>
        </form>

    </div>

    <?php endif; ?>

</div>