<div class="item">
    <h2>Envio</h2>
    <p>
        Estado: <?php echo $direccion->estado->titulo ?><br>
        Delegación o mpo.: <?php echo $direccion->municipio->titulo ?><br>
        Colonia: <?php echo ($direccion->nombreColonia) ? $direccion->nombreColonia : $direccion->colonia->titulo ?><br>
	    Calle: <?php echo $direccion->calle ?> No. <?php echo $direccion->numero_ext ?><?php if($direccion->numero_int) echo " Int. ".$direccion->numero_int ?><br>
        Código postal: <?php echo $direccion->codigo ?>
    </p>
</div>