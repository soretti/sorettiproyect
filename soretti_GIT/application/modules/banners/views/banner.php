<div class="modulo banner relative">
	<?php if($this->acceso->valida('pagina','editar')) { ?>
	       <i class='tip-tools'></i>
	       <div id='user-options'>
	          <a href='<?php echo base_url('modulo/banners/editar/'.$banner->id.'/'.$columna_id); ?>' class='editar'><span class="glyphicon glyphicon-edit"></span></a>
	       </div>
	       <div class='editable'><div class='zona-editable'></div></div>
	   <?php } ?>
	<div class="contenido">
		 <?php if($banner->liga) {?> <a href="<?php echo $banner->liga ?>" target="<?php echo $banner->target ?>"> <?php } ?>
		 	<img src="<?php echo $banner->imagen ?>" class="img-responsive" alt="<?php echo $banner->titulo_imagen ?>">
		 <?php if($banner->liga) {?> </a> <?php } ?>
	</div>
</div>
