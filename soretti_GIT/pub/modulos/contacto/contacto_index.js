function contacto(){
	$('#enviar-contacto').click(function(event) {
		event.preventDefault();
		$("#mcontacto").val('TRS6745-*1');
		$("#form-contacto").submit();
 	});
}
$(document).ready(function(){
	contacto();

	 $("#form-contacto input[name=boletin]").click(function(){
                if( $(this).is( ":checked" ) ){
                    $("#form-contacto #temas-de-interes").removeClass('hide');
                }else{
                     $("#form-contacto #temas-de-interes").addClass('hide');
                }
            });
});
