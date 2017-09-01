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


});
