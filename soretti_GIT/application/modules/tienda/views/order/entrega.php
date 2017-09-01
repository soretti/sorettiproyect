<?php if($envio->estado=='Tamaulipas' && $envio->ciudad=='Altamira') {?>
	Envio terrestre Altamira.<br>
	Tiempo de entrega: de 24 a 48 horas habiles. 
<?php } elseif($envio->estado=='Tamaulipas' && $envio->ciudad=='Tampico') {?>
	 Envio terrestre Tampico.<br>
	Tiempo de entrega: de 24 a 48 horas habiles. 
<?php } elseif($envio->estado=='Tamaulipas' && $envio->ciudad=='Ciudad Madero') {?>
	Envio terrestre Madero.<br>
	Tiempo de entrega: de 24 a 48 horas habiles. 
<?php } else {?>
	Envio Foraneo (terrestre) <?php if($pago->flete_gratis) echo "gratis" ?>. <br>
	Tiempo de entrega: 2 a 6 días habiles. 
<?php } ?>
