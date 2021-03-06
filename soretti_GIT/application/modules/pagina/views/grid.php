<form action="" method="post" id="myform">
  <input type="hidden" name="ordenar" id="ordenar" value="">
  <div class="row">
    <div class="col-md-12">
      <?php if($this->session->flashdata('mensaje')) {?>
      <div class="alert alert-success">
        <?php echo $this->session->flashdata('mensaje'); ?>
      </div>
      <?php } ?>
    </div>
  </div>
  <div class="row">
      <div class="col-md-8">
        <?php if($this->acceso->valida('pagina','editar')) {?>
        <a class="btn btn-primary"  href="<?php echo base_url('modulo/pagina/agregar') ?>"><i class="glyphicon glyphicon-plus icon-white"></i> Agregar</a>
        <?php } ?>
        <?php if($this->acceso->valida('pagina','eliminar')) {?>
        <a class="btn btn-danger seleccionados" href="<?php echo base_url('modulo/pagina/eliminar') ?>" ><i class="glyphicon glyphicon-trash icon-white"></i> Eliminar seleccionados</a>
        <?php } ?>
      </div>
      <div class="col-md-4" style="text-align:right">
        <div class="input-group">
           <input class="form-control" id="" name="buscar"  type="text" value="<?php echo $this->session->userdata('pagina_buscar') ?>">
           <span class="input-group-btn"><input class="btn btn-default"  type="submit" name="action_buscar" value="Buscar" ></span>
        </div>
      </div>
 </div>
  <div class="row">
      <div class="col-md-12">  
        <div class="table-responsive">
          <table class="table table-bordered grid">
            <thead>
              <tr>
                <th><input type="checkbox" class="checkall"></th>
                <th class="titulo_campos" campo="id">ID <?php icon_order($this->session->userdata('pagina_ordenar'),'id'); ?></th>
                <th class="titulo_campos" campo="titulo">TITULO <?php icon_order($this->session->userdata('pagina_ordenar'),'titulo'); ?></th>
                <th class="titulo_campos" campo="contenido">CONTENIDO <?php icon_order($this->session->userdata('pagina_ordenar'),'contenido'); ?></th>
                <th class="titulo_campos" campo="fecha_creacion">FECHA CREACIÓN <?php icon_order($this->session->userdata('pagina_ordenar'),'fecha_creacion'); ?></th>
                <th class="titulo_campos" campo="hits">HITS <?php icon_order($this->session->userdata('pagina_ordenar'),'hits'); ?></th>
                <th class="">ACCIONES</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($paginas as $pagina) { ?>
              <tr>
                <td nowrap><input type="checkbox" value="<?php echo $pagina->id; ?>"  name="post_ids[]"></td>
                <td nowrap><?php echo $pagina->id; ?></td>
                <td ><?php echo $pagina->titulo; ?></td>
                <td ><?php echo character_limiter(strip_tags($pagina->contenido),120); ?></td>
                <td ><?php echo $this->dateutils->datees(strtotime($pagina->fecha_creacion),'C','c','m'); ?></td>
                <td ><?php echo $pagina->hits; ?></td>
                <td nowrap>
                  <?php
                    if(!$pagina->tipo) $pagina->tipo='web';
                  ?>
                  <button class="btn  btn-default btn-sm seleccionar" type="button" value="<?php echo $pagina->id; ?>" titulo="<?php echo $pagina->titulo; ?>" uri="<?php echo ($pagina->uri=='') ? site_url() : site_url($pagina->tipo.'/'.$pagina->uri); ?>" >Insertar</button>
                  
                  <?php if($pagina->tipo=='blogs') {?>
                  <a href="<?php echo base_url('modulo/blog/listar/'.$pagina->id); ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon glyphicon-th-list"></i></a>
                  <?php } ?>

                  <?php if($pagina->tipo=='galeria') {?>
                    <a href="<?php echo base_url('modulo/galeria/editar/'.$pagina->id); ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon glyphicon-th-list"></i></a>
                  <?php } ?>
                  
                  <?php if($this->acceso->valida('pagina','consultar')) {?>
                  <a href="<?php echo base_url('modulo/pagina/editar/'.$pagina->id); ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-edit"></i></a>
                  <?php } ?>
                  <?php if($this->acceso->valida('pagina','eliminar') && $pagina->id!=24) {?>
                  <button class="btn btn-danger btn-sm  action_row" value="basura" type="button" href="<?php echo base_url('modulo/pagina/eliminar'); ?> " ><i class="glyphicon glyphicon-trash"></i></button>
                  <?php } ?>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
         <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
  </div>
</form>