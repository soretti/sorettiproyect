<?php  if($visitantes->result_count()){?>
<ul class="list-group visitantes-panel">
	<?php foreach ($visitantes as $visitante) {?>
	<li class="<?php if($visitante->navegando || $visitante->mensajes) echo "list-group-item-success" ?>  list-group-item  <?php echo  str_replace(".", "-",$visitante->dominio) ?>">
		<strong>
			<a href="<?php echo site_url('chat/conversacion') ?>/?conversacion=<?php echo $visitante->id ?>" class="sala_visitante"><?php  echo $visitante->nombre ?></a>
		</strong>
		<?php if($visitante->ultimo_movimiento) {?>
		<small class="text-muted">
					<?php
					list($fecha,$hora)=explode(" ",$visitante->ultimo_movimiento);
					if($fecha==date('Y-m-d')) echo date('g:i a',strtotime($visitante->ultimo_movimiento));    
					else echo $fecha." ".date('g:i a',strtotime($visitante->ultimo_movimiento));
					?>
		</small>
		<?php } ?>
		<?php if($visitante->location) {
			$location=json_decode($visitante->location);
			if(isset($location->city)){ ?>
		<small class="text-muted"><?php echo $location->city." "; echo (isset($location->regionName)) ? $location->regionName : ''; ?></small>
		<?php }} ?>
		<?php if($visitante->mensajes) {?>
		<span class="badge"><?php echo $visitante->mensajes ?></span>
		<?php } ?>
	</li>
	<? } ?>
</ul>
	<input type="hidden" id="visitantes_nuevos" value="<?php echo ($visitantes_nuevos) ? $visitantes_nuevos : '0'; ?>">
	<input type="hidden" id="mensajes_nuevos" value="<?php echo( $mensajes_nuevos) ?  $mensajes_nuevos : '0'; ?>">
	<input type="hidden" id="ultimo_visitante" value="<?php echo ($ultimo_visitante) ? $ultimo_visitante : '0'; ?>">
<? } ?>