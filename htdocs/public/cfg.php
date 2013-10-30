<?php ob_start(); ?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <title>Configuration Tool</title>
        <link href="cfg/css/bootstrap.css" rel="stylesheet">
        <link href="cfg/css/cfg.css" rel="stylesheet">
        <link href="cfg/css/bootstrap-responsive.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">

            <?php
//                session_start();
                include_once './cfg/cfg.php';
                $cfg = new Cfg();
                echo $cfg->render();
            ?>
        </div>
<!--        <script src="cfg/js/jquery.js"></script>
        <script src="cfg/js/bootstrap-transition.js"></script>
        <script src="cfg/js/bootstrap-alert.js"></script>
        <script src="cfg/js/bootstrap-modal.js"></script>
        <script src="cfg/js/bootstrap-dropdown.js"></script>
        <script src="cfg/js/bootstrap-scrollspy.js"></script>
        <script src="cfg/js/bootstrap-tab.js"></script>
        <script src="cfg/js/bootstrap-tooltip.js"></script>
        <script src="cfg/js/bootstrap-popover.js"></script>
        <script src="cfg/js/bootstrap-button.js"></script>
        <script src="cfg/js/bootstrap-collapse.js"></script>
        <script src="cfg/js/bootstrap-carousel.js"></script>
        <script src="cfg/js/bootstrap-typeahead.js"></script>-->
    </body>
</html>

<?php ob_end_flush(); ?>