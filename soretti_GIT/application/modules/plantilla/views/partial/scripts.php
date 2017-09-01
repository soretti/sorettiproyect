 <!-- Path Predefinido -->
 <script>
    <?php $lang=(IDIOMA=='_en') ? 'en/' : ''; ?>
 	  var base_url="<?php echo base_url().$lang; ?>";
 </script>

<?php if(ENVIRONMENT=='development') {?>
        <link rel="stylesheet" href="<?php echo base_url('pub/libraries/fancybox/jquery.fancybox.css?v=2.1.5') ?>" type="text/css" media="screen" />
        <link href="<?php echo base_url('pub/libraries/font-awesome-4.3.0/css/font-awesome.min.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('pub/libraries/bootstrap-3.2.0-dist/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('pub/libraries/bootstrap-3.2.0-dist/css/bootstrap-theme.min.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('pub/libraries/cssmenu/styles.css') ?>" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('pub/libraries/owl-carousel/css/owl.carousel.css'); ?>" />
        <link href="<?php echo base_url('pub/theme/css/all.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('pub/theme/css/plantilla.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('pub/libraries/bootstrap-pricing-table/css/pricing-table.css') ?>" rel="stylesheet">
        <link rel='stylesheet' id='camera-css'  href='<?php echo base_url('pub/theme/css/camera.css'); ?>' type='text/css' media='all'>
        <link rel='stylesheet' href='<?php echo base_url('pub/theme/css/animate.css'); ?>' type='text/css' media='all'>
<?php } ?>

<?php if(ENVIRONMENT=='production') {?>
        <link href="<?php echo base_url('pub/theme/css/todo.css?v=1') ?>" rel="stylesheet">
<?php  } ?>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="<?php echo base_url('pub/libraries/bootstrap-filestyle/js/bootstrap-filestyle.min.js') ?>"> </script>

<?php if(ENVIRONMENT=='development') {?>
    <script src="<?php echo base_url('pub/theme/js/jquery.fractionslider.js'); ?>" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo base_url('pub/libraries/fancybox/jquery.fancybox.js?v=2.1.5'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('pub/libraries/fancybox/jquery.mousewheel-3.0.6.pack.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('pub/libraries/fancybox/helpers/jquery.fancybox-media.js'); ?>"></script>
    <script src="<?php echo base_url('pub/libraries/bootstrap-3.2.0-dist/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url('pub/libraries/owl-carousel/js/owl.carousel.js');?>"></script>
    <script src="<?php echo base_url('pub/libraries/pinterest_grid.js') ?>"></script>
    <script src="<?php echo base_url('pub/libraries/elevatezoom/jquery.elevatezoom.js') ?>"></script>
    <script src="<?php echo base_url('pub/libraries/cssmenu/script.js') ?>"></script>
    <script type='text/javascript' src='<?php echo base_url('pub/theme/js/camera.min.js'); ?>'></script> 
    <script src="<?php echo base_url('pub/theme/js/scripts.js') ?>"></script>
    <script src="<?php echo base_url('pub/libraries/wow.min.js') ?>"></script>
<?php } ?>

<?php if(ENVIRONMENT=='production') {?>
       <script src="<?php echo base_url('pub/theme/js/todo.js?v=1') ?>"></script>
<?php  }?>

<!-- Librerias para el Tool Bar Superior -->
<?php if($this->acceso->valida_login()) {?>
    <script src="<?php echo base_url('pub/libraries/toolbar/jquery.toolbar.js') ?>"></script>
    <script src="<?php echo base_url('pub/libraries/trahctools/js/edicion_frontal.js') ?>"></script>
    <script src="<?php echo base_url('pub/libraries/jquerycookie/jquery.cookie.js'); ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('pub/libraries/toolbar/jquery.toolbars.css') ?>" />
    <link href="<?php echo base_url('pub/libraries/trahctools/css/backend.css') ?>" rel="stylesheet">
    <style>
        body{
            margin-top: 180px !important;
        }
    </style>
<?php } ?>


<script>
    $(document).ready(function () {
        new WOW().init();
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
