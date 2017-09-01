<div class="acc_item<?php if($this->session->userdata('checkout_paso') && $this->session->userdata('checkout_paso') == 2): ?> activo <?php endif; ?>">
  <div class="acc_pestana">
    2.Forma de entrega
  </div>
  <?php if($this->session->userdata('checkout_paso') && $this->session->userdata('checkout_paso') == 2): ?>
  <div class="acc_body col-md-12">
    <form action="<?php echo base_url('tienda/checkout/mostrar') ?>" method="post" >
      <div class="form-group">
        <label>Costo de envío</label>
      </div>
    <?php if($flete['error'] && $this->input->post('aceptar_envio')) {?>
    <div class="alert alert-danger">
      <?php echo $flete['error']; ?>
    </div>
    <?php } ?>
    <div class="row">
      <div class="col-md-6">
      <ul class="metodos_entrega">
        <li>
          <input type="radio" name="forma_entrega" id="" value="3" <?php if($this->input->post('forma_entrega')=='3' || !$this->input->post('forma_entrega')) echo "checked"; ?>> Paqueteria
            <div style="padding-left:15px;">
                  <p>
                  <?php if($flete['gratis']): ?>
                    El envio de este pedido es gratutito.
                    <?php else: ?>
                    El precio de envio es de <strong><?php echo  formato_precio($flete['precio']) ?></strong>
                    <?php endif; ?>
                  </p>
                  <?php if( $flete['precio'] || ($flete['gratis']==1)) {?>
                  <?php echo $this->load->view('carrito/flete', null,true); ?>
                  <?php } ?>
            </div>
        </li>
      </ul>        
      </div>
      <div class="col-md-6">
        <img src="<?php echo base_url('pub/uploads/paqueteria2r.png') ?>" alt="" class="img-responsive">
      </div>
    </div>
      <div style="border-top:1px solid #D9D9D9; margin:30px 0;"></div>
      <div class="row">
        <div class="col-md-6">
          <a style="text-decoration:underline" href="<?php echo base_url('tienda/checkout/regresar/1') ?>">< Regresar</a>
        </div>
        <div class="col-md-6" style="text-align:right">
          <input type="submit" name="aceptar_envio" class="btn btn-primary" value="Continuar">
        </div>
      </div>
    </form>
  </div>
  <?php endif; ?>
</div>