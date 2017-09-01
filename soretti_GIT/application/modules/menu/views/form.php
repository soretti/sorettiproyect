<div class="row">
    <div class="col-md-12">
        <?php if(count($menu->error->all) || count($boton->error->all)) {?>
        <div class="alert alert-danger">
            <?php echo $this->lang->line('alert_error'); ?>
        </div>
        <?php } ?>
        <?php if($this->session->flashdata('alert_save')) {?>
        <div class="alert alert-success">
            <?php echo $this->session->flashdata('alert_save'); ?>
        </div>
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <form action="" method="post" id="menu">
            <legend>EDITAR MENU</legend>
            <div class="btn-toolbar form-group">
                <?php  echo '<button class="btn btn-success" id="guardar-menu" type="submit" onclick="goto(\''.base_url('modulo/menu/guardar/'.$menu->id).'\',\'menu\')">Guardar</button>'; ?>
            </div>
            <blockquote>
                <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>
            <div class="form-group">
                <label>Titulo *</label>
                <input type="text" name="titulo" value="<?php echo $menu->titulo ?>" class="form-control">
                <input type="hidden" name="deep" id="deep" value="<?php echo ($menu->profundidad) ? $menu->profundidad : '5'; ?>">
                <?php echo $menu->error->titulo; ?>
            </div>
            <?php if(in_array('en',$this->config->item('idiomas','proyecto'))) {?>
            <div class="form-group">
                <label>Titulo Inglés</label>
                <input type="text" name="titulo_en" value="<?php echo $menu->titulo_en ?>" class="form-control">
                <?php echo $menu->error->titulo_en; ?>
            </div>
            <?php } ?>
            <?php
            echo '<input type="hidden" id="nestable2-output" name="nestable2-output">';
            echo $menu->nestable_menu;
            ?>
        </form>
    </div>
    <div class="col-md-6">
        <?php if(!is_null($menu->id)): ?>
        <legend><?php echo ($boton->id) ? 'EDITAR BOTON' : 'AGREGAR BOTON' ?></legend>
        <form action="" method="post" id="boton">
            <div class="btn-toolbar form-group">
                <?php echo '<button class="btn btn-success" type="submit" onclick="goto(\''.base_url('modulo/menu/guardar_link/'.$menu->id.'/'.$boton->id).'\',\'boton\')">Guardar</button>'; ?>
            </div>
            <blockquote>
                <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>
            <div class="form-group">
                <label>Titulo *</label>
                <input type="text" name="titulo" value="<?php echo $boton->titulo ?>" class="form-control">
                <?php echo $boton->error->titulo; ?>
            </div>
<!--             <div class="form-group">
                <label>Texto</label>
                <input type="text" name="texto" value="<?php echo $boton->texto ?>" class="form-control">
                <?php echo $boton->error->texto; ?>
            </div> -->
             <?php if(in_array('en',$this->config->item('idiomas','proyecto'))) {?>
            <div class="form-group">
                <label>Titulo Inglés</label>
                <input type="text" name="titulo_en" value="<?php echo $boton->titulo_en ?>" class="form-control">
                <?php echo $boton->error->titulo_en; ?>
            </div>
            <div class="form-group">
                <label>Texto Inglés</label>
                <input type="text" name="texto_en" value="<?php echo $boton->texto_en ?>" class="form-control">
                <?php echo $boton->error->texto_en; ?>
            </div>
            <?php } ?>
            <div class="form-group">
                <label class="control-label">Link</label>
                <div class="input-group">
                    <input class="form-control" type="text" value="<?php echo $boton->link ?>" name="link">
                    <span class="input-group-addon"><a href="<?php echo base_url('modulo/link/agregar') ?>" class="popup"> Asistente </a></span>
                </div>
            </div>
            <div class="form-group">
                <label>Abrir la página en:</label>
                <select name="target" class="form-control">
                    <option value="_self">La misma ventana</option>
                    <option value="_blank" <?php if($boton->target== "_blank") echo 'selected' ?>>En una ventana nueva</option>
                </select>
            </div>
        </form>
        <?php endif; ?>
    </div>
</div>