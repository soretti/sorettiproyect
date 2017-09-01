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
        <?php if($this->acceso->valida('chat','editar')) {?>
        <a class="btn btn-primary"  href="<?php echo base_url('modulo/chat/respuesta/agregar/') ?>"><i class="glyphicon glyphicon-plus icon-white"></i> Agregar</a>
        <?php } ?>
        <?php if($this->acceso->valida('chat','eliminar')) {?>
        <a class="btn btn-danger seleccionados" href="<?php echo base_url('modulo/chat/respuesta/eliminar') ?>" ><i class="glyphicon glyphicon-trash icon-white"></i> Eliminar seleccionados</a>
        <?php } ?>
      </div>
      <div class="col-md-4" style="text-align:right">
        <div class="input-group">
           <input class="form-control" id="" name="buscar"  type="text" value="<?php echo $this->session->userdata('respuesta_buscar') ?>">
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
                <th class="titulo_campos" campo="id">ID <?php icon_order($this->session->userdata('respuesta_ordenar'),'id'); ?></th>
                <th class="titulo_campos" campo="titulo">TITULO <?php icon_order($this->session->userdata('respuesta_ordenar'),'titulo'); ?></th>  
                <th class="titulo_campos" campo="tipo_id">CLASIFICACIÓN <?php icon_order($this->session->userdata('respuesta_ordenar'),'tipo_id'); ?></th>  
                <th class="titulo_campos" campo="snipet">SNIPET <?php icon_order($this->session->userdata('respuesta_ordenar'),'snipet'); ?></th>  
                <th class="">ACCIONES</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($paginas as $pagina) { ?>
              <tr>
                <td nowrap><input type="checkbox" value="<?php echo $pagina->id; ?>"  name="post_ids[]"></td>
                <td nowrap><?php echo $pagina->id; ?></td>
                <td><?php echo $pagina->titulo; ?></td>
                <td><?php echo $pagina->tipo_titulo; ?></td>
                <td><?php echo $pagina->snipet; ?></td>
                <td nowrap>
                  <button class="btn  btn-default btn-sm seleccionar" type="button" value="<?php echo $pagina->id; ?>" titulo="<?php echo $pagina->titulo; ?>" uri="<?php echo base_url('producto/'.$pagina->uri.".html"); ?>" > Insertar </button>
                  <div class="respuesta hide"><?php echo $pagina->respuesta; ?></div>
                  <?php if($this->acceso->valida('chat','consultar')) {?>
                  <a href="<?php echo base_url('modulo/chat/respuesta/editar/'.$pagina->id); ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-edit"></i></a>
                  <?php } ?>
                  <?php if($this->acceso->valida('chat','eliminar')) {?>
                  <button class="btn btn-danger btn-sm  action_row" value="basura" type="button" href="<?php echo base_url('modulo/chat/respuesta/eliminar/'); ?> " ><i class="glyphicon glyphicon-trash"></i></button>
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
<script>

  jQuery(document).ready(function($) {
       if(window.self !== window.top){
        $(".seleccionar").show();
     }
  });

 $(".seleccionar").click(function(){
    window.parent.$("#mensaje").val( $(this).next().text() );
    window.parent.$.fancybox.close();
 });

</script>