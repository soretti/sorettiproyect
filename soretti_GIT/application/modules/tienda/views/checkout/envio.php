<div class="acc_item<?php if($this->session->userdata('checkout_paso') && $this->session->userdata('checkout_paso') == 1): ?> activo <?php endif; ?>">
    <a name="datosEnvio"></a>
    <div class="acc_pestana">1. Información de envío </div>

    <?php if($this->session->userdata('checkout_paso') && $this->session->userdata('checkout_paso') == 1): ?>

    <div class="acc_body col-md-12">
        <form action="<?php echo site_url('tienda/checkout/mostrar') ?>" method="post" id="direccionform">
            <div class="form-group">
                <label>Dirección de envio</label>
                <select class="form-control" id="direccion_envio_select" name="direccion_id">
                    <?php foreach ($direcciones as $key => $d): ?>
                        <option value="<?php echo $d->id ?>" <?php echo ($d->id==$direccion_id)?'selected':''; ?>><?php echo $d->estado->titulo ?> <?php echo $d->municipio->titulo ?> <?php echo $d->calle; ?>  <?php echo $d->numero_ext; ?></option>
                    <?php endforeach; ?>
                    <option value="nueva_direccion" <?php echo ($direccion_id=="nueva_direccion")?'selected':''; ?>>+ Nueva Dirección</option>
                </select>
            </div>

            <?php if($direccion_id=="nueva_direccion" || !$direcciones->result_count()): ?>
            <div id="direccion_fields">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><span class="required">* </span> Nombre</label>
                            <input type="text" class="form-control" name="nombre" value="<?php echo $direccion->nombre ?>">
                            <?php echo $direccion->error->nombre; ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><span class="required">* </span> Apellido paterno</label>
                            <input type="text" class="form-control" name="apellidoPaterno"  value="<?php echo $direccion->apellidoPaterno ?>">
                            <?php echo $direccion->error->apellidoPaterno; ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><span class="required"> </span> Apellido materno</label>
                            <input type="text" class="form-control" name="apellidoMaterno"  value="<?php echo $direccion->apellidoMaterno ?>">
                            <?php echo $direccion->error->apellidoMaterno; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><span class="required">* </span> Lada</label>
                            <input type="text" class="form-control" name="lada" value="<?php echo $direccion->lada ?>" >
                            <?php echo $direccion->error->lada; ?>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <label><span class="required">* </span> Teléfono</label>
                            <input type="text" class="form-control" name="telefono" value="<?php echo $direccion->telefono ?>" >
                            <?php echo $direccion->error->telefono; ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Celular</label>
                    <input type="text" name="celular" value="<?php echo $direccion->celular ?>" class="form-control" />
                    <?php echo $direccion->error->celular; ?>
                </div>

                <div class="row"><a name="estadoCiudad"></a>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><span class="required">* </span> Estado/Provincia</label>
                            <select class="form-control" name="estado_id" id="estado_select">
                                <option value=""></option>
                                <?php foreach($estados as $e): ?>
                                <option value="<?php echo $e->id ?>"<?php if($e->id==$estado_id): ?> selected<?php endif ?>><?php echo $e->titulo ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php echo $direccion->error->estado_id; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><span class="required">* </span> Ciudad, delegación, muncipio</label>
                            <div  id="municipio_container">
                                <select class="form-control" id="municipio_select" name="municipio_id">
                                    <option value=""></option>
                                    <?php foreach($municipios as $m): ?>
                                    <option value="<?php echo $m->id ?>"<?php if($m->id==$municipio_id): ?> selected<?php endif ?>><?php echo $m->titulo ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php echo $direccion->error->municipio_id; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row"> <a name="colonia"></a>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><span class="required">* </span> Colonia <a href="" id="micolonia"> click aquí para escribir manualmente mi colonia</a></label>
                            <select class="form-control" name="colonia_id" id="colonia_select">
                                <option value=""></option>
                                <?php if(isset($colonias)): ?>
                                <?php foreach($colonias as $colonia): ?>
                                <option codigo="<?php echo $colonia->cp ?>" value="<?php echo $colonia->id ?>"<?php if($colonia->id==$colonia_id): ?> selected<?php endif ?>><?php echo $colonia->titulo ?></option>
                                <?php endforeach; ?>
                                        <?php if($colonias->result_count()>0) {?><option value="n/a" codigo="" <?php if($colonia_id=='n/a' || $direccion->nombreColonia) echo "selected" ?> >Escribir manualmente mi colonia</option><?php } ?>
                                <?php endif; ?>
                            </select>
                            <?php echo $direccion->error->colonia_id; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><span class="required">* </span>Código Postal</label>
                            <input type="text" name="codigo" value="<?php echo $codigo_postal ?>" class="form-control" id="codigo_input" />
                            <?php echo $direccion->error->codigo; ?>
                        </div>
                    </div>
                    <div class="col-md-12 <?php if($colonia_id!='n/a' && !$nombreColonia) echo "hide" ?> " id="otraColonia">
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
                    <?php echo $direccion->error->calle; ?>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><span class="required">* </span>Número exterior</label>
                            <input type="text" name="numero_ext" value="<?php echo $direccion->numero_ext ?>" class="form-control" />
                            <?php echo $direccion->error->numero_ext; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Número interior</label>
                            <input type="text" name="numero_int" value="<?php echo $direccion->numero_int ?>" class="form-control" />
                            <?php echo $direccion->error->numero_int; ?>
                        </div>
                    </div>
                </div>

<!--                 <div class="form-group">
                    <label>Persona que recibe</label>
                    <input type="text" name="suplente" value="<?php echo $direccion->suplente ?>" class="form-control" />
                    <?php echo $direccion->error->suplente; ?>
                </div> -->

                <div class="form-group">
                    <label>Referencia</label>
                    <input type="text" name="referencia" value="<?php echo $direccion->referencia ?>" class="form-control" />
                    <?php echo $direccion->error->referencia; ?>
                </div>

            </div>
            <?php endif; ?>

            <div style="border-top:1px solid #D9D9D9; margin:30px 0;"></div>

            <div class="row">
                <div class="col-md-6">
                    <span class="required">*<i>Campos requeridos</i></span>
                </div>
                <div class="col-md-6" style="text-align:right">
                    <input type="submit" name="guardar_direccion" class="btn btn-primary" value="Continuar">
                </div>
            </div>


        </form>
    </div>


<script>

$("body").delegate('#direccion_envio_select','change',function(){
    $("#direccionform").attr('action',$("#direccionform").attr('action')+'#datosEnvio');
    $("#direccionform").submit();
});

$("body").delegate('#estado_select','change',function(){
     $("#direccionform").attr('action',$("#direccionform").attr('action')+'#estadoCiudad');
    $("#direccionform").submit();
});

$("body").delegate('#municipio_select','change',function(){
    $("#direccionform").attr('action',$("#direccionform").attr('action')+'#estadoCiudad');
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

$("body").delegate('#micolonia','click',function(event){
        event.preventDefault();
        $("#colonia_select").val('n/a');
        $("#otraColonia").removeClass('hide');
        $("#otraColonia").find('input').eq(0).focus();
});

</script>
<?php endif; ?>

</div>


