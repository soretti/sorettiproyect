
function contacto_inmediato(){
	$('#enviar-inmediato').click(function(event) {
      	event.preventDefault();
      	$('#contenedor-contactoinmediato').load(base_url+"contacto/inmediato #inner-contactoinmediato", { nombre: $('#f_nombre').val(), email: $('#f_email').val(),mcontacto:1, texto: $('#f_texto').val()  }, contacto_inmediato );
    });
}
$(document).ready(function(){
	contacto_inmediato();
});

