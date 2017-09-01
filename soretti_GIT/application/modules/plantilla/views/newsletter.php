<!DOCTYPE html>
<html lang="es-mx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?php echo base_url('pub/theme/img/favicon.ico') ?>" type="image/x-icon" />
        <title><?php echo $meta['titulo'] ?></title>
        <meta name="description" content="<?php echo $meta['descripcion']; ?>" />
        <meta name="keywords" content="<?php echo $meta['palabras_clave']; ?>" />
        <?php $this->load->view('plantilla/partial/scripts'); ?>
        <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-63795837-2', 'auto');
        ga('send', 'pageview');
        </script>
    </head>
    <body>
        <?php echo modules::run('admin/menu'); ?>
        <div class="container section">
            <?php $this->load->view('plantilla/columna-superior'); ?>
            <?php $this->load->view('plantilla/partial/header'); ?>
            <div class="row">
                <div class="col-md-3">
                    <?php $this->load->view('plantilla/lateral-derecho-portada'); ?>
                </div>
                <div class="col-md-9">
                    <?php $this->load->view("plantilla/partial/slogan-buscador"); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h1 align="center">¡Hasta Luego!</h1>
                            <p align="center" style="padding-bottom:60px">La cuenta de email <i><?php echo $email ?></i> ha sido dada de baja del newsletter como se solicitó.</p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="container footer">
            <?php $this->load->view('plantilla/partial/footer'); ?>
        </div>
    </body>
</html>