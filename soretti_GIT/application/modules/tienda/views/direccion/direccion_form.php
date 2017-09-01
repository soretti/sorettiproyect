<div class="row">
    <div class="col-md-12">
        <?php if(count($direccion->error->all)): ?>
        <div class="alert alert-danger">
            <?php echo $this->lang->line('alert_error'); ?>
        </div>
        <?php endif ?>
        <?php if($direccion->valid): ?>
        <div class="alert alert-success">
            <?php echo $this->lang->line('alert_save'); ?>
        </div>
        <?php endif ?>
        <div><h1>Mi Cuenta</h1>
            <div class="text-small form-group">Desde aquí puedes ver tus actividades recientes y actualizar la información de tu cuenta.</div>
            <div class="row">
                <div class="col-md-3">
                    <?php $this->load->view("tienda/cuenta/menu"); ?>
                </div>
                <div class="col-md-9">
                    <div class="encabezado"><?php echo $titulo; ?></div>
                    <div class="text-right" style="margin-bottom:50px;">
                    </div>
                    <form action="<?php echo base_url('tienda/direccion/formulario/'.$id)  ?>" method="post" id="direccionform">


                        <div class="form-group">
                            <label><span class="required">* </span> Tipo:</label>
                            <select name="tipo" class="form-control" id="" onChange="$(form).eq(0).submit();" >
                                <option value="">Seleccione una opción</option>
                                <option value="1" <?php if($direccion->tipo==1) echo "selected"; ?>>Entrega</option>
                                <option value="2" <?php if($direccion->tipo==2) echo "selected"; ?>>Facturación</option>
                            </select>
                            <span class="errores"><?php echo $direccion->error->tipo; ?></span>
                        </div>
                        <?php if($direccion->tipo==1) {?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><span class="required">* </span> Nombre</label>
                                    <input type="text" class="form-control" name="nombre" value="<?php echo $direccion->nombre ?>">
                                    <span class="errores"><?php echo $direccion->error->nombre; ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><span class="required">* </span> Apellido paterno</label>
                                    <input type="text" class="form-control" name="apellidoPaterno"  value="<?php echo $direccion->apellidoPaterno ?>">
                                    <span class="errores"><?php echo $direccion->error->apellidoPaterno; ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><span class="required"> </span> Apellido Materno</label>
                                    <input type="text" class="form-control" name="apellidoMaterno"  value="<?php echo $direccion->apellidoMaterno ?>">
                                    <span class="errores"><?php echo $direccion->error->apellidoMaterno; ?></span>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if($direccion->tipo==2) {?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span class="required">* </span> RFC</label>
                                    <input type="text" class="form-control" name="rfc" value="<?php echo $direccion->rfc ?>">
                                    <span class="errores"><?php echo $direccion->error->rfc; ?></span>
                                </div>
                            </div>
                            <div class="col-md-6    ">
                                <div class="form-group">
                                    <label><span class="required">* </span> Nombre o Razon social</label>
                                    <input type="text" class="form-control" name="razon_social"  value="<?php echo $direccion->razon_social ?>">
                                    <span class="errores"><?php echo $direccion->error->razon_social; ?></span>
                                </div>
                            </div> 
                        </div>
                        <?php } ?>
                        <?php if($direccion->tipo==1) {?>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><span class="required">* </span> Lada</label>
                                    <input type="text" class="form-control" name="lada" value="<?php echo $direccion->lada ?>" >
                                    <span class="errores"><?php echo $direccion->error->lada; ?></span>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label><span class="required">* </span> Teléfono</label>
                                    <input type="text" class="form-control" name="telefono" value="<?php echo $direccion->telefono ?>" >
                                    <span class="errores"><?php echo $direccion->error->telefono; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Celular</label>
                            <input type="text" name="celular" value="<?php echo $direccion->celular ?>" class="form-control" />
                            <span class="errores"><?php echo $direccion->error->celular; ?></span>
                        </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span class="required">* </span> Estado</label>
                                    <select class="form-control" name="estado_id" id="estado_select">
                                        <option value=""></option>
                                        <?php if(isset($estados)): ?>
                                        <?php foreach($estados as $estado): ?>
                                        <option value="<?php echo $estado->id ?>"<?php if($estado->id==$direccion->estado_id): ?> selected<?php endif ?>><?php echo $estado->titulo ?></option>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <span class="errores"><?php echo $direccion->error->estado_id; ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span class="required">* </span> Delegación/Muncipio</label>
                                    <div  id="municipio_container">
                                        <select class="form-control" id="municipio_select" name="municipio_id">
                                            <option value=""></option>
                                            <?php if(isset($municipios)): ?>
                                            <?php foreach($municipios as $municipio): ?>
                                            <option value="<?php echo $municipio->id ?>"<?php if($municipio->id==$direccion->municipio_id): ?> selected<?php endif ?>><?php echo $municipio->titulo ?></option>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                        <span class="errores"><?php echo $direccion->error->municipio_id; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span class="required">* </span> Colonia</label>
                                    <select class="form-control" name="colonia_id" id="colonia_select">
                                        <option value=""></option>
                                        <?php if(isset($colonias)): ?>
                                        <?php foreach($colonias as $colonia): ?>
                                        <option codigo="<?php echo $colonia->cp ?>" value="<?php echo $colonia->id ?>"<?php if($colonia->id==$direccion->colonia_id): ?> selected<?php endif ?>><?php echo $colonia->titulo ?></option>
                                        <?php endforeach; ?>
                                        <?php if($colonias->result_count()>0) {?><option value="n/a" codigo="" <?php if($direccion->colonia_id=='n/a' || $direccion->nombreColonia) echo "selected" ?> >Escribir manualmente mi colonia</option><?php } ?>
                                        <?php endif; ?>
                                    </select>
                                    <span class="errores"><?php echo $direccion->error->colonia_id; ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span class="required">* </span>Código Postal</label>
                                    <input type="text" name="codigo" value="<?php echo $direccion->codigo ?>" class="form-control" id="codigo_input" />
                                    <span class="errores"><?php echo $direccion->error->codigo; ?></span>
                                </div>
                            </div>
                            <div class="col-md-12 <?php if($direccion->colonia_id!='n/a' && !$direccion->nombreColonia) echo "hide" ?> " id="otraColonia">
                                <div class="form-group">
                                    <label><span class="required">* </span>Nombre de la colonia</label>
                                    <input type="text" name="nombreColonia" id="nombreColonia" class="form-control" value="<?php echo $direccion->nombreColonia ?>">
                                    <span class="errores"><?php echo $direccion->error->nombreColonia; ?></span>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><span class="required">* </span> Calle</label>
                            <input type="text" name="calle" value="<?php echo $direccion->calle ?>" class="form-control" />
                            <span class="errores"><?php echo $direccion->error->calle; ?></span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span class="required">* </span>Número exterior</label>
                                    <input type="text" name="numero_ext" value="<?php echo $direccion->numero_ext ?>" class="form-control" />
                                    <span class="errores"><?php echo $direccion->error->numero_ext; ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Número interior</label>
                                    <input type="text" name="numero_int" value="<?php echo $direccion->numero_int ?>" class="form-control" />
                                    <span class="errores"><?php echo $direccion->error->numero_int; ?></span>
                                </div>
                            </div>
                        </div>
                        <?php if($direccion->tipo==1) {?>
                        <div class="form-group">
                            <label>Persona que recibe</label>
                            <input type="text" name="suplente" value="<?php echo $direccion->suplente ?>" class="form-control" />
                            <span class="errores"><?php echo $direccion->error->suplente; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Referencia</label>
                            <input type="text" name="referencia" value="<?php echo $direccion->referencia ?>" class="form-control" />
                            <span class="errores"><?php echo $direccion->error->referencia; ?></span>
                        </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div><a href="<?php echo base_url('tienda/direccion/listar'); ?>"><< Regresar</a></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input class="btn btn-success" type="submit" name="enviar"  value="Guardar">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
    $("body").delegate('#estado_select','change',function(){
        $("#direccionform").submit();
    });
    $("body").delegate('#municipio_select','change',function(){
        $("#direccionform").submit();
    });
    $("body").delegate('#colonia_select','change',function(){
        $("#codigo_input").attr("value", $("option:selected",this).attr("codigo"));
        if($(this).val()=='n/a'){
            $("#otraColonia").removeClass('hide');
            $("#otraColonia").find('input').eq(0).focus();
        }else{
            $("#otraColonia").addClass('hide');
        }
    });
    </script>