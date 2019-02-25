<?php
$resource_host = $_SERVER['HTTP_HOST'];
?>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $sitename; ?>会员信息管理系统</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="<?php echo 'http://' . $resource_host; ?>/favicon.ico" type="image/x-icon"/> 
        <!-- Vendor styles -->
        <link rel="stylesheet" href="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
        <link rel="stylesheet" href="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/animate.css/animate.min.css">
        <link rel="stylesheet" href="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/jquery.scrollbar/jquery.scrollbar.css">
        <link rel="stylesheet" href="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/fullcalendar/dist/fullcalendar.min.css">
        <link rel="stylesheet" href="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/sweetalert2/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/lightgallery/dist/css/lightgallery.min.css">
        <link rel="stylesheet" href="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/trumbowyg/dist/ui/trumbowyg.min.css">
        <link rel="stylesheet" href="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css">
        <link rel="stylesheet" href="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/nouislider/distribute/nouislider.min.css">
        <link rel="stylesheet" href="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/flatpickr/dist/flatpickr.min.css" />
        <link rel="stylesheet" href="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/dropzone/dist/dropzone.css">
        <link rel="stylesheet" href="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/select2/dist/css/select2.min.css">
        <!-- App styles -->
        <link rel="stylesheet" href="<?php echo 'http://' . $resource_host; ?>/css/app.min.css">
        <!-- Javascript -->
        <!--Vendors -->
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/tether/dist/js/tether.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/Waves/dist/waves.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/jquery.scrollbar/jquery.scrollbar.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/jquery-scrollLock/jquery-scrollLock.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/jqvmap/dist/jquery.vmap.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/jqvmap/dist/maps/jquery.vmap.world.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/salvattore/dist/salvattore.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/jquery.sparkline/jquery.sparkline.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/moment/min/moment.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
        <!--Vendors Data tables -->
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/jszip/dist/jszip.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <!--Alerts-->
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/remarkable-bootstrap-notify/dist/bootstrap-notify.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/sweetalert2/dist/sweetalert2.min.js"></script>
        <!--Gallery-->
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/lightgallery/dist/js/lightgallery.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/lightgallery/demo/js/lg-fullscreen.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/lightgallery/demo/js/lg-thumbnail.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/lightgallery/demo/js/lg-zoom.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/lightgallery/demo/js/lg-video.min.js"></script>
        <!--Notes-->
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/Clamp.js/clamp.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/trumbowyg/dist/trumbowyg.min.js"></script>
        <!--Forms-->
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/select2/dist/js/select2.full.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/dropzone/dist/min/dropzone.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/flatpickr/dist/flatpickr.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/nouislider/distribute/nouislider.min.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
        <!--Flot Charts-->
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/flot/jquery.flot.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/flot/jquery.flot.pie.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/flot/jquery.flot.resize.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/flot.orderbars/js/jquery.flot.orderBars.js"></script>
        <!-- Charts and maps-->
        <script src="<?php echo 'http://' . $resource_host; ?>/demo/js/flot-charts/curved-line.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/demo/js/flot-charts/line.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/demo/js/flot-charts/chart-tooltips.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/demo/js/other-charts.js"></script>
        <script src="<?php echo 'http://' . $resource_host; ?>/demo/js/jqvmap.js"></script>
        <!--Form-->
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/autosize/dist/autosize.min.js"></script>
        <!-- App functions and actions -->
        <script src="<?php echo 'http://' . $resource_host; ?>/js/app.min.js"></script>
        <!--countUp-->
        <script src="<?php echo 'http://' . $resource_host; ?>/js/countUp.js"></script>
        <!--Sidebar-->
        <script src="<?php echo 'http://' . $resource_host; ?>/js/public.js"></script>
    </head>