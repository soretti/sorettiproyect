<?php if(isset($navegacion)) {?>
<div>
         <ol class="breadcrumb">
            <li>
                <a href="<?php echo site_url(); ?>"><i class="fa fa-home"></i></a>
            </li>
            <?php  foreach ($navegacion as $key => $item){ ?>
            <li>
                <a href="<?php echo url_idioma($item['uri']) ?>"><?php echo $item['titulo']; ?></a>
            </li>
            <?php } ?>
        </ol>
 
</div>
<?php } ?>
