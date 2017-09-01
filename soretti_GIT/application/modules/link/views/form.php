<form action="" method="post" id="myform">
  <div class="row">
    <div class="col-md-12">
      <div class="btn-toolbar">
        <input type="button" name="Aplicar" value="Aplicar" id="aplicar" class="btn btn-primary">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <ul class="nav nav-tabs" id="myTab">
        <li class="active"><a href="#externo" data-toggle="tab" value="externo" >Externo</a></li>
        <li><a href="#archivo" data-toggle="tab" value="archivo">Archivo</a></li>
        <li><a href="#mail" data-toggle="tab" value="mail">Mail</a></li>
        <?php if($config_proyecto['catalogo']) {?>
        <li><a href="#categoria" data-toggle="tab" value="categoria">Categoría</a></li>
        <li><a href="#producto" data-toggle="tab" value="producto">Producto</a></li>
        <?php } ?>
        <li><a href="#pagina" data-toggle="tab" value="pagina">Página</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="externo">
          <div class="form-group">
            <label>URL: </label>
            <input type="text" class="link form-control">
          </div>
        </div>
        <div class="tab-pane" id="archivo">
          <div class="form-group">
            <label class="control-label">Archivo:</label>
            <div class="input-group">
              <input class="form-control link" type="text" value="" name="imagen">
              <span class="input-group-addon"><a href="<?php echo base_url('modulo/filemanager') ?>" class="filemanager popup"><small>Seleccionar archivo</small> </a></span>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="mail">
          <div class="form-group">
            <label>E-mail: </label>
            <input type="text" class="link form-control">
          </div>
        </div>
        <div class="tab-pane" id="categoria">
          <div class="form-group">
            <label class="control-label">Categoría: *</label>
            <div class="input-group">
              <input type="hidden" value="" name="" class="uri-input link">
              <div class="form-control titulo" style="min-width:100px;"></div>
              <span class="input-group-addon"><a href="<?php echo base_url('modulo/catalogo/catalogocategoria/listar') ?>" class="filemanager grid_seleccionar"> seleccionar </a></span>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="producto">
          <div class="form-group">
            <label class="control-label">Producto: </label>
            <div class="input-group">
              <input type="hidden" value="" name="" class="uri-input link">
              <div class="form-control titulo" style="min-width:100px;"></div>
              <span class="input-group-addon"><a href="<?php echo base_url('modulo/catalogo/listar') ?>" class="filemanager grid_seleccionar"> seleccionar </a></span>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="pagina">
          <div class="form-group">
            <label class="control-label">Página:</label>
            <div class="input-group">
              <input type="hidden" value="" name="" class="uri-input link">
              <div class="form-control titulo"></div>
              <span class="input-group-addon"><a href="<?php echo base_url('modulo/pagina/listar') ?>" class="filemanager grid_seleccionar"> seleccionar </a></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>