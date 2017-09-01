<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<div class="row">
  <div class="col-md-3">

    <div class="form-registro">

      <h5><?php echo $pagina->titulo ?></h5>

      <a name="contacto"></a>
      <form class="form-horizontal" action="<?php echo current_url()."#contacto"; ?>" method="POST" id="form-contacto" enctype="multipart/form-data" >
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
                    <input type="hidden" name="enviado" id="enviado" value="1">
                  </div>
                  <?php } else { ?>
                    <div class="form-group">
                      <!-- <label for="">Nombre: * </label> -->
                      <div class="col-md-12">
                        <input type="text"  class="form-control input-sm" name="nombre" id="f_nombre" value="<?php echo $this->input->post('nombre'); ?>" placeholder="Nombre(s) Completo(s) sin abreviar: *"/>
                        <span class="errores"><?php echo form_error('nombre'); ?></span>
                      </div>
                      
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        <input type="text"  class="form-control input-sm" name="apellido_paterno" id="f_appat" value="<?php echo $this->input->post('apellido_paterno'); ?>" placeholder="Apellido Paterno: *"/>
                        <span class="errores"><?php echo form_error('apellido_paterno'); ?></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-12">
                        <input type="text"  class="form-control input-sm" name="apellido_materno" id="f_apmat" value="<?php echo $this->input->post('apellido_materno'); ?>" placeholder="Apellido Materno: *"/>
                        <span class="errores"><?php echo form_error('apellido_materno'); ?></span>
                      </div>
                    </div>
                    
                        <div class="form-group">
                          <div class="col-md-12">
                            <select class="form-control input-sm" name="genero" >
                              <option value="">Genero: *</option>
                              <option value="masculino" <?php if($this->input->post('genero')=='masculino') echo "selected" ?>>Masculino</option>
                              <option value="femenino" <?php if($this->input->post('genero')=='femenino') echo "selected" ?>>Femenino</option>
                            </select>
                            <span class="errores"><?php echo form_error('genero'); ?></span>
                          </div>
                        </div>

                        <div class="form-group">

                          <div class="col-md-12">
                          <label for="fecha_nacimiento" style="font-weight:normal; font-size: 14px; color: #000080"> Fecha de nacimiento: </label>
                          <div class="row">
                          <div class="col-md-4">
                          <select class="form-control input-sm" name="dia" id="f_dia">
                            <option value="dia">D&iacute;a</option>
                            <?php for ($i=1; $i < 32; $i++) { ?>
                              <option value="<?php echo $i ?>" <?php if($this->input->post('dia')==$i) echo "selected" ?>><?php echo $i; ?></option>
                            <?php } ?>
                          </select>
                          </div>
                          <div class="col-md-4">
                          <select class="form-control input-sm" name="mes" id="f_mes">
                            <option value="mes">Mes</option>
                            <option value="01" <?php if($this->input->post('mes')=='01') echo "selected" ?>>ene</option>
                            <option value="02" <?php if($this->input->post('mes')=='02') echo "selected" ?>>feb</option>
                            <option value="03" <?php if($this->input->post('mes')=='03') echo "selected" ?>>mar</option>
                            <option value="04" <?php if($this->input->post('mes')=='04') echo "selected" ?>>abr</option>
                            <option value="05" <?php if($this->input->post('mes')=='05') echo "selected" ?>>may</option>
                            <option value="06" <?php if($this->input->post('mes')=='06') echo "selected" ?>>jun</option>
                            <option value="07" <?php if($this->input->post('mes')=='07') echo "selected" ?>>jul</option>
                            <option value="08" <?php if($this->input->post('mes')=='08') echo "selected" ?>>ago</option>
                            <option value="09" <?php if($this->input->post('mes')=='09') echo "selected" ?>>sep</option>
                            <option value="10" <?php if($this->input->post('mes')=='10') echo "selected" ?>>oct</option>
                            <option value="11" <?php if($this->input->post('mes')=='11') echo "selected" ?>>nov</option>
                            <option value="12" <?php if($this->input->post('mes')=='12') echo "selected" ?>>dic</option>
                          </select>
                          </div>
                          <div class="col-md-4">
                            <select class="form-control input-sm" name="anno" id="f_anno">
                              <option value="anio">A&ntilde;o</option>
                                <?php 
                                  for ($i=date("Y"); $i >= 1905; $i--) { ?>
                                    <option value="<?php echo $i; ?>" <?php if($this->input->post('anno')==$i) echo "selected" ?>><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <div class="input-group">
                              <input type="hidden"  name="fecha_nacimiento" id="fecha_nacimiento" value=""/>
                            </div>
                            
                          </div>
                          
                          </div>
                          <span class="errores"><?php echo form_error('fecha_nacimiento'); ?></span>
                          </div>
                        </div>
                        
                        <h5>Contacto y lugar de residencia</h5>

                        <div class="form-group">
                          <div class="col-md-6">
                            <input type="text"  class="form-control input-sm" name="telefono" id="f_telefono" value="<?php echo $this->input->post('telefono'); ?>" placeholder="Teléfono: "/>
                            <span class="errores"><?php echo form_error('telefono'); ?></span>
                          </div>
                           <div class="col-md-6">
                            <input type="text"  class="form-control input-sm" name="celular" id="f_celular" value="<?php echo $this->input->post('celular'); ?>" placeholder="Celular: *"/>
                            <span class="errores"><?php echo form_error('celular'); ?></span>
                          </div>
                          
                        </div>


                        <div class="form-group">
                          <div class="col-md-12">
                           <select class="form-control input-sm" name="pais" id="pais"></select>
                            <span class="errores"><?php echo form_error('pais'); ?></span>
                          </div>
                        </div>


                        <div class="form-group">
                          <div class="col-md-12">
                            <select class="form-control input-sm" name="estado" id="estado"></select>
                            <span class="errores"><?php echo form_error('estado'); ?></span>
                          </div>
                        </div>


                        <div class="form-group">
                          <div class="col-md-12">
                            <select class="form-control input-sm" name="municipio" id="municipio"></select>
                            <span class="errores"><?php echo form_error('municipio'); ?></span>
                          </div>
                        </div>


                        <div class="form-group">
                          <div class="col-md-6">
                            <input type="text"  class="form-control input-sm" name="colonia" id="f_colonia" value="<?php echo $this->input->post('colonia'); ?>" placeholder="Colonia: *"/>
                            <span class="errores"><?php echo form_error('colonia'); ?></span>
                          </div>
                          
                          <div class="col-md-6">
                             <input type="text"  class="form-control input-sm" name="cp" id="f_cp" value="<?php echo $this->input->post('cp'); ?>" placeholder="Código Postal: *"/>
                             <span class="errores"><?php echo form_error('cp'); ?></span>
                          </div>
                        </div>

                        <h5>Especialidad</h5>

                        <div class="form-group">
                          <!-- <label for="">Area de desarollo profesional:*  </label> -->
                          <?php 
                            // if(!isset($this->input->post('area_desarrollo'))){
$area = $this->db->query("SELECT id, titulo FROM bloquecontenidos WHERE bloque_id=3 AND is_enable=1 ORDER BY titulo ASC");
// print_r($area); die();
                    //}
                          ?>
                          <div class="col-md-12">
                            <select class="form-control input-sm" name="area_desarrollo" id="area_desarrollo">
                              <option value="desarrollo">Área de desarrollo profesional*</option>

                              <?php foreach($area->result_array() as $value){ ?>
                                <option value="<?php echo $value['id']; ?>" <?php if($this->input->post('area_desarrollo')==$value['id']) echo "selected" ?>><?php echo $value['titulo']; ?></option>
                              <?php } ?>

                            </select>
                            <input type="hidden" name="desarrollo_profesional" id="desarollo_profesional" value="">
                            <span class="errores"><?php echo form_error('desarrollo_profesional'); ?></span>
                          </div>
                        </div>


                        <div class="form-group">
                          <!-- <label for="">Nombre: * </label> -->
                          <div class="col-md-12">
                            <select class="form-control input-sm" name="especialidad" id="especialidad">
                              <option value=''>Especialidad *</option>
                            </select>
                            <span class="errores"><?php echo form_error('especialidad'); ?></span>
                          </div>
                          
                        </div>

                        <div class="form-group">
                          <!-- <label for="">Correo:*  </label> -->
                          <div class="col-md-12">
                            <input type="text" class="form-control hide" name="email_field"  value="" />
                            <input type="text" class="form-control input-sm" name="email" id="f_email" value="<?php echo $this->input->post('email'); ?>" placeholder="Correo electrónico: *" />
                            <span class="errores"><?php echo form_error('email'); ?></span>
                          </div>
                        </div>

                        <div class="form-group">
                          <!-- <label for="">Confirmar correo:*  </label> -->
                          <div class="col-md-12">
                            <input type="text" class="form-control input-sm" name="confirmar_email"  value="<?php echo $this->input->post('confirmar_email'); ?>" placeholder="Confirmar correo electrónico" />
                            <span class="errores"><?php echo form_error('confirmar_email'); ?></span>
                          </div>
                        </div>


                        <div class="form-group">
                          <!-- <label for="">Adjuntar: *</label> -->
                          <div class="col-md-12">
                            <input type="file" name="curriculum" id="add-file" class="filestyle" data-buttonText="&nbsp;Examinar..." data-placeholder="Adjuntar Currículum *">
                            <!-- <input type="file" name="curriculum" id="add-file" placeholder="Adjuntar currículum" value="Adjuntar currículum"> -->
                            <span class="errores"><?php  if(isset($error[0]) && $error[0]) echo $error[0]; ?></span>
                          </div>
                        </div>

                        <div class="form-group privacidad-check">
                          <div class="col-md-12">
                            <input type="checkbox"  name="privacidad" value="1" id="" <?php if($this->input->post('privacidad')==1) echo "checked"; ?> >  He leído y acepto el  <a href="<?php echo site_url('modulo/pagina/blank/politica-de-privacidad'); ?>" class="fancybox-frame">aviso de privacidad. </a>
                            <span class="errores"><?php echo form_error('privacidad'); ?></span>
                          </div>
                        </div>

                        <div class="form-group form-buscar text-center">
                          <div class="col-md-12">
                            <input type="hidden" name="mcontacto" id="mcontacto" value="">
                            <button type="button" id="enviar-contacto" class="btn btn-success btn-lg">REGISTRARSE</button>
                          </div>
                        </div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>

                </form>
              </div>

            </div>
            <div class="col-md-6">
              <div id="div1"></div>
              <div class="relative">
                <?php  if($this->acceso->valida('pagina','editar')) {?>
                  <i class="tip-tools"></i>
                  <div id="user-options">
                    <a href="<?php echo base_url('modulo/pagina/editar/'.$pagina->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
                  </div>
                  <div class="editable">
                    <div class="zona-editable"></div>
                  </div>
                  <?php } ?>
                  <div class="contenido-default">
                    <?php echo $pagina->{'contenido'.IDIOMA} ?>
                  </div>
                </div>

                <?php echo modules::run('formslider/index'); ?>


            </div>

		
            </div>


            <div class="col-md-3">

				 <div class="content-redes">

			        <div class="content-redes-txt">Siganos en</div>
			        <div class="content-redes-ico">
			            <a href="#">
			                <img src="<?php echo base_url('pub/theme/img/facebook.png') ?>" alt="" border="0">
			            </a>
			        </div>
			        <div class="content-redes-ico">
			            <a href="#">
			                <img src="<?php echo base_url('pub/theme/img/twitter.png') ?>" alt="" border="0">
			            </a>
			        </div>
			        <div class="content-redes-ico">
			            <a href="#">
			                <img src="<?php echo base_url('pub/theme/img/linkedin.png') ?>" alt="" border="0">
			            </a>
			        </div>
			    </div>


				<?php echo modules::run('menu/lista', 10); ?>
			</div>

            <div class="col-md-12">

                <?php echo modules::run('banners/mostrar',"14","7"); ?>

            </div>
            

</div>
