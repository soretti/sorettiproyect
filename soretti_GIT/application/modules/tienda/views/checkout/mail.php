<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
	</head>
	<body style="margin:0; padding:0;">
		<table style="background-color: #F5F5F2; font-family:Arial,Helvetica;" border="0" width="100%" cellspacing="0" cellpadding="0" align="center">
			<tbody>
				<tr>
					<td style="padding:20px;">
						<table style="width: 600px;border: 1px solid #D9D9D9; background-color:#fff;color:#373737;font-size:12px; font-family:Arial,Helvetica;" width="600" cellspacing="0" cellpadding="0" align="center" data-bgcolor="light-gray-bg">
							<tbody>
								<tr>
									<td style="padding:0px 20px;">
										<table width="100%" cellspacing="0" cellpadding="0" border="0">
											<tr>
												<td>
													<div style="margin-top:10px; margin-bottom:10px;"><img src="<?php echo base_url('pub/theme/img/logo.jpg') ?>" alt=""/></div>
												</td>
												<td>
													<table style="width:100%; font-size:12px; font-family:Arial;" border="0" cellspacing="0" cellpadding="2">
														<tr>
															<td style="color:#26639F; text-align:right">No. de Orden: </td>
															<td style="text-align:left"><?php echo $order->id ?></td>
														</tr>
														<tr>
															<td style="color:#26639F; text-align:right">Fecha: </td>
															<td style="text-align:left"><?php echo $fecha ?></td>
														</tr>
														<tr>
															<td style="color:#26639F; text-align:right">Status de la cotización: </td>
															<td style="text-align:left"><?php echo $estatus ?></td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
										<table width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#90B74D; font-family:Arial; text-align:center; color:#FFFFFF; padding-top:10px; padding-bottom:10px;">
											<tr>
												<td>
													<p style="text-align:center"><strong>Estimado <?php echo $usuario->nombre ?> <?php echo $usuario->apellidoPaterno ?> <?php echo $usuario->apellidoMaterno ?></strong></p>
													<div style="text-align:center: font-size:12px"><?php echo $frase; ?></div>
													<?php if($this->input->post('mensajeText')) {?>
													<div style="text-align:center: font-size:12px"><?php echo nl2br($this->input->post('mensajeText')); ?></div>
													<?php } ?>

												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td style="padding: 0px 20px">
										<table width="100%" style=" font-size:12px; font-family:Arial;" cellspacing="0" cellpadding="0" border="0" >
											<tr>
												<td width="50%" valign="top" style="padding-bottom:10px;">
													<table style="color:#FFFFFF; background:#90B74D; width:100%; font-family:Arial;  font-size:12px;">
														<tr>
															<td style="padding:5px 10px; "><div><strong>Datos de entrega</strong></div></td>
														</tr>
													</table> 

													<table width="100%" style=" font-size:12px; font-family:Arial;" cellspacing="1" cellpadding="1" border="0" >
														<tr>
															<td style="color:#26639F">Nombre</td>
															<td><?php echo $envio->nombre ?> <?php echo $envio->apellidoPaterno ?> <?php echo $envio->apellidoMaterno ?></td>
														</tr>
														<tr>
															<td style="color:#26639F">Teléfono</td>
															<td ><?php echo $envio->lada ?> <?php echo $envio->telefono ?></td>
														</tr>
														<tr>
															<td style="color:#26639F">Celular</td>
															<td ><?php echo $envio->celular ?></td>
														</tr>
														<tr>
															<td style="color:#26639F">Estado</td>
															<td ><?php echo $envio->estado ?></td>
														</tr>
														<tr>
															<td style="color:#26639F">Deleg/Mun</td>
															<td ><?php echo $envio->municipio ?></td>
														</tr>
														<tr>
															<td style="color:#26639F">Colonia</td>
															<td ><?php echo $envio->colonia ?></td>
														</tr>
														<tr>
															<td style="color:#26639F">CP:</td>
															<td ><?php echo $envio->codigo ?></td>
														</tr>
														<tr>
															<td style="color:#26639F">Calle:</td>
															<td ><?php echo $envio->calle ?></td>
														</tr>
														<tr>
															<td style="color:#26639F">Número ext:</td>
															<td ><?php echo $envio->numero_ext ?></td>
														</tr>
														<tr>
															<td style="color:#26639F">Número int:</td>
															<td ><?php echo ($envio->numero_int) ? $envio->numero_int : 'N/A'; ?></td>
														</tr>
													</table>
												</td>
												<td width="50%" valign="top" style="padding-bottom:10px;">


													<table style="color:#FFFFFF; background:#90B74D; width:100%; font-family:Arial;  font-size:12px;">
														<tr>
															<td style="padding:5px 10px; "><div><strong>Datos de facturación</strong></div></td>
														</tr>
													</table>

													<?php if($factura->rfc){ ?>
													<table style="font-size:12px; width:100%; font-family:Arial,Helvetica;" cellspacing="1" cellpadding="1" border="0">
														<tr>
															<td style="color:#26639F">RFC:</td>
															<td ><?php echo $factura->rfc ?></td>
														</tr>
														<tr>
															<td style="color:#26639F">Razón social:</td>
															<td ><?php echo $factura->razon_social ?></td>
														</tr>
														<tr>
															<td style="color:#26639F">Estado:</td>
															<td ><?php echo $factura->estado ?></td>
														</tr>
														<tr>
															<td style="color:#26639F">Municipio:</td>
															<td ><?php echo $factura->municipio ?></td>
														</tr>
														<tr>
															<td style="color:#26639F">Colonia:</td>
															<td ><?php echo $factura->colonia ?></td>
														</tr>
														<tr>
															<td style="color:#26639F">Código postal:</td>
															<td ><?php echo $factura->codigo ?></td>
														</tr>
														<tr>
															<td style="color:#26639F">Calle:</td>
															<td ><?php echo $factura->calle ?></td>
														</tr>
														<tr>
															<td style="color:#26639F">Número exterior:</td>
															<td ><?php echo $factura->numero_ext ?></td>
														</tr>
														<tr>
															<td style="color:#26639F">Número interior:</td>
															<td ><?php echo ($factura->numero_int) ? $factura->numero_int : 'N/A';  ?></td>
														</tr>
													</table>
													<?php }else{ ?>
													  	<div style="text-align:center">N/A</div>
													<?php }?>
													
												</td>
											</tr>
										</td>
									</tr>
								</table>
								<div style="margin-top:10px;">
									<table cellspacing="0" style="border-collapse: collapse; width:100%; font-family:Arial,Helvetica; font-size:12px; ">
										<tr>
											<th style="border:1px solid #D9D9D9;padding:5px;margin:5px;background-color:#f5f5f5; font-size:12px; ">sku</th>
											<th style="border:1px solid #D9D9D9;padding:5px;margin:5px;background-color:#f5f5f5; font-size:12px; ">Producto</th>
											<th style="border:1px solid #D9D9D9;padding:5px;margin:5px;background-color:#f5f5f5; font-size:12px; ">Cantidad</th>
											<th style="border:1px solid #D9D9D9;padding:5px;margin:5px;background-color:#f5f5f5; font-size:12px; ">Precio</th>
											<th style="border:1px solid #D9D9D9;padding:5px;margin:5px;background-color:#f5f5f5; font-size:12px; ">Subtotal</th>
										</tr>
										<?php foreach ($items as $key => $item): ?>
										<tr style="font-size:11px;">
											<td style="border:1px solid #D9D9D9;padding:5px;margin:5px;"><?php echo $item->SKU; ?></td>
											<td style="border:1px solid #D9D9D9;padding:5px;margin:5px;">
												<?php if(isset($item->imagen)){ ?>
												<img src="<?php echo base_url('pub/uploads/thumbs/'.name_image($item->imagen,'catalogo','cat_imagen',100,100)); ?>" alt="" align="left" width="50" style="margin-right:5px;">
												<?php } ?>
												<?php echo $item->titulo; ?>
												<?php if($item->options) {?>
												<div>
													<?php foreach (json_decode($item->options,true) as $i => $value): ?>
													<p> <?php echo $i.':'.$value ?> </p>
													<?php endforeach; ?>
												</div>
												<?php } ?>
											</td>
											<td style="border:1px solid #D9D9D9;padding:10px;margin:10px;"><?php echo $item->cantidad; ?></td>
											<td style="border:1px solid #D9D9D9;padding:10px;margin:10px;"><?php echo formato_precio($item->precio); ?></td>
											<td style="border:1px solid #D9D9D9;padding:10px;margin:10px;"><?php echo formato_precio($item->precio * $item->cantidad); ?></td>
										</tr>
										<?php endforeach; ?>
									</table>
								</div>
							</td>
						</tr>

						<tr>
							<td style="padding:15px 20px 30px 20px;">
								<table align="right" style="font-family:Arial,Helvetica; font-size:12px;" >
									<tr>
										<td style="text-align:right;padding-right:10px; font-family:Arial,Helvetica; ">Subtotal</td>
										<td style="text-align:right; color:#90B74D; "><?php echo formato_precio($pago->subtotal) ?></td>
									</tr>
									<?php if($order->cupon) {?>
									<tr>
										<td style="text-align:right;padding-right:10px; font-family:Arial,Helvetica; ">Descuento cupón: </td>
										<td style="text-align:right; color:#90B74D; "><?php echo "- ". formato_precio($pago->descuentoCupon) ?></td>
									</tr>
									<?php } ?>
									<?php if($pago->descuentoMayoreo) {?>
									<tr>
										<td style="text-align:right;padding-right:10px; font-family:Arial,Helvetica; ">Descuento: </td>
										<td style="text-align:right; color:#90B74D; "><?php echo "- ". formato_precio($pago->descuentoMayoreo) ?></td>
									</tr>
									<?php } ?>
									<tr>
										<td style="text-align:right;padding-right:10px;padding-bottom:15px; font-family:Arial,Helvetica; ">
											<div>Flete</div>
											<?php
        										 $metodos_entrega=$this->config->item('metodos_entrega','proyecto');
											if($pago->forma_entrega==3){
												 echo $this->load->view('order/entrega',array('email'=>$email),true);
											}else{
          										echo $metodos_entrega[$pago->forma_entrega];
											}
											 ?>
										</td>
										<td style="text-align:right;padding-bottom:15px; color:#90B74D; "><?php echo formato_precio($pago->flete) ?></td>
									</tr>
									<tr>
										<td style="text-align:right;font-size:14px;font-weight:bold;padding-right:10px; font-family:Arial,Helvetica;">TOTAL</td>
										<td style="text-align:right; color:#90B74D; font-size:20px ">
											<?php echo formato_precio($pago->total) ?>
											<div><small>iva incluido</small></div>
										</td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td style="padding: 0px 20px">
								<table cellspacing="1" cellpadding="0" border="0" style="width:100%;">
									<tr>
										<td style="font-family:Arial; font-size:12px; padding:15px">
											<?php echo $this->load->view('order/metodo_de_pago',array('banco'=>$banco,'pago'=>$pago),true); ?>
										</td>
									</tr>
								</table>
								
							</td>
						</tr>

						<tr>
							<td style="padding:0px 20px 20px 20px;">

								<table width="100%" CELLSPACING="0" CELLPADDING="0" border="0" >
									<tr>
										<td style=" padding: 15px 10px; color:#aaaaaa; font-family:Arial; border-top:3px solid #90B74D; background:#2A2A2A; font-size:12px; font-style: italic; width:100%; height:100%;">
											Para cualquier duda o aclaración escríbanos a <a href="mailto:<?php echo $email ?>" style="color:#90B74D"><?php echo $email ?></a><br> indicándonos su número de pedido.<br><br>
											<table  style="width:100%; font-family:Arial,Helvetica; font-size:12px; font-style: italic;">
												<tr>
													<td style="color:#90B74D; font-size:23px; font-style:normal;">
														<?php echo $telefonos ?>
													</td>
													<td style=" font-style:normal;">
														Muchas gracias por su confianza,<br>
														Atentamente<br>
														<?php echo $empresa ?><br>
														<a href="<?php echo $dominio ?>" style="color:#FFFFFF"><?php echo $dominio ?></a><br>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
								
								<table width="100%" CELLSPACING="0" CELLPADDING="0">
									<tr>
										<td style=" padding: 15px 10px; background:#1C1C1C;color:#aaaaaa; font-family:Arial; font-size:12px; border-top:2px solid #000000; text-align:center; width:100%; height:100%; ">
											Copyright © 2015 <a href="<?php echo $dominio ?>" style="color:#90B74D"><?php echo $dominio ?></a> Todos los derechos reservados
										</td>
									</tr>
								</table>
								<div >
								</td>
							</tr>
						</tbody>
					</table>
					<p>&nbsp;</p>
				</td>
			</tr>
		</tbody>
	</table>
</body>
</html>