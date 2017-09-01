<div class="item">
    <h2>Factura</h2>

	<?php if($factura_requerida): ?>
		<p>
			RFC: <?php echo $direccion->rfc ?><br>
			Razón social: <?php echo $direccion->razon_social ?><br>
	        Estado: <?php echo $direccion->estado->titulo ?><br>
	        Municipio: <?php echo $direccion->municipio->titulo ?><br>
	        Colonia: <?php echo ($direccion->nombreColonia) ? $direccion->nombreColonia : $direccion->colonia->titulo; ?><br>
	        CP: <?php echo $direccion->codigo ?><br>
	        <?php echo $direccion->calle ?> No. <?php echo $direccion->numero_ext ?><br>

    	</p>
	<?php else: ?>

		<p>Factura no requerida</p>

	<?php endif; ?>

</div>