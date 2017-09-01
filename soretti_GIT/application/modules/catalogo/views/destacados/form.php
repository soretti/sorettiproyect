<script>
    var customFunctionSelect=1;

    function customSelect(obj,window)
    {
        html='<div class="form-group">'+
             '<div class="input-group col-md-6">'+
              '<span class="input-group-addon"><a href="#" class="remove_imagenes"> <i class="glyphicon glyphicon-trash"></i></a> </span>'+
              '<input type="hidden" value="'+$(obj).attr('value')+'" name="destacados[]">'+
              '<div class="form-control titulo">'+$(obj).attr('titulo')+'</div>'+
              '<span class="input-group-addon"><a href="'+base_url+'modulo/catalogo/editar/'+$(obj).attr('value')+'" class="filemanager popup"> Editar </a></span>'+
            '</div>'+
        '</div>';
        $("#contenedor_galeria").prepend(html);
        remove_items();
        window.close();
    }

    function remove_items()
    {
        $(".popup").popupWindow({width:800,scrollbars:1,resizable:1,centerScreen:1} );
        $(".remove_imagenes").off('click');
        $(".remove_imagenes").click(function(event){
            event.preventDefault();
            if(confirm('¿Está seguro de ejecutar esta acción?'))
            {
                $(this).parent().parent().parent().remove();
            }
        });
        $( "#contenedor_galeria" ).sortable({ items: "> div.form-group" });
    }
    $(document).ready(remove_items);
</script>
<form action="" method="post" id="myform">
    <?php if($this->session->flashdata('mensaje')) {?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('mensaje'); ?>
    </div>
    <?php } ?>
    <div class="row">
        <div class="col-md-12">
            <div class="btn-toolbar" contenedor="contenedor_galeria">
                <button class="btn btn-primary" type="submit" onclick="goto('<?php echo base_url('modulo/catalogo/catalogoDestacados/guardar/'.$seccion) ?>')">Guardar</button>
                <span class="add-on">
                    <a href="<?php echo base_url('modulo/catalogo/listar') ?>" class="btn btn-success filemanager popup">Agregar</a>
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <blockquote>
                <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>
            <div id="contenedor_galeria">
                <?php foreach ($item as $destacado) {?>
                    <div class="form-group">
                        <div class="input-group col-md-6">
                            <span class="input-group-addon"><a href="#" class="remove_imagenes"> <i class="glyphicon glyphicon-trash"></i></a> </span>
                            <input type="hidden" value="<?php echo $destacado->producto_id ?>" name="destacados[]">
                            <div class="form-control titulo"> <?php echo character_limiter( $destacado->producto_titulo,60 ) ?> </div>
                            <span class="input-group-addon"><a href="<?php echo base_url('modulo/catalogo/editar/'.$destacado->producto_id); ?>" class="filemanager popup"> Editar </a></span>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</form>
