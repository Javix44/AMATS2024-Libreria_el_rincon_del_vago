<?php
$Usuario =  $_SESSION["IdUsuario"];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Rincon del Estudiante | Admin </title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="template/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="template/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="template/assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="template/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="template/assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="template/assets/vendors/owl-carousel-2/owl.theme.default.min.css">

    <!-- plugins para los formularios -->
    <link rel="stylesheet" href="template/assets/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="template/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="template/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo URL ?>resources/img/libro-abierto.png">

    <!-- Cargar jQuery primero -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container-scroller">
        <!-- menu izquierdo -->
        <?php require_once("menulateral.php"); ?>

        <div class="container-fluid page-body-wrapper">
            <!-- barra arriba -->
            <?php require_once("menusuperior.php"); ?>
            <!-- contenido -->
            <!-- por el momento no borrar aqui va ir contenido -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <!-- dentro de aqui va ir llamdo de cada pagina -->
                    <?php
                    //por el momento no hay secciones creadas
                    $pages = new Pages();
                    require_once($pages->ViewPage());

                    $url = isset($_GET["url"]) ? $_GET["url"] : null;
                    $url = explode('/', $url);
                    if ($url[0] == "index.html") {
                        $ProductoController = new ProductoController();
                        $resultados_admin = $ProductoController->Stock_Minimo();
                    ?>
                        <div class="container mt-5">
                            <h2 class="text-center">Registro de Existencias de Productos Bajos</h2>
                            <table class="table table-striped table-hover table-borderless table-dark align-middle">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Cantidad Actual</th>
                                        <th class="text-center">Stock Mínimo</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    <?php
                                    if ($resultados_admin == NULL) {
                                    ?>
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <div class="alert alert-info" role="alert">
                                                    <strong>Existencias de Productos Suficientes</strong>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    } else {
                                        foreach ($resultados_admin as $fila) {
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= htmlspecialchars($fila->getNombre()) ?></td>
                                                <td class="text-center"><?= htmlspecialchars($fila->getStock()) ?></td>
                                                <td class="text-center"><?= htmlspecialchars($fila->getUmbral()) ?></td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php }
                    ?>
                </div>
                <!-- Aqui tenemos el pie de pagina -->
                <?php require_once("footer.php"); ?>
            </div>
            <!-- main-panel ends -->
        </div>
    </div>


    <!-- Otros scripts de vendor o dependencias -->
    <script src="template/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="template/assets/vendors/chart.js/Chart.min.js"></script>
    <script src="template/assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="template/assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="template/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="template/assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>

    <!-- plugins para formularios -->
    <script src="template/assets/vendors/select2/select2.min.js"></script>
    <script src="template/assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>

    <!-- Inicializar DataTables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <!-- Archivos personalizados -->
    <script src="template/assets/js/off-canvas.js"></script>
    <script src="template/assets/js/hoverable-collapse.js"></script>
    <script src="template/assets/js/misc.js"></script>
    <script src="template/assets/js/settings.js"></script>
    <script src="template/assets/js/todolist.js"></script>
    <script src="template/assets/js/dashboard.js"></script>
    <script src="template/assets/js/file-upload.js"></script>
    <script src="template/assets/js/typeahead.js"></script>
    <script src="template/assets/js/select2.js"></script>
</body>
</html>