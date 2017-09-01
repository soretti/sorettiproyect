<div class='columna relative root'>
		{{ if($this->acceso->valida('pagina','editar')) { }}
			<i class='tip-tools'></i>
			<div id='user-options'>
				<a href='{{ echo base_url('modulo/columna/editar/<?php echo $columna->id; ?>') }}' class='editar'><i class='icon-edit'></i></a>
			</div>
			<div class='editable'><div class='zona-editable'></div></div>
		{{ } }}

<?php
if(is_array($elements) && $elements>0) echo "{{\n";

	if(is_array($elements)) foreach ($elements as $key => $element) {
		if($element["tipo"] == "modulo"){
			switch ($element["id"]) {
				case 25:
					?> echo modules::run('blog/plugin_archivo_blog'); <?
				break;
				case 24:
					?> echo modules::run('blog/ultimos_post_blog'); <?
				break;
				case 23:
					?> echo modules::run('blog/blogcategorias/blog'); <?
				break;
				case 19:
					?> echo modules::run('catalogo/catalogocategoria/index'); <?
				break;
				case 2:
			   		?> if($this->uri->segment(2)!='contacto') echo modules::run('contacto/inmediato'); <?
				break;
				case 26:
			   		?> echo modules::run('catalogo/catalogodestacados/promociones'); <?
				break;
				case 27:
			   		?> echo modules::run('catalogo/catalogodestacados/recomienda'); <?
				break;
				case 28:
			   		?> echo modules::run('catalogo/catalogodestacados/lomasvendido'); <?
				break;
			}
		}
		if($element["tipo"] == "banner"){
			?> echo modules::run('banners/mostrar',"<?php echo $element["id"] ?>","<?php echo  $columna->id ?>"); <?
		}
	}
if(is_array($elements) && $elements>0) echo "}}\n";
?>
</div>