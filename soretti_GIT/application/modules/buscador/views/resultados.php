<div class="resultados relative">
  <?php $i=0; foreach ($resultados->result() as $item) {
  $img='';
  if($item->tipo=='producto'){
    $thumb=new cat_imagen;
    $thumb->select('imagen')->order_by('sort','asc')->limit(1)->get_by_producto_id($item->id);
    if($thumb->result_count()>0) $img=base_url('pub/uploads/thumbs/'.name_image($thumb->imagen,'catalogo','cat_imagen',100,100));
    $item->uri='catalogo/'.$item->categoria."/".$item->uri;
  }
  if($item->tipo=='articulo'){
    $thumb=new articulo;
    $thumb->select('resumen_imagen as imagen')->get_by_id($item->id);
    if($thumb->result_count()>0) $img=$thumb->imagen;
    $item->uri='blog/'.$item->categoria."/".$item->uri;
  }
  if($item->tipo=='pagina'){
    $item->uri='web/'.$item->uri;
  }
  if(!$img) {
   $img=base_url('pub/uploads/thumbs/thumb-default.jpg');
  }
  ?>
  <div class="item wrapper">

    <div class="wrapper">
          <a href="<?php echo url_idioma(base_url($item->uri.".html")); ?>" class="boton-style boton-go">
      <img src="<?php echo $img ?>" class="img-responsive">
    </a>

      <a href="<?php echo url_idioma(base_url($item->uri.".html")); ?>" class="boton-style boton-go">
        <h3><?php echo highlight_phrase($item->{'titulo'.IDIOMA}, $keyword, '<strong>', '</strong>');  ?></h3>
      </a>
      <div>
        <?php if($item->tipo=='articulo') {?>
        <div class="fecha"><?php if(IDIOMA)  $fidioma=substr(IDIOMA,1); else $fidioma='es';  echo $this->dateutils->{'date'.$fidioma}(strtotime($item->fecha_creacion),'c','c');  ?></div>
        <?php } ?>
      </div>
      <p>
        <a href="<?php echo url_idioma(base_url($item->uri.".html")); ?>" class="boton-style boton-go">
        <?php  echo  highlight_phrase(character_limiter($item->{'resumen'.IDIOMA},200,'...'), $keyword, '<span class="highlight">', '</span>');  ?>
      </a>
      </p>
    </div>
  </div>
  
  <?php
  $i++;
  } ?>
  <?php if( !$resultados->num_rows() ) {?>
  <div>
    <div class="alert alert-danger">Te recomendamos verificar que las palabras estén escritas correctamente, así como probar algunas otras relacionadas con la búsqueda que necesitas realizar</div> </div>
    <?php } ?>
    <div class="pagination"> <?php echo $this->pagination->create_links(); ?> </div>
    
  </div>