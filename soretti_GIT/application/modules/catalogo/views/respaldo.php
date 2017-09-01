<!-- Inicio del Bloque -->


               <div class="row">

                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Atributo:  </label>
                        <select class="form-control" name="atributos_name" id="grupo-atributos">
                        <?php foreach ($atributos as $value) { ?>
                            <option value="<?php echo $value->id ?>" <?php if($value->nombre==$this->input->post('atributos_name'))echo "selected" ?>><?php echo $value->nombre; ?></option>
                        <?php } ?>
                        </select>
                    </div>
                  </div>

                  <div id="contenedor-atributos">

                  </div>

                </div>


                <div class="form-group">
                  <label>SKU:</label>
                  <input type="text" name="SKU" id="input-SKU" value="<?php echo $precios->SKU; ?>" class="form-control">
                </div>






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

          <div class="row  <?php if(!$this->input->post('promocion')!=1) echo 'hide'; ?>" id="mostrar-precio">
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
                                <input type="radio" name="descuento_tipo" id="porcentaje1" value="porcentaje"  <?php if (isset($precios->descuento_tipo) && $precios->descuento_tipo=="porcentaje") echo "checked";?>>Porcentaje
                              </label>
                              <label class="radio-inline">
                                <input type="radio" name="descuento_tipo" id="porcentaje2" value="cantidad" <?php if (isset($precios->descuento_tipo) && $precios->descuento_tipo=="cantidad") echo "checked";?>>Precio Final
                              </label>
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
<!-- Fin del Bloque -->
