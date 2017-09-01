<!DOCTYPE html>
<html>
<head>
    <title>LOGIN TRAHC TOOLS</title>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <!-- jQuery -->
    <script src="<?php echo base_url('pub/libraries/jquery/jquery-1.10.1.min.js') ?>"></script>
    <script src="<?php echo base_url('pub/libraries/jquery/jquery.popupWindow.js') ?>"></script>

    <!-- Bootstrap -->
    <link href="<?php echo base_url('pub/libraries/bootstrap-3.2.0-dist/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('pub/libraries/bootstrap-3.2.0-dist/css/bootstrap-theme.min.css') ?>" rel="stylesheet">
    <script src="<?php echo base_url('pub/libraries/bootstrap-3.2.0-dist/js/bootstrap.min.js') ?>"></script>

    <!-- TRAHC TOOLS -->
    <script src="<?php echo base_url("pub/libraries/trahctools/js/trahctools.js") ?>"></script>
    <link href="<?php echo base_url('pub/libraries/trahctools/css/backend.css') ?>" rel="stylesheet" media="screen">

</head>
    <body class="login">
    	<div class="container">

    		 <form action="" method="POST" class="form-signin" id="myform">


                
                <div class="logo"> <img src="<?php  echo base_url('pub/libraries/trahctools/img/logoch.png') ?>" alt=""></div>
                <?php if(isset($error['login'])) {?>
                    <div class="error"> <?php echo $error['login']; ?> </div>
                <?php } ?>

	    		<div>
                    <input class="form-control" name="email" type="text" placeholder="Email">
                    <?php if(isset($error['email'])) {?>
                        <div class="error"> <?php echo $error['email']; ?> </div>
                    <?php } ?>
                </div>
	    		
                <div>
                    <input class="form-control" type="password" name="password" placeholder="Contraseña"> 
                    <?php if(isset($error['password'])) {?>
                        <div class="error"> <?php echo $error['password']; ?> </div>
                    <?php } ?>        
                </div>
                <div class="captcha">
                    <?php echo $caption['image']; ?>
                </div>
                <div>
                    <input class="form-control" name="captcha" type="text" placeholder="Capture el código de seguridad">
                    <?php if(isset($error['captcha'])) {?>
                        <div class="error"> <?php echo $error['captcha']; ?> </div>
                    <?php } ?>
                </div>                
				<button class="btn btn-large btn-block btn-success" onclick="goto('<?php echo base_url('modulo/admin/accesar') ?>')">Accesar</button>
                 <input type="hidden" name="tools_token" value="<?php echo $this->acceso->set_token('acceso'); ?>">
    		</form>
        </div>
    </body>
</html>