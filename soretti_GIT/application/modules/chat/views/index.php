<html>
	<head>
		<title>live trahc</title>
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


			/*Mensaje enter o click enviar*/
			$('#mensaje').keyup(function (event) {
				if (event.keyCode == '13' && $("#mensaje").val()) {
				$.ajax({
				url: '<?php echo base_url()?>/chat/set_mensaje',
				type: 'POST',
				data: {mensaje:$("#mensaje").val()},
				})
				.done(function() {
				console.log("success");
				$("#mensaje").val('');
				})
				.fail(function() {
				console.log("error");
				})
				.always(function() {
				console.log("complete");
				});
				}
			});

			$("#enviar").click(function(){
			if($("#mensaje").val()){
				$.ajax({
				url: '<?php echo base_url()?>/chat/set_mensaje',
				type: 'POST',
				data: {mensaje:$("#mensaje").val()},
				})
				.done(function() {
				console.log("success");
				$("#mensaje").val('');
				})
				.fail(function() {
				console.log("error");
				})
				.always(function() {
				console.log("complete");
				});
				}
			});


			$(".panel-heading").click(function(){
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


			var num_mensajes=$(".panel-heading").attr('totalMensajesInicial');

			window.setInterval(function(){
				$("#mensajes").load('<?php echo base_url("chat/get_mensajes") ?>',null,function(){
					console.log(num_mensajes);
					if(num_mensajes!=$(".list-group li").length){
						$.cookie('chat-status','close');
						$("#mensajes, #footer-chat").removeClass('hide');
						$("#control span").removeClass('glyphicon-plus');
						$("#control span").addClass('glyphicon-minus');
						window.parent.postMessage('400', '*');			
					}
					num_mensajes=$(".list-group li").length;
				});	
			}, 1500);	

		});

		</script>
		<style>
		body{
			background: transparent;
			margin: 0;
			padding: 0;
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
		.panel-heading{
			cursor: pointer;
		}
		</style>
	</head>
	<body>
		<div class="panel panel-primary chat">
			<div class="panel-heading" totalMensajesInicial="<?php echo $total_mensajes; ?>">
				<h3 class="panel-title"> <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> <strong>Atención en línea </strong><a href="#" id="control"><span class="pull-right glyphicon glyphicon-plus" aria-hidden="true"></span></a></h3>
			</div>
			<div class="hide" style="overflow:auto; width:100%; height:300px" id="mensajes">

			</div>
			<div class="hide panel-footer" id="footer-chat">
			<div class="input-group input-group-sm">
				<input type="text" class="form-control" name="mensaje" id="mensaje" placeholder="Escribe tu mensaje...">
				<span class="input-group-btn">
					<button class="btn btn-primary" type="button" id="enviar"  ><span class="glyphicon glyphicon-send" aria-hidden="true"></span></button>
				</span>
			</div>
			</div>
		</div>
	</body>
</html>