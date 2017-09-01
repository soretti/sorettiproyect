
    <div class="inner relative">
        <?php  if($this->acceso->valida('menu','editar')) {?>
        <i class="tip-tools"></i>
        <div id="user-options">
            <a href="<?php echo base_url('modulo/catalogo/catalogoCategoria/editar'); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
        </div>
        <div class="editable"><div class="zona-editable"></div></div>
        <?php } ?>
        
        <div class="barra-azul text-center fila-top categorias ">
            Categorias
            <i class="fa fa-bars"></i>
        </div>
        <div class="modulo menu-categorias-vertical">
        <div id='cssmenu'>
            <ul>
                <?php foreach($categorias as $key => $c): ?>
                <?php $tmp1 = clone $c ?>
                <?php $c->where("padre_id",$c->id)->get() ?>
                <li class="
                    <?php if($c->result_count()): ?>has-sub<?php endif ?>
                    <?php if($categorias->result_count() == $key+1): ?> last<?php endif ?>
                    <?php if($this->uri->segment( 3 )==$tmp1->uri): ?> open<?php endif ?>">
                    <a href='<?php echo base_url('catalogo/'.$tmp1->uri.'.html') ?>'><span><?php echo ucfirst(strtolower($tmp1->titulo)) ?></span></a>
                    <?php if($c->result_count()): ?>
                    <ul>
                        <?php foreach ($c as $key2 => $subc):?>
                        <?php $tmp2 = clone $subc ?>
                        <?php $subc->where("padre_id",$subc->id)->get(); ?>
                        <li class="
                            <?php if($subc->result_count()): ?>has-sub<?php endif ?>
                            <?php if($c->result_count() == $key2+1): ?> last<?php endif ?>
                            <?php if($this->uri->segment( 3 )==$tmp2->uri): ?> open<?php endif ?>">
                            <a href='<?php echo base_url('catalogo/'.$tmp2->uri.'.html') ?>'><span><?php echo ucfirst(strtolower($tmp2->titulo)) ?></span></a>
                            <?php if($subc->result_count()): ?>
                            <ul>
                                <?php foreach ($subc as $key3 => $subc2):?>
                                <li class="<?php if($subc->result_count() == $key3+1): ?> last<?php endif ?><?php if($this->uri->segment( 3 )==$subc2->uri): ?> open<?php endif ?>"><a href='<?php echo base_url('catalogo/'.$subc2->uri.'.html') ?>'><span><?php echo ucfirst(strtolower($subc2->titulo)) ?></span></a></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        </div>
    </div>
 