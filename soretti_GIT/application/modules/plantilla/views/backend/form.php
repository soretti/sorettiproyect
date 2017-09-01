<!DOCTYPE html>
<html>
<head>
    <title><?php echo $this->titulo ?></title>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script>
        var base_url='<?php echo base_url() ?>';
    </script>

     <!-- jQuery -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="<?php echo base_url('pub/libraries/jquery/jquery.popupWindow.js') ?>"></script>

     <!-- Jquery cookies  -->
     <script type="text/javascript" src="<?php echo base_url('pub/libraries/jquerycookie') ?>/jquery.cookie.js"></script>

     <!-- Jquery ui  -->
     <script type="text/javascript" src="//code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>  
     <link rel="stylesheet" media="all" type="text/css" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

     <!-- Juery timepicker calendario -->
     <script type="text/javascript" src="<?php echo base_url('pub/libraries/jquerytimepicker') ?>/jquery-ui-timepicker-addon.js"></script>    
     <link rel="stylesheet" media="all" type="text/css" href="<?php echo base_url('pub/libraries/jquerytimepicker') ?>/timepicker.css" />

     <!-- FANCYBOX -->
    <link rel="stylesheet" href="<?php echo base_url('pub/libraries/fancybox/jquery.fancybox.css?v=2.1.5'); ?>" type="text/css" media="screen" />
    <script type="text/javascript" src="<?php echo base_url('pub/libraries/fancybox/jquery.fancybox.js?v=2.1.5'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('pub/libraries/fancybox/jquery.mousewheel-3.0.6.pack.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('pub/libraries/fancybox/helpers/jquery.fancybox-media.js'); ?>"></script>
    
    <!-- Bootstrap -->
    <link href="<?php echo base_url('pub/libraries/bootstrap-3.2.0-dist/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('pub/libraries/bootstrap-3.2.0-dist/css/bootstrap-theme.min.css') ?>" rel="stylesheet">
    <script src="<?php echo base_url('pub/libraries/bootstrap-3.2.0-dist/js/bootstrap.min.js') ?>"></script>

    <!-- palabras clave -->
    <link href="<?php echo base_url('pub/libraries/tags/jquery.tagit.css') ?>" rel="stylesheet" media="screen">
    <link href="<?php echo base_url('pub/libraries/tags/tagit.ui-zendesk.css') ?>" rel="stylesheet" media="screen">
    <script src="<?php echo base_url("pub/libraries/tags/tag-it.min.js") ?>"></script>

     <!-- TINYMCE -->
    <script type="text/javascript" src="<?php echo base_url('pub/libraries/tinymce') ?>/tinymce.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('pub/libraries/tinymce') ?>/jquery.tinymce.min.js"></script>
    
    <!-- TRAHC TOOLS CSSS -->
    <script src="<?php echo base_url("pub/libraries/trahctools/js/input_file_elfinder.js") ?>"></script>
    <script src="<?php echo base_url("pub/libraries/trahctools/js/trahctools.js") ?>"></script>
    <link href="<?php echo base_url('pub/libraries/trahctools/css/backend.css') ?>" rel="stylesheet" media="screen">
 
    <?php 
    
    if(is_array($this->layout_assets)) foreach ($this->layout_assets as $key => $assets) {
        switch ($key) {
            case 'css':
                foreach ($assets as $value) {
                    echo '<link href="'.$value.'" rel="stylesheet" media="screen">';
                }
            break; 
            case 'js':
                foreach ($assets as $value) {
                    echo '<script src="'.$value.'"></script>';
                }
            break;
        }
    }?>

</head>
<body class="backend">
    <?php  echo modules::run('admin/menu');  ?>
    <div class="container">
        <div class="panel panel-default">
          <div class="panel-heading"><?php echo $this->titulo; ?></div>
          <div class="panel-body">
              <?php echo $this->layout_content; ?>
          </div>
        </div>
    </div>
</body>
</html>