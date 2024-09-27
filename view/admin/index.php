<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Corona Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../template/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../template/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../../template/assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="../../template/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../../template/assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="../../template/assets/vendors/owl-carousel-2/owl.theme.default.min.css">

    <!-- plugins para los formularios -->
    <link rel="stylesheet" href="../../template/assets/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="../../template/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../../template/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../../template/assets/images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <!-- menu izquierdo -->
        <?php
        require_once("menulateral.php");
        ?>

        <div class="container-fluid page-body-wrapper">
            <!-- barra arriba -->
            <?php
            require_once("menusuperiror.php");
            ?>
            <!-- contenido -->
            <!-- por el momento no borrar aqui va ir contenido -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <!-- dentro de aqui va ir llamdo de cada pagina -->
                    <?php
                    //por el momento no hay secciones creadas
                    //$pages = new Pages();
                    // require_once($pages->ViewPage());
                    require_once("form/agregarusuario.php")
                    ?>
                </div>
                <!-- Aqui tenemos el pie de pagina -->
                <?php
                require_once("footer.php");
                ?>
            </div>
            <!-- main-panel ends -->
        </div>
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../template/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../../template/assets/vendors/chart.js/Chart.min.js"></script>
    <script src="../../template/assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="../../template/assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="../../template/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="../../template/assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <!-- plugins para formularios -->
    <script src="../../template/assets/vendors/select2/select2.min.js"></script>
    <script src="../../template/assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../../template/assets/js/off-canvas.js"></script>
    <script src="../../template/assets/js/hoverable-collapse.js"></script>
    <script src="../../template/assets/js/misc.js"></script>
    <script src="../../template/assets/js/settings.js"></script>
    <script src="../../template/assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="../../template/assets/js/dashboard.js"></script>
    <!-- Custom para formularios -->
    <script src="../../template/assets/js/file-upload.js"></script>
    <script src="../../template/assets/js/typeahead.js"></script>
    <script src="../../template/assets/js/select2.js"></script>
    <!-- End custom js for this page -->
</body>

</html>