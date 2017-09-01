
<div class="row">
    <div class="col-md-3">

        <?php echo modules::run('contacto/solicitud_servicios'); ?>

    </div>


    <div class="col-md-6">
        
        <div class="relative">
            <?php  if($this->acceso->valida('pagina','editar')) {?>
            <i class="tip-tools"></i>
            <div id="user-options">
                <a href="<?php echo base_url('modulo/pagina/editar/'.$pagina->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
            </div>
            <div class="editable"><div class="zona-editable"></div></div>
            <?php } ?>
            <div class="contenido-default">
                <?php echo $pagina->{'contenido'.IDIOMA} ?>
            </div>
        </div>

        <?php echo modules::run('formsliderorg/index'); ?>
    
    </div>

    
    
</div>
<div class="col-md-3">

    <div class="content-redes">

        <div class="content-redes-txt">Siganos en</div>
        <div class="content-redes-ico">
            <a href="#">
                <img src="<?php echo base_url('pub/theme/img/facebook.png') ?>" alt="" border="0">
            </a>
        </div>
        <div class="content-redes-ico">
            <a href="#">
                <img src="<?php echo base_url('pub/theme/img/twitter.png') ?>" alt="" border="0">
            </a>
        </div>
        <div class="content-redes-ico">
            <a href="#">
                <img src="<?php echo base_url('pub/theme/img/linkedin.png') ?>" alt="" border="0">
            </a>
        </div>
    </div>
    <?php echo modules::run('menu/lista', 9); ?>
</div>
<div class="col-md-12">
     <div class="modulo banner relative">
        <div class="contenido">
            <?php echo modules::run('banners/mostrar',"15","8"); ?>
        </div>
     </div>
</div>