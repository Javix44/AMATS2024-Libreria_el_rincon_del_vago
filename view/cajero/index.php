<?php
if (isset($_POST["notificar_admin"])) {
    $email_controller = new email_controller();
    $mensaje = $email_controller->sendStockBajoEmail();
    // Mostrar una alerta con el mensaje devuelto
    if (!empty($mensaje)) {
        echo "<script>alert('$mensaje');</script>";
        echo "<script>location.href='index';</script>";  // Redirigir a la página principal
    } else {
        echo "<script>alert('Error inesperado al enviar el correo');</script>";
        echo "<script>location.href='index';</script>";
    }
}
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
        <?php
        $url = isset($_GET["url"]) ? $_GET["url"] : null;
        $url = explode('/', $url);
        if ($url[0] == "Imprimir_Factura") {
        } else {
            require_once("menulateral.php");
        }
        ?>
        <div class="container-fluid page-body-wrapper">
            <!-- barra arriba -->
            <?php
            $url = isset($_GET["url"]) ? $_GET["url"] : null;
            $url = explode('/', $url);
            if ($url[0] == "Imprimir_Factura") {
            } else {
                require_once("menusuperior.php");
            }
            ?>
            <!-- contenido -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <!-- dentro de aqui va ir llamdo de cada pagina -->
                    <?php
                    $ProductoController = new ProductoController();

                    $pages = new Pages();
                    require_once($pages->ViewPage());
                    $url = isset($_GET["url"]) ? $_GET["url"] : null;
                    $url = explode('/', $url);
                    if ($url[0] == "index" || $url[0] == "index.php" || $url[0] == "") {
                        $resultados_admin = $ProductoController->Stock_Minimo();
                    ?>
                        <div class="container">
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
                                <tfoot>
                                    <td colspan="3">
                                        <form method="POST">
                                            <div class="text-center">
                                                <button type="submit" name="notificar_admin" class="btn btn-primary">
                                                    <i class="mdi mdi-bell-outline"></i> Notificar Administrador
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tfoot>
                            </table>
                        </div>
                        <?php
                        $listaProducto = $ProductoController->ShowProductos();
                        ?>
                        <div class="container mt-4">
                            <div class="row">
                                <div class="col-lg-12 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title text-center h2">Consulta de Listado de productos</h4>
                                            <div class="table-responsive">
                                                <table id="table" class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre</th>
                                                            <th>Descripcion</th>
                                                            <th>Categoria</th>
                                                            <th>Stock</th>
                                                            <th>Precio Venta</th>
                                                            <th>Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($listaProducto as $pro) {
                                                            $verEstado = $pro->getEstado() == 1 ? "Activo" : "Inactivo";
                                                            $descripcionCorta = substr($pro->getDescripcion(), 0, 18) . (strlen($pro->getDescripcion()) > 18 ? "..." : "");

                                                            echo "
                                                        <tr>
                                                        <td>" . $pro->getNombre() . "</td>
                                                        <td title='" . htmlspecialchars($pro->getDescripcion(), ENT_QUOTES) . "'>" . $descripcionCorta . "</td>
                                                        <td>" . $pro->getCategoria()->getNombre() . "</td>
                                                        <td>" . $pro->getStock() . "</td>
                                                        <td>" . $pro->getPrecioVenta() . "</td>
                                                        <td>" . $verEstado . "</td>
                                                        </tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            <?php
                    }
            ?>

            <!-- Aqui tenemos el pie de pagina -->
            <?php
            $url = isset($_GET["url"]) ? $_GET["url"] : null;
            $url = explode('/', $url);
            if ($url[0] == "Imprimir_Factura") {
            } else {
                require_once("footer.php");
            }
            ?>

            </div>
            <!-- main-panel ends -->
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
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
                },
                "initComplete": function() {
                    $('.paginate_button').addClass('btn btn-dark p-0');
                }
            });
        });
    </script>
</body>

</html>