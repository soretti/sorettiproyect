/*Cuenta JS*/

function registro(){

        $('#submit_tienda').click(function(event) {
            event.preventDefault();
            $("#tienda_registro").val('TRS6745-*1');
            $("#form-tienda").submit();
        });

        $('#submit_editar').click(function(event) {
            event.preventDefault();
            $("#tienda_registro").val('TRS6745-*1');
            $("#form-editar").submit();
        });

}

$(document).ready(function(){

     var elementos = $(".grupos").length;
     var totalcheck=$("input[name='grupos[]']:checked").length;

    registro();

     $("#form-tienda input[name=boletin]").click(function(){
                    if( $(this).is( ":checked" ) ){
                        $("#form-tienda #temas-de-interes").removeClass('hide');
                    }else{
                         $("#form-tienda #temas-de-interes").addClass('hide');
                    }
                });

     $("#form-editar input[name=pass]").click(function(){
                    if( $(this).is( ":checked" ) ){
                        $("#form-editar #cambiar-contrasena").removeClass('hide');
                    }else{
                         $("#form-editar #cambiar-contrasena").addClass('hide');
                    }
                });

     $("#marcarTodo").change(function() {
            if ($(this).is(':checked')) {
                $("input[type=checkbox]").prop('checked', true);
            } else {
                $("input[type=checkbox]").prop('checked', false);
            }
    });
 

    $("input[name=inlineRadioOptions]").change(function () {
         if($(this).val()=='option1'){
            $("#form-grupo .grupos-interes").removeClass('hide');
         }else{
            $("#form-grupo .grupos-interes").addClass('hide');
         }
    });

    $("input[name='grupos[]']:checked").each(
          function() {
            if(totalcheck==elementos){
                    $("#marcarTodo").prop('checked', true);
            }
          }
    );


    $("#section-catalogo-button").mouseover(function(){
        $(this).css('background-color','#85A327');
        $('#section-catalogo-button a').css('color','#ffffff');
        $('#section-catalogo-button img').attr("src",$(this).attr('imgDos'));

    });
    
    if($('#camera_wrap_1').length){
         $('#camera_wrap_1').camera({
          fx: 'simpleFade',
          loader: 'none',
          playPause: false,
          pagination: true,
          height:'25%'
      });   
    }


     $("#section-catalogo-button").mouseout(function(){
        $(this).css('background-color','#ffffff');
        $('#section-catalogo-button a').css('color','#85A327');
        $('#section-catalogo-button img').attr("src",$(this).attr('imgUno'));
    });
           
});

/**/



/*CONTACTO INDEX*/
function contacto(){
    $('#enviar-contacto').click(function(event) {
         event.preventDefault();
         console.log('llego');
         return 1;
        // $("#mcontacto").val('TRS6745-*1');
        // $("#form-contacto").submit();
    });
}
$(document).ready(function(){
    //contacto();

     $("#form-contacto input[name=boletin]").click(function(){
                if( $(this).is( ":checked" ) ){
                    $("#form-contacto #temas-de-interes").removeClass('hide');
                }else{
                     $("#form-contacto #temas-de-interes").addClass('hide');
                }
            });
});

/**/


/*CONTACTO INMEDIATO*/

function contacto_inmediato(){
    $('#enviar-inmediato').click(function(event) {
        event.preventDefault();
        $('#contenedor-contactoinmediato').load(base_url+"contacto/inmediato #inner-contactoinmediato", { nombre: $('#f_nombre').val(), email: $('#f_email').val(),mcontacto:1, texto: $('#f_texto').val()  }, contacto_inmediato );
    });
}
$(document).ready(function(){
    contacto_inmediato();
});
/**/
/*Ficha*/
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
/**/



var owl;
var owlProductos;

jQuery(document).ready(function($) {


    $("#suscribirse").click(function(){
        $("#mnewsletter").val('TRS6745-*1');
        action = $("#formulario-newsletter").find("form").eq(0).attr("action");
        $("#formulario-newsletter").load(action+" #formulario-newsletter-inner", $("#formulario-newsletter").find("form").eq(0).serializeArray());
    });

    $("#suscribe_sendblaster").click(function(event){
        event.preventDefault();
        $("#mnewsletterf").val('TRS6745-*1');
        $.ajax({
            url: base_url+'/boletin/newsletter/suscribe_sendblaster',
            type: 'POST',
            dataType: 'json',
            data: $("#boletin").serialize(),
        })
        .done(function(data) {
            if(data.error) alert(data.error);
            if(data.enviado) alert(data.enviado);
            console.log("success");
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        
    });


    owl=$('.owl-carousel').owlCarousel({
            loop:true,
            margin:30,
            nav:true,
            responsiveClass:true,
            responsive:{
                0:{items:1},
                600:{items:2},
                1000:{items:3 }
            }
    });

    owlProductos=$('.owl-carousel-productos').owlCarousel({
            loop:true,
            margin:30,
            nav:true,
            responsiveClass:true,
            responsive:{
                0:{items:1},
                490:{items:2},
                560:{items:3},
                1000:{items:4 }
            },
            navText: [ '<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>' ]
    });
    
    owlMarcas=$('.owl-carousel-marcas').owlCarousel({
            loop:true,
            margin:30,
            nav:true,
            responsiveClass:true,
            responsive:{
                0:{items:3},
                769:{items:4},
                1000:{items:6 }
            },
            navText: [ '<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>' ]
    });

     $('#pinterest_grid').pinterest_grid({
        no_columns: 3,
        padding_x: 0,
        padding_y: 0,
        margin_bottom: 50,
        single_column_breakpoint: 700
    });

     $('#pinterest_grid_categorias').pinterest_grid({
        no_columns: 3,
        padding_x: 0,
        padding_y: 0,
        margin_bottom: 50,
        single_column_breakpoint: 700
    });

     $('#pinterest_grid_productos').pinterest_grid({
        no_columns: 4,
        padding_x: 0,
        padding_y: 0,
        margin_bottom: 50,
        single_column_breakpoint: 700
    });

    // $("a.ficha_thumb").click(function(event) {
    //     event.preventDefault();
    //     $('#foto_ficha').attr('src',$(this).attr('foto-sm'));
    //     $('#img-fancy').attr('href',$(this).attr('href'));
    // });


    $("a.fancy").fancybox();

    // $("#boton-search").click(function(){
    //     document.location=base_url+'buscador/'+$('#input-search').val();
    // });
    // $('#input-search').keyup(function (event) {
    //         if (event.keyCode == '13') {
    //             document.location=base_url+'buscador/'+$('#input-search').val();
    //         }
    //         return false;
    // });

    $("#boton-search").click(function(){
        document.location=base_url+'buscador/'+$('#input-search').val();
    });

    $('#input-search').keyup(function (event) {
            if (event.keyCode == '13') {
                document.location=base_url+'buscador/'+$('#input-search').val();
            }            return false;
    });

    $(".menu-princial").find("li.active").eq(0).parents().addClass('active');

    $("a[rel=producto]").fancybox({
        'transitionIn'      : 'none',
        'transitionOut'     : 'none',
        'titlePosition'     : 'over',
        'titleFormat'       : function(title, currentArray, currentIndex, currentOpts) {
            return '<span id="fancybox-title-over">Image ' +  (currentIndex + 1) + ' / ' + currentArray.length + ' ' + title + '</span>';
    }});

    $(".categorias").click(function(event) {
       if($(window).width()<992) $(".menu-categorias-vertical").toggle("fast");
    });

    $(".fancybox-frame").fancybox({
        'type': 'iframe',
        width       : '60%',
        height      : '60%'
    });

    $("#form-contacto input[name=boletin]").click(function(){
        if( $(this).is( ":checked" ) ){
            $("#form-contacto #temas-de-interes").removeClass('hide');
        }else{
             $("#form-contacto #temas-de-interes").addClass('hide');
        }
    });


});

function formato_precio(total) {
    var neg = false;
    if(total < 0) {
        neg = true;
        total = Math.abs(total);
    }
    return (neg ? "-$ " : '$ ') + parseFloat(total, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
}


$(document).ready(function(){
    $("#zoom_03").elevateZoom({
        gallery:'gallery_01',
        cursor: 'pointer',
        galleryActiveClass: "active",
        imageCrossfade: true,
        lensSize : 200,
        scrollZoom : true,
        loadingIcon: "http://www.elevateweb.co.uk/spinner.gif"
    });

    $("#zoom_03").bind("click", function(e) {
        var ez =   $('#zoom_03').data('elevateZoom');
        ez.closeAll(); //NEW: This function force hides the lens, tint and window
        $.fancybox(ez.getGalleryList());
        return false;
    });
});



jQuery(document).ready(function($) {
       var enviando=0;

       $(".solicitar_cotizacion").click(function(){ 
             $('#paqueteid').val($(this).attr('item-articulo')); 
             $('#modal-asunto-titulo').html($(this).attr('asunto-titulo'));

       });

     $("#btn-informacion-producto").click(function(){

          if(enviando==1){
             return false;
          }

          enviando=1;

          $.ajax({

            url: $(this).attr('href')+'/'+$('#paqueteid').val(),

            type: 'POST',

            dataType: 'json',

            data: { privacidad:$("#privacidad").serialize(),boletin:$("#boletin").serialize(),grupos:$("input[name='grupos[]']").serializeArray(),nombre: $("#nombre_f").val(), email: $("#email_f").val(), telefono: $("#telefono_f").val(), lada: $("#lada_f").val(), texto: $("#texto_f").val(), email_field_f:$("#texto_f").val(),mcontacto:'TRS6745-*1'  },

          })

          .done(function(data) {
            
            enviando=0;

            if(data.error){

              alert(data.error);

            }

            if(data.enviado){

             $("#cotizacion-body").prepend('<div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <strong>Su solicitud se envio correctamente</strong> en breve nos pondremos en contacto con usted</div>')

            }

          });
    });
 });

// jQuery(document).ready(function($) {
  
//   $(window).scroll(function() {
//     if ($(this).scrollTop() > 200){  
//         $('#menu-principal').addClass("sticky");
//         $('.img-logo').attr('width',120);
//         // console.log("Hola mundo 1")
//       }
//       else{
//         $('#menu-principal').removeClass("sticky");
//         $('.img-logo').attr('width',140);
//         // console.log("Hola mundo 2")
//       }
//   });

// });
// 
// 
