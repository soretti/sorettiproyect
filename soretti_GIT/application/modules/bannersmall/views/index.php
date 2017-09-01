<?php  if($this->acceso->valida('pagina','editar')) {?>
    <i class="tip-tools"></i>
    <div id="user-options">
        <a href="<?php echo base_url('modulo/bannersmall/editar/'.$bloque->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
    </div>
    <div class="editable"><div class="zona-editable"></div></div>
<?php } ?>

<?php foreach ($sliders as $i=>$item){ ?>
    <div class="banner banner-small  <?php if($i==0) echo "top"; ?> ">
         <?php if($item->liga){ ?>
            <a href="<?php echo $item->liga ?>" target="<?php echo $item->target ?>">
        <?php } ?>
            <img src="<?php echo $item->imagen ?>" border="0" class="img-responsive" alt="<?php echo $item->titulo_imagen ?>">
        <?php if($item->liga){ ?>
        </a>
        <?php } ?>
    </div>
 <?php } ?>
