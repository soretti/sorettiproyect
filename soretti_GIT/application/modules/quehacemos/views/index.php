
    <?php  if($this->acceso->valida('pagina','editar')) {?>
      <i class="tip-tools"></i>
      <div id="user-options">
          <a href="<?php echo base_url('modulo/quehacemos/editar/'.$bloque->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
      </div>
      <div class="editable"><div class="zona-editable"></div></div>
  <?php } ?>    

  <div id="carousel-id" class="carousel slide" data-ride="carousel">
    
    <ol class="carousel-indicators">
      <?php foreach ($quehacemos as $key=>$item) {?>
      <li  data-toggle="tooltip" data-placement="top" title="<?php echo $item->titulo ?>"  data-target="#carousel-id" data-slide-to="<?php echo $key; ?>" class="<?php if($key==0) echo "active"; ?>"></li>
      <?php } ?>
    </ol>

    <div class="carousel-inner">

    <?php foreach ($quehacemos as $key=>$item) {?>
        <div class="item <?php  if($key==0) echo "active"; ?>">
            <div class="row">
              <div class="col-md-3">
                <div class="image categorias">
                  <img src="<?php echo $item->imagen; ?>" class="img-responsive" alt="<?php echo $item->titulo ?>" title="<?php echo $item->titulo ?>">
                </div>
              </div>
              <div class="col-md-9">
              <div class="title-categorias"><?php echo $item->titulo ?></div>
                  <?php echo $item->texto ?>
              </div>
            </div>
        </div>
    <?php } ?>
    </div>
  </div>