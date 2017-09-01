<?php if($sliders->result_count())  {?>
<div class="relative table">
    <?php  if($this->acceso->valida('pagina','editar')) {?>
    <i class="tip-tools"></i>
    <div id="user-options">
        <a href="<?php echo base_url('modulo/formslider/editar/'.$bloques->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
    </div>
    <div class="editable"><div class="zona-editable"></div></div>
<?php } ?>


<div class="content-slider form-slider-content">
        

        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
          <!-- Indicators -->
          
          <div class="carousel-indicators bloque-textos">

            <?php foreach ($sliders as $i=>$tituloimg){ ?>
              <!-- <div data-target="#carousel-example-generic" class="scuare-txt-slide <?php //if($i==0) echo 'active'; ?>" data-slide-to="<?php //echo $i; ?>">
                <?php //echo $tituloimg->titulo_imagen; ?>
              </div> -->
            <?php } ?>

          </div>


          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">

            <?php foreach ($sliders as $key => $item) { ?>
              <div class="item <?php if($key==0) echo 'active'; ?>">
                  <img src="<?php echo $item->imagen; ?>" class="img-responsive" alt="Image">
                  <div class="carousel-caption">

                    <div class="title-slide">
                      <?php echo $item->titulo ?>
                    </div>
                    <div class="parrafo-slide">
                      <?php echo character_limiter($item->texto, 400); ?>
                    </div>
                  </div>
                </div>
            <?php } ?>
               
           
          </div>


        </div>

        <!-- Controls -->
        <div id="controles_form">
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
          <!-- <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> -->
          <img src="<?php echo base_url('pub/theme/img/left-arrow.png'); ?>" alt="" width="20">
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
          <!-- <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> -->
          <img src="<?php echo base_url('pub/theme/img/right-arrow.png'); ?>" alt="" width="20">
          <span class="sr-only">Next</span>
        </a>
        </div>

</div>
<?php } ?>