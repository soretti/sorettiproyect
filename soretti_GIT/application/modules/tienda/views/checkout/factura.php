<div class="acc_item<?php if($this->session->userdata('checkout_paso') && $this->session->userdata('checkout_paso') == 3): ?> activo <?php endif; ?>">
    <a name="datosFactura"></a>
    <div class="acc_pestana">
        3.       DATOS DE FACTURACIÓN
    </div>
    <?php if($this->session->userdata('checkout_paso') && $this->session->userdata('checkout_paso') == 3): ?>
    <div class="acc_body col-md-12">
        <form method="post" action="<?php echo site_url('tienda/checkout/mostrar')  ?>" id="facturaform">
            <div class="form-group">
                <div class="radio">
                    <label><input type="radio" name="factura_requerida" value="0" <?php if(!$this->input->post("factura_requerida")){echo "checked";} ?>> No deseo factura</label>
                </div>
            </div>
            <div class="form-group">
                <div class="radio">
                    <label><input type="radio" name="factura_requerida" value="1" <?php if($this->input->post("factura_requerida")){echo "checked";}  ?>> Deseo factura</label>
                </div>
            </div>
            <?php if($this->input->post("factura_requerida") == 1): ?>
                    <div class="form-group">
                        <label>Direcciones de facturación</label>
                        <select class="form-control" id="direccion_envio_select" name="direccion_id">
                            <?php foreach ($direcciones as $key => $dir): ?>
                            <option value="<?php echo $dir->id ?>" <?php echo ($dir->id==$this->input->post("direccion_id"))?'selected':''; ?>><?php echo $dir->rfc ?> <?php echo $dir->razon_social ?></option>
                            <?php endforeach; ?>
                            <option value="nueva_direccion" <?php echo ("nueva_direccion"==$this->input->post("direccion_id"))?'selected':''; ?>>+ Una Nueva Dirección</option>
                        </select>
                    </div>

            <?php if($this->input->post("direccion_id")=="nueva_direccion" || !$direcciones->result_count() ): ?>
            <div class="row">
                <div class="col-md-12"> 

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span class="required">* </span> RFC</label>
                                    <input type="text" class="form-control" name="rfc" value="<?php echo  $this->input->post('rfc');?>">
                                    <?php echo $direccion->error->rfc ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span class="required">* </span> Razón Social</label>
                                    <input type="text" class="form-control" name="razon_social" value="<?php echo  $this->input->post('razon_social');?>">
                                    <?php echo $direccion->error->razon_social ?>
                                </div>
                            </div>
                        </div>    
                </div>
            <?php if($this->input->post("direccion_id")=="nueva_direccion" || !$direcciones->result_count() ){ ?>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Misma direccion que:</label>
                        <select name="direccion_select_factura" id="" class="form-control" onchange="$(form).eq(0).submit();">
                            <option value="">Seleccione una opción</option>
                            <?php foreach ($direcciones_list as $item) {?>
                            <option value="<?php echo $item->id ?>" <?php if($item->id==$this->input->post('direccion_select_factura')) echo "selected" ?>><?php echo $item->estado->titulo ?> <?php echo $item->municipio->titulo ?> <?php echo $item->calle ?> <?php echo $item->numero_ext ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            <?php } ?>
                <div class="col-md-6"><a name="estadoCiudadFactura"></a>
                    <div class="form-group">
                        <label><span class="required">* </span> Estado/Provincia</label>
                        <select class="form-control" name="estado_id" id="estado_select">
                            <option value=""></option>
                            <?php foreach($estados as $e): ?>
                            <option value="<?php echo $e->id ?>"<?php if($e->id==$this->input->post('estado_id')): ?> selected<?php endif ?>><?php echo $e->titulo ?></option>
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
                                <option value="<?php echo $m->id ?>"<?php if($m->id==$this->input->post('municipio_id')): ?> selected<?php endif ?>><?php echo $m->titulo ?></option>
                                <?php endforeach; ?>
                                
                            </select>
                            <?php echo $direccion->error->municipio_id; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><span class="required">* </span> Colonia <a href="" id="micolonia"> click aquí para escribir manualmente mi colonia</a></label>
                        <select class="form-control" name="colonia_id" id="colonia_select">
                            <option value=""></option>
                            
                            <?php foreach($colonias as $colonia): ?>
                            <option codigo="<?php echo $colonia->cp ?>" value="<?php echo $colonia->id ?>"<?php if($colonia->id==$this->input->post('colonia_id')): ?> selected<?php endif ?>><?php echo $colonia->titulo ?></option>
                            <?php endforeach; ?>
                            <?php if($colonias->result_count()>0) {?><option value="n/a" codigo="" <?php if($colonia_id=='n/a' || $direccion->nombreColonia) echo "selected" ?> >Escribir manualmente mi colonia</option><?php } ?>
                            
                        </select>
                        <?php echo $direccion->error->colonia_id; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><span class="required">* </span>Código Postal</label>
                        <input type="text" name="codigo" value="<?php echo $direccion->codigo ?>" class="form-control" id="codigo_input" />
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
            <?php endif; ?>
            <?php endif; ?>
            <div style="border-top:1px solid #D9D9D9; margin:30px 0;"></div>
            <div class="row">
                <div class="col-md-6">
                    <span class="required">*<i>Campos requeridos</i></span><br>
                    <a style="text-decoration:underline" href="<?php echo base_url('tienda/checkout/regresar/2') ?>">< Regresar</a>
                </div>
                <div class="col-md-6" style="text-align:right">
                    <input type="submit" name="guardar_direccion_fiscal" class="btn btn-primary" value="Continuar">
                </div>
            </div>
        </form>
    </div>
    <script>
    $('input:radio[name="factura_requerida"]').change(function(){
     $('#facturaform').submit();
    });

    $("body").delegate('#direccion_envio_select','change',function(){
         $("#facturaform").attr('action',$("#facturaform").attr('action')+'#datosFactura');
        $("#facturaform").submit();
    });

    $("body").delegate('#estado_select','change',function(){
        $("#facturaform").attr('action',$("#facturaform").attr('action')+'#estadoCiudadFactura');
        $("#facturaform").submit();
    });

    $("body").delegate('#municipio_select','change',function(){
        $("#facturaform").attr('action',$("#facturaform").attr('action')+'#estadoCiudadFactura');
        $("#facturaform").submit();
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