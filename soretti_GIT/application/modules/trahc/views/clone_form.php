<form action="" method="post" id="myform">
    <div class="row">
        <div class="col-md-12">
            <?php if(count(${{object_modelo}}->error->all)) {?>
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
                <?php if($this->acceso->valida('{{object_modelo}}','editar')) {?>
                <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/{{object_modelo}}/guardar/'.${{object_modelo}}->id) ?>')">Guardar</button>
                <?php } ?>
                <a class="btn btn-default" href="<?php echo base_url('modulo/{{object_modelo}}/listar') ?>">Regresar</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            
            <blockquote>
                <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>
            {{form}}
            
            
        </div>
    </div>
</form>