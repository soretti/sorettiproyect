<div class="widget fila-top archivo-blog">

   <div class="barra-azul text-center fila-top categorias ">
    	Publicaciones por Fecha
    </div>

    <ul class="nav nav-pills nav-stacked">

        <?php foreach ($archivo as $item): 

         $total_x_fecha=$articulos->is_active()->where( array("YEAR(fecha_creacion)"=>$item->year,"MONTH(fecha_creacion)"=>$item->month,'pagina_id'=>$pagina->id) )->count(); ?>

        	<li> 
                <a href="<?php echo site_url('blog/'.$pagina->uri."/archivo/".$item->year."/".$this->dateutils->months($item->month)); ?>"><?php  echo $this->dateutils->months($item->month)." ".$item->year; ?> (<?php echo  $total_x_fecha; ?>) </a>

        	</li>

        <?php endforeach ?>

    </ul>

</div>