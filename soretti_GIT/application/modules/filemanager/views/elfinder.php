<!DOCTYPE HTML>
<head>
    <title>File Manager ElFinder</title>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />

    <script type="text/javascript">
    var base_url='<?php echo base_url(); ?>';
    </script>

     <!-- jQuery -->
    <script type="text/javascript" src="<?php echo  base_url("pub/libraries/google/ajax/libs/jquery/1.6.2/jquery.min.js")?>" ></script>

    <!-- Trach tools -->
    <script type="text/javascript" src="<?php echo  base_url("pub/libraries/trahctools/js/trahctools.js")?>" ></script>
    <script type="text/javascript" src="<?php echo  base_url("pub/libraries/trahctools/js/elfinder.js")?>" ></script>

     <!-- jQuery UI -->
    <link rel="stylesheet" type="text/css" media="screen" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/smoothness/jquery-ui.css" />
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script>

    <!-- EL finder -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo  base_url("pub/modulos/filemanager")?>/css/elfinder.min.css">
    <script type="text/javascript" src="<?php echo  base_url("pub/modulos/filemanager")?>/js/elfinder.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo  base_url("pub/modulos/filemanager")?>/css/theme.css">
    <script type="text/javascript" src="<?php echo  base_url("pub/modulos/filemanager")?>/js/i18n/elfinder.es.js"></script>
</head>

<body>
    <form action="" method="post" id="myform">
      <div id="file-manager"></div>
      <input type="hidden" name="width" id="width">
      <input type="hidden" name="height" id="height">
      <input type="hidden" name="imagen" id="imagen">
      <input type="hidden" name="campo" id="campo">
      <input type="hidden" name="modulo" id="modulo">
    </form>
</body>
</html>
