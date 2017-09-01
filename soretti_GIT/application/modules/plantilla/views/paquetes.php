<!DOCTYPE html>
<html lang="es-mx">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $meta['titulo'] ?></title>
    <meta name="description" content="<?php echo $meta['descripcion']; ?>" />
    <meta name="keywords" content="<?php echo $meta['palabras_clave']; ?>" />

    <meta property="og:url"                content="<?php echo current_url(); ?>" />
    <meta property="og:type"               content="article" />
    <meta property="og:title"              content="<?php echo $meta['titulo'] ?>" />
    <meta property="og:description"        content="<?php echo $meta['descripcion']; ?>" />

    <?php if($this->uri->segment(1)=='blog' && isset($post) && isset($post->resumen_imagen)) {?>
        <meta property="og:image"  content="<?php echo $post->resumen_imagen; ?>" />
    <?php } ?>
    <?php if($this->uri->segment(1)=='catalogo' && isset($producto)  && isset($imagenes) ) {?>
        <meta property="og:image"  content="<?php echo base_url('pub/uploads/thumbs/'.name_image($producto->cat_imagen->imagen,'catalogo','cat_imagen',$producto->cat_imagen->lista_w,$producto->cat_imagen->lista_h)) ?>" />
    <?php } ?>
    <?php $this->load->view('plantilla/partial/scripts'); ?>
  </head>

  <body id="contenido">
    <?php echo modules::run('admin/menu'); ?>
    <header>
      <div class="container-fluid header">
        <nav class="navbar navbar-default navbar-fixed-top" id="menu-principal">
          <div class="container">
            <?php echo modules::run('menu'); ?>
          </div>
        </nav>
      </div>
    </header>
    <section>
      <div class="container section">
         <?php echo $this->layout_content ?>


<div class="pricing-tables attached">
 
        <div class="row">
          <div class="col-sm-3 col-md-3">
           
           <div class="plan  first">

              <div class="head">
                <h2>Parallax</h2>
              </div> 
              
             
              <a href="#" item-articulo="1" class="btn btn-success solicitar_cotizacion" asunto-titulo="Parallax" data-toggle="modal" data-target="#myModal" border="0" >Solicitar Cotización</a>


              <ul class="item-list">
                   <li>Una pagina <strong>Parallax</strong></li>
                   <li>Diseño  web estándar</li>
                   <li>Diseño web responsivo</li>
                   <li><strong>2</strong> Banners</li>
                   <li>Enlace a redes sociales</li>
                   <li><strong>6 meses gratis</strong> de hosting </li>
                   <li>Dominio .com o .com.mx por <strong>1 año</strong></li>
                   <li>cuentas de correo ilimitadas</li>
                   <li><strong>1 GB</strong> de espacio</li>
                   <li>Formulario de contacto</li>
                   <li>Mapa de ubicación en google maps</li>
                   <li>Integración de Google Analytics</li>              
              </ul>

              <div class="price">
                <h3><span class="symbol">$</span>5,000</h3>
                  <h4>MXN</h4>
              </div>


           </div>
             
            
          </div>


          <div class="col-sm-3 col-md-3 ">
                      <div class="plan ">

              <div class="head">
                <h2>Estandar</h2>
              </div>  
              <a href="#" item-articulo="2" class="btn btn-success solicitar_cotizacion" asunto-titulo="Estandar" data-toggle="modal" data-target="#myModal" border="0" >Solicitar Cotización</a>


              <ul class="item-list">
                   <li><strong>3 a 5</strong> Secciones</li>
                   <li>Diseño  web estándar</li>
                   <li>Diseño web responsivo</li>
                   <li><strong>2</strong> Banners</li>
                   <li>Enlace a redes sociales</li>
                   <li><strong>6 meses gratis</strong> de hosting </li>
                   <li>Dominio .com o .com.mx por <strong>1 año</strong></li>                   
                   <li>cuentas de correo ilimitadas</li>
                   <li><strong>1 GB</strong> de espacio</li>
                   <li>Formulario de contacto</li>
                   <li>Mapa de ubicación en google maps</li>
                   <li>Integración de Google Analytics</li>
                   <li>Administrador de contenidos Trahc Tools</li>
              </ul>

              <div class="price">
                <h3><span class="symbol">$</span>9,000</h3>
                <h4>MXN</h4>
              </div>


           </div>

          </div>


          <div class="col-sm-3 col-md-3 ">
              
              <div class="plan recommended">

                <div class="head">
                  <h2>Profesional</h2>
                </div>  
                <a href="#" item-articulo="3" class="btn btn-success solicitar_cotizacion" asunto-titulo="Profesional" data-toggle="modal" data-target="#myModal" border="0" >Solicitar Cotización</a>

              <ul class="item-list">
                   <li><strong>3 a 5</strong> Secciones</li>
                   <li>Diseño personalizado</li>
                   <li>Diseño web responsivo</li>
                   <li><strong>2</strong> Banners</li>
                   <li>Enlace a redes sociales</li>
                   <li><strong>6 meses gratis</strong> de hosting </li>
                   <li>Dominio .com o .com.mx por <strong>1 año</strong></li>                   
                   <li>cuentas de correo ilimitadas</li>
                   <li><strong>3 GB</strong> de espacio</li>
                   <li>Formulario de contacto</li>
                   <li>Mapa de ubicación en google maps</li>
                   <li>Integración de Google Analytics</li>
                   <li>Administrador de contenidos Trahc Tools</li>
                   <!-- <li>Chat en linea Trahc Tools</li>
                   <li>Envío de Newsletters Trahc Tools</li> -->
              </ul>

              <div class="price">
                <h3><span class="symbol">$</span>18,000</h3>
                <h4>MXN</h4>
              </div>

           </div>

          </div>

          <div class="col-sm-3 col-md-3 ">
              
              <div class="plan last">

                <div class="head">
                  <h2>Tienda</h2>
                </div>

               <a href="#" item-articulo="4" class="btn btn-success solicitar_cotizacion" asunto-titulo="Tienda" data-toggle="modal" data-target="#myModal" border="0" >Solicitar Cotización</a>



                    <ul class="item-list">
                         <li>Diseño personalizado</li>
                         <li>Diseño web responsivo</li>
                         <li><strong>2</strong> Banners</li>
                         <li>Enlace a redes sociales</li>
                         <li><strong>6 meses gratis</strong> de hosting </li>
                         <li>Dominio .com o .com.mx por <strong>1 año</strong></li>                   
                         <li>cuentas de correo ilimitadas</li>
                         <li><strong>5 GB</strong> de espacio</li>
                         <li>Formulario de contacto</li>
                         <li>Mapa de ubicación en google maps</li>
                         <li>Integración de Google Analytics</li>
                         <li>Administrador de contenidos Trahc Tools</li>
                         <!-- <li>Chat en linea Trahc Tools</li> -->
                         <!-- <li>Envío de Newsletters Trahc Tools</li> -->
                         <li>IP estática 1 año</li>
                         <li>Certificado SSL 1 año</li>
                         <li>Depósitos y transferencias como medios de pago</li>
                         <li>Tarifa plana y envios gratis</li>
                    </ul>
                <div class="price">
                  <h3><span class="symbol">$</span>26,000</h3>
                  <h4>MXN</h4>
                </div>


           </div>

          </div>

        </div> <!-- row-->

      </div>

      </div>
      <?php echo modules::run('atributos'); ?>
    </section>
    <div class="clearfix"></div>
    <footer class="clearfix">
      <div class="footer contenedor">
        <div class="footer-logo">
          <a href="#"><img src="<?php echo base_url('pub/theme/img/logofooter.fw.png'); ?>" class="img-responsive" alt="Image"></a>
        </div>
        <ul class="nav nav-pills">
          <li role="presentation"><a href="#">Cotizar</a></li>
          <li role="presentation"><a href="#">Portafolio</a></li>
        </ul>
        <div class="footer-texto">
          <p>Paseo de las Palmas 555 <span class="verde">/</span> Ciudad de México<br>
            +52 5520 1155, 01 8000 000 4278<span class="verde"> / </span><?php echo safe_mailto('info@paginasweb.mx'); ?><br>
            © Trahc Studio desde 2005.
          </p>
        </div>
      </div>
    </footer>
<div id="live-chat"></div>
<script>
$("#live-chat").html("<iframe src='https://www.algaespirulina.mx/chat.html?dominio=paginasweb.mx&title="+encodeURI(document.title)+"' frameborder='0' height='40'></iframe>");
$(window).on('message', receiveMessage);
    function receiveMessage(e) {
      if ( e.originalEvent.origin === 'https://www.algaespirulina.mx' ) {
        $("#live-chat iframe").height(e.originalEvent.data);
      }
}
</script>



  <div class="modal fade informacion" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" id="form-contacto">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h2 class="modal-title fondo azul" id="myModalLabel">Solicitar Cotización</h2>
          <div id="modal-asunto-titulo"></div>
        </div>
        <div class="modal-body" id="cotizacion-body">
            <div class="form-group">
              <label for="">Cual es tu Nombre?: </label>
              <input type="text" class="form-control" id="nombre_f" placeholder="Nombre:">
            </div>
            <div class="form-group">
              <label for="">Danos tu Email: </label>
              <input type="text" class="form-control" id="email_f" placeholder="Email:">
            </div>
            <div class="form-group">
              <label for="">Aquí tu Teléfono: </label>
              <div class="row">
                <div class="col-md-2"><input type="text" class="form-control" id="lada_f" placeholder="Lada:"></div>
                <div class="col-md-10"><input type="text" class="form-control" id="telefono_f" placeholder="Teléfono:"></div>
              </div>
            </div>
            <div class="form-group">
              <label for="">Dinos, ¿que necesitas?: </label>
              <textarea class="form-control" name="" id="texto_f" cols="30" rows="5" placeholder="Mensaje:"></textarea>
            </div>
            <div class="form-group">
              <input type="checkbox"  name="privacidad"  value="1" id="privacidad" <?php if($this->input->post('privacidad')==1) echo "checked"; ?> >  He leído y acepto la nota informativa sobre el  <a href="<?php echo site_url('modulo/pagina/blank/politica-de-privacidad'); ?>" class="fancybox-frame">aviso de privacidad. </a>
              
              <input type="hidden" class="form-control" id="paqueteid" value="">              
            </div>
          </div>

   
        <div class="modal-footer">
          <input type="text" class="form-control hide" name="email_field_f" id="email_field_f"  value="" />
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-success" id="btn-informacion-producto" href="<?php echo base_url('modulo/blog/solicitar_informacion'); ?>">Enviar</button>
        </div>
      </div>
      </div>
    </div>
  </div>
  </body>
</html>