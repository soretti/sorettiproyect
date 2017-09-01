<div class="row">
	<div class="col-md-12">

		<?php if($this->session->flashdata('mensaje')) {?>
		<div class="alert alert-success">
			<?php echo $this->session->flashdata('mensaje'); ?>
		</div>
		<?php } ?>

			<h1>Mi cuenta</h1>

			<div class="text-small form-group">Desde aquí puedes ver tus actividades recientes y actualizar la información de tu cuenta.</div>

		<div class="row">
			<div class="col-md-3">
				<?php $this->load->view("tienda/cuenta/menu"); ?>
			</div>
			<div class="col-md-9">
				<div class="encabezado"><?php echo $titulo; ?></div>
				<div class="table-responsive">
				<table class="table carrito" id="tbl_carrito">
					<tr>
						<th># Pedido</th>
						<th>Enviar a</th>
						<th>Total del pedido</th>
						<th>Forma de pago</th>
						<th>Estatus</th>
						<th>&nbsp;</th>
					</tr>
					<?php foreach ($orders as $key => $o): ?>
						<?php $o->datos_envio  = json_decode($o->datos_envio);
						      $o->datos_pago = json_decode($o->datos_pago); ?>
						<tr class='<?php echo ($this->session->flashdata('order_id')==$o->id)?"success":"" ?>'>
							<td><?php echo $o->id ?></td>
							<td><?php echo $o->datos_envio->calle ?> <?php echo $o->datos_envio->numero_ext ?></td>
							<td><?php echo formato_precio($o->datos_pago->total) ?></td>
							<td><?php echo $metodos_de_pago[$o->datos_pago->metodo_pago];  ?></td>
							<td><?php echo $status_tienda[$o->estatus]; ?></td>
							<td>
								<a href="<?php echo base_url('tienda/order/ver/'.$o->id) ?>" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-eye-open"></a>
								<a href="<?php echo base_url('tienda/order/printm/'.$o->id) ?>" class="btn btn-sm btn-default" target="_blank"><span class="glyphicon glyphicon-print"> </a>
							</td>
						</tr>
				<?php endforeach; ?>
			</table>
			<div class="text-right"><?php echo $this->pagination->create_links(); ?></div>
			</div>
		</div>
	</div>
</div>
</div>
