    function remove_items(){

        $(".popup").click(function(){
            group = $(this).parent().parent();
        });
        $(".popup").popupWindow({width:800,scrollbars:1,resizable:1,centerScreen:1} );

        $(".remove_imagenes").off('click');


        $(".remove_imagenes").click(function(event){
            event.preventDefault();
             var m=$(this).parent().next().val();  

            if(confirm('¿Está seguro de ejecutar esta acción?'))
            {
               

                $.ajax({
                    url: base_url+'modulo/bloque/eliminar_bloque',
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