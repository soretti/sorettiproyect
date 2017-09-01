<div class='columna relative root'>
		<?php  if($this->acceso->valida('pagina','editar')) { ?> 
			<i class='tip-tools'></i>
			<div id='user-options'>
				<a href='<?php  echo base_url('modulo/columna/editar/1') ?> ' class='editar'><i class='icon-edit'></i></a>
			</div>
			<div class='editable'><div class='zona-editable'></div></div>
		<?php  } ?> 

<?php 
 echo modules::run('blog/blogcategorias/blog');  echo modules::run('blog/ultimos_post_blog');  echo modules::run('banners/mostrar',"13","1");  echo modules::run('blog/plugin_archivo_blog');  if($this->uri->segment(2)!='contacto') echo modules::run('contacto/inmediato'); ?> 
</div>