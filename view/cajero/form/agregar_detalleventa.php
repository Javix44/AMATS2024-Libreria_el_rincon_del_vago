<?php
// Sesion con el id de venta
$id_venta = $_SESSION['id_venta'];
// Controladores
$VentaController = new VentaController();
$productoController = new ProductoController();
$email_controller = new email_controller();

if (isset($_POST["agregar_detalleventa"])) {
    // Creamos la variable mensaje y mandamos el objeto a la función 
    $mensaje = $VentaController->InsertDetalleVenta(new Producto(
        $_POST["idproducto"],
        $_POST["cantidad"],
        $id_venta,
    ));
    if (!empty($mensaje)) {
        echo "<script>alert('$mensaje');</script>";
        echo "<script>location.href='agregardetalles';</script>";
    } else {
        echo "<script>alert('Error al crear la Venta');</script>";
        echo "<script>location.href='agregardetalles';</script>";
    }
}

// Logica para eliminar registro
if (isset($_POST["eliminar"])) {
    $mensaje = $VentaController->DeleteDetalleVenta($_POST["id_detalle_venta"]);

    if (!empty($mensaje)) {
        echo "<script>alert('$mensaje');</script>";
        echo "<script>location.href='agregardetalles';</script>";
    } else {
        echo "<script>alert('Error al eliminar la venta');</script>";
        echo "<script>location.href='agregardetalles';</script>";
    }
}
// Logica para finalizar detalles y registrar venta
if (isset($_POST["finalizar_detalles"])) {
    $mensaje = $VentaController->FinalizarDetallesVenta($id_venta);
    $mensaje2 = $email_controller->sendComprobanteElectronicoEmail($id_venta);
    echo "<script>alert('$mensaje2');</script>";
    if (!empty($mensaje)) {
        echo "<script>alert('$mensaje');</script>";
        echo "<script>location.href='agregarventa';</script>";
    } else {
        echo "<script>alert('Error al eliminar la venta');</script>";
        echo "<script>location.href='agregardetalles';</script>";
    }

}

?>
<style>
    /* Estilo para el campo readonly */
    input[readonly] {
        background-color: #283038 !important;
        color: #fff !important;
    }
</style>
<div class="page-header">
    <h3 class="page-title"> Agregar Detalle venta</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Detalle de Ventas</li>
            <li class="breadcrumb-item"><a href="agregarventa">Agregar Ventas</a></li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Registrar Detalle de Venta</h4>
                <p class="card-description"> Ingrese la información </p>
                <!-- Formulario para registrar la compra -->
                <form class="forms-sample" method="post" enctype="multipart/form-data">
                    <!-- Inputs que guardan el id del usuario y del producto -->
                    <div class="form-group">
                        <label for="exampleInputUsername1">Elemento a vender</label> <br>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="nombreProducto" placeholder="Producto Seleccionado..." aria-describedby="button-addon2" readonly required>
                            <!-- Abre el modal del listado de productos -->
                            <button type='button' class='btn btn-primary' onclick='openmodalSeleccion()'>
                                Listar <i class='mdi mdi-format-list-bulleted-type'></i>
                            </button>
                            <input type="hidden" name="idproducto" id="idproducto" required>
                            <br>
                        </div>
                        <div class="form-group">
                            <label for="exampleTextarea1">Cantidad a vender</label>
                            <input type="number" class="form-control" name="cantidad" min="1" placeholder="Cantidad Ingresada" required>
                        </div>
                        <button name="agregar_detalleventa" type="submit" class="btn btn-primary mr-2" id="btnAgregar">Agregar</button>
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
                <table id="tablaProductos2" class="table">
                    <thead>
                        <tr>
                            <th class="text-center">Nombre Producto</th>
                            <th class="text-center">Existencias</th>
                            <th class="text-center">Agregar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productoController->ShowProductos2() as $fila_producto): ?>
                            <tr>
                                <td class="text-center"><?= htmlspecialchars($fila_producto->getNombre()) ?></td>
                                <td class="text-center"><?= htmlspecialchars($fila_producto->getStock()) ?></td>
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

<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Detalles de Venta Creada</h4>
            <!-- Tabla responsiva -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">Elemento</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ventas = $VentaController->ShowDetalleVenta($id_venta);
                        if (empty($ventas)) {
                            echo '<tr><td colspan="3" class="text-center"><strong>Sin Detalles...</strong></td></tr>';
                        } else {
                            foreach ($ventas as $fila_Ingreso) {
                                //Use los getters del modelo Venta porque era mas facil usar dicho modelo con 4 atributos que mandar 8 null por otro modelo
                                echo "<tr>
                                    <td class='text-center'>{$fila_Ingreso->getUsuario()}</td>
                                    <td class='text-center'>{$fila_Ingreso->getNombreCliente()}</td>
                                    <td class='text-center'>
                                        <form method='post'>
                                            <input type='hidden' name='id_detalle_venta' value='{$fila_Ingreso->getIdVenta()}'>
                                            <button type='submit' name='eliminar' class='btn btn-outline-danger btn-icon-text'>
                                                <i class='mdi mdi-delete-forever'></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>";
                            }
                            // Botón de finalizar detalles de venta
                            echo "<tr>
                              <td colspan='3' class='text-center'>
                                  <form method='post'>
                                      <button type='submit' name='finalizar_detalles' class='btn btn-success btn-icon-text'>
                                          <i class='mdi mdi-check-circle'></i> Finalizar detalles de venta
                                      </button>
                                  </form>
                              </td>
                          </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tablaProductos2').DataTable({
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