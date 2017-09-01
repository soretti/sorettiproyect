<form action="" method="post" id="myform">
	<legend><?php echo $columna->nombre ?></legend>
	
	<div class="btn-toolbar form-group">
		<?php if($this->acceso->valida('pagina','editar')) {?>
		<?php echo '<button class="btn btn-success" id="guardar-columna" type="submit" onclick="goto(\''.base_url('modulo/columna/guardar/'.$columna->id).'\')">Guardar</button>'; ?>
		<?php echo '<button class="btn btn-primary" id="guardar-columna" type="submit" onclick="goto(\''.base_url('modulo/banners/listar/'.$columna->id).'\')">Banners</button>'; ?>
		<?php } ?>
		<a class="btn btn-default" href="<?php echo base_url('modulo/columna/listar') ?>"> Regresar </a>
	</div>
	<div class="form-group">
		Titulo:   <input type="text" name="nombre" value="<?php echo $columna->nombre; ?>" class="form-control">
		<?php echo $columna->error->nombre; ?>
	</div>
	<div class="row">
		<div class="col-md-12">
		<blockquote>  <small>Activar, desactivar y ordenar módulos de esta columna</small></blockquote>
	</div>
</div>
<input type="hidden" id="lista_json_modulos" name="lista_json_modulos">
<div class="row" id="example-2-1">
	<div class="col-md-6">
		<div class="dd" id="nestable">
			<ol class="sortable-list dd-list list1" id="contenedor_publicidad">
				<?php
					foreach ($modulos_inactivos as $key => $modulo)
					{
						echo '<li class="sortable-item dd-item" id="'.$modulo['id'].'" tipo="'.$modulo['tipo'].'">';
								echo "<div class='action-menu'>";
										if($modulo['tipo'] == "publicidad"){
											echo "<a class='btn confirm' href='".base_url('modulo/columna/eliminar_group/'.$columna->id.'/'.$modulo['id'])."'><i class='icon-remove'></i></a>";
											echo "<a class='btn popup' href='";
													echo base_url("modulo/publicidad/editar_group/".$modulo['id']);
											echo "'><i class='icon-edit'></i></a>";
										}
								echo "</div>";
								echo "<div class='dd-handle'>";
										echo $modulo['titulo'];
								echo "</div>";
						echo '</li>';
					}
				?>
			</ol>
		</div>
	</div>
	<div class="col-md-6" id="nestable2">
		<div class="dd" id="nestable2">
			<ol class="sortable-list dd-list list2">
				<?php
					foreach ($modulos_activos as $key => $modulo)
					{
						echo '<li class="sortable-item dd-item" id="'.$modulo['id'].'" tipo="'.$modulo['tipo'].'">';
								echo "<div class='action-menu'>";
										if($modulo['tipo'] == "publicidad"){
											echo "<a class='btn confirm' href='".base_url('modulo/columna/eliminar_group/'.$columna->id.'/'.$modulo['id'])."'><i class='icon-remove'></i></a>";
											echo "<a class='btn popup' href='";
													echo base_url("modulo/publicidad/editar_group/".$modulo['id']);
											echo "'><i class='icon-edit'></i></a>";
										}
								echo "</div>";
								echo "<div class='dd-handle'>";
										echo $modulo['titulo'];
								echo "</div>";
						echo '</li>';
					}
				?>
				
			</ol>
		</div>
	</div>
</div>
</form>