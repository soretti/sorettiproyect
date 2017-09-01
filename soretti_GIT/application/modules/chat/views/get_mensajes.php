<?php  if($mensajes->result_count()){?>
<ul class="list-group" totalMensajes="<?php echo $mensajes->result_count(); ?>">
	<?php foreach ($mensajes as $mensaje) {?>
		<li class="list-group-item ">
			<div class="<?php if(strstr($mensaje->usuario,'visitante')) echo "user_visit"; elseif($mensaje->usuario!='sistema') echo "user_agent"; ?>">
				<strong class="<?php if(strstr($mensaje->usuario,'visitante')) {$mensaje->usuario='visitante'; echo " text-primary ";} elseif($mensaje->usuario!='sistema') echo " text-success "; ?>">
					<?php  echo $mensaje->usuario ?> : 
				</strong>
				<small class="text-muted">
					<?php
					list($fecha,$hora)=explode(" ",$mensaje->fecha);
					if($fecha==date('Y-m-d')) echo date('g:i a',strtotime($mensaje->fecha));
					else echo $fecha." ".date('g:i a',strtotime($mensaje->fecha));
					?>
				</small>

				<?php echo strip_tags($mensaje->mensaje,'<span><p><a>'); ?>
				
			</div>
			
		</li>
	<? } ?>
</ul>
<? } else{ ?>
<div class="text-center">
	<img src="<?php echo base_url('pub/uploads/speech116.png')?>" alt="">
	<h3 class="text-primary">Chat en vivo</h3>
	<div class="text-primary">Estamos siempre  dispuestos a ayudarlo</div>
</div>
<?php } ?>
