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
    <body id="defalut" class="internal">
        <?php echo modules::run('admin/menu'); ?>
        <div class="container main">
            <div class="row">
                <div class="col-md-12 catalogo relative">
                    <?php  if($this->acceso->valida('pagina','editar')) {?>
                    <i class="tip-tools"></i>
                    <div id="user-options">
                        <a href="<?php echo base_url('modulo/pagina/editar/'.$pagina->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
                    </div>
                    <div class="editable"><div class="zona-editable"></div></div>
                    <?php } ?>
                    <?php echo $this->layout_content; ?>
                </div>
            </div>
        </div>
    </body>
</html>
