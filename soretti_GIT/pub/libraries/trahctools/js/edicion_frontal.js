$(document).ready(function() {

  $('a').css('z-index','0');
  if(self != top){
     $("#menu-backend").hide();
  }
  if(opener!=null)
  {
    $("#menu-backend").hide();
  }
  

if($.cookie!=undefined) {
    if (($.cookie('texto'))=='abierto'){
      //Candado abierto
      $('#pad-lock').css('backgroundPosition','bottom');
      $('.zona-editable').css('display', 'none');
      $('.zona-editable:hover').css('display', 'none');
      $('.editable:hover > .zona-editable').css('display', 'none');
      $('.editable').css('display', 'none');
      $('.root > .tip-tools, .root > .tip-tools').css('display', 'none');
      $('.tip-tools').css('display', 'none');
      $('a').css('z-index','9');
      $('.foto').css('z-index','100');
      $.cookie('texto','abierto');
    }

    if ((($.cookie('texto'))=='cerrado') || (($.cookie('texto'))=='') || (($.cookie('texto'))=='undefined')){
      //Candado cerrado
      $('#pad-lock').css('backgroundPosition','top');
      $('.zona-editable').css('display', 'block');
      $('.zona-editable:hover').css('display', 'block');
      $('.editable:hover > .zona-editable').css('display', 'block');
      $('.editable').css('display', 'block');
      $('.root > .tip-tools, .root > .tip-tools').css('display', 'block');
      $('.tip-tools').css('display', 'block');
      $('a').css('z-index','0');
      $('.foto').css('z-index','0');
      $.cookie('texto','cerrado');
    }
}

  $('#pad-lock').click(function(event) {


    if($(this).css("backgroundPosition")=='50% 0%'){
      //Abre candado
      $(this).css('backgroundPosition','bottom');
      $('.zona-editable').css('display', 'none');
      $('.zona-editable:hover').css('display', 'none');
      $('.editable:hover > .zona-editable').css('display', 'none');
      $('.editable').css('display', 'none');
      $('.root > .tip-tools, .root > .tip-tools').css('display', 'none');
      $('.tip-tools').css('display', 'none');
      $('a').css('z-index','9');
      $('.foto').css('z-index','100');
      $.cookie('texto','abierto');

    }else{
      //Cierra candado
      $(this).css('backgroundPosition','top');
      $('.zona-editable').css('display', 'block');
      $('.zona-editable:hover').css('display', 'block');
      $('.editable:hover > .zona-editable').css('display', 'block');
      $('.editable').css('display', 'block');
      $('.root > .tip-tools, .root > .tip-tools').css('display', 'block');
      $('.tip-tools').css('display', 'block');
      $('a').css('z-index','0');
      $('.foto').css('z-index','0');
      $.cookie('texto','cerrado');
    }
  });

  $('#salircookie').click(function(event) {
      $.cookie('texto', null);
  });
  


$('.tip-tools').toolbar({
   content: '#user-options',
   position: 'bottom',
   hideOnClick: true
});

    $('.tool-item.status').click(function(){
      var url=$(this).attr('href');
      var instancia=$(this).attr('instancia');
      var action=$(this).attr('action');
      if(confirm('¿Esta seguro que desea llevar a cabo esta acción?'))
      {
        $.ajax({
          url: url,
          type: 'POST',
          data: {'action': action,'instancia': instancia, pagina:'mipagina' },
      })
        .done(function() {
          console.log("success");
          location.reload();
      })
        .fail(function() {
          console.log("error");
      }) 
    }
  });

  $('.tool-item.editar').click(function(){
      var url=$(this).attr('href');
      $.fancybox({
          type: 'iframe',
          width:'100%',
          href: url,
          afterClose: function(){
              window.location.reload();
          }
      });
  });

  $('.tool-item.eliminar').click(function(){
      var url=$(this).attr('href');
      if(confirm('¿Esta seguro que desea llevar a cabo esta acción?'))
      {
        $.ajax({
          url: url,
          type: 'POST',
          data: {},
      })
        .done(function() {
          console.log("success");
          location.reload();
      })
        .fail(function() {
          console.log("error");
      }) 
    }
  });
/*
  if((self==top)){
      $('.tip-tools').css( "display", "none" );
      $('.editable').css( "display", "none" );
  }
*/


});



function recargarFrame() {
  opener.location.reload();
}

