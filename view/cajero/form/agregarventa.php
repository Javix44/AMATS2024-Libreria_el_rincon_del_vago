<?php
// Controladores
$VentaController = new VentaController();
$IdUsuario = $_SESSION["IdUsuario"];
if (isset($_POST["agregar_venta"])) {
    // Creamos la variable mensaje y mandamos el objeto a la función 
    $mensaje = $VentaController->InsertVenta(new Venta(
        null,
        $IdUsuario,
        $_POST["nombre_cliente"],
        $_POST["correo_cliente"],
        null // Fecha asignada automáticamente por la BD
        // El estado predeterminado será "I" (Iniciado)
    ));
    // Suponiendo que $mensaje contiene el resultado de la inserción
    if (!empty($mensaje)) {
        echo "<script>alert('$mensaje');</script>";
        echo "<script>location.href='agregarventa';</script>";
    } else {
        echo "<script>alert('Error al crear la Venta');</script>";
        echo "<script>location.href='agregarventa';</script>";
    }
}
//Logica para eliminar registro
if (isset($_POST["eliminar"])) {
    $mensaje = $VentaController->DeleteVenta($_POST["id_venta"]);

    if (!empty($mensaje)) {
        echo "<script>alert('$mensaje');</script>";
        echo "<script>location.href='agregarventa';</script>";
    } else {
        echo "<script>alert('Error al eliminar la venta');</script>";
        echo "<script>location.href='agregarventa';</script>";
    }
}

//Logica de cambio de pagina
if (isset($_POST["agregar_detalle"])) {
    $idVenta = $_POST['id_venta'];
    $_SESSION['id_venta'] = $idVenta;
    // Redirigir a la página de detalles de la venta
    echo "<script>location.href='agregardetalles';</script>";
}

?>
<style>
    /* Para truncar el nombre del cliente con puntos suspensivos */
    td.text-center {
        white-space: nowrap;
        /* Evita que el texto haga un salto de línea */
        overflow: hidden;
        /* Oculta el texto que se salga del contenedor */
        text-overflow: ellipsis;
        /* Muestra los puntos suspensivos */
    }

    td.text-center:hover {
        overflow: visible;
        /* Permite que el texto completo se vea en el hover */
    }
</style>

<?php
// Controladores
$VentaController = new VentaController();
$IdUsuario = $_SESSION["IdUsuario"];

if (isset($_POST["agregar"])) {
    // Redirigir a agregardetalles con el id de la venta
    $idVenta = $_POST['id_venta'];
    echo "<script>location.href='agregardetalles?id={$idVenta}';</script>";
}

if (isset($_POST["eliminar"])) {
    $mensaje = $VentaController->DeleteVenta($_POST["id_venta"]);

    if (!empty($mensaje)) {
        echo "<script>alert('$mensaje');</script>";
        echo "<script>location.href='agregarventa';</script>";
    } else {
        echo "<script>alert('Error al eliminar la venta');</script>";
        echo "<script>location.href='agregarventa';</script>";
    }
}
?>
<div class="page-header">
    <h3 class="page-title">Agregar Venta</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="listaventa">Ver Registros</a></li>
            <li class="breadcrumb-item active" aria-current="page">Agregar Ventas</li>
        </ol>
    </nav>
</div>
<div class="row">
    <!-- Columna para el formulario -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Registrar Venta</h4>
                <p class="card-description">Ingrese la información</p>
                <form class="forms-sample" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nombre_cliente">Nombre Cliente</label>
                        <input type="text" class="form-control" name="nombre_cliente" placeholder="Ingrese nombre del cliente" required>
                    </div>
                    <div class="form-group">
                        <label for="correo_cliente">Correo Cliente</label>
                        <input type="email" class="form-control" name="correo_cliente" placeholder="Ingrese correo del cliente" required>
                    </div>
                    <button name="agregar_venta" type="submit" class="btn btn-primary mr-2">Agregar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Columna para la tabla -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Venta Creada</h4>
                <!-- Tabla responsiva -->
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">Cliente</th>
                                <th class="text-center">Detalles</th>
                                <th class="text-center">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $ventas = $VentaController->ShowVenta();
                            if (empty($ventas)) {
                                echo '<tr><td colspan="3" class="text-center"><strong>Sin Venta Activa</strong></td></tr>';
                            } else {
                                foreach ($ventas as $fila_Ingreso) {
                                    // Trunca el nombre del cliente si excede los 10 caracteres
                                    $nombreCliente = $fila_Ingreso->getNombreCliente();
                                    $nombreTruncado = (strlen($nombreCliente) > 10) ? substr($nombreCliente, 0, 10) . '...' : $nombreCliente;

                                    echo "<tr>
                                        <td class='text-center' title='{$nombreCliente}'>{$nombreTruncado}</td>
                                       <td class='text-center'>
                                            <form method='post'>
                                                <input type='hidden' name='id_venta' value='{$fila_Ingreso->getIdVenta()}'>
                                                <button type='submit' name='agregar_detalle' class='btn btn-outline-info btn-icon-text'>
                                                    <i class='mdi mdi-plus-circle-outline'></i> Agregar Detalles
                                                </button>
                                            </form>
                                        </td>
                                        <td class='text-center'>
                                            <form method='post'>
                                                <input type='hidden' name='id_venta' value='{$fila_Ingreso->getIdVenta()}'>
                                                <button type='submit' name='eliminar' class='btn btn-outline-danger btn-icon-text'>
                                                    <i class='mdi mdi-delete-forever'></i> Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>