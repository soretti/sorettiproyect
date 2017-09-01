var atributos = [];
var valores=[];

$( document ).ready(function() {
        reset_atributos();

        $("#contenedor-atributos").load(base_url+'catalogo/atributos_valores/'+$("#grupo-atributos").val() );

	 $("#grupo-atributos").change(function(event) {
	 	$("#contenedor-atributos").load(base_url+'catalogo/atributos_valores/'+$(this).val() );
	 });


  	$("#myform input[name=promocion]").click(function(){
	                if( $(this).is( ":checked" ) ){
	                    $("#myform #mostrar-precio").removeClass('hide');
	                }else{
	                     $("#myform #mostrar-precio").addClass('hide');
	                }
            	});

  	$(".txtNumbers").keydown(function(event) {
   if(event.shiftKey)
   {
        event.preventDefault();
   }

   if (event.keyCode == 46 || event.keyCode == 8)    {
   }
   else {
        if (event.keyCode < 95) {
          if (event.keyCode < 48 || event.keyCode > 57) {
                event.preventDefault();
          }
        }
        else {
              if (event.keyCode < 96 || event.keyCode > 105) {
                  event.preventDefault();
              }
        }
      }
   });


});


function add_attr(){

        var idcom=$("#myform select[name=atributos_name]").val();
        var tipo =$("#grupo-atributos option:selected").html();
        var idval=$("#myform select[name=atributos_valores]").val();
        var valor =$("#grupo-valores option:selected").html();

        result = jQuery.inArray(idval,atributos);
         if(result==-1){
              atributos.push(idval);//Arreglo de id de Atributos
              valores.push(idcom);//Arreglo de id de Valores
              $(".atributos").append("<option value='"+idval+"' valor='"+idcom+"'>"+tipo+": "+valor+"</option>");
              atributos.sort();
              valores.sort();
              console.log(valores);
              document.getElementById("arreglo").value = valores;
         }else{
             alert('Sólo se puede añadir una combinación según el tipo de atributo');
         }

}

function reset_atributos(){
          $(".atributos option").each(function(index, val) {
           atributos.push($(this).val());
         });

         $(".atributos option").each(function(index, val){
           valores.push($(this).attr('valor'));
         });
}
function del_attr(){

      var resp=$(".atributos option:selected").val();

      console.log(resp);

       if(resp!=undefined){
         atributos = [];
         valores = [];
         $(".atributos option:selected").remove();

        reset_atributos();

        }else{
           return false;
        }

        atributos.sort();
        valores.sort();
        $("#arreglo").val('');
        if(valores.length>0)$("#arreglo").val(valores);
}


 function NumCheck(e, field) {
    key = e.keyCode ? e.keyCode : e.which
    if (key == 8) return true
    if (key > 47 && key < 58) {
      if (field.value == "") return true
      regexp = /.[0-9]{10}$/
      return !(regexp.test(field.value))
    }
    if (key == 46) {
      if (field.value == "") return false
      regexp = /^[0-9]+$/
      return regexp.test(field.value)
    }
    return false
  }
