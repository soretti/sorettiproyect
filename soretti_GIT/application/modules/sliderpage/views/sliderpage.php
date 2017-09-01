 <?php $urlstring=(uri_string()) ? uri_string() : 'paginas/index';
               $urlpage=explode('/', $urlstring); ?>
<?php if($sliders->result_count())  {?>
<div class="relative table">
    <?php  if($this->acceso->valida('pagina','editar')) {?>
    <i class="tip-tools"></i>
    <div id="user-options">
        <a href="<?php echo base_url('modulo/sliderpage/editar/'.$bloques->id.'/'. $urlpage[1]); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
    </div>
    <div class="editable"><div class="zona-editable"></div></div>
<?php } ?>


<div id="carousel-slider-content" class="carousel slide slider-content" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators pages-indicators">

   <?php foreach ($sliders as $i=>$item){ ?>
    <li data-target="#carousel-slider-content" data-slide-to="<?php echo $i; ?>" class="<?php if($i==0) echo 'active' ?>"></li>
   <?php } ?>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">

    <?php foreach ($sliders as $j=>$item){ ?>
      <div class="item <?php if($j==0) echo 'active' ?>">
        <img src="<?php echo $item->imagen ?>" >
        <?php if($item->visible_titulo==1){ ?>
        <div class="carousel-caption">
          <?php echo $item->texto; ?>
        </div>
        <?php } ?>
      </div>
    <?php $i++; } ?>
   
  </div>

  <!-- Controls -->
  <?php if($i>1){ ?>
    <a class="left carousel-control" href="#carousel-slider-content" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carousel-slider-content" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  <?php } ?>

</div>


</div>
<?php } ?>