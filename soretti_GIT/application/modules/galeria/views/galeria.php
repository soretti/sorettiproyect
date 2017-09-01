<div class="modulo galeria relative">
	<?php if($this->acceso->valida('pagina','editar')) { ?>
				       <i class='tip-tools'></i>
				       <div id='user-options'>
				          <a href='<?php echo base_url('modulo/galeria/listar'); ?>' class='editar'><span class="glyphicon glyphicon-edit"></span></a>
				       </div>
				       <div class='editable'><div class='zona-editable'></div></div>
   				<?php } ?>
	<div id="carga">
		<?php $this->load->controller('galeria/mostrar_galeria',array($item->id)); ?>
	</div>
	 <!-- Carrusel de imagenes -->
	<div id="ultimas_multimedia">
		<div class="lo_ultimo_multimedia" w="<?php echo $item->galeriaimagenes->t_width ?>">
				<?php foreach ($item as $key => $value) { $value->galeriaimagenes->order_by('sort','asc')->get(1); ?>
					<div class='thumb'>
						<a href="<?php echo base_url('ficha/'.$value->internal_title.".html"); ?>" id='<?php echo $value->id; ?>'>
							<img src="<?php echo base_url('pub/uploads/thumbs/'.name_image($value->galeriaimagenes->path,'galeria','path',$value->galeriaimagenes->t_width,$value->galeriaimagenes->t_height) ) ?>" title="<?php echo $value->title; ?>" >
						</a>
					</div>
				<?php }  ?>
		</div>
	</div>

</div>
