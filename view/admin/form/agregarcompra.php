<?php
//llamado controladores
$ProveedorController = new ProveedorController();
$Prove =  $ProveedorController->ShowProveedores();
$productoController = new ProductoController();
$CompraController = new CompraController();

if (isset($_POST["agregar"])) {
    // Validación de la cantidad ingresada
    $cantidadIngreso = $_POST["cantidad_ingreso"];
    if ($cantidadIngreso <= 0) {
        echo "<script>alert('La cantidad ingresada debe ser un número positivo.');</script>";
        echo "<script>location.href='ingresoproducto';</script>";
        exit; // Detenemos la ejecución del script si hay un error
    }
    // Creamos la variable mensaje y mandamos el objeto a la función 
    $mensaje = $CompraController->InsertIngreso(new Compra(
        null,
        $Usuario,
        $_POST["id_proveedor"],
        $_POST["idproducto"],
        null, // Fecha asignada por la BD automaticamente
        $cantidadIngreso
    ));

    // Suponiendo que $mensaje contiene el resultado de la inserción
    if (!empty($mensaje)) {
        echo "<script>alert('$mensaje');</script>";
        echo "<script>location.href='ingresoproducto';</script>";
    } else {
        echo "<script>alert('Error al registrar el ingreso');</script>";
        echo "<script>location.href='ingresoproducto';</script>";
    }
}
?>
<style>
    /* Estilo para el campo readonly */
    input[readonly] {
        background-color: #283038 !important;
        /* Color de fondo normal */
        color: #fff !important;
        /* Color del texto normal */
    }
</style>
<div class="page-header">
    <h3 class="page-title"> Ingreso de Productos</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="listaingresos">Ver Registros</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ingreso de Productos</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Registrar Ingreso de Producto</h4>
                <p class="card-description"> Ingrese la información </p>
                <!-- Aqui esta el formulario para registar la compra -->
                <form class="forms-sample" method="post" enctype="multipart/form-data">
                    <!-- Inputs que guardan el id del usuario y del producto -->
                    <input type="hidden" id="idproducto" name="idproducto">
                    <div class="form-group">
                        <label for="exampleInputUsername1">Elemento Ingresado</label> <br>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="nombreProducto" placeholder="Producto Seleccionado..." aria-describedby="button-addon2" readonly required>
                            <!-- Abre el modal del listado de productos -->
                            <button type='button' class='btn btn-primary' onclick='openmodalSeleccion()'>
                                Listar <i class='mdi mdi-format-list-bulleted-type'></i>
                            </button>
                            <br>
                        </div>
                        <div class="form-group">
                            <label for="exampleTextarea1">Cantidad Ingresada</label>
                            <input type="number" class="form-control" name="cantidad_ingreso" min="1" placeholder="Cantidad Ingresada" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleTextarea1">Proveedor</label>
                            <div>
                                <select class="form-control" name="id_proveedor" required>
                                    <option value="" selected>Seleccionar Proveedor</option>
                                    <?php foreach ($Prove as $fila_prove) {
                                        echo "<option value='" . $fila_prove->getIdProveedor() . "'>" . $fila_prove->getNombre() . "</option>";
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <button name="agregar" type="submit" class="btn btn-primary mr-2" id="btnAgregar">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para selección de producto -->
<div class="modal fade" id="modalSeleccion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Seleccionar Producto</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tablaProductos" class="table">
                    <thead>
                        <tr>
                            <th class="text-center">Nombre Producto</th>
                            <th class="text-center">Agregar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productoController->ShowProductos() as $fila_producto): ?>
                            <tr>
                                <td class="text-center"><?= htmlspecialchars($fila_producto->getNombre()) ?></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-dark" id="seleccionar" data-id="<?= htmlspecialchars($fila_producto->getIdProducto()) ?>" data-nombre="<?= htmlspecialchars($fila_producto->getNombre()) ?>">
                                        +
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tablaProductos').DataTable({
            language: {
                "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            }
        });
    });

    function openmodalSeleccion() {
        $('#modalSeleccion').modal('show');
    }

    $(document).on('click', '#seleccionar', function() {
        var idProducto = $(this).data('id');
        var nombreProducto = $(this).data('nombre');
        $('#idproducto').val(idProducto);
        $('#nombreProducto').val(nombreProducto);
        $('#modalSeleccion').modal('hide');
    });

    document.getElementById('btnAgregar').addEventListener('click', function(event) {
        var nombreProducto = document.getElementById('nombreProducto').value;

        if (nombreProducto === "") {
            event.preventDefault(); // Evita que el formulario se envíe
            alert("Por favor, selecciona un producto antes de agregar.");
        }
    });
</script>