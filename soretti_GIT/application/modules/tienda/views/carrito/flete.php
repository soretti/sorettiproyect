<div class="txt-envio">
		<?php if($flete['estado']=='Tamaulipas' && $flete['ciudad']=='Altamira') {?>
		 <div>Envió terrestre Altamira</div>
		 <div class="text-right"><small>de 24 a 48 horas habiles</small></div>
		<?php } elseif($flete['estado']=='Tamaulipas' && $flete['ciudad']=='Tampico') {?>
		 <div>Envió terrestre Tampico</div>
		 <div class="text-right"><small>de 24 a 48 horas habiles</small></div>
		<?php } elseif($flete['estado']=='Tamaulipas' && $flete['ciudad']=='Ciudad Madero') {?>
		 <div>Envió terrestre Madero</div>
		 <div class="text-right"><small>de 24 a 48 horas habiles</small></div>
		<?php } else {
		  if( ($flete['gratis']==1) && ($flete['precio']==0) ){ ?>
		  <div>Envió Foráneo (terrestre) gratis:</div>
		  <div class="text-right"><small>2 a 6 días hábiles</small></div>
		 <?php  }else{ ?>
		       <div>Envió Foráneo (terrestre):</div>
		       <div class="text-right"><small>2 a 6 días hábiles</small></div>
		  <?php } } ?>
</div>