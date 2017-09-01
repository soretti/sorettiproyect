<?php if($sliders->result_count())  {?>
<div class="relative table">
    <?php  if($this->acceso->valida('pagina','editar')) {?>
    <i class="tip-tools"></i>
    <div id="user-options">
        <a href="<?php echo base_url('modulo/slider/editar/'.$bloques->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
    </div>
    <div class="editable"><div class="zona-editable"></div></div>
<?php } ?>
<div class="modulo-camera">
  <div class="camera_wrap camera_azure_skin" id="camera_wrap_1">
     <?php foreach ($sliders as $i=>$item){ ?>
    <div data-src="<?php echo $item->imagen ?>">
      <div class="slider-titulos">
        <div class="slider-titulo01 fadeInUp animated"><?php echo $item->titulo ?></div>
        <div class="slider-titulo03 fadeInUp animated"><?php echo $item->texto ?></div>
        <!-- <div class="slider-titulo02 fadeInUp animated"><?php //echo $item->subtitulo ?></div> -->
         
      </div>
    </div>
    <?php } ?>
  </div>

</div>
</div>
<?php } ?>