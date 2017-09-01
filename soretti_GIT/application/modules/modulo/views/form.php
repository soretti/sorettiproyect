<form action="" method="post" id="myform">
    <div class="row">
        <div class="col-md-12">
            <?php if(count($modulo->error->all)) {?>
            <div class="alert alert-danger">
                <?php echo $this->lang->line('alert_error'); ?>
            </div>
            <?php } ?>
            <?php if($this->session->flashdata('mensaje')) {?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('mensaje'); ?>
            </div>
            <?php } ?>
            <div class="btn-toolbar">
                <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/modulo/guardar/'.$modulo->id) ?>')">Guardar</button>
                <a class="btn btn-default" href="<?php echo base_url('modulo/modulo/listar') ?>">Regresar</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <blockquote>
                <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>
            <div class="form-group">
                <label>Nombre *</label>
                <input type="text" name="nombre" value="<?php echo $modulo->nombre ?>" class="form-control">
                <?php echo $modulo->error->nombre; ?>
            </div>
            <div class="form-group">
                <blockquote>
                    <small>Seleccionar columnas:</small>
                </blockquote>
                <?php
                $valores=explode(",",$modulo->columnas);
                $i=0; foreach($columna as $value) {?>
                <div> <input type="checkbox" name="columnas[]" value="<?php echo $value->id; ?>" <?php if(in_array($value->id, $valores)) echo 'checked';  ?>> <?php echo $value->nombre; ?></div>
                <?php $i++; } ?>
            </div>
        </div>
    </div>
</form>