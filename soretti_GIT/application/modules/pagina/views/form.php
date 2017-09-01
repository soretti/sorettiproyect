<form action="" method="post" id="myform">
    <div class="row">
        <div class="col-md-12">
            <?php if(count($pagina->error->all)) {?>
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
                <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/pagina/guardar/'.$pagina->id) ?>')">Guardar</button>
                <?php } ?>
                <a class="btn btn-default" href="<?php echo base_url('modulo/pagina/listar') ?>">Regresar</a>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#1" data-toggle="tab">Contenido</a></li>
                    <li><a href="#2" data-toggle="tab">Optimización SEO</a></li>
                    <li><a href="#3" data-toggle="tab">Publicación</a></li>
                    <?php if(in_array('en',$this->config->item('idiomas','proyecto'))) {?>
                    <li><a href="#4" data-toggle="tab">Inglés</a></li>
                    <?php } ?>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="1">

                        <blockquote>
                            <small>Los campos marcados con (*) son requeridos</small>
                        </blockquote>

						<?php if($pagina->tipo==""){ ?>
	                        <div class="form-group">
	                            <div class="btn-group" data-toggle="buttons">
	                              <label class="btn btn-primary" id="especialidades">
	                                <input type="radio" name="options" id="option1" autocomplete="off" > Contenido Especialidades
	                              </label>
	                              <label class="btn btn-primary active" id="estandar">
	                                <input type="radio" name="options" id="option2" autocomplete="off" checked> Contenido Estándar
	                              </label>   
	                            </div>
	                        </div>
	                    <?php } ?> 
<?php //echo  'tipo'.$pagina->tipo; die();?>
                        <script type="text/javascript">

                        	$(document).ready(function(){
                        		
                        		<?php if($pagina->tipo==1){ ?>
                        			$('#c_estandar').hide();
                        			$("#c_especialidades #select-bloquecontenido_id").attr('name', 'bloquecontenido_id');
	                        		$("#c_especialidades #texta-titulo").attr('name', 'titulo');
	                                $('#input-tipo-page').val(1);
                        		<?php } ?>


                        		<?php if($pagina->tipo==0){ ?>
                        			$('#c_especialidades').hide();
                        			$('#c_estandar').show();
                        			$('#c_estandar input#input-titulo').attr('name', 'titulo'); 
                                 	$('#c_estandar input#input-bloquecontenido_id').attr('name', 'bloquecontenido_id');
                                 	$('#input-tipo-page').val(0);
                        		<?php } ?>

                        		<?php if($pagina->tipo=='blogs'){ ?>
                        			$('#c_especialidades').hide();
                        			$('#c_estandar').show();
                        			$('#c_estandar input#input-titulo').attr('name', 'titulo'); 
                                 	$('#c_estandar input#input-bloquecontenido_id').attr('name', 'bloquecontenido_id');
                                 	$('#input-tipo-page').val(0);
                        		<?php } ?>
                        	});

                        	$('#especialidades').on('click', function() {
                        		$('#c_estandar input#input-titulo').removeAttr('name'); 
                                $('#c_estandar input#input-bloquecontenido_id').removeAttr('name');
                        		$('#c_estandar').hide();

                        		$("#c_especialidades #select-bloquecontenido_id").attr('name', 'bloquecontenido_id');
                        		$("#c_especialidades #texta-titulo").attr('name', 'titulo');
                                $('#c_especialidades').show();

                                $('#input-tipo-page').val(1);   
                            });

                            $('#estandar').on('click', function() {
                                 $("#c_especialidades #select-bloquecontenido_id").removeAttr('name');
                        		 $("#c_especialidades #texta-titulo").removeAttr('name'); 
                                 $('#c_especialidades').hide();

                                 $('#c_estandar input#input-titulo').attr('name', 'titulo'); 
                                 $('#c_estandar input#input-bloquecontenido_id').attr('name', 'bloquecontenido_id');
                                 $('#c_estandar').show();

                                 $('#input-tipo-page').val(0);
                            });

                        </script>
				
                        <div id="c_especialidades">
                            <div class="form-group">
                            <label>Area:  </label>
                              <select class="form-control" id="select-bloquecontenido_id">
                                <?php foreach ($areas as $key => $area) { ?>
                                   <option value="<?php echo $area->id ?>" <?php if($pagina->bloquecontenido_id==$area->id) echo 'selected' ?>><?php echo $area->titulo; ?></option>
                                <?php } ?>
                              </select>
                            </div>

                            <div class="form-group">
                                <label>Título *</label>
                                <textarea class="html-editable" id="texta-titulo"><?php echo $pagina->titulo; ?></textarea>
                                <?php echo $pagina->error->titulo; ?>
                            </div>
                        </div>


                         <div class="form-group" id="c_estandar">
                            <label>Título *</label>
                            <input type="text" id="input-titulo" value="<?php echo $pagina->titulo; ?>" class="form-control ">
                            <input type="hidden" id="input-bloquecontenido_id" value="0">
                            <?php echo $pagina->error->titulo; ?>
                        </div>   


                        <div class="form-group">
                        	<input type="hidden" name="tipo_page" id="input-tipo-page" value="">
                            <label>URI *</label>
                            <input type="text" name="uri" id="input-uri" value="<?php echo $pagina->uri; ?>" class="form-control">
                            <?php echo $pagina->error->uri; ?>
                            <?php   if($pagina->tipo==0 || $pagina->tipo==1) $pagina_tipo='web';  ?> 
                            <?php   if($pagina->tipo=='blogs') $pagina_tipo='blog';  ?> 
                            <br>
                                <div class="mutted">
                                <?php echo "Español: "; echo($pagina->uri=='') ? site_url() : base_url($pagina_tipo.'/'.$pagina->uri.".html"); echo "<br>"; ?>
                                <!-- <?php //echo "Ingles: "; echo($pagina->uri=='') ? site_url() : base_url('en/'.$pagina->tipo.'/'.$pagina->uri.".html"); echo "<br>"; ?> -->
                            </div>
                        </div>


                         <div class="form-group">
                            <label>Pertenece a algún menú?:  </label>
                              <select class="form-control" name="menu_id" id="select-menu_id">
                                <option value="">No Pertenece a algún menú</option>
                                
                                <?php foreach ($menu as $key => $opcion) { ?>
                                   <option value="<?php echo $opcion->id ?>" <?php if($pagina->menu_id==$opcion->id) echo 'selected' ?>><?php echo $opcion->titulo; ?></option>
                                <?php } ?>
                              </select>
                            </div>

                       


                        <div class="form-group">
                            <label>Contenido</label>
                            <textarea name="contenido" class="html-editable"><?php echo $pagina->contenido; ?></textarea>
                            <?php echo $pagina->error->contenido; ?>
                        </div>
                    </div>
                    <div class="tab-pane" id="2">
                        <div class="form-group">
                            <label>meta Titulo *</label>
                            <input type="text" name="metatitulo" id="input-metatitulo" value="<?php echo $pagina->metatitulo; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>meta Descripción <small class="muted"> 150 caracteres máximo </small></label>
                            <textarea name="descripcion" class="form-control"><?php echo $pagina->descripcion; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>meta Tags:</label><small class="muted"> *10 palabras separadas por (,)</small>
                            <input type="text" name="palabras_clave" id="palabras_clave" value="<?php echo $pagina->palabras_clave; ?>" class="form-control">
                        </div>
                    </div>

                    <div class="tab-pane" id="3">

                        <?php if(!$pagina->plantilla || $pagina->plantilla=='blog') {?>
                        <div class="form-group">
                            <label for="c_fecha"> Incluir fecha de creación: </label>
                            <input type="checkbox" name="c_fecha"  id="c_fecha" value="1" <?php if($pagina->c_fecha) echo "checked"; ?> >
                        </div>
                        <div class="form-group">
                            <label for='c_usuario'> Incluir autor: </label>
                            <input type="checkbox" name="c_usuario"  id="c_usuario" value="1" <?php if($pagina->c_usuario) echo "checked"; ?> >
                        </div>

                        <div class="form-group">
                            <label for='c_comentarios'> Incluir comentarios: </label>
                            <input type="checkbox" name="c_comentarios"  id="c_comentarios" value="1" <?php if($pagina->c_comentarios) echo "checked"; ?> >
                        </div>
                        <div class="form-group">
                            <label for='c_comentarios'> Incluir categorias: </label>
                            <input type="checkbox" name="c_categorias"  id="c_categorias" value="1" <?php if($pagina->c_categorias) echo "checked"; ?> >
                        </div>
                        <div class="form-group">
                            <label for='c_comentarios'> Incluir publicaciones por fecha: </label>
                            <input type="checkbox" name="c_archivo"  id="c_archivo" value="1" <?php if($pagina->c_archivo) echo "checked"; ?> >
                        </div>
                        <div class="form-group">
                            <label for='c_comentarios'> Incluir últimas publicaciones: </label>
                            <input type="checkbox" name="c_ultimos_post"  id="c_ultimos_post" value="1" <?php if($pagina->c_ultimos_post) echo "checked"; ?> >
                        </div>
                        <div class="form-group">
                            <label for='c_comentarios'> Compartir con redes sociales: </label>
                            <input type="checkbox" name="c_compartir"  id="c_compartir" value="1" <?php if($pagina->c_compartir) echo "checked"; ?> >
                        </div>
                        
                      <label>Tipo de Página:  </label>
                      <select class="form-control" name="tipo" id="input-tipo">
                        <option value="0" <?php if($pagina->tipo=='0') echo 'selected' ?>>Contenido</option>
                        <option value="blogs"  <?php if($pagina->tipo=='blogs') echo 'selected' ?>>Blog</option>
                      </select>
                        <?php } ?>

                        <div class="form-group">
                            <label> Fecha de creación: </label>
                            <div class="edicion_fecha">
                                <div class="input-group">
                                    <input class="form-control" type="text"  name="fecha_creacion" id="fecha_creacion" value="<?php echo $this->dateutils->format_date_time($pagina->fecha_creacion); ?>">
                                    <span class="input-group-addon"><a href=""   onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Fecha de activación: </label>
                            <div class="edicion_fecha">
                                <div class="input-group">
                                    <input class="form-control" type="text"  name="fecha_activacion" id="fecha_activacion" value="<?php echo $this->dateutils->format_date_time($pagina->fecha_activacion); ?>">
                                    <span class="input-group-addon"><a href=""   onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Fecha de desactivación: </label>
                            <div class="edicion_fecha">
                                <div class="input-group">
                                    <input class="form-control" type="text"  name="fecha_desactivacion" id="fecha_desactivacion" value="<?php echo $this->dateutils->format_date_time($pagina->fecha_desactivacion); ?>">
                                    <span class="input-group-addon"><a href=""  onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="4">

                        <blockquote>
                            <small>Los campos marcados con (*) son requeridos</small>
                        </blockquote>



                        <div class="form-group" style="margin-top:10px;">
                          <a  href="#" class="btn btn-default" id="copy-content"> Copiar el contenido en español </a>
                        </div>

                        <div class="form-group">
                            <label>Titulo *</label>
                            <input type="text" name="titulo_en" id="input-titulo-en" value="<?php echo $pagina->titulo_en; ?>" class="form-control">
                            <?php echo $pagina->error->titulo_en; ?>
                        </div>
                        
                        <div class="form-group">
                            <label>Contenido</label>
                            <textarea name="contenido_en" class="html-editable"><?php echo $pagina->contenido_en; ?></textarea>
                            <?php echo $pagina->error->contenido_en; ?>
                        </div>
                        <h5 class="page-header"> Optimizacion SEO</h5>
                        <div class="form-group">
                            <label>meta Titulo </label>
                            <input type="text" name="metatitulo_en" id="input-metatitulo-en" value="<?php echo $pagina->metatitulo_en; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>meta Descripción <small class="muted"> 150 caracteres máximo </small></label>
                            <textarea name="descripcion_en" class="form-control"><?php echo $pagina->descripcion_en; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>meta Tags:</label><small class="muted"> *10 palabras separadas por (,)</small>
                            <input type="text" name="palabras_clave_en" id="palabras_clave_en" value="<?php echo $pagina->palabras_clave_en; ?>" class="form-control">
                        </div>
                    </div>
                        



                </div>
            </div>
        </div>
    </form>
