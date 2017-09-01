<form action="" method="post" id="myform">
    <div class="row">
        <div class="col-md-12">
            <?php if(count($atributo->error->all) || count($valor->error->all)) {?>
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
                <?php if($this->acceso->valida('catalogo','editar')) {?>
                <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/catalogo/catalogoatributo/guardar/'.$atributo->id) ?>')">Guardar</button>
                <?php } ?>
                <a class="btn btn-default" href="<?php echo base_url('modulo/catalogo/catalogoatributo/listar') ?>">Regresar</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="tabs_catalogo">
                    <li class="active"><a href="#1" data-toggle="tab"> Contenido </a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="1">
                        <blockquote>
                            <small>Los campos marcados con (*) son requeridos</small>
                        </blockquote>
                        <div class="form-group">
                            <label>Nombre: * </label>
                            <input type="text" name="nombre" id="input-nombre" value="<?php echo $atributo->nombre; ?>" class="form-control">
                            <?php echo $atributo->error->nombre; ?>
                        </div>

                        <div class="form-group">
                            <label>Tipo: * </label>
                            <?php if($atributo->id): ?>
                            <?php echo $atributo->tipos[$atributo->tipo-1]; ?>
                            <input type="hidden" value="<?php echo $atributo->tipo ?>" name="tipo">
                            <?php else: ?>
                            <select class="form-control" name="tipo">
                                <option value="1"<?php if($atributo->tipo == 1) echo "selected" ?>><?php echo $atributo->tipos[0]; ?></option>
                                <option value="2"<?php if($atributo->tipo == 2) echo "selected" ?>><?php echo $atributo->tipos[1]; ?></option>
                                <option value="3"<?php if($atributo->tipo == 3) echo "selected" ?>><?php echo $atributo->tipos[2]; ?></option>
                            </select>
                            <?php echo $atributo->error->tipo; ?>
                        <?php endif; ?>
                    </div>
            </div>
        </div>
    </div>
</div>
</div>
</form>


<?php if($atributo->id): ?>
    <h3>Agregar valores</h3>
    <form action="<?php echo base_url('modulo/catalogo/catalogoatributo/guardarvalor/'.$atributo->id) ?>" method="post">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-toolbar">
                    <?php if($this->acceso->valida('catalogo','editar')): ?>
                    <button class="btn btn-success" type="submit">Guardar</button>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Nombre: * </label>
                <input type="text" name="nombre" value="<?php echo $valor->nombre; ?>" class="form-control">
                <?php echo $valor->error->nombre; ?>
            </div>
            <?php if($atributo->tipo == 3): ?>
            <div class="form-group">
                <label>Color: *</label>
                <input type='text' id="custom" />
                <input type='hidden' name="micolor" class="micolor" />
            </div>
            <script>
            $("#custom").spectrum({
                color: "#fff",
                change: function(color) {
                    console.log(color.toHexString());
                    $(".micolor").attr("value",color.toHexString());
                }
            });
            </script>
        <?php endif; ?>
    </div>
</div>
</form>

<h3>Ordenar valores</h3>
<form action="<?php echo base_url('modulo/catalogo/catalogoatributo/ordenarvalores/'.$atributo->id) ?>" method="post">
 <div class="row">
    <div class="col-md-12">
        <div class="btn-toolbar">
            <?php if($this->acceso->valida('catalogo','editar')): ?>
            <button class="btn btn-success" type="submit">Guardar</button>
        <?php endif; ?>
    </div>
</div>
</div>
<div class="row">
    <div class="col-md-12">
        <div id="contenedor_galeria row" class="sortable">
            <?php foreach($valores as $valor): ?>
            <div class="form-group">
                <div class="input-group col-md-6">
                    <span class="input-group-addon">
                        <a href="<?php echo base_url('modulo/catalogo/catalogoatributo/eliminarvalor/'.$atributo->id.'/'.$valor->id) ?>">
                            <span class="glyphicon glyphicon-trash "></span>
                        </a> 
                    </span>
                    <input type="hidden" value="<?php echo $valor->id ?>" name="valores_id[]">
                    <div class="form-control titulo"> <?php echo $valor->nombre ?> </div>
                    
                        <div class="input-group-addon" <?php if($valor->micolor): ?>style="background-color:<?php echo $valor->micolor ?>"<?php endif; ?>></div>
                    
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</div>
</form>

<?php endif; ?>