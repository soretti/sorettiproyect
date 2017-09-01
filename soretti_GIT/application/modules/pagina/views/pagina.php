<div class="row relative">

	<?php  if($this->acceso->valida('pagina','editar')) {?>
		<i class="tip-tools"></i>
		<div id="user-options">
			<a href="<?php echo base_url('modulo/pagina/editar/'.$pagina->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
		</div>
		<div class="editable"><div class="zona-editable"></div></div>
	<?php } ?>

	<div class="col-md-12">
		<?php if($pagina->c_fecha) {?>
			<div class="text-right"> Fecha: <?php echo $this->dateutils->datees(strtotime($pagina->fecha_creacion),'C','L','n'); ?> </div>
		<?php } ?>
		<?php if($pagina->c_usuario) {?>
			<div class="text-right"> Autor: <?php echo $pagina->usuario_nombre; ?> </div>
		<?php } ?>
		<?php if($pagina->c_compartir) {?>
			<div class="text-right clearfix"> <div class="addthis_native_toolbox pull-right"></div> </div>
		<?php } ?>

	</div>


	<div class="col-md-12">
		
		<div class="row">
			<div class="col-md-9">
				
				<h1><?php echo $pagina->titulo ?></h1>
				<div class="contenido-html">
					<?php echo modules::run('sliderpage'); ?>
			    	<?php echo $pagina->{'contenido'.IDIOMA} ?>
			    </div>
			</div>
			<div class="col-md-3">
				
				<div class="content-redes">

					<div class="content-redes-txt">Siganos en</div>
					<div class="content-redes-ico">
						<a href="#">
							<img src="<?php echo base_url('pub/theme/img/facebook.png') ?>" alt="" border="0">
						</a>
					</div>
					<div class="content-redes-ico">
						<a href="#">
							<img src="<?php echo base_url('pub/theme/img/twitter.png') ?>" alt="" border="0">
						</a>
					</div>
					<div class="content-redes-ico">
						<a href="#">
							<img src="<?php echo base_url('pub/theme/img/linkedin.png') ?>" alt="" border="0">
						</a>
					</div>
				</div>

				<?php 
 
					$query = $this->db->query("SELECT bloquecontenido_id, menu_id FROM paginas WHERE uri='".$this->uri->segment(2)."'");
					$row = $query->row();

					if($row->bloquecontenido_id!=0){ ?>


						<div id="nav-soretti">
					
								<div class="titulo-categorias">PERFILES IT</div>
								<div class="titulo-especialista">
								<ul>
							
								<?php $especialidades = $this->db->query("SELECT metatitulo, uri FROM paginas WHERE bloquecontenido_id='".$row->bloquecontenido_id."' ORDER BY metatitulo ASC");

								foreach ($especialidades->result_array() as $especialidad){ 
										$estilo = ($this->uri->segment(2)==$especialidad['uri']) ? "style='color:#7BAF1D; font-weight:500'" : "";
									?>

								<li>
								
									<a title="<?php echo $especialidad['metatitulo'] ?>" href="<?php echo 'http://www.soretti.com.mx/web/'.$especialidad['uri'].'.html'; ?>" <?php echo $estilo; ?>>
										<?php echo $especialidad['metatitulo']; ?>
									</a>
								</li>

								<?php } ?>
							</ul>
							</div>
					
						</div>

						<div class="content-profesionales">
							<div class="title-profesionales">
								Profesionales Especializados Disponibles
							</div>
							<div class="text-profesionales">
								<ul>
									<li>
										<div class="nom-profesionales"><a href="#">Alfred Benitez Llanes</a></div>
										<div class="esp-profesionales">Programador ABAP 10 años de esperiencia</div> 
									</li>
									<li>
										<div class="nom-profesionales"><a href="#">Alfred Benitez Llanes</a></div>
										<div class="esp-profesionales">Programador ABAP 10 años de esperiencia</div> 
									</li>
									<li>
										<div class="nom-profesionales"><a href="#">Alfred Benitez Llanes</a></div>
										<div class="esp-profesionales">Programador ABAP 10 años de esperiencia</div> 
									</li>
									<li>
										<div class="nom-profesionales"><a href="#">Alfred Benitez Llanes</a></div>
										<div class="esp-profesionales">Programador ABAP 10 años de esperiencia</div> 
									</li>
									<li>
										<div class="nom-profesionales"><a href="#">Alfred Benitez Llanes</a></div>
										<div class="esp-profesionales">Programador ABAP 10 años de esperiencia</div> 
									</li>
									<li>
										<div class="nom-profesionales"><a href="#">Alfred Benitez Llanes</a></div>
										<div class="esp-profesionales">Programador ABAP 10 años de esperiencia</div> 
									</li>
									<li>
										<div class="nom-profesionales"><a href="#">Alfred Benitez Llanes</a></div>
										<div class="esp-profesionales">Programador ABAP 10 años de esperiencia</div> 
									</li>
									<li>
										<div class="nom-profesionales"><a href="#">Alfred Benitez Llanes</a></div>
										<div class="esp-profesionales">Programador ABAP 10 años de esperiencia</div> 
									</li>
									<li>
										<div class="nom-profesionales"><a href="#">Alfred Benitez Llanes</a></div>
										<div class="esp-profesionales">Programador ABAP 10 años de esperiencia</div> 
									</li>
									<li>
										<div class="nom-profesionales"><a href="#">Alfred Benitez Llanes</a></div>
										<div class="esp-profesionales">Programador ABAP 10 años de esperiencia</div> 
									</li>
								</ul>
							</div>
							
						</div>

				<?php }	else{
					  if($row->menu_id!=""){
					  	echo modules::run('menu/lista', $row->menu_id);
					  }

					  if($row->menu_id==4){
					  	echo modules::run('contacto/solicitud_servicios');
					  }

					} 
					?>
					
		    </div>
		</div>
				
	</div>

	<div class="col-md-12">
		<div class="publicidad-content">
			<img src="<?php echo base_url('pub/theme/img/publicidad.png') ?>" class="img-responsive" alt="Image">
		</div>
	</div>

	<?php if($pagina->c_comentarios) {?>
		<div class="col-md-12">
			<h3 class="page-header">Comentarios:</h3>
			<div class="fb-comments" data-href="<?php echo current_url(); ?>" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
		</div>
	<?php } ?>
</div>
