<div class="carrusel marcas relative">
    <div class="box">
        <div class="owl-carousel-marcas">
            <?php foreach ($marcas as $marca) {?>
            <div class="item">
                <div class="imagen">
                    <a href="<?php echo site_url('catalogo/marca/'.$marca->uri); ?>" target="#" title="#">
                        <img src="<?php echo $marca->imagen; ?>" class="img-responsive" alt="">
                    </a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>