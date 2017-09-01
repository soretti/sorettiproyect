<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Recortar imagen</title>

 

  <!-- jQuery -->
  <script src="<?php echo base_url('pub/libraries/jquery/jquery-1.10.1.min.js') ?>"></script>

	<!--Recortar imagenes-->
	<link href="<?php echo base_url('pub/libraries/jcrop/css/jquery.Jcrop.min.css') ?>" rel="stylesheet">
	<script type="text/javascript" src="<?php echo base_url('pub/libraries/jcrop/js/jquery.Jcrop.min.js') ?>"></script>

<script>
base_url='<?php echo base_url(); ?>';
$(document).ready(function() {
	

  $('#imagen_lista').Jcrop({
        allowResize:0,
        allowSelect:0,        
        setSelect: [ 0, 0, <?php echo $lista_w ?>,  <?php echo $lista_h ?>], 
        onChange:  function(c){ $("#cordenadas_lista").val('{"x":'+c.x+',"y":'+c.y+',"x2":'+c.x2+',"y2":'+c.y2+'}'); }
      },
      function(){
        jcrop_api_p = this;
      }
  );

  $('#imagen_thumb').Jcrop({
        allowResize:0,
        allowSelect:0,        
        setSelect: [ 0, 0, <?php echo $thumb_w ?>,  <?php echo $thumb_h ?>], 
        onChange:  function(c){ $("#cordenadas_thumb").val('{"x":'+c.x+',"y":'+c.y+',"x2":'+c.x2+',"y2":'+c.y2+'}'); }
      },
      function(){
        jcrop_api_p = this;
      }
  );

  $("#aplicar").click(function(){
    $.ajax({
      url: base_url+'modulo/catalogo/recortar',
      type: 'POST',
      dataType: 'json',
      data: { 
      imagen_lista: '<?php echo $imagen_lista; ?>',cordenadas_lista : $("#cordenadas_lista").val(),
      imagen_thumb: '<?php echo $imagen_thumb; ?>',cordenadas_thumb : $("#cordenadas_thumb").val()
      }
    })
    .done(function() {
      opener.input_file_selected.val('<?php echo base_url($imagen); ?>');    
      window.close();
      console.log("success");
    })
    .fail(function() {
      console.log("error");
    });
    
  });

});
  </script>
  <style> 
    .foto{
      margin-bottom: 10px;
      float: left;
      margin-left: 10px;
    }
  </style>
</head>
<body>

<div class="container">
     <div class="form-group"><legend>RECORTAR IMAGEN</legend></div>

<div class="form-group"> <input type="button" name="Aplicar" class=" btn btn-primary" value="Aplicar" id="aplicar">   </div>

   <div class="foto">
    <div><small>Thumb</small></div>
    <img src="<?php echo base_url($imagen_thumb) ?>" alt="" id="imagen_thumb">
    <input type="hidden" name="cordenadas_thumb" id="cordenadas_thumb" value="">
  </div>
 <div>&nbsp;</div>
  <div class="foto">
    <div><small>Lista de productos</small></div>
    <img src="<?php echo base_url($imagen_lista) ?>" alt="" id="imagen_lista">
    <input type="hidden" name="cordenadas_lista" id="cordenadas_lista" value="">
  </div>
 
</div>

  
</body>
</html>