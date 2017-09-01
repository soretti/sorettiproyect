function remove_items(){
    $(".remove_imagenes").off('click');
    $(".remove_imagenes").click(function(event){
        event.preventDefault();

        if(confirm('¿Está seguro de ejecutar esta acción?'))
        {
            m=$(this).parent().next().val();

            $.ajax({
                url: base_url+'modulo/galeria/eliminar',
                type: 'POST',
                data: {post_ids: m},
            });
            $(this).parent().parent().parent().remove();
        }
    });

    $( "#contenedor_galeria" ).sortable({ items: "> div.form-group" });
}
$(document).ready(remove_items);