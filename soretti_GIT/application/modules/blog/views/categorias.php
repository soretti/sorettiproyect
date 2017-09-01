<div class="relative">
    <?php  if($this->acceso->valida('pagina','editar')) {?>
    <i class="tip-tools"></i>
    <div id="user-options">
        <a href="<?php echo base_url('modulo/blog/blogcategorias/listar/'.$pagina_id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
    </div>
    <div class="editable"><div class="zona-editable"></div></div>
    <?php } ?>
    <div class="barra-azul text-center fila-top categorias ">
        Categorias
        <i class="fa fa-bars"></i>
    </div>
    <div class="modulo menu-categorias-vertical">
        <div id='cssmenu'>
            <ul>
            <?php foreach ($categorias as $categoria) {
            $segment_pag=2;  if(IDIOMA)  $segment_pag=3;
            $total_x_categoria=$articulos->is_active()->where('categoria_id',$categoria->id)->count();
            ?>
            
                <?php if($total_x_categoria) {?>
                <li> <a href="<?php echo url_idioma(base_url('blog/'.$this->uri->segment($segment_pag)."/categoria/".$categoria->uri.".html")); ?>"> <?php echo $categoria->{'titulo'.IDIOMA} ?> (<?php echo $total_x_categoria; ?>) </a>  </li>
                <?php } ?>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>