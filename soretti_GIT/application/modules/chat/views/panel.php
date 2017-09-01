<script>
		jQuery(document).ready(function($) {


		/*Mensaje enter o click enviar*/
		$('#mensaje').keyup(function (event) {
            if (event.keyCode == '13' && $("#mensaje").val()) {
						$.ajax({
							url: '<?php echo base_url()?>/chat/set_mensaje_panel',
							type: 'POST',
							data: {mensaje:$("#mensaje").val(),conversacion:$("#visitante_id").val()},
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
			if(!$("#visitante_id").val()){ 
				alert('Selecciona un visitante');
				return false;
				 }  
			if($("#mensaje").val()){
				$.ajax({
					url: '<?php echo base_url()?>/chat/set_mensaje_panel',
					type: 'POST',
					data: {mensaje:$("#mensaje").val(),conversacion:$("#visitante_id").val()},
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

	});




		window.setInterval(function(){
			if($("#visitante_id").val()) $("#mensajes").load('<?php echo site_url("chat/conversacion") ?>?conversacion='+$("#visitante_id").val());
		}, 1000);
	

		var n_visitantes='';
		var n_mensajes='';
		var last='';

		window.setInterval(function(){
			$("#lista_visitantes").load('<?php echo site_url("chat/lista_visitantes") ?>',null,function(){
					//$('.list-group-item-success').prependTo('.visitantes-panel');
					if(n_mensajes!=($("#mensajes_nuevos").val()) && n_mensajes!='' ) { document.getElementById("audio_uno").play(); }
					if(last!=($("#ultimo_visitante").val()) && last!='' ) { document.getElementById("audio_dos").play(); }
					n_visitantes=$("#visitantes_nuevos").val();
					n_mensajes=$("#mensajes_nuevos").val();
					last=$("#ultimo_visitante").val();

			});
		}, 1000);

	</script>

<style>

	ul.list-group li.algaespirulina-mx{
		background: url("../../pub/espirulina.png") no-repeat;
		padding-left: 20px;
	}
	ul.list-group li.espirulina360-com{
		background: url("../../pub/360.png") no-repeat;
		padding-left: 20px;
	}
	ul.list-group li.paginasweb-mx{
		background: url("../../pub/paginas.png") no-repeat;
		padding-left: 20px;
	}
	ul.list-group li.algaespirulina-com{
		background: url("../../pub/ae.png") no-repeat;
		padding-left: 20px;
	}
	ul.list-group li.list-group-item-success{
		background-color:#D8FED9;
	}

	.list-group{
		border: 0;
		box-shadow: none;
		width: 99%;
	}
	.lista_mensajes_panel li{
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

	.visitantes-panel li{
			font-size: 11px;
			line-height: 13px;
			font-family: Arial;
			padding: 8px 15px;
			background: transparent;
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
	     left:0;
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
	#mensajes, #lista_visitantes{
		background: url('../../../pub/uploads/confectionary.png') repeat;
	}
	.list-group-item.sistem{
		color: #9B9191;
		padding: 2px;
		margin:2px;
		font-size: 10px;
	}



</style>

<audio src="<?php echo base_url("pub/uploads/beep_2.mp3") ?>" id="audio_uno" preload="on"   flash_fallback="on"></audio> <!-- nuevo mensaje -->
<audio src="<?php echo base_url("pub/uploads/alert_49.mp3") ?>" id="audio_dos" preload="on"   flash_fallback="on"></audio> <!-- nuevo visitante -->

<div class="row">
	<div class="col-md-8">
		<div class="row">
			<div class="col-md-12" id="mensajes" style="height:450px; overflow: auto;">
				<?php echo modules::run('chat/conversacion',0); ?>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label>Escribe tu mensaje</label>
					<div class="input-group">
						<input type="text" class="html-editable form-control" name="mensaje" id="mensaje">
						<span class="input-group-btn">
							<button class="btn btn-primary" type="button" id="enviar">Enviar!</button>
							<a class="btn btn-default admin-fancybox" href="<?php echo site_url('modulo/chat/respuesta/listar') ?>" ><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				Visitantes
			</div>
			<div style="overflow:auto; height:420px" id="lista_visitantes">
				<?php echo modules::run('chat/lista_visitantes'); ?>
			</div>
		</div>
	</div>
</div>
<script>
	var loading=0;
	$( "#lista_visitantes" ).delegate(".sala_visitante", "click", function(event) {
		event.preventDefault();

		 if(loading==1){
		 	return false;
		 }
	     
	     loading=1;
	     $("#mensajes").addClass("transparent");
	     $("#mensajes").html('');
	     console.log('cargado');
	     $("#mensajes").load($(this).attr('href'),null,function(){
	     	$("#mensajes").removeClass("transparent");
	     	loading=0;
	     });

	});
	
	jQuery(document).ready(function($) {
		   $("#mensajes").html('&nbsp;');		
  
	});

	window.onbeforeunload = function (e) {
	    var e = e || window.event;

        $.ajax({
         	url: '<?php echo site_url("chat/status_moderador")?>',
         	type: 'GET'
         });
	};

if(navigator.userAgent.toLowerCase().indexOf('firefox') > -1)
{
		var myEvent = window.attachEvent || window.addEventListener;
		var chkevent = window.attachEvent ? 'onbeforeunload' : 'beforeunload'; /// make IE7, IE8 compitable

            myEvent(chkevent, function(e) { // For >=IE7, Chrome, Firefox
                var confirmationMessage = 'Estas seguro que deseas abandonas el chat?';  // a space
                (e || window.event).returnValue = confirmationMessage;
                       $.ajax({
				         	url: '<?php echo site_url("chat/status_moderador")?>',
				         	type: 'GET'
				         }); 
            });
}


</script>