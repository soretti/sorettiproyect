<div class="acc_item resumen<?php if($this->session->userdata('checkout_paso') && $this->session->userdata('checkout_paso') == 5): ?> activo <?php endif; ?>">
    <div class="acc_pestana">
        5. Resumen del pedido
    </div>
    <?php if($this->session->userdata('checkout_paso') && $this->session->userdata('checkout_paso') == 5): ?>
    <?php if($this->session->flashdata('declined')) {?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo "Lo sentimos, tu tarjeta ha sido declinada por el banco, te recomendamos intentarlo nuevamente, probar con otra tarjeta o bien llamar a los teléfonos mencionados en este sitio."; ?>
    </div>
    <?php } ?>
    <div class="acc_body col-md-12">
        <div class="table-responsive">
            <table class="carrito" id="tbl_carrito">
                <tr>
                    <th>Sku</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>
                <?php foreach ($this->cart->contents() as $items): ?>
                <tr>
                    <td class="sku"><?php echo $items['sku']; ?></td>
                    <td class="producto">
                        <?php if($items['imagen']) {?>
                        <img src="<?php echo base_url('pub/uploads/thumbs/'.name_image($items['imagen'],'catalogo','cat_imagen',100,100)); ?>" alt="" class="thumb pull-left">
                        <?php } ?>
                        <?php echo $items['name']; ?>
                        <?php if($items['options']!=''): ?>
                        <div>
                            <?php foreach ($items['options'] as $key => $value): ?>
                            <p><small><?php echo $key.':'.$value ?></small></p>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </td>
                    <td class="cantidad">
                        <?php echo $items['qty']; ?>
                    </td>
                    <td class="precio"><?php echo formato_precio($items['price']); ?></td>
                    <td class="subtotal"><?php echo formato_precio($items['price']*$items['qty']); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="row fila-top">
            <div class="col-lg-4">
                &nbsp;
            </div>
            <div class="col-lg-8">
                <div class="cuadro wrapper">
                    <table class="pull-right total-compra">
                        <tr>
                            <td class="text-left">Subtotal</td>
                            <td class="text-right importe"><?php echo formato_precio( $this->cart->total() ); ?></td>
                        </tr>
                        <?php if($datos['cantidadcupon']){ ?>
                        <tr>
                                <td>Descuento cupón: </td>
                                <td class="text-right importe" id="subtotal"><?php  echo '-'.formato_precio($datos['cantidadcupon']);  ?></td>
                        </tr>
                        <?php } ?>

                      <?php if(is_array($promocion)){ ?>
                      <tr>
                        <td class="text-left">Descuento <?php if($promocion['porcentaje']==6) echo "Medio Mayoreo"; if($promocion['porcentaje']==12) echo "Mayoreo" ?></td>
                        <td class="text-right importe" ><?php  echo '-'.formato_precio( $promocion['importe_descuento'] );  ?></td>
                      </tr>
                      <?php } ?>

                        <tr>
                            <td class="text-left">
                                <?php
                                if($flete['forma_entrega']==3){
                                echo $this->load->view('carrito/flete',null,true);
                                }else{
                                echo $metodos_entrega[$flete['forma_entrega']];
                                }
                                
                                ?>
                            </td>
                            <td class="text-right importe">
                                <?php echo formato_precio($flete['precio']); ?>
                            </td>
                        </tr>


                        <tr>
                            <td class="text-left total">TOTAL  </td>
                            <td class="text-right "><span class="importe total"><?php echo formato_precio($total); ?></span> <div class="small"> iva incluido</div></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <?php if($this->session->userdata('checkout_pago')==1) {?>
        <form action="<?php echo site_url('tienda/checkout/procesar_compra') ?>" method="POST" id="payment-form">
            <input type="hidden" name="token_id" id="token_id">
            <div class="row" id="openpay">
                <div class="col-md-12">
                    <div class="barra-azul text-left"> <strong>Tarjeta de crédito o débito</strong></div>
                </div>
                <div class="col-md-4">
                    <div class="tarjetas">
                        <strong>Tarjetas de débito</strong>
                        <img src="<?php echo base_url('pub/theme/img/openpay/cards1.png');?>" class="img-responsive" alt="">
                    </div>
                </div>
                <?php if($this->session->flashdata('error')) {?>
                <div class="col-md-12">
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                         <?php echo $this->session->flashdata('error'); ?>
                    </div>
                </div>
                <?php } ?>
                <div class="col-md-8">
                    <div class="tarjetas">
                        <strong>Tarjetas de crédito</strong>
                        <img src="<?php echo base_url('pub/theme/img/openpay/cards2.png');?>" class="img-responsive" alt="">
                    </div>
                </div>


                <div class="col-md-5">
                    <div class="form-group">
                        <label>Nombre del titular</label>
                        <input type="text" class="form-control" name="holder" placeholder="Como aparece en la tarjeta" autocomplete="off" data-openpay-card="holder_name">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-group">
                        <label>Número de tarjeta</label>
                        <input type="text" class="form-control" name="card" autocomplete="off" data-openpay-card="card_number">
                    </div>
                </div>
                <div class="col-md-5">
                    <label>Fecha de expiración</label>
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" name="month" placeholder="MM" data-openpay-card="expiration_month" class="form-control">
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" name="year" placeholder="AA" data-openpay-card="expiration_year" class="form-control">
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <label>Código de seguridad</label>
                    <div class="row">
                        <div class="col-xs-6">
                            <input type="text" name="cvv" placeholder="3 dígitos" autocomplete="off" data-openpay-card="cvv2" class="form-control">
                        </div>
                        <div class="col-xs-6">
                            <img src="<?php echo base_url('pub/theme/img/openpay/cvv.png')?>" alt="" class="img-responsive">
                        </div>
                    </div>
                </div>
                <div class="col-md-8 text-right">
                    Transacciones realizadas vía:<br>
                    <img src="<?php echo base_url("pub/theme/img/openpay/openpay.png")?>" class="img-responsive" alt="" align="right">
                </div>
                <div class="col-md-4 ">
                     <img src="<?php echo base_url("pub/theme/img/openpay/security.png")?>" class="img-responsive" alt="" align="left">
                    Tus pagos se realizan de forma segura con encriptación de 256 bits
                </div>
                <div class="col-md-6">
                    <a style="text-decoration:underline" href="<?php echo base_url('tienda/checkout/regresar/4') ?>">< Regresar</a>
                </div>
                <div class="col-md-6" style="text-align:right">
                    <a href="#" class="btn btn-primary" id="pay-button">Aceptar Compra</a>
                </div>
            </div>
        </form>

<script type="text/javascript">
        $(document).ready(function() {

            OpenPay.setId('<?php echo $openpay["openpay_id"] ?>');
            OpenPay.setApiKey('<?php echo $openpay["openpay_llave_publica"] ?>');
            OpenPay.setSandboxMode(false);
            //Se genera el id de dispositivo
            var deviceSessionId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");
            
            $('#pay-button').on('click', function(event) {
                event.preventDefault();
                $("#pay-button").prop( "disabled", true);
                OpenPay.token.extractFormAndCreate('payment-form', sucess_callbak, error_callbak);                
            });

            var sucess_callbak = function(response) {
              var token_id = response.data.id;
              $('#token_id').val(token_id);
              $('#payment-form').submit();
            };

            var error_callbak = function(response) {
                var desc = response.data.description != undefined ? response.data.description : response.message;
                alert("ERROR [" + response.status + "] " + desc);
                $("#pay-button").prop("disabled", false);
            };

        });
</script>


        <?php } else{ ?>
        <div class="row">
            <div class="col-md-6">
                <a style="text-decoration:underline" href="<?php echo base_url('tienda/checkout/regresar/4') ?>">< Regresar</a>
            </div>
            <div class="col-md-6" style="text-align:right">
                <a href="<?php echo site_url('tienda/checkout/procesar_compra') ?>" class="btn btn-primary ">Aceptar Compra</a>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php endif; ?>
</div>
