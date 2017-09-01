<html>
	<head>
		<meta charset="utf-8">
		<meta content="width=device-width; height=device-height;" name="viewport">
		<title>:: <?php echo $proyecto['titulo']; ?> ::</title>
		<link href="<?php echo base_url('pub/libraries/bootstrap-3.2.0-dist/css/bootstrap.min.css') ?>" rel="stylesheet">
		<link href="<?php echo base_url('pub/libraries/bootstrap-3.2.0-dist/css/bootstrap-theme.min.css') ?>" rel="stylesheet">
		<style>
		.acceso{
		color: #FFFFFF;
		margin-top: 30px;
		}
		.entrar{
			padding-top: 25px;
		}
		body{
			background:url('http://pals.mx/pub/theme/img/website-coming-soon.jpg');
		}
		</style>
	</head>
	<body>
		<form method="post">
			<div class="container">
				<div class="row acceso">
					<div class="col-md-12">
						<?php if($error) {?>
						<div class="alert alert-danger">
							<?php echo $error; ?>
						</div>
						<?php } ?>
					</div>
					<div class="col-md-offset-1 col-md-4">
						<div class="form-group">
							<label for="exampleInputEmail1">Usuario</label>
							<input type="text" class="form-control" id="exampleInputEmail1" placeholder="Usuario" name="usuario" value="<?php echo $this->input->post('usuario') ?>">
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label for="exampleInputPassword1">Contraseña</label>
							<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Contraseña" name="contrasenna">
						</div>
					</div>
					<div class="ol-md-offset-1 col-md-2">
						<div class="form-group entrar">
							<input type="submit" class="btn btn-success" name="entrar" value="Entrar">
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</body>
</html>