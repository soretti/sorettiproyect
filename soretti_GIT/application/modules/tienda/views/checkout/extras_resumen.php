<div class="item">
    <h2>Forma de entrega</h2>
     <p>
       <?php $metodos_entrega=$this->config->item('metodos_entrega','proyecto'); ?>
        <?php if($this->session->userdata('forma_entrega')==3) {?>
                      <?php if($flete['gratis']): ?>
                              El envio de este pedido es gratutito.
                          <?php else: ?>
                              El precio de envio es de <?php echo  formato_precio($flete['precio']); ?>.
                          <?php endif; ?>
                      </p>

                        <?php if( $flete['precio'] ||($flete['gratis']==1)) {?>
                          <?php echo $this->load->view('carrito/flete',null,TRUE); ?>
                        <?php } ?>
          <?php }else{ 
          echo $metodos_entrega[$this->session->userdata('forma_entrega')];
        } ?>
      </p>    
</div>