<div class="row fila-top">
    <div class="col-md-12">
        <div class="slogan barra-azul text-center"><?php echo modules::run('menu'); ?></div>
        <div class="input-group buscador">
            <input type="text" class="form-control" id="input-search" placeholder="¿Qué estas buscando?" value="<?php if (isset($keyword) && $keyword) echo $keyword; ?>">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button" id="boton-search"><i class="fa fa-search"></i></button>
            </span>
        </div>
    </div>
</div>