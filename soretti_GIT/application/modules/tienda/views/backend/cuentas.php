<form action="" method="post" id="myform">

<input type="hidden" name="ordenar" id="ordenar" value="">
<div class="row">
      <div class="col-md-8">
      <?php if($this->acceso->valida('tienda','editar')) {?>
      	<a class="btn btn-primary" href="<?php echo base_url('modulo/tienda/backend/cuenta/agregar') ?>"><span class="glyphicon glyphicon-plus icon-white"></span> Agregar </a>
      <?php } ?> 
        <?php if($this->acceso->valida('tienda','eliminar')) {?>
        <a class="btn btn-danger seleccionados" href="<?php echo base_url('modulo/tienda/backend/cuenta/eliminar/'.'?uri='.$this->uri->uri_string()) ?>" ><i class="glyphicon glyphicon-trash icon-white"></i> Eliminar seleccionados</a>
        <?php } ?>
        <a class="btn btn-success seleccionados" href="<?php echo base_url('modulo/tienda/backend/cuenta/activar/'.'?uri='.$this->uri->uri_string()) ?>" ><i class="glyphicon glyphicon-ok icon-white"></i> Activar</a>

      </div>
      <div class="col-md-4" style="text-align:right">
        <div class="input-group">
           <input class="form-control" id="" name="buscar"  type="text" value="<?php echo $this->session->userdata('cuenta_buscar') ?>">
           <span class="input-group-btn"><input class="btn btn-default"  type="submit" name="action_buscar" value="Buscar" ></span>
        </div>
      </div>
 </div>
<div class="table-responsive">
	<table class="table table-bordered grid">
		<thead>
			<tr>
				<th><input type="checkbox" class="checkall"></th>
				<th class="titulo_campos" campo="id">ID <?php icon_order($this->session->userdata('cuenta_ordenar'),'id'); ?></th>
				<th class="titulo_campos" campo="nombre">Nombre/Razón Social <?php icon_order($this->session->userdata('cuenta_ordenar'),'nombre'); ?></th>
				<th class="titulo_campos" >TELÉFONO</th>
				<th class="titulo_campos" campo="descuento_id">TIPO DISTRIBUIDOR <?php icon_order($this->session->userdata('cuenta_ordenar'),'descuento_id'); ?></th>
				<th class="titulo_campos" campo="is_enable">ACTIVO <?php icon_order($this->session->userdata('cuenta_ordenar'),'is_enable'); ?></th>
				<th class="">ACCIONES</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($cuentas as $key => $cuenta): 
				$total=$this->db->where('subordinado_id', $cuenta->id)->count_all_results('subordinados');
			?>
			<tr class="<?php if($total) echo "ocupados";  ?>">
				<td nowrap><input type="checkbox" value="<?php echo $cuenta->id; ?>"  name="post_ids[]"></td>
				<td nowrap><?php echo $cuenta->id; ?></td>
				<td nowrap><?php echo ($cuenta->tipo=='moral') ? $cuenta->nombre : $cuenta->nombre." ".$cuenta->apellidoPaterno." ".$cuenta->apellidoMaterno; ?></td>
				<td nowrap><?php echo $cuenta->lada."-".$cuenta->telefono; ?></td>
				<td nowrap>
					<?php   if($cuenta->descuento_id){
								$descuento = new Descuento();
						        $descuento->where('id',$cuenta->descuento_id)->get();
						        echo "Descuento: ".$descuento->titulo.' - '.$descuento->porcentaje.'%';
						        if($cuenta->cupon_cupon) echo "<br>Cupon: ".$cuenta->cupon_cupon;
					    	}else{
					    		echo "";
					    	}
					?>
				</td>
                <td><?php if($cuenta->is_enable) {?><span class="label label-success">Si</span><?php } else {?> <span class="label label-danger">No</span><?php } ?></td>
						
				<td nowrap>
					<button class="btn  btn-default btn-sm seleccionar" type="button" value="<?php echo $cuenta->id; ?>" titulo="<?php echo $cuenta->nombre." ".$cuenta->apellidoPaterno; ?>" uri="" > Insertar </button>
					<?php if($this->acceso->valida('tienda','consultar')) {?>
					<a href="<?php echo base_url('modulo/tienda/backend/cuenta/ver/'.$cuenta->id); ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-eye-open"></i></a>
					<?php } ?>
					<?php if($this->acceso->valida('tienda','eliminar')) {?>
					<button href="<?php echo base_url('modulo/tienda/backend/cuenta/eliminar/'.'?uri='.$this->uri->uri_string()); ?>" type="button" class="btn btn-default btn-sm action_row"><i class="glyphicon glyphicon-trash"></i></a>
					<?php } ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php echo $this->pagination->create_links(); ?>
</div>
</form>
<script>

  jQuery(document).ready(function($) {
       if(window.self !== window.top){
        $(".seleccionar").show();
        $(".ocupados").hide();
     }
  });

 $(".seleccionar").click(function(){
    window.parent.$("#lista-subordinados").prepend('<li class="list-group-item"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span><input type="hidden" name="subordinados[]" value="'+$(this).attr('value')+'" > '+$(this).attr('titulo')+'</li>');
    window.parent.$.fancybox.close();
 });



</script>
