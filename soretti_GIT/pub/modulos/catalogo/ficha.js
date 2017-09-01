var owlFicha;

jQuery(document).ready(function($) {
	
	    owlFicha=$('.owl-carousel-ficha').owlCarousel({
            margin:30,
            nav:true,
            responsiveClass:true,
            navText: [ '<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>' ],
            responsive:{
                0:{items:2},
                490:{items:3},
                560:{items:4},
                1000:{items:3 }
            }
    	});

    	/*Input radio colores de atributos*/
	    $(".combinaciones .tipo3").each(function(index) {
	        $(this).find('div').eq(0).css("background-color",$(this).attr('color'));
	    });

		  if( typeof combinaciones != "undefined")
		     combinaciones_productos();

  	  $(".atributo").change(function(event) {
  	      combinaciones_productos();            
  	  });
  

});

function combinaciones_productos(){
          var combinacion=new Array();
          var combinacion_index='';
          var i=0;
          var json_combinaciones = new Object();

          $(".atributo").each(function(index) {
             atributo_padre=$(this).prev().text();
      
             if( $(this).is(':radio:checked') ){
                combinacion[i]=$(this).val();
                i++;
                json_combinaciones[atributo_padre]=$(this).attr('stringValue');
             }
             if($(this).is('select') ){
                combinacion[i]=$(this).val();
                i++;
                json_combinaciones[atributo_padre]=$('option:selected', this).attr('stringValue');
             }
          });

          $("#input_combinaciones").val(JSON.stringify(json_combinaciones));

          /*el index de la combinacion son los atributos ordenados  de manera ascendente y separados por "," */

          combinacion.sort();
          var total_cambinacion=combinacion.length-1; 
          $.each(combinacion,function(index, el) {
             extra='';
             if(total_cambinacion!=index) extra=',';
              combinacion_index=combinacion_index+el+extra;
          });
          
          if( typeof combinaciones[combinacion_index] != "undefined"){

            // Imagenes seleccionadas por combinacion si no existe imagen en el atributo muestra todas las imagenes
            combinacion_imagenes = combinaciones[combinacion_index].imagenes.split(",");
            $(".owl-carousel-ficha .item").each(function(index){
                 $(this).parent().removeClass('hide');
                 imageid=$(this).attr('imageId');
                 imagen = combinacion_imagenes.indexOf(imageid);
                 if(imagen < 0 && combinaciones[combinacion_index].imagenes!=''){
                   $(this).parent().addClass('hide');
                 }
            });
            //{{FIN}}
            
            owlFicha.trigger('to.owl.carousel',0);
            $(".foto_sm").find('a').attr('href',$(".owl-item:not(.hide)").eq(0).find('a').attr('href'));
            $(".foto_sm").find('img').attr('src',$(".owl-item:not(.hide)").eq(0).find('a').attr('foto-sm'));

             //{{FIN}}

            $("#precio").text(formato_precio(combinaciones[combinacion_index].precio));

            if(combinaciones[combinacion_index].precio_sin_promocion){
               $("#precio_sin_promocion").removeClass('hide');
              $("#precio_sin_promocion").text(formato_precio(combinaciones[combinacion_index].precio_sin_promocion));
            }  else {
               $("#precio_sin_promocion").addClass('hide');
            }

            $("#stock").text(combinaciones[combinacion_index].stock);
            $("#producto_id").val(combinaciones[combinacion_index].id);

 

            if( combinaciones[combinacion_index].mayoreo_precio && (combinaciones[combinacion_index].mayoreo_cantidad*1)>0 ){
              $("#mayoreo").text('Aparir de '+combinaciones[combinacion_index].mayoreo_cantidad+' piezas '+formato_precio(combinaciones[combinacion_index].mayoreo_precio) );
              $("#mayoreo").removeClass('hide');
            }else{
              $("#mayoreo").addClass('hide');
            }
             
            if(combinaciones[combinacion_index].stock*1==0 && combinaciones[combinacion_index].comprar_sin_stock*1==0){
              $("#producto-data, #comprar").addClass('hide');
              $(".alert-warning").addClass('show');
              $(".alert-warning").text('Este producto ya no está en stock con estos atributos , pero está disponible con otros.');
              return;
            }else{
              if(combinaciones[combinacion_index].comprar_sin_stock==1){
                $(".box-stock").addClass('hide');  
              }else{
                 $(".box-stock").removeClass('hide'); 
              }
            }
            $(".alert-warning").removeClass('show');
            $(".alert-warning").text('');
            $("#producto-data, #comprar").removeClass('hide');
          }else{
            $("#producto-data, #comprar").addClass('hide');
            $(".alert-warning").addClass('show');
            $(".alert-warning").text('Esta combinacion no existe para este producto. Porvafor selecciona otra combinación.');
          }
}