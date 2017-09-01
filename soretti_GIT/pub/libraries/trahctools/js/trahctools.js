
function replaceAll( text, busca, reemplaza ){
  while (text.toString().indexOf(busca) != -1)
      text = text.toString().replace(busca,reemplaza);
  return text;
}


function friendly_url(str,max) {
if (max === undefined) max = 80;
  var a_chars = new Array(
    new Array("a",/[áàâãªÁÀÂÃ]/g),
    new Array("e",/[éèêÉÈÊ]/g),
    new Array("i",/[íìîÍÌÎ]/g),
    new Array("o",/[òóôõºÓÒÔÕ]/g),
    new Array("u",/[úùûÚÙÛ]/g),
    new Array("c",/[çÇ]/g),
    new Array("n",/[Ññ]/g)
  );
  for(var i=0;i<a_chars.length;i++)
    str = str.replace(a_chars[i][1],a_chars[i][0]);
  return str.replace(/\s+/g,'-').toLowerCase().replace(/[^a-z0-9\-]/g, '').replace(/\-{2,}/g,'-').replace(/(^\s*)|(\s*$)/g, '').substr(0,max);
}

function ini()
{
    $('a.confirm').click(function(event){
        event.preventDefault();
        if(confirm('¿Esta seguro de realizar esta acción?')){
          if($(this).attr('href').length){
            document.location=$(this).attr('href');
          }
        }else{
          return false;
        }
    });

    $('.checkall').click(function () {
        $(this).closest('table.grid').find(':checkbox').prop('checked', this.checked);
    });

    $(".titulo_campos").click(function(){
            $("#ordenar").val($(this).attr('campo'));
            document.forms[0].submit();
    });

    $("#search_button").click(function(event){
            $( "#action" ).val('search');
            if($("form#form-grid").length>0)
            {
                $("form#form-grid").submit();
                return;
            }
            document.forms[0].submit();
    });

    $(".submit").keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
             if($("form#form-grid").length>0)
            {
                $("form#form-grid").submit();
                return;
            }
            document.forms[0].submit();
        }
    });

    $("#buscador").keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            $( "#action" ).val('search');
            if($("form#form-grid").length>0)
            {
                $("form#form-grid").submit();
                return;
            }
            document.forms[0].submit();
        }
    });


    $(".seleccionados").click(function(event){
         var marcados;
         event.preventDefault();
         $("input[name='post_ids[]']").each(function(){
             if ($(this).prop("checked")==true) marcados=1;
         });

         // $("#action").val($(this).val());

        if(!marcados)
        {
            alert('Seleccione al menos un registro');
            return false;
        }

        if(!confirm('¿Esta seguro que desea llevar a cabo esta acción?'))
          {
             return false;
          }
          action=$(this).attr('href');
          goto(action);
          document.forms[0].submit();
    });

     $(".action_row").click(function(event){
        event.preventDefault();
        var index = $(this).parent().parent().index();
        $("input[name='post_ids[]']").prop( "checked", false );
        $("input[name='post_ids[]']").eq(index).prop( "checked", true );
        if(!confirm('¿Esta seguro que desea llevar a cabo esta acción?'))
        {
            $("input[name='post_ids[]']").eq(index).prop( "checked", false );
            return false;
        }
        $( "#action" ).val($(this).val());
            action=$(this).attr('href');
            goto(action)
            document.forms[0].submit();
    });

 $("#eliminar_form").click(function(event){
    if(!confirm('¿Esta seguro que desea llevar a cabo esta acción?')){
        return false;
    }
 });


}
$( document ).ready(function() {
    ini();
});


function goto(url,id_form) {
  id_form = typeof id_form !== 'undefined' ?  id_form : 'myform';
  $('#'+id_form).attr( 'action',url);
}

function recargar_frame()
{
    opener.location.reload();
}

$(document).ready(function() {
    $('.preview').click(function() {
        window.open('', 'formpopup', 'width=1000,height=700,resizeable,scrollbars');
        $('#myform').attr('action',$(this).attr('action') );
        $('#myform').attr('target','formpopup');

    });
});

function ChangePage(url){
  document.location=url;
}

jQuery(document).ready(function($) {
  $('a').css('z-index','0');
  if(self != top){
     $("#menu-backend").hide();
  }
  if(opener!=null)
  {
    $("#menu-backend").hide();
  }


});

 if (window.opener) {
        jQuery(document).ready(function($) {
                $(".seleccionar").click(function(){
                    if(opener.customFunctionSelect==1){
                        opener.customSelect(this,window);
                        return false;
                    }
                    contenedor=opener.group;
                    contenedor.find('.titulo').text($(this).attr('titulo'));
                    contenedor.find('.uri-input').val($(this).attr('uri'));
                    window.close();
                });
        });
}else{
  jQuery(document).ready(function($) {
      $(".seleccionar").hide();

      if ($('#gratis').is(':checked')) {
          $(".modulo-config").addClass('transparent');
          $(".opciones").prop( "disabled", true );
      }else{
          $(".modulo-config").removeClass('transparent');
          $(".opciones").prop( "disabled", false );
      }

  });

}

 function adicionar(){
    if ($('#gratis').is(':checked')) {
          $(".modulo-config").addClass('transparent');
          $(".opciones").prop( "disabled", true );
      }else{
          $(".modulo-config").removeClass('transparent');
           $(".opciones").prop( "disabled", false );
      }
}



function elFinderBrowser (field_name, url, type, win) {
      tinymce.activeEditor.windowManager.open({
        file: base_url+'/modulo/filemanager',
        title: 'elFinder 2.0',
        width: 900,
        height: 600,
        resizable: 'yes'
      }, {
        setUrl: function (url) {
          win.document.getElementById(field_name).value = url;
        }
      });
      return false;
    }

    config_tinymce={
                selector: "textarea.html-editable",
                content_css : base_url+"pub/theme/css/plantilla.css,"+base_url+"pub/libraries/bootstrap-3.2.0-dist/css/bootstrap.min.css",
                plugins: [
                        "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "table contextmenu directionality emoticons template textcolor paste textcolor autoresize table"
                ],
                language : "es",
                image_advtab: true,


                toolbar1: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | forecolor backcolor | styleselect formatselect fontselect fontsizeselect ",
                toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | inserttime",
                toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft",
                force_p_newlines : false,
                force_br_newlines : true,
                forced_root_block : '',
                menubar: false,
                file_browser_callback : elFinderBrowser,
                remove_script_host : false,
                        convert_urls : true,
                        relative_urls :false,
                document_base_url : base_url,
                toolbar_items_size: 'small',

                templates: [
                        {title: 'Test template 1', content: 'Test 1'},
                        {title: 'Test template 2', content: 'Test 2'}
                ]
  };
  config_tinymce_template={
                selector: "textarea.html-editable-template",
                content_css :"",
                plugins: [
                        "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "table contextmenu directionality emoticons template textcolor paste textcolor autoresize table"
                ],
                language : "es",
                image_advtab: true,
                toolbar1: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | forecolor backcolor | styleselect formatselect fontselect fontsizeselect ",
                toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image code",
                toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | ltr rtl | visualchars visualblocks | template",
                force_p_newlines : false,
                force_br_newlines : true,
                forced_root_block : '',
                menubar: false,
                file_browser_callback : elFinderBrowser,
                remove_script_host : false,
                convert_urls : true,
                relative_urls :false,
                document_base_url : base_url,
                toolbar_items_size: 'small',
                templates : base_url+"modulo/boletin/template/json_templates"
                // templates: [
                // {title: 'Test template 1', url: base_url+'modulo/boletin/template'},
                // {title: 'Test template 2', content: 'Test 2'}
                // ]
  };
  if (typeof(tinymce)!=undefined ){
    tinymce.init(config_tinymce);
    var template=tinymce.init(config_tinymce_template);
  }

function meta_titulo(obj){
       if(typeof obj != "undefined") return false;
       total= 70 - parseInt(obj.val().length);
       obj.prev().html('meta Titulo * <small class="text-muted"> '+total+' caracteres restantes</small>');
}function meta_descripcion(obj){
   if(typeof obj != "undefined") return false;
       total= 150 - parseInt(obj.val().length);
       obj.prev().html('meta Descripción * <small class="text-muted"> '+total+' caracteres restantes</small>');
}

$(document).ready(function()
{
      
    meta_titulo($( "#input-metatitulo" ));
      
    $( "#input-metatitulo" ).keyup(function(event) {
       meta_titulo($(this));
    });   

    meta_descripcion($( "textarea[name='descripcion']" ));
      
    $( "textarea[name='descripcion']"  ).keyup(function(event) {
       meta_descripcion($(this));
    });


    $( "#input-titulo" ).focusout(function() {
        if($( "#input-uri" ).val() == ""){
            $( "#input-uri" ).val( friendly_url( $(this).val() ) );
        }

        if($( "#input-metatitulo" ).length && $( "#input-metatitulo" ).val() == ""){
            $( "#input-metatitulo" ).val( $(this).val() );
        }

    });

    $( "#input-titulo-en" ).focusout(function() {
        if($( "#input-uri-en" ).val() == ""){
            $( "#input-uri-en" ).val( friendly_url( $(this).val() ) );
        }

        if($( "#input-metatitulo-en" ).length && $( "#input-metatitulo-en" ).val() == ""){
            $( "#input-metatitulo-en" ).val( $(this).val() );
        }

    });

      $(".popup").click(function()
      {
          input_file_selected = $(this).parent().prev();
      });
      $(".popup").popupWindow({width:800,scrollbars:1,resizable:1,centerScreen:1} );


    $('#palabras_clave').tagit({
            allowSpaces: true,
            singleField: true,
            singleFieldNode: $('#palabras_clave')
    });

    $('#palabras_clave_en').tagit({
            allowSpaces: true,
            singleField: true,
            singleFieldNode: $('#palabras_clave_en')
    });

     $.datepicker.regional['es'] = {
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            currentText: 'Hoy',
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
            closeText:'Aceptar',
            timeText: 'Time',
            hourText: 'Hora',
            minuteText: 'Minuto'
    };

    $('#fecha_creacion, #fecha_activacion, #fecha_desactivacion, #fecha_envio, #activacion_promocion, #desactivacion_promocion').datetimepicker({
        altFieldTimeOnly: false,
        dateFormat: "dd/mm/yy",
        monthNames:$.datepicker.regional[ "es" ].monthNames,
        currentText: $.datepicker.regional[ "es" ].currentText,
        dayNamesMin: $.datepicker.regional[ "es" ].dayNamesMin,
        closeText:$.datepicker.regional[ "es" ].closeText,
        timeText:$.datepicker.regional[ "es" ].timeText,
        hourText: $.datepicker.regional[ "es" ].hourText,
        minuteText: $.datepicker.regional[ "es" ].minuteText,
        onClose: function(dateText, inst){}
    });


    /*$(".admin-fancybox").fancybox();*/

    $(".admin-fancybox").fancybox({
      'width'       : '75%',
      'height'      : '75%',
      'autoScale'       : false,
      'transitionIn'    : 'none',
      'transitionOut'   : 'none',
      'type'        : 'iframe'
    });

});
jQuery(document).ready(function($) {

  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

  $('.nav-tabs a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $.cookie('last_tab', $(e.target).attr('href'));
    });

      var lastTab = $.cookie('last_tab');

      if (lastTab) {
          $('a[href=' + lastTab + ']').tab('show');
      } else {
           $('a[data-toggle="tab"]:first').tab('show');
      }


});
