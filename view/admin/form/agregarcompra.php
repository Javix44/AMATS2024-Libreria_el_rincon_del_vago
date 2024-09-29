<?php
$ProveedorController = new ProveedorController();
$Prove =  $ProveedorController->ShowProveedores();
$productoController = new ProductoController();
?>
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
                    <input type="hidden" value="<?php echo $Usuario ?>" id="IdUsuario" name="IdUsuario">
                    <input type="hidden" id="idproducto" name="idproducto">
                    <div class="form-group">
                        <label for="exampleInputUsername1">Elemento Ingresado</label> <br>
                        <button type='button' class='btn btn-primary' onclick='openmodalSeleccion()'>
                            Listar <i class='mdi mdi-format-list-bulleted-type'></i>
                        </button>
                        <br>
                        <input name="nombre" type="text" class="form-control" placeholder="Producto Seleccionado a Registrar" readonly>
                    </div>

                    <div class="form-group">
                        <label for="exampleTextarea1">Cantidad Ingresada</label>
                        <input type="number" class="form-control" name="cantidad_ingreso" min="1" placeholder="Cantidad Ingresada" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleTextarea1">Proveedor</label>
                        <div>
                            <select class="form-control" name="id_proveedor" required>
                                <option selected>Seleccionar Proveedor</option>
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <table id="tablaProductos" class="table table-striped table-hover table-borderless">
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
                                    <button type="button" class="btn btn-dark agregar-herramienta" data-id="<?= htmlspecialchars($fila_producto->getIdProducto()) ?>" data-nombre="<?= htmlspecialchars($fila_producto->getNombre()) ?>">
                                        <i class="fa-solid fa-square-plus"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script>
    function openmodalSeleccion() {
        var modalSeleccion = new bootstrap.Modal(document.getElementById('modalSeleccion'));
        modalSeleccion.show();
    }
    $(document).ready(function() {
        // Inicializar DataTable
        $('#tablaProductos').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
            }
        });

        // Agregar evento click a los botones de agregar
        $('.agregar-herramienta').on('click', function() {
            var idProducto = $(this).data('id');
            var nombreProducto = $(this).data('nombre');

            // Establecer el ID del producto en el campo oculto
            $('#idproducto').val(idProducto);

            // Mostrar el nombre del producto en el botón o en otra etiqueta
            $('#btnListaCompleta').html('Producto Seleccionado: ' + nombreProducto + ' <i class="fa-solid fa-list-check"></i>');

            // Cerrar el modal
            $('#modalSeleccion').modal('hide');
        });

        $('#btnAgregar').on('click', function(e) {
            if ($('#idproducto').val() === '') {
                e.preventDefault();
                alert('Por favor, selecciona un producto antes de agregar.');
            }
        });

    });
</script>