<form action="" method="post" id="myform">
    <div class="row">
        <div class="col-md-12">
            <?php if(count($galeria->error->all)) {?>
            <div class="alert alert-danger">
                <?php echo $this->lang->line('alert_error'); ?>
            </div>
            <?php } ?>
            <?php if($this->session->flashdata('mensaje')) {?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('mensaje'); ?>
            </div>
            <?php } ?>
            <div class="btn-toolbar form-group">
                <?php if($this->acceso->valida('pagina','editar')) {?>
                <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/galeria/guardar/'.$galeria->id) ?>')">Guardar</button>
                <?php } ?>
                <?php if($galeria->id) {?>
                <a class="btn btn-primary" href="<?php echo base_url('modulo/galeria/agregar_imagen/'.$galeria->id) ?>">Agregar imagen</a>
                <?php } ?>
                <a class="btn btn-default" href="<?php echo base_url('modulo/pagina/listar') ?>">Regresar</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <blockquote>
                <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>
            
            <?php if($galeria->id) {?>
            <div class="form-group">
                <div id="contenedor_galeria">
                    <?php foreach ($imagenes as $value) {?>
                    <div class="control-group" style="margin-bottom:10px;">
                        <div class="input-group">
                            <span class="input-group-addon"><a href="<?php  ?>" class="remove_imagenes"> <i class="glyphicon glyphicon-trash"></i></a> </span>
                            <input class="trip" type="hidden" value="<?php echo $value->id ?>" name="slide[]">
                            <div class="form-control titulo"> <?php echo $value->title ?> </div>
                            <span class="input-group-addon"><a href="<?php echo base_url('modulo/galeria/editar_imagen/'.$galeria->id.'/'.$value->id.'') ?>" class="filemanager"> Editar </a></span>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</form>