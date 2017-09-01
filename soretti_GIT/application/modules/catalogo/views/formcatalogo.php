<script>
jQuery(document).ready(function($) {
  $("#catalogoImagenes .btn-danger").click(function(event){
        event.preventDefault();
        var m=$(this).attr('delete');
        if(confirm('¿Está seguro de ejecutar esta acción?'))
        {
        $.ajax({
        url: base_url+'modulo/catalogo/eliminar_imagen',
        type: 'POST',
        data: {post_ids: m},
        })
        .done(function() {
        console.log("success");
        })
        .fail(function() {
        console.log("error");
        })
        .always(function() {
        console.log("complete");
        });
        $(this).parent().parent().parent().remove();
        }
  });

  $( ".sortable" ).sortable({ items: "> div.row", handle: ".glyphicon-move" });
  $("#comprar_sin_stock").click(function(){
      if( !$(this).is(':checked') ){
      $(".stock").removeClass("hide");
      }else{
      $(".stock").addClass("hide");
      }
  });
});
</script>
<form action="" method="post" id="myform">
  <div class="row">
    <div class="col-md-12">
      <?php if(count($catalogo->error->all)) {?>
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
        <button class="btn btn-success" type="submit" onclick="goto('<?php echo base_url('modulo/catalogo/guardar/'.$catalogo->id) ?>')">Guardar</button>
        <?php } ?>
        <a class="btn btn-default" href="<?php echo base_url('modulo/catalogo/listar/') ?>">Regresar</a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tabbable">
        <ul class="nav nav-tabs" id="tabs_catalogo">
          <li class="active"><a href="#1" data-toggle="tab"> Contenido </a></li>
          <li><a href="#1b" data-toggle="tab">Precio</a></li>
          <li><a href="#2" data-toggle="tab">Optimización SEO</a></li>
          <li><a href="#3" data-toggle="tab">Imagenes</a></li>
          <?php if($catalogo->id) {?>
          <li><a href="#4" data-toggle="tab">Combinaciones</a></li>
          <?php  } ?>
          <li><a href="#5" data-toggle="tab">Publicación</a></li>
          <li><a href="#6" data-toggle="tab">Productos Relacionados</a></li>
          <?php if( in_array('en',$this->config->item('idiomas','proyecto')) ) {?>
          <li><a href="#6" data-toggle="tab">Inglés</a></li>
          <?php } ?>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="1">
            <blockquote>
              <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>
            <div class="form-group">
              <label>Titulo: * </label>
              <input type="text" name="titulo" id="input-titulo" value="<?php echo $catalogo->titulo; ?>" class="form-control">
              <?php echo $catalogo->error->titulo; ?>
            </div>
            <div class="form-group">
              <label>Uri: *</label>
              <input type="text" name="uri" id="input-uri" value="<?php echo $catalogo->uri; ?>" class="form-control">
              <?php echo $catalogo->error->uri; ?>
            </div>
            <div class="form-group">
              <label>SKU: *</label>
              <input type="text" name="SKU" id="input-SKU" value="<?php echo $catalogo->SKU; ?>" class="form-control">
              <?php echo $catalogo->error->SKU; ?>
            </div>
            <div class="form-group">
              <label>Comprar sin stock: </label>
              <input type="checkbox" name="comprar_sin_stock" value="1" id="comprar_sin_stock" <?php if($catalogo->comprar_sin_stock) echo "checked"; ?> >
            </div>
            <div class="form-group">
              <label>Producto Agotado: </label>
              <input type="checkbox" name="agotado" value="1" id="agotado" <?php if($catalogo->agotado) echo "checked"; ?> >
            </div>
            <?php if(! $combinaciones->result_count()) {?>
            <div class="form-group <?php if( $combinaciones->result_count() || $catalogo->comprar_sin_stock ) echo "hide"; ?> stock">
              <label>Stock: </label>
              <input type="text" name="stock" id="input-stock" value="<?php echo $catalogo->stock; ?>" class="form-control">
              <?php echo $catalogo->error->stock; ?>
            </div>
            <?php } ?>
            <div class="form-group">
              <label>Peso: </label>
              <div class="input-group input-group">
                <span class="input-group-addon" id="sizing-addon1">Kg</span>
                <input type="text" name="peso" value="<?php echo $catalogo->peso; ?>" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <label>Categoría principal: * </label>
                  <div class="scroll-categorias" >
                    <?php echo $menu_categorias ?>
                  </div>
                  <?php echo $catalogo->error->categoria_id; ?>
                </div>
                <div class="col-md-6">
                  <label>Otras categorias: </label>
                  <div class="scroll-categorias" >
                    <?php echo $menu_categorias_multiple ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <label>Marca:  </label>
              <select class="form-control" name="marca_id" id="input-marca_id">
                <option value="">Selecciona una marca</option>
                <?php foreach ($marcas as $value) { ?>
                <option value="<?php echo $value->id; ?>" <?php if($value->id==$catalogo->marca_id) echo 'selected' ?>><?php echo $value->titulo; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Resumen: </label>
                <textarea name="resumen" id=""  rows="5" class="form-control"><?php echo $catalogo->resumen; ?></textarea>
              </div>
              <div class="form-group">
                <label>Descripción </label>
                <textarea name="descripcion" class="html-editable"><?php echo $catalogo->descripcion; ?></textarea>
              </div>
              <div class="form-group">
                <label>Características </label>
                <textarea name="caracteristicas" class="html-editable"><?php echo $catalogo->caracteristicas; ?></textarea>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="1b">
            <blockquote>
              <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>
            <!-- Bloque -->
            <div class="form-group">
              <label>Costo:</label>
              <input type="text" name="costo" id="input-costo" value="<?php echo $precios->costo; ?>" class="form-control"  onkeypress="return NumCheck(event, this);" >
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Precio: *</label>
                  <input type="text" name="precio" id="input-precio" value="<?php echo $precios->precio; ?>" class="form-control" onkeypress="return NumCheck(event, this);">
                  <?php echo $precios->error->precio; ?>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Moneda:  </label>
                  <select class="form-control" name="moneda">
                    <option value="" <?php if($precios->moneda=="")echo "selected" ?>>Mondeda tipo:</option>
                    <option value="peso" <?php if($precios->moneda=="peso")echo "selected" ?>>Peso</option>
                    <option value="dolar" <?php if($precios->moneda=="dolar")echo "selected" ?>>Dolar</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Precio Mayoreo:</label>
                  <input type="text" name="precio_mayoreo" id="input-precio_mayoreo" value="<?php echo $precios->precio_mayoreo; ?>" class="form-control" onkeypress="return NumCheck(event, this);">
                  <?php echo $precios->error->precio_mayoreo; ?>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>A partir de:</label>
                  <input type="text" name="cantidad" id="input-cantidad" value="<?php echo $precios->cantidad; ?>" class="form-control txtNumbers">
                  <?php echo $precios->error->cantidad; ?>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Impuesto:  </label>
              <select class="form-control" name="impuesto">
                <option value="" <?php if($precios->impuesto=="")echo "selected" ?>>Sin impuesto</option>
                <option value="16" <?php if($precios->impuesto=="16")echo "selected" ?>>IVA 16%</option>
              </select>
            </div>
            <div class="form-group">
              <label class="checkbox-inline">
                <input type="checkbox" name="promocion" value="1" <?php if(($this->input->post('promocion')==1) || ($precios->promocion==1) || (($precios->descuento_cantidad!=0) && ($precios->descuento_cantidad!=''))) echo "checked"; ?> >Promoción
              </label>
            </div>
            <div class="row  <?php if(!$this->input->post('promocion')!=1 or $precios->promocion!=1) echo 'hide'; ?>" id="mostrar-precio">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Precio de promoción:</label>
                  <input type="text" name="descuento_cantidad" id="input-descuento_cantidad" value="<?php echo $precios->descuento_cantidad; ?>" class="form-control" onkeypress="return NumCheck(event, this);">
                  <?php echo $precios->error->descuento_cantidad; ?>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="radio-inline">
                    <input type="radio" name="descuento_tipo" id="porcentaje1" value="porcentaje"  <?php if(!$precios->descuento_tipo) $precios->descuento_tipo='porcentaje'; if (isset($precios->descuento_tipo) && $precios->descuento_tipo=="porcentaje") echo "checked";?>>Porcentaje
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="descuento_tipo" id="porcentaje2" value="cantidad" <?php if (isset($precios->descuento_tipo) && $precios->descuento_tipo=="cantidad") echo "checked";?>>Precio Final
                  </label>
                </div>
              </div>

            <div class="col-md-12">
             <div class="form-group">
              <label>Fecha de activación: </label>
              <div class="edicion_fecha">
                <div class="input-group">
                  <input class="form-control" type="text"  name="activacion_promocion" id="activacion_promocion" value="<?php echo $this->dateutils->format_date_time($precios->activacion_promocion); ?>">
                  <span class="input-group-addon"><a href=""   onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
                </div>
              </div>
            </div>
            </div>
            <div class="col-md-12">
            <div class="form-group">
              <label>Fecha de desactivación: </label>
              <div class="edicion_fecha">
                <div class="input-group">
                  <input class="form-control" type="text"  name="desactivacion_promocion" id="desactivacion_promocion" value="<?php echo $this->dateutils->format_date_time($precios->desactivacion_promocion); ?>">
                  <span class="input-group-addon"><a href=""  onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
                </div>
              </div>
            </div>
            
            </div>

            </div>

            <!-- End del bloque -->
          </div>
          <div class="tab-pane" id="2">
            <blockquote>
              <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>
            <div class="form-group">
              <label>meta Titulo *</label>
              <input type="text" name="metatitulo" id="input-metatitulo" value="<?php echo $catalogo->metatitulo; ?>" class="form-control">
            </div>
            <div class="form-group">
              <label>meta Tags:</label><small class="muted"> *10 palabras separadas por (,)</small>
              <input type="text" name="palabras_clave" id="palabras_clave" value="<?php echo $catalogo->palabras_clave; ?>" class="form-control">
            </div>
          </div>
          <div class="tab-pane" id="3">
            <blockquote>
              <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <label for="">Titulo de la imagen</label>
                  <input type="text" name="titulo_imagen" id="" class="form-control">
                </div>
                <div class="col-md-6">
                  
                                <label>
                Imagen   &nbsp;<?php echo "(".$catalogo->cat_imagen->lista_w."px ancho por ".$catalogo->cat_imagen->lista_h."px de alto)"; ?>
                <small class="muted inline-block">&nbsp;Formatos: jpg, jpeg, gif, png</small>
              </label>
              <div class="input-group">
                <span class="input-group-addon"><a href="#" class="show_image_input"> <i class="glyphicon glyphicon-eye-open"></i></a> </span>
                <input class="form-control" type="text" value="" name="cat_imagen" modulo='catalogo' catalogo="1" width="<?php echo $catalogo->cat_imagen->lista_w; ?>" height="<?php echo $catalogo->cat_imagen->lista_h; ?>">
                <span class="input-group-addon"><a href="<?php echo base_url('modulo/filemanager') ?>" class="filemanager popup"><small>Seleccionar archivo </small></a></span>
              </div>
              <?php echo $catalogo->error->imagen; ?>


                </div>
              </div>

            </div>
            <div class="form-group sortable" id="catalogoImagenes">
              <?php if(isset($catalogoImagen)) foreach ($catalogoImagen as $imagenes) {?>
              <div class="row">
                <div class="col-md-10"><img width="50" src="<?php echo base_url( 'pub/uploads/thumbs/'.name_image($imagenes->imagen,'catalogo','cat_imagen',$catalogoImagen->thumb_w,$catalogoImagen->thumb_h) ) ; ?>" alt=""></div>
                <div class="col-md-2">
                  <div class="btn-group">
                    <input type="hidden" name="cat_imagenes[]" value="<?php echo $imagenes->id ?>" >
                    <button type="button" class="btn btn-danger" delete="<?php echo $imagenes->id ?>"><span class="glyphicon glyphicon-trash" ></span></button>
                    <span class="btn btn-default"> <span class="glyphicon glyphicon-move"></span> </span>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
          <div class="tab-pane" id="4">
            <blockquote>
              <small>Adicionar o modificar combinaciones para este producto: </small>
            </blockquote>
            <div class="row">
              <div class="col-md-6">
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6">
                    <span class="add-on">
                      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                      <a href="<?php echo base_url('modulo/catalogo/agregar_combinacion/'.$catalogo->id); ?>" class="filemanager popup">Agregar combinacion</a>
                    </span>
                  </div>
                  <!-- <div class="col-md-6">
                    <span class="add-on">
                      <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                      <a href="<?php //echo base_url('modulo/catalogo/listar') ?>" class="filemanager popup">Borrar un producto</a>
                    </span>
                  </div> -->
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered grid">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>SKU</th>
                    <th>Combinacion</th>
                    <?php if(!$catalogo->comprar_sin_stock) {?>
                      <th>Stock</th>
                    <?php } ?>
                    <th>Combinacion predeterminada</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($combinaciones as $key => $value) { ?>
                  <tr>
                    <td><?php echo $value->id; ?></td>
                    <td><?php echo $value->SKU; ?></td>
                    <td>
                      <?php  if(isset($value->result_combinaciones))  foreach ($value->result_combinaciones as $key => $datos) {
                      echo $datos->grupo_nombre.':'.$datos->nombre.'  ';
                      } ?>
                    </td>
                    <?php if(!$catalogo->comprar_sin_stock) {?>
                      <td><?php echo $value->stock; ?></td>
                    <?php } ?>
                    <td><?php echo ($value->default) ? 'Si' : 'No' ; ?></td>

                    <td nowrap>
                      <a href="<?php echo base_url('modulo/catalogo/editar_combinacion/'.$value->id); ?>" class="filemanager popup btn btn-default btn-sm"><span class="glyphicon glyphicon-edit "></span></a>
                      <?php if($this->acceso->valida('catalogo','eliminar')) {?>
                      <button class="btn btn-danger btn-sm  action_row" value="basura" type="button" href="<?php echo base_url('modulo/catalogo/eliminar_combinacion/'.$value->id); ?> " ><span class="glyphicon glyphicon-trash "></span></button>
                      <?php } ?>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane" id="5">
            <blockquote>
              <small>&nbsp;</small>
            </blockquote>
            <div class="form-group">
              <label> Fecha de creación: </label>
              <div class="edicion_fecha">
                <div class="input-group">
                  <input class="form-control" type="text"  name="fecha_creacion" id="fecha_creacion" value="<?php echo $this->dateutils->format_date_time($catalogo->fecha_creacion); ?>">
                  <span class="input-group-addon"><a href=""   onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Fecha de activación: </label>
              <div class="edicion_fecha">
                <div class="input-group">
                  <input class="form-control" type="text"  name="fecha_activacion" id="fecha_activacion" value="<?php echo $this->dateutils->format_date_time($catalogo->fecha_activacion); ?>">
                  <span class="input-group-addon"><a href=""   onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Fecha de desactivación: </label>
              <div class="edicion_fecha">
                <div class="input-group">
                  <input class="form-control" type="text"  name="fecha_desactivacion" id="fecha_desactivacion" value="<?php echo $this->dateutils->format_date_time($catalogo->fecha_desactivacion); ?>">
                  <span class="input-group-addon"><a href=""  onClick="return false"><i class="glyphicon glyphicon-calendar"></i></a></span>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="6">
            <script>
            var customFunctionSelect=1;
            function customSelect(obj,window)
            {
            html='<div class="form-group">'+
              '<div class="input-group col-md-6">'+
                '<span class="input-group-addon"><a href="#" class="remove_imagenes"> <i class="glyphicon glyphicon-trash"></i></a> </span>'+
                '<input type="hidden" value="'+$(obj).attr('value')+'" name="destacados[]">'+
                '<div class="form-control titulo">'+$(obj).attr('titulo')+'</div>'+
                '<span class="input-group-addon"><a href="'+base_url+'modulo/catalogo/editar/'+$(obj).attr('value')+'" class="filemanager popup"> Editar </a></span>'+
              '</div>'+
            '</div>';
            $("#contenedor_galeria").prepend(html);
            remove_items();
            window.close();
            }
            function remove_items()
            {
            $(".popup").popupWindow({width:800,scrollbars:1,resizable:1,centerScreen:1} );
            $(".remove_imagenes").off('click');
            $(".remove_imagenes").click(function(event){
            event.preventDefault();
            if(confirm('¿Está seguro de ejecutar esta acción?'))
            {
            $(this).parent().parent().parent().remove();
            }
            });
            $( "#contenedor_galeria" ).sortable({ items: "> div.form-group" });
            }
            $(document).ready(remove_items);
            </script>
            <form action="" method="post" id="myform">
              <div class="row">
                <div class="col-md-12">
                  <div class="btn-toolbar" contenedor="contenedor_galeria">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-5">
                    <blockquote>
                      <small>Puedes arrastrar los productos para ordenarlos.</small>
                    </blockquote>
                  </div>
                  <div class="col-md-7">
                    <span class="add-on">
                      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                      <a href="<?php echo base_url('modulo/catalogo/listar') ?>" class="filemanager popup">Agregar un producto</a>
                    </span>
                  </div>
                  <div class="col-md-12">
                    <div id="contenedor_galeria">
                      <?php if(isset($item) && $item->result_count()) foreach ($item as $destacado) {?>
                      <div class="form-group">
                        <div class="input-group col-md-6">
                          <span class="input-group-addon"><a href="#" class="remove_imagenes"> <i class="glyphicon glyphicon-trash"></i></a> </span>
                          <input type="hidden" value="<?php echo $destacado->producto_id ?>" name="destacados[]">
                          <div class="form-control titulo"> <?php echo $destacado->producto_titulo ?> </div>
                          <span class="input-group-addon"><a href="<?php echo base_url('modulo/catalogo/editar/'.$destacado->producto_id); ?>" class="filemanager popup"> Editar </a></span>
                        </div>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="tab-pane" id="6">
            <blockquote>
              <small>Los campos marcados con (*) son requeridos</small>
            </blockquote>
            <div class="form-group">
              <label>Titulo *</label>
              <input type="text" name="titulo_en" id="input-titulo-en" value="<?php echo $catalogo->titulo_en; ?>" class="form-control">
              <?php echo $catalogo->error->titulo_en; ?>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Resumen: </label>
                <textarea name="resumen_en" id=""  rows="5" class="form-control"><?php echo $catalogo->resumen_en; ?></textarea>
              </div>
              <div class="form-group">
                <label>Descripción </label>
                <textarea name="descripcion_en" rows="30" class="html-editable"><?php echo $catalogo->descripcion_en; ?></textarea>
              </div>
            </div>
            <h5 class="page-header"> Optimizacion SEO</h5>
            <div class="form-group">
              <label>meta Titulo </label>
              <input type="text" name="metatitulo_en" id="input-metatitulo-en" value="<?php echo $catalogo->metatitulo_en; ?>" class="form-control">
            </div>
            <div class="form-group">
              <label>meta Tags:</label><small class="muted"> *10 palabras separadas por (,)</small>
              <input type="text" name="palabras_clave_en" id="palabras_clave_en" value="<?php echo $catalogo->palabras_clave_en; ?>" class="form-control">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>