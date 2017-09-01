<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
	<title>:: <?php echo $proyecto['titulo']; ?> ::</title>
    <!-- Bootstrap -->
    <link href="<?php echo base_url('pub/libraries/bootstrap-3.2.0-dist/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('pub/libraries/bootstrap-3.2.0-dist/css/bootstrap-theme.min.css') ?>" rel="stylesheet">
    <style>
        .header{
            background: url('pub/theme/img/enconstruccion/logo.jpg') no-repeat right;
            height: 60px;
            padding-top: 20px;
        }
        .row.footer{
            padding-top:50px;
        }
        .mundo{
            padding-top: 20px;
        }
        .acceso{
            margin-top: 40px;
        }
    </style>
</head>
<body>
        <div class="container">
            <div class="row">
                <div class="col-md-offset-6 col-md-6">
                    <div class="header text-right" style="color:#ffffff;">
                        Dias para lanzamiento: <?php echo dias_transcurridos( $proyecto['fecha_liberacion'], date('Y-m-d')) ?>
                    </div>
                </div>
            </div>
            <div class="row acceso">
                <div class="col-md-4">
                    <h3>Desarrollando</h3>
                    <h1><?php echo $proyecto['titulo']; ?></h1>
                    <?php if($error) {?>
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php } ?>
                    <p class="text-muted">
                        <small>
                            Gracias por confiar en TRAHC STUDIO Total Web.
                            Para ver los avances de su desarrollo por favor
                            digite las claves electrónicas que le fueron
                            asignadas.
                        </small>
                   </p>

                    <form method="post">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Usuario</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Usuario" name="usuario" value="<?php echo $this->input->post('usuario') ?>">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Contraseña</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Contraseña" name="contrasenna">
                      </div>
                      <input type="submit" class="btn btn-success" name="entrar" value="Entrar">
                    </form>

                </div>
                <div class="col-md-offset-2 col-md-6 text-center mundo">
                    <img src="<?php echo base_url('pub/theme/img/enconstruccion/mundo.jpg')?>" alt="">
                </div>
            </div>
            <div class="row footer">
                <div class="col-md-12 text-center">
                    <small class="text-muted"><a href="http://www.paginasweb.mx" style="color:#777777; text-decoration:none;" target="_blank">www.paginasweb.mx</a> | TRAHC STUDIO</small>
                </div>
            </div>
       </div>
</body>
</html>
