<!DOCTYPE html>
<html lang="es-mx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $meta['titulo'] ?></title>
        <meta name="description" content="<?php echo $meta['descripcion']; ?>" />
        <meta name="keywords" content="<?php echo $meta['palabras_clave']; ?>" />
        <?php $this->load->view('plantilla/partial/scripts'); ?>     
    </head>
    <body>
        <?php echo modules::run('admin/menu'); ?>
        <div class="container section">
            <?php $this->load->view('plantilla/partial/header'); ?>
            <?php $this->load->view("plantilla/partial/slogan-buscador"); ?>
            <?php echo $this->layout_content ?>
        </div>
        <div class="container section">
            <div class="row">
                <div class="col-md-12">
                    <?php  echo modules::run('catalogo/catalogomarca/index'); ?>
                </div>
            </div>
        </div>
        <div class="container footer">
            <?php $this->load->view('plantilla/partial/footer'); ?>
        </div>
    </body>
</html>