<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>RECORTAR IMAGEN</title>

  <!-- jQuery -->
  <script src="<?php echo base_url('pub/libraries/jquery/jquery-1.10.1.min.js') ?>"></script>

 

	<!--Recortar imagenes-->
	<link href="<?php echo base_url('pub/libraries/jcrop/css/jquery.Jcrop.min.css') ?>" rel="stylesheet">
	<script type="text/javascript" src="<?php echo base_url('pub/libraries/jcrop/js/jquery.Jcrop.min.js') ?>"></script>

<script>
base_url='<?php echo base_url(); ?>';
$(document).ready(function() {
	
  $('#imagen').Jcrop({
        allowResize:<?php echo ($original_height) ? 0 : 1  ?>,
        allowSelect:0,        
        setSelect: [ 0, 0, <?php echo $width; ?>, <?php echo $height; ?> ], 
        onChange:  function(c){ $("#cordenadas").val('{"x":'+c.x+',"y":'+c.y+',"x2":'+c.x2+',"y2":'+c.y2+'}'); }
      },
      function(){
        jcrop_api_p = this;
      }
    );

  $("#aplicar").click(function(){
    $.ajax({
      url: base_url+'modulo/imagen/recortar',
      type: 'POST',
      dataType: 'json',
      data: {imagen: '<?php echo $imagen_escalada; ?>',cordenadas : $("#cordenadas").val() },
    })
    .done(function() {
     if(opener.input_file_selected.attr('originalName')==1){
      opener.input_file_selected.val('<?php echo base_url($imagen); ?>');
     }else{
      opener.input_file_selected.val('<?php echo base_url($imagen_escalada); ?>');
     }
      window.close();
      console.log("success");
    })
    .fail(function() {
      console.log("error");
    });
    
  });

});
  </script>
</head>
<body>
    
 
     <div class="form-group"><legend>RECORTAR IMAGEN</legend></div>
      <div class="form-group">
      <input type="hidden" name="cordenadas" id="cordenadas" value="">
      <input type="button" class=" btn btn-primary" name="Aplicar" value="Aplicar" id="aplicar"> 
    </div>

	 <img src="<?php echo base_url($imagen_escalada) ?>" alt="" id="imagen">
 
</body>
</html>