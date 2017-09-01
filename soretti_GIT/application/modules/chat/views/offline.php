<html>
	<head>
		<title>live trahc offline</title>
		<meta charset="utf-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="<?php echo base_url('pub/libraries/jquery.cookie.js') ?>"></script>
		<!-- Bootstrap -->
		<link href="<?php echo base_url('pub/libraries/bootstrap-3.2.0-dist/css/bootstrap.min.css') ?>" rel="stylesheet">
		<link href="<?php echo base_url('pub/libraries/bootstrap-3.2.0-dist/css/bootstrap-theme.min.css') ?>" rel="stylesheet">
		<script src="<?php echo base_url('pub/libraries/bootstrap-3.2.0-dist/js/bootstrap.min.js') ?>"></script>
		<script>

		jQuery(document).ready(function($) {

		/*Se envia por ajax la navegacion que tiene el usuario*/
			$.ajax({
				url: '<?php echo base_url()?>/chat/navegacion',
				type: 'POST',
				data: {navegacion: "<?php echo strip_tags($this->input->get('title')) ?>"},
				})
				.done(function() {
				console.log("success");
				})
				.fail(function() {
				console.log("error");
				})
				.always(function() {
				console.log("complete");
			});



			$("#enviar").click(function(){
				$.ajax({
					url: '<?php echo base_url()?>/chat/set_mensaje_off_line',
					type: 'POST',
					data: {nombre:$("#nombre").val(),email:$("#email").val(),mensaje:$("#mensaje").val(),'enviar':'enviar+(@)','dominio':'<?php echo $this->input->get("dominio") ?>'},
					dataType:'json'
				})
				.done(function(data) {  
					if(data.error) alert(data.error);
					else{
						$("#nombre").val(''); $("#mensaje").val(''); $("#email").val('');
						alert('Su mensaje se ha enviado, en breve nos pondremos en contacto con usted');
					}
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
			});
 
			
			$("#control").click(function(){
				if(!$.cookie('chat-status') || $.cookie('chat-status')=='open'){ 
					$.cookie('chat-status','close');
					$("#mensajes, #footer-chat").removeClass('hide');
					$("#control span").removeClass('glyphicon-plus');
					$("#control span").addClass('glyphicon-minus');
					window.parent.postMessage('400', '*'); 
				}
				else if($.cookie('chat-status')=='close'){
					$.cookie('chat-status','open')
					$("#mensajes, #footer-chat").addClass('hide');
					$("#control span").removeClass('glyphicon-minus');
					$("#control span").addClass('glyphicon-plus');
					window.parent.postMessage('35', '*');
				}
			});

			if($.cookie('chat-status')=='close'){
				$("#mensajes, #footer-chat").removeClass('hide');
				$("#control span").removeClass('glyphicon-plus');
				$("#control span").addClass('glyphicon-minus');
				window.parent.postMessage('400', '*');
			}	


		});

		</script>
		<style>
		body{
			background: transparent;
			margin: 0;
			padding: 0;
			font-size: 13px;
		}
		.panel{
			margin-bottom: 0;
		}
		.panel-title{
			font-size: 13px;
		}
		.panel-heading{
			padding: 8px 15px;
		}
		.list-group{
			border: 0;
			box-shadow: none;
		}
		.list-group li{
			font-size: 11px;
			line-height: 13px;
			font-family: Arial;
			margin:10px 0;
			padding: 0 15px;
			background: transparent;
			border: 0;
			display: table;
			width: 100%;
		}
		.user_agent,.user_visit{
			display: inline-block;
			clear: both;
			width: 90%;
			padding: 8px 10px;
		}
		.user_visit:after{
		 	 content: "";
		     top: 0;
		     left:-1;
		     position: absolute;
		     border-top: 16px solid #CFD7EC;
		     border-left:   16px solid transparent;
		     /*border-color: #CFD7EC #CFD7EC #e5e5e5 #e5e5e5;*/
		}
		.user_agent:after{
		 	 content: "";
		     top: 0;
		     right:0;
		     position: absolute;
		     border-bottom: 16px solid transparent;
		     border-left:   16px solid #CFECDA;
		}		
		.user_visit{
			background: #CFD7EC;
			float: left;
		}
		.user_agent{
			background: #CFECDA;
			float: right;
		}
		.glyphicon-comment{
			font-size: 18px;
			float: left;
			margin-right: 10px;
		}
		#mensajes{
			background: url('pub/uploads/confectionary.png') repeat;
		}
		.form-group{
			margin-bottom: 5px;
		}
		.form-group label{
			margin-bottom: 2px;
		}
		.form-group .form-control{
			padding: 4px 7px;
			font-size: 13px;
			line-height: 1;
		}
		</style>
	</head>
<body>
	<div class="panel panel-primary chat">
		<div class="panel-heading" totalMensajesInicial="0">
			<h3 class="panel-title"> <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> <strong>Chat Offline </strong><a href="#" id="control"><span class="pull-right glyphicon glyphicon-plus" aria-hidden="true"></span></a></h3>
		</div>
		<div class="hide" style="overflow:auto; width:100%; height:300px" id="mensajes">
			<div class="panel-body">
				<div class="form-group">
					<small> Por el momento no nos encontramos, te invitó  a comprar ingresando el cupón <strong>SUPERFOOD</strong> para obtener un <strong>5% de descuento</strong>. Déjanos tus preguntas y en breve te responderemos. </small>
				</div>
				
				<div class="form-group">
					<label>Nombre:* </label>
					<input type="text" class="form-control" name="nombre" id="nombre">
				</div>
				<div class="form-group">
					<label>E-mail: </label>
					<input type="text" class="form-control" name="email" id="email">
				</div>
				<div class="form-group">
					<label>Mensaje: *</label>
					<textarea  class="form-control" name="mensaje" id="mensaje" cols="30" rows="3"></textarea>
				</div>
			</div>
		</div>
		<div class="hide panel-footer text-right" id="footer-chat">
			<button class="btn btn-primary" type="button" id="enviar"  ><span class="glyphicon glyphicon-send" aria-hidden="true"></span> Enviar</button>
		</div>
	</div>
</body>
</html>