    function remove_items(){

        $(".remove_imagenes").off('click');


        $(".remove_imagenes").click(function(event){
            event.preventDefault();

            if(confirm('¿Está seguro de ejecutar esta acción?'))
            {
                m=$(this).parent().next().val();  

                $.ajax({
                    url: base_url+'modulo/blog/blogcategorias/eliminar',
                    type: 'POST',
                    data: {post_ids: m},
                })
                .done(function() {
                    console.log("success 1");
                })
                .fail(function() {
                    console.log("error 1");
                })
                .always(function() {
                    console.log("complete 1");
                });
                $(this).parent().parent().parent().remove();
            }
        });
        $( ".sortable" ).sortable({ items: "> div.form-group" });
    }
    $(document).ready(remove_items);