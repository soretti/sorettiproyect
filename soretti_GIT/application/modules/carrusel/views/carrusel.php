<div class="carrusel relative">
  <?php  if($this->acceso->valida('pagina','editar')) {?>
  <i class="tip-tools"></i>
  <div id="user-options">
    <a href="<?php echo base_url('modulo/carrusel/editar/'.$bloque->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
  </div>
  <div class="editable"><div class="zona-editable"></div></div>
  <?php } ?>
  <h2 class="text-center"><?php echo $bloque->{'titulo'.IDIOMA} ?></h2>
  <div class="box">
    <div class="owl-carousel">
      <?php foreach ($fotos as $foto) {?>
      <div class="item">
          <?php if($foto->liga) {?>
            <a href="<?php echo $foto->liga ?>" target="<?php echo $foto->target ?>" title="<?php echo $foto->{'titulo'.IDIOMA} ?>">
          <?php } ?>
           <img src="<?php echo $foto->imagen ?>" class="img-responsive" alt="<?php echo $foto->{'titulo'.IDIOMA} ?>">
          <?php if($foto->liga) {?>
            </a>
          <?php } ?>          
        </a>
      </div>
      <?php } ?>
    </div>
  </div>
</div>