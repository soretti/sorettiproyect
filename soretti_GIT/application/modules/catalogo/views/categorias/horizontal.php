  <!-- Navigation -->
    <nav class="navbar navbar-inverse relative" role="navigation">

                <?php  if($this->acceso->valida('menu','editar')) {?>
                    <i class="tip-tools"></i>
                    <div id="user-options">
                         <a href="<?php echo base_url('modulo/catalogo/catalogocategoria/editar'); ?>" class="editar"><span class="glyphicon glyphicon-edit"></span></a>
                    </div>
                    <div class="editable"><div class="zona-editable"></div></div>
                <?php } ?>


            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                 <a class="navbar-brand hide" href="#"><?php echo $this->lang->line('catalogo'); ?> Bondy Fiesta</a>

            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse menu-principal" id="bs-example-navbar-collapse-1">
                 <?php echo $menu_categorias ?>
            </div>
            <!-- /.navbar-collapse -->

        <!-- /.container -->
    </nav>