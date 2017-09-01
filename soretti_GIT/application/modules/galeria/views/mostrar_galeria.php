<div id="titulo_galeria" style="text-transform:uppercase;"><h2><?php echo $item->title; ?></h2> </div>
<!-- Slider de la galeria -->
<div class="box multimedia_cont">
		<div class="multimedia">
			<div class="lo_ultimo_fotog" w="<?php echo $item->galeriaimagenes->t_w; ?>">
				<?php foreach ($item->galeriaimagenes->order_by('sort','asc')->where('is_enable',1)->order_by('sort','asc')->get() as $value) {?>
				<div class="slide">
					<a href="<?php echo $value->path; ?>" class='fancygaleria' rel="g1">
						<img src="<?php echo base_url('pub/uploads/thumbs/'.name_image($value->path,'galeria','path',$value->width,$value->height) ) ?>" class="img-responsive" >
					</a>
					<div class="caption">
							<p><?php echo $value->title; ?></p>
							<div class="texto"><?php echo 	$value->description; ?></div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
</div>