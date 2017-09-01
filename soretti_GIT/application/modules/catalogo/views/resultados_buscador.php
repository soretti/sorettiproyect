<?php $direction=($this->direction_orden=='asc') ? array('direction'=>'desc','icon'=>'up') : array('direction'=>'asc','icon'=>'down'); ?>
<div class="row">
  <div class="col-md-12">
    <h1>Resultados de búsqueda: <?php echo $keyword; ?></h1>
  </div>
</div>
<div class="row fila controles">
  <div class="col-md-12 form-inline">
    <div class="controls">
      <strong class="trLabel"><?php echo $total_rows; ?> resultados</strong>
      <span class="trLabel"><?php echo $this->lang->line('ordenar') ?></span>
      <div class="input-group">
        <select class="control-catalogo form-control"  name="" id="" onChange="document.location='<?php echo url_idioma(site_url('buscador/catalogo/'.$keyword)); ?>?orden='+this.value">
          <option value="nombre" <?php if($this->orden=='nombre') echo "selected" ?> >A-z</option>
          <option value="popularidad" <?php if($this->orden=='popularidad') echo "selected" ?> ><?php echo $this->lang->line('popularidad') ?></option>
          <option value="precio" <?php if($this->orden=='precio') echo "selected" ?> >Precio</option>
        </select>
        <span class="input-group-btn">
          <a class="btn btn-default" href="<?php echo site_url('buscador/catalogo/'.$keyword) ?>?direction=<?php echo $direction['direction'] ?>" role="button"><i class="fa fa-angle-<?php echo $direction['icon'] ?>"></i></a>
        </span>
      </div>
      <span class="trLabel"><?php echo $this->lang->line('mostrar') ?> </span>
      <select  class="control-catalogo form-control" name="" id="" onChange="document.location='<?php echo url_idioma(site_url('buscador/catalogo/'.$keyword)); ?>?per_page='+this.value ">
        <option value="12" <?php if($this->per_page==12) echo "selected" ?> >12</option>
        <option value="24" <?php if($this->per_page==24) echo "selected" ?> >24</option>
        <option value="36" <?php if($this->per_page==36) echo "selected" ?> >36</option>
      </select>
      <span>por página</span>
  
<!--       <span class="trLabel">
        articulos con existencias 
        <input type="checkbox" name="" id="" <?php if($this->wstock=='true') echo "checked"; ?> onClick="document.location='<?php echo url_idioma(site_url('buscador/catalogo/'.$keyword)); ?>?wstock='+$(this).is(':checked')" > 
      </span> -->
    </div>
  </div>
</div>
<?php $this->load->view('catalogo/lista_productos'); ?>
