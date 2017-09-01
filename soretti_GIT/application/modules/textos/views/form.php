<form action="" method="post" id="myform">
    
    <div class="row">
        <div class="col-md-12">
            <?php if(count($bloques->error->all)) {?>
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
                <?php if($this->acceso->valida('pagina','editar')) {?>
                <button class="btn btn-primary" type="submit" onclick="goto('<?php echo base_url('modulo/textos/guardar_bloque/'.$bloque->id.'/'.$bloques->id) ?>')">Guardar</button>
                <?php } ?>
                <a class="btn btn-default" href="<?php echo base_url('modulo/textos/editar/'.$bloque->id) ?>">Regresar</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#1" data-toggle="tab">Contenido</a></li>
                    <li class=""><a href="#2" data-toggle="tab">Inglés</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="1">
                        <blockquote>
                            <small>Los campos marcados con (*) son requeridos</small>
                        </blockquote>
                        
                        <!--<div class="form-group">
                            <label>Titulo: * </label>
                            <input type="text" name="titulo" value="<?php echo $bloques->titulo; ?>" class="form-control">
                            <input type="hidden" name="bloque_id" value="<?php echo $bloque->id; ?>">
                            <?php echo $bloques->error->titulo; ?>
                        </div> -->
                        <input type="hidden" name="bloque_id" value="<?php echo $bloque->id; ?>">
                        <div class="form-group">
                            <label>Texto: * </label>
                            <textarea name="texto" class="html-editable"><?php echo $bloques->texto; ?></textarea>
                            <?php echo $bloques->error->texto; ?>
                        </div>
                    </div>
                    <div class="tab-pane " id="2"> 
                         <div class="form-group">
                            <label>Texto:</label>
                            <textarea name="texto_en" class="html-editable"><?php echo $bloques->texto_en; ?></textarea>
                            <?php echo $bloques->error->texto_en; ?>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </form>