<div class="form-registro">

        <h5>Registro y solicitud de servicios</h5>
        
        
        <a name="contacto"></a>
        <form action="<?php echo current_url()."#contacto"; ?>" method="POST" id="form-contacto" enctype="multipart/form-data" >
        <div class="modulo contacto-inmediato" id="contenedor-contacto">
            <div id="inner-contacto">
                <div class="contenido">
                    <?php if( validation_errors() ) {?>
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $this->lang->line('alert_error'); ?>
                    </div>
                    <?php } ?>
                    <?php if($enviado) {?>
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Gracias por registrarte.</strong> Hemos recibido tu información...
                    </div>
                    <?php } else { ?>

                    <div class="form-group">
                        <!-- <label for="">Tipo de servicio requerido: * </label> -->
                        <select class="form-control input-sm" name="tipo_sevicio" >
                            <option value="">Servicio requerido por la empresa: * </option>
                            <option value="opcion i" <?php if($this->input->post('tipo_sevicio')=='opcion i') echo "selected" ?>>Opcion I</option>
                        </select>
                        <span class="errores"><?php echo form_error('tipo_sevicio'); ?></span>
                    </div>   

                        <h5>Detalle de la especialidad</h5>
                        
                            <div class="form-group">
                                <!-- <label for="">Titulo ó  nombre de laposición ó  cargo requerido: * </label> -->
                                <input type="text" id="form-titulo" class="form-control input-sm" name="titulo" value="<?php echo $this->input->post('titulo'); ?>" placeholder="Título de la posición requerida por la empresa: *"/>
                                <span class="errores"><?php echo form_error('titulo'); ?></span>
                            </div>

                            <div class="form-group">
                                <!-- <label for="">Lugar de trabajo: * </label> -->
                                <input type="text" id="form-lugar_trabajo"  class="form-control input-sm" name="lugar_trabajo" value="<?php echo $this->input->post('lugar_trabajo'); ?>" placeholder="Lugar de trabajo: * "/>
                                <span class="errores"><?php echo form_error('lugar_trabajo'); ?></span>
                            </div>
                            
                           <!--  <div class="form-group">
                               <label for="">Propósito y  objetivos de la posición  ó cargo requerido: * </label> -->
                                <!-- <textarea class="form-control input-sm" name="objetivos" id="" placeholder="Propósito y  objetivos de la posición ó cargo requerido: * "><?php //echo $this->input->post('objetivos'); ?></textarea>
                                <span class="errores"><?php //echo form_error('objetivos'); ?></span> -->
                            <!-- </div> -->

                            <div class="form-group">
                                <!-- <label for="">Tareas clave a realizar por el profesional: * </label> -->
                                <textarea class="form-control input-sm" name="tareas" id="" placeholder="Tareas / funciones a realizar: * "><?php echo $this->input->post('tareas'); ?></textarea>
                                <span class="errores"><?php echo form_error('tareas'); ?></span>
                            </div>

                            <div class="form-group">
                                <!-- <label for="">Experiencia requerida del profesional: * </label> -->
                                <textarea class="form-control input-sm" name="experiencia" id="" placeholder="Experiencia / Certificación requeridas: * "><?php echo $this->input->post('experiencia'); ?></textarea>
                                <span class="errores"><?php echo form_error('experiencia'); ?></span>
                            </div>

                            <!-- <div class="form-group">
                                <label for="">Conocimientos y certifiaciones clave requeridas por el profesional: * </label> -->
                                <!--<textarea class="form-control input-sm" name="conocimientos_certificaciones" id="" placeholder="Conocimientos y certifiaciones clave requeridas por el profesional: * "><?php //echo $this->input->post('conocimientos_certificaciones'); ?></textarea>
                                <span class="errores"><?php //echo form_error('conocimientos_certificaciones'); ?></span>
                            </div> -->

                            <!-- <div class="form-group"> -->
                                <!-- <label for="">Esquema de contratación ofrecida: * </label> -->
                                <!-- <select class="form-control input-sm" name="esquema_contratacion" >
                                    <option value="">¿Esquema de contratación del personal: *</option>
                                    <option value="opcion i" <?php //if($this->input->post('esquema_contratacion')=='opcion i') echo "selected" ?>>Opcion I</option>
                                </select>
                                <span class="errores"><?php //echo form_error('esquema_contratacion'); ?></span>
                            </div>  -->

                        
                            <h5>Empresa u Organización</h5>
                       
                        
                               <div class="form-group">
                                    <!-- <label for="">Nombre ó Razón social: * </label> -->
                                    <input type="text"  class="form-control input-sm" name="nombre_razon_social"  value="<?php echo $this->input->post('nombre_razon_social'); ?>" placeholder="Nombre ó Razón social: * "/>
                                    <span class="errores"><?php echo form_error('nombre_razon_social'); ?></span>
                                </div>
                                
                                <!-- <div class="form-group"> -->
                                    <!-- <label for="">Giro o Sector: * </label> -->
                                    <!-- <input type="text"  class="form-control input-sm" name="giro"  value="<?php //echo $this->input->post('giro'); ?>" placeholder="Giro o Sector: * "/>
                                    <span class="errores"><?php //echo form_error('giro'); ?></span>
                                </div> -->
          

                                <div class="form-group">
                                    <!-- <label for="">País: * </label> -->
                                    <input type="text"  class="form-control input-sm" name="pais"  value="<?php echo $this->input->post('pais'); ?>" placeholder="País: * "/>
                                    <span class="errores"><?php echo form_error('pais'); ?></span>
                                </div>

                                <div class="form-group">
                                    <!-- <label for="">Estado: * </label> -->
                                    <input type="text"  class="form-control input-sm" name="estado"  value="<?php echo $this->input->post('estado'); ?>" placeholder="Estado: *"/>
                                    <span class="errores"><?php echo form_error('estado'); ?></span>
                                </div>
                       
                       
                            <h5>Contacto</h5>
                        
                               <div class="form-group">
                                    <!-- <label for="">Nombre: * </label> -->
                                    <input type="text"  class="form-control input-sm" name="nombre" id="f_nombre" value="<?php echo $this->input->post('nombre'); ?>" placeholder="Nombre: * "/>
                                    <span class="errores"><?php echo form_error('nombre'); ?></span>
                                </div>
                                
                                
                                   
                                        <div class="form-group">
                                            <!-- <label for="">Apellido Paterno: * </label> -->
                                            <input type="text"  class="form-control input-sm" name="apellido_paterno" id="f_nombre" value="<?php echo $this->input->post('apellido_paterno'); ?>" placeholder="Apellido Paterno: * "/>
                                            <span class="errores"><?php echo form_error('apellido_paterno'); ?></span>
                                        </div>
                                    
                                        <div class="form-group">
                                            <!-- <label for="">Apellido Materno: * </label> -->
                                            <input type="text"  class="form-control input-sm" name="apellido_materno" id="f_nombre" value="<?php echo $this->input->post('apellido_materno'); ?>" placeholder="Apellido Materno: *"/>
                                            <span class="errores"><?php echo form_error('apellido_materno'); ?></span>
                                        </div>
                                   
                                
                                                      
                                
                                   
                                        <div class="form-group">
                                            <!-- <label for="">Teléfono: * </label> -->
                                            <input type="text"  class="form-control input-sm" name="telefono" id="f_nombre" value="<?php echo $this->input->post('telefono'); ?>" placeholder="Teléfono: * "/>
                                            <span class="errores"><?php echo form_error('telefono'); ?></span>
                                        </div>
                                    
                                        <div class="form-group">
                                           <!--  <label for="">Usuario Skype: * </label> -->
                                            <input type="text"  class="form-control input-sm" name="celular" id="f_nombre" value="<?php echo $this->input->post('celular'); ?>" placeholder="Celular: "/>
                                            <span class="errores"><?php echo form_error('celular'); ?></span>
                                        </div>
                                    
                                

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <!-- <label for="">Puesto, Posición ó Cargo: * </label> -->
                                            <input type="text"  class="form-control input-sm" name="puesto" id="f_nombre" value="<?php echo $this->input->post('puesto'); ?>" placeholder="Puesto, Posición ó Cargo: * "/>
                                            <span class="errores"><?php echo form_error('puesto'); ?></span>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <!-- <label for="">Área ó Departamento: * </label> -->
                                            <!-- <input type="text"  class="form-control input-sm" name="departamento" id="f_nombre" value="<?php //echo $this->input->post('departamento'); ?>" placeholder="Área ó Departamento: * "/>
                                            <span class="errores"><?php //echo form_error('departamento'); ?></span> -->
                                        <!--</div>
                                    </div> -->
                                </div>          

                                
                                <div class="row">
                                    <div class="col-md-12">


                                        <div class="form-group">
                                            <!-- <label for="">Correo:*  </label> -->
                                            <input type="text" class="form-control hide" name="email_field"  value="" />
                                            <input type="text" class="form-control input-sm" name="email" id="f_email" value="<?php echo $this->input->post('email'); ?>" placeholder="Correo organizacional:*  "/>
                                            <span class="errores"><?php echo form_error('email'); ?></span>
                                        </div>

                                        <div class="form-group">
                                            <!-- <label for="">Confirmar correo:*  </label> -->
                                            <input type="text" class="form-control input-sm" name="confirmar_email"  value="<?php echo $this->input->post('confirmar_email'); ?>" placeholder="Confirmar correo organizacional:*  "/>
                                            <span class="errores"><?php echo form_error('confirmar_email'); ?></span>
                                        </div>

                                    </div>
                                </div>

                    <!-- <span style="font-size: 11px"> He leído y acepto la nota informativa sobre el  <a href="<?php //echo site_url('modulo/pagina/blank/politica-de-privacidad'); ?>" class="fancybox-frame">aviso de privacidad. </a></span>
                    <input type="checkbox"  name="privacidad" value="1" id="" <?php //if($this->input->post('privacidad')==1) echo "checked"; ?> > 
                    <span class="errores"><?php //echo form_error('privacidad'); ?></span> -->


                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group privacidad-check">
                              <div class="col-md-12">
                                <input type="checkbox"  name="privacidad" value="1" id="" <?php if($this->input->post('privacidad')==1) echo "checked"; ?> >  He leído y acepto el  <a href="<?php echo site_url('modulo/pagina/blank/politica-de-privacidad'); ?>" class="fancybox-frame">aviso de privacidad. </a>
                                <span class="errores"><?php echo form_error('privacidad'); ?></span>
                              </div>
                            </div>


                            <div class="form-group form-buscar text-center">
                                <button type="button" id="enviar-contacto" class="btn btn-success btn-lg">REGISTRARSE</button>
                                <input type="hidden" name="mcontacto" id="mcontacto" value="">
                            </div>

                        </div>
                    </div>



                    <?php } ?>
                </div>
            </div>
        </div>
    </form>
    </div>
