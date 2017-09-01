<?php if($combinaciones->result_count()){ ?>
<script>
var combinaciones=<?php echo json_encode($producto_combinaciones); ?>;
</script>
<?php } ?>
<?php $producto->cat_imagen->order_by('sort','asc')->get(); ?>
<div class="row relative" itemscope itemtype="http://schema.org/Product">
  <?php  if($this->acceso->valida('catalogo','editar')) { ?>
  <i class="tip-tools"></i>
  <div id="user-options">
    <a href="<?php echo base_url('modulo/catalogo/editar/'.$producto->id); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
  </div>
  <div class="editable"><div class="zona-editable"></div></div>
  <?php } ?>
  <div class="col-md-12">
    <?php echo $breadcrum; ?>
  </div>
  <div class="col-md-12">
    <?php if($this->session->flashdata('is_out_of_stock')) {?>
    <div class="alert alert-danger">
      <?php echo $this->session->flashdata('is_out_of_stock'); ?>
    </div>
    <?php } ?>
  </div>
  <div class="col-md-6">
    <div class="row">
    <?php if($producto->cat_imagen->result_count()>1 ) {?>
   
      <?php foreach ($producto->cat_imagen as $imagen): ?>
        
          <div class="col-md-6">
            <div class="item img-proyectos" imageId="<?php echo $imagen->id ?>">
              
                <img class="img-responsive img-mini" src="<?php echo base_url('pub/uploads/thumbs/'.name_image($imagen->imagen,'catalogo','cat_imagen',$producto->cat_imagen->thumb_w,$producto->cat_imagen->thumb_h)) ?>" alt="<?php echo $imagen->titulo ?>" >
              
            </div>
          </div>
       
      <?php endforeach ?>
   
    <?php } ?>
    </div>
  </div>
  <div class="col-md-6">
    <form method="post" action="<?php echo base_url('tienda/carrito/agregar/'.$producto->id) ?>">
      <h1><?php echo $producto->titulo; ?></h1>
      <?php $precio=$producto->precio(1,$producto,$producto->combinacion); ?>
      
      <div class="alert alert-warning hide"></div>
      <?php if($combinaciones->result_count()){ ?>
      <div class="combinaciones">
        <?php foreach ($atributos_padre->result() as $indice=>$atributo) {?>
        <div class="form-group">
          <label for="" class="label_atributos"><?php echo $atributo->nombre ?></label>
          <?php if($atributo->tipo==1) {?>
          <select name="atributo_<?php echo $indice; ?>" id="" class="atributo">
            <?php foreach ($atributo->valores as $valor) {?>
            <option stringValue="<?php echo $valor->nombre; ?>"  value="<?php echo $valor->id ?>" <?php  if(in_array($valor->id,explode(",",$producto->combinacion->combinaciones))) echo "selected"; ?> ><?php echo $valor->nombre ?></option>
            <?php } ?>
          </select>
          <?php } ?>
          <?php if($atributo->tipo==2) {?>
          <?php foreach ($atributo->valores as $valor) {?>
          <input stringValue="<?php echo $valor->nombre; ?>"  type="radio" name="atributo_<?php echo $indice; ?>" id="atributo_<?php echo $indice."_".$valor->id; ?>" value="<?php echo $valor->id ?>" class="atributo" <?php  if(in_array($valor->id,explode(",",$producto->combinacion->combinaciones))) echo "checked"; ?>>
          <label class="tipo2" color="<?php echo $valor->micolor ?>" for="atributo_<?php echo $indice."_".$valor->id; ?>">
            <?php echo $valor->nombre ?>
          </label>
          <?php } ?>
          <?php } ?>
          <?php if($atributo->tipo==3) {?>
          <?php foreach ($atributo->valores as $valor) {?>
          <input stringValue="<?php echo $valor->nombre; ?>"  type="radio" name="atributo_<?php echo $indice; ?>" id="atributo_<?php echo $indice."_".$valor->id; ?>" value="<?php echo $valor->id ?>" class="radio_3 atributo" <?php  if(in_array($valor->id,explode(",",$producto->combinacion->combinaciones))) echo "checked"; ?>>
          <label class="tipo3" color="<?php echo $valor->micolor ?>" for="atributo_<?php echo $indice."_".$valor->id; ?>">
            <div></div>
          </label>
          <?php } ?>
          <?php } ?>
        </div>
        <? } ?>
      </div>
      <?php } ?>
      
      <?php if($producto->descripcion) {?>
      <div class="fila">
        <div class="row">
        </div>
        <div>
          <?php echo $producto->descripcion ?>
        </div>
      </div>
      <?php } ?>
    </form>
  </div>
</div>
 
