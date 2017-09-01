<!-- Portafolio -->
<div class='columna relative root'>
    <?php  if($this->acceso->valida('columna','editar')) { ?> 
          <i class='tip-tools'></i>
          <div id='user-options'>
            <a href='<?php  echo base_url('modulo/columna/editar/4') ?> ' class='editar'><i class='icon-edit'></i></a>
          </div>
          <div class='editable'><div class='zona-editable'></div></div>
        <?php  } ?> 
    <?php 
    echo modules::run('catalogo/catalogodestacados/recomienda'); ?> 
</div>