<div class="panel panel-default">
	<div class="panel-heading">
		<?php if($visitante->exists()) {
			if($visitante->dominio=='algaespirulina.mx')echo "<img src='".base_url('pub/espirulina.png')."'/>";
			if($visitante->dominio=='espirulina360.com')echo "<img src='".base_url('pub/360.png')."'/>";
			if($visitante->dominio=='paginasweb.mx')echo "<img src='".base_url('pub/paginas.png')."'/>";
			echo " Live chat | Visitante: ".$visitante->id;  echo " | IP: ".$visitante->ip;
		}?>
	</div>
	<div>
		<input type="hidden" name="visitante_id" id="visitante_id" value="<?php echo $visitante->id ?>">
		<?php  if($mensajes->result_count()){?>
		<ul class="list-group lista_mensajes_panel">
			<?php foreach ($mensajes as $mensaje) {?>
			<li class="list-group-item <?php if($mensaje->usuario=='sistema') echo " sistem"; ?>">
				<div class="<?php if(strstr($mensaje->usuario,'visitante')) echo "user_visit"; elseif($mensaje->usuario!='sistema') echo "user_agent"; elseif($mensaje->usuario=='sistema') echo "user_sistem"; ?>">
					<?php if($mensaje->usuario!='sistema') {?>
					<strong class="<?php if($mensaje->usuario=='sistema') echo " text-muted "; if(strstr($mensaje->usuario,'visitante')) echo " text-primary "; elseif($mensaje->usuario!='sistema') echo " text-success "; ?>">
					<?php  echo $mensaje->usuario ?> :
					</strong>
					<small class="text-muted">
					<?php
					list($fecha,$hora)=explode(" ",$mensaje->fecha);
					if($fecha==date('Y-m-d')) echo date('g:i a',strtotime($mensaje->fecha));
					else echo $fecha." ".date('g:i a',strtotime($mensaje->fecha));
					?>
					</small>
					<?php echo strip_tags($mensaje->mensaje) ?>
					<?php } else{?>
					<?php list($usuario,$mensaje_txt)=explode(":",strip_tags($mensaje->mensaje)); ?>
					<?php
					list($fecha,$hora)=explode(" ",$mensaje->fecha);
					if($fecha==date('Y-m-d')) echo date('g:i a',strtotime($mensaje->fecha));
					else echo $fecha." ".date('g:i a',strtotime($mensaje->fecha));
					?>
					<?php echo $mensaje_txt; ?>
					<?php } ?>
					
					
				</div>
			</li>
			<? } ?>
		</ul>
		<? } ?>
	</div>
</div>