<div class="row">


  <div class="col-md-3">



    <div class="relative">
      <?php  if($this->acceso->valida('pagina','editar')) {?>
        <i class="tip-tools"></i>
        <div id="user-options">
          <a href="<?php echo base_url('modulo/pagina/editar/'.$pagina->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
        </div>
        <div class="editable"><div class="zona-editable"></div></div>
        <?php } ?>
        <div class="contenido-default">
          <?php //echo $pagina->{'contenido'.IDIOMA} ?>
        </div>

      </div>

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
                    </div>
                    <?php } else { ?>
                      <div class="form-group">
                        <!-- <label for="">Nombre: * </label> -->
                        <div class="col-md-12">
                          <input type="text"  class="form-control input-sm" name="nombre" id="f_nombre" value="<?php echo $this->input->post('nombre'); ?>" placeholder="Nombre(s)"/>
                        </div>
                        <span class="errores"><?php echo form_error('nombre'); ?></span>
                      </div>
                      <div class="form-group">
                        <!-- <label for="">Apellido Paterno: * </label> -->
                        <div class="col-md-12">
                          <input type="text"  class="form-control input-sm" name="apellido_paterno" id="f_nombre" value="<?php echo $this->input->post('apellido_paterno'); ?>" placeholder="Apellido Paterno"/>
                        </div>
                        <span class="errores"><?php echo form_error('apellido_paterno'); ?></span>
                      </div>

                      <div class="form-group ap_mat">
                        <!-- <label for="">Apellido Materno: * </label> -->
                        <div class="col-md-12">
                          <input type="text"  class="form-control input-sm" name="apellido_materno" id="f_nombre" value="<?php echo $this->input->post('apellido_materno'); ?>" placeholder="Apellido Materno"/>
                        </div>
                        <span class="errores"><?php echo form_error('apellido_materno'); ?></span>
                      </div>

                      <div class="form-group">

                        <div class="col-xs-4">
                          <input type="text" class="form-control input-sm" name="lada" id="f_lada" value="<?php echo $this->input->post('lada'); ?>" placeholder="Lada"/>
                          <span class="errores"><?php echo form_error('lada'); ?></span>
                        </div>
                        <div class="col-xs-8">
                          <input type="text" class="form-control input-sm" name="telefono" id="f_telefono" value="<?php echo $this->input->post('telefono'); ?>" placeholder="Teléfono"/>
                          <span class="errores"><?php echo form_error('telefono'); ?></span>
                        </div>

                      </div>


                      <div class="form-group">
                        <!-- <label for="">Correo:*  </label> -->
                        <div class="col-md-12">
                          <input type="text" class="form-control hide" name="email_field"  value="" />
                          <input type="text" class="form-control input-sm" name="email" id="f_email" value="<?php echo $this->input->post('email'); ?>" placeholder="Correo electrónico" />
                          <span class="errores"><?php echo form_error('email'); ?></span>
                        </div>
                      </div>

                      <!-- <div class="form-group">
                       
                        <div class="col-md-12">
                          <input type="text" class="form-control input-sm" name="confirmar_email"  value="<?php //echo $this->input->post('confirmar_email'); ?>" placeholder="Confirmar correo electrónico" />
                          <span class="errores"><?php //echo form_error('confirmar_email'); ?></span>
                        </div>
                      </div> -->

                      <div class="form-group">
                        <!-- <label for="">Area de desarollo profesinal:*  </label> -->
                        <div class="col-md-12">
                          <select class="form-control input-sm" name="area_desarrollo" >
                            <option value="">Área con la que desea contactar</option>
                            <option value="opcion i" <?php if($this->input->post('area_desarrollo')=='opcion i') echo "selected" ?>>Opcion I</option>
                          </select>
                          <span class="errores"><?php echo form_error('area_desarrollo'); ?></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-md-12">
                          <textarea name="texto" rows="6" class="form-control input-sm" id="f_texto" placeholder="Indique su comentario, este será analizado por uno de nuestros ejecutivos y luego se pondrá en contacto con usted para confirmarlo y luego actuar según corresponda.                                                                        Gracias."><?php echo $this->input->post('texto'); ?></textarea>
                          <span class="errores"><?php echo form_error('texto'); ?></span>
                        </div>
                      </div>

                      <div class="form-group privacidad-check">
                        <div class="col-md-12">
                          <input type="checkbox"  name="privacidad" value="1" id="" <?php if($this->input->post('privacidad')==1) echo "checked"; ?> >  He leído y acepto las <strong>Condiciones de uso y la </strong><a href="<?php echo site_url('modulo/pagina/blank/politica-de-privacidad'); ?>" class="fancybox-frame">Política de privacidad. </a>
                          <span class="errores"><?php echo form_error('privacidad'); ?></span>
                        </div>
                      </div>

                      <div class="form-group form-buscar text-right">
                        <div class="col-md-12">
                          <input type="hidden" name="mcontacto" id="mcontacto" value="">
                          <button type="button" id="enviar-contacto" class="btn btn-success btn-lg">ENVIAR</button>
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

               <div class="contacto-imagen">
                    <?php echo modules::run('banners/mostrar',"17","10"); ?>
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


          <?php echo modules::run('menu/lista', 11); ?>
        </div>

          <div class="col-md-12">

                <?php echo modules::run('banners/mostrar',"16","9"); ?>

          </div>

        </div>
