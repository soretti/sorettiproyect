<div class="row">
	<div class="col-md-12">
		<?php if($this->session->flashdata('mensaje')) {?>
			    <div class="alert alert-success">
			        <?php echo $this->session->flashdata('mensaje'); ?>
			    </div>
		<?php } ?>
		<div>
			<h1><?php echo $titulo; ?></h1>

			<div class="text-small form-group">Desde aquí puedes ver tus actividades recientes y actualizar la información de tu cuenta.</div>
			<div class="row">
				<div class="col-md-3">

					<?php $this->load->view("tienda/cuenta/menu"); ?>
				</div>


				<div class="col-md-9">
					<div class="encabezado encabezadobigger">¡Hola <?php echo $this->session->userdata('nombre'); ?>!</div>
					<?php if($usuario->descuento_id) {?>
					<div class="alert alert-info">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<strong>Envio gratis</strong> en todas tus compras mayores a $ 3,000 MXN
					</div>
					<?php } ?>

					<div class="text-right" style="margin-bottom:50px;">
                                				<!-- <a href="<?php //echo base_url('tienda/direccion/formulario') ?>" style="text-decoration:underline"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Agregar una nueva dirección</a> -->
                            				</div>
					<div class="row" style="margin-bottom:50px;">
						<div class="col-md-6">
						<p>INFORMACIÓN DE USUARIO</p>
						<p>
						<?php 
							echo 'Nombre/Razón Social: '.$usuario->nombre.'<br>';
							if(isset($usuario->distribuidor->tipo)=='moral')
								echo "RFC: ".$usuario->distribuidor->rfc;
							else
							echo 'Apellidos: '.$usuario->apellidoPaterno.' '.$usuario->apellidoMaterno.'<br>';
						?>
						</p>
						<p>
							<a href='<?php  echo base_url('tienda/cuenta/editar') ?> ' style="text-decoration:underline">
								<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
								Modificar información
							</a>
						</p>
						</div>
						<div class="col-md-6">
							<p>NEWSLETTERS</p>
							<?php if(($grupos!='')&&($boletin_usuario->unsuscribed!=1)){ ?>
							<p>Suscrito a Newsletter en los siguientes grupos:</p>
								<p>
									<?php  foreach ($grupos as $key => $grupo):
											echo $grupo->nombre.$val=($key+1)<$total ? ', ' : ' ';
										endforeach; ?>
								</p>

							<?php }else if($boletin_usuario->unsuscribed==0){ ?>
							<p>Suscrito a Newsletter.</p>
							<?php }else{ ?>
								<div>No estas suscrito al Newsletter.</div>
							<?php } ?>
							<p>
								<a href='<?php  echo base_url('tienda/cuenta/editargrupo') ?> ' style="text-decoration:underline">
									<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									Modificar información
								</a>
							</p>

						</div>
					</div>
					
					<?php if($usuario->descuento_id && isset($cupon->cupon)) {?>
					<div class="row">
						<div class="col-md-6">
							<div class="text-muted">
								<small>Entrega este cupón a tus clientes y obtén comisiones por cada compra que realicen</small>
							</div>
							<div class="cupon">
	                            <div class="borde">
	                                <div>
	                                    <div class="porcentaje">6%</div>
	                                    <div class="descuento">DE DESCUENTO</div>
	                                    <div class="compras">EN TODAS TUS COMPRAS</div>
	                                    <div class="codigo">CÓDIGO:</div>
	                                    <div class="cupon">
	                                        <?php echo $cupon->cupon; ?>
	                                    </div>
	                                    <div class="link">
	                                        comprando en: http://www.algaespirulina.mx
	                                    </div>
	                                    
	                                </div>
	                            </div>
							</div>
							<div style="text-align:center"><a href="<?php  echo base_url('tienda/cuenta/print_cupon') ?>" target="_blank"><span class="glyphicon glyphicon-import" aria-hidden="true"></span> Descargar cupones</a></div>
						</div>
					</div>
					<?php } ?>

				</div>

			</div>
		</div>
	</div>
</div>



