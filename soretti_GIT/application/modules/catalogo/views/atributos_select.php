  <div class="col-xs-4 col-sm-4 col-md-4">
    <div class="form-group">
        <label>Valores:  </label>
        <select class="form-control" name="atributos_name" id='grupo-valores'>
        <?php foreach ($atributos as $value) { ?>
            <option value="<?php echo $value->id ?>" <?php if($value->nombre==$this->input->post('atributos_name'))echo "selected" ?>><?php echo $value->nombre; ?></option>
        <?php } ?>
        </select>
    </div>
  </div>
