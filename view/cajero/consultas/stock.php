<?php
$categoriaController = new CategoriaController();
$productoController = new ProductoController();


// Lógica para actualizar producto
if (isset($_POST["actualizar"])) {
    $mensaje = "";
    // Asegúrate de que estás utilizando la clase correcta, en este caso Producto
    $mensaje = $productoController->UpdateProducto(new Producto(
        $_POST["id"],
        null,
        $_POST["nombre"],
        $_POST["descripcion"],
        new Categoria($_POST["categoria"]),
        null,
        $_POST["umbral"],
        $_POST["precioCompra"],
        $_POST["precioVenta"],
        $_POST["estado"]
    ));

    // Verificamos el resultado de la actualización
    if (!empty($mensaje)) {
        // Mostramos el mensaje en un alert y redirigimos a la lista de productos
        echo "<script>alert('$mensaje');</script>";
        echo "<script>location.href='stock';</script>";
    } else {
        // Si no hay mensaje, mostramos un error genérico
        echo "<script>alert('Error al actualizar producto');</script>";
        echo "<script>location.href='stock';</script>";
    }
}


//logica para eliminar
if (isset($_POST["eliminar"])) {
    $mensaje = "";
    $mensaje = $productoController->DeleteProducto($_POST["id"]);
    // Suponiendo que $mensaje contiene el resultado de la eliminación
    if (!empty($mensaje)) {
        echo "<script>alert('$mensaje');</script>";
        echo "<script>location.href='stock';</script>";
    } else {
        echo "<script>alert('Error al eliminar producto');</script>";
        echo "<script>location.href='stock';</script>";
    }
}
$listaCategoria = $categoriaController->ShowCategorias();
$listaProducto = $productoController->ShowProductos();
?>
<div class="page-header">
    <h3 class="page-title"> Stock </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="agregarproducto">Agregar Producto</a></li>
            <li class="breadcrumb-item active" aria-current="page">Administrar Productos</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Lista de productos</h4>
                <p class="card-description"> Información de usuarios</p>
                <div class="table-responsive">
                    <table id="table" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Categoria</th>
                                <th>Stock</th>
                                <th>umbral</th>
                                <th>Precio Compra</th>
                                <th>Precio Venta</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($listaProducto as $pro) {
                                $verEstado = $pro->getEstado() == 1 ? "Activo" : "Inactivo";

                                echo "
                                <tr>
                                <td>" . $pro->getCodigo() . "</td>
                                <td>" . $pro->getNombre() . "</td>
                                <td>" . $pro->getDescripcion() . "</td>
                                <td>" . $pro->getCategoria()->getNombre() . "</td>
                                <td>" . $pro->getStock() . "</td>
                                <td>" . $pro->getUmbral() . "</td>
                                <td>" . $pro->getPrecioCompra() . "</td>
                                <td>" . $pro->getPrecioVenta() . "</td>
                                <td>" . $verEstado . "</td>
                                <td>
        <form method='post' onsubmit='return confirmarEliminacion(\"" . addslashes($pro->getNombre()) . "\");'>
            <input type='hidden' name='id' value='" . $pro->getIdProducto() . "'>
            <button type='submit' name='eliminar' class='btn btn-outline-danger btn-icon-text'>
                <i class='mdi mdi-delete-forever btn-icon-append'></i> Eliminar
            </button>
        
<button type='button' class='btn btn-outline-secondary btn-icon-text' 
onclick='openEditModal(" . $pro->getIdProducto() . ", 
\"" . addslashes($pro->getNombre()) . "\",
\"" . addslashes($pro->getDescripcion()) . "\",
\"" . addslashes($pro->getCategoria()->getIdCategoria()) . "\",
\"" . addslashes($pro->getUmbral()) . "\",
\"" . addslashes($pro->getPrecioCompra()) . "\", 
\"" . addslashes($pro->getPrecioVenta()) . "\",  
\"" . $pro->getEstado() . "\")'>
<i class='mdi mdi-border-color btn-icon-append'></i> Editar 
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
</div>
<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" method="post">
                    <!-- Campo para ingresar el ID del producto (oculto) -->
                    <input type="hidden" name="id" id="editId">

                    <!-- Campo para ingresar el nombre -->
                    <div class="form-group">
                        <label for="editNombre">Nombre</label>
                        <input name="nombre" type="text" class="form-control" id="editNombre" placeholder="Ingrese el nombre del producto" required>
                    </div>

                    <!-- Campo para ingresar la descripción -->
                    <div class="form-group">
                        <label for="editDescripcion">Descripción</label>
                        <textarea name="descripcion" class="form-control" id="editDescripcion" rows="3" placeholder="Ingrese la descripción del producto" required></textarea>
                    </div>

                    <!-- Select para elegir la categoría -->
                    <div class="form-group">
                        <label for="selectCategoria">Seleccione la categoría</label>
                        <select name="categoria" class="form-control" id="selectCategoria" required>
                            <option value=''>Seleccione una categoría</option>
                            <?php
                            foreach ($listaCategoria as $cat) {
                                echo "<option value='" . $cat->getIdCategoria() . "'>" . $cat->getNombre() . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Campo para ingresar el umbral -->
                    <div class="form-group">
                        <label for="editUmbral">Umbral</label>
                        <input name="umbral" type="number" class="form-control" id="editUmbral" placeholder="Ingrese el umbral mínimo" required>
                    </div>

                    <!-- Campo para ingresar el precio de compra -->
                    <div class="form-group">
                        <label for="editPrecioCompra">Precio de Compra</label>
                        <input name="precioCompra" type="number" step="0.01" class="form-control" id="editPrecioCompra" placeholder="Ingrese el precio de compra" required>
                    </div>

                    <!-- Campo para ingresar el precio de venta -->
                    <div class="form-group">
                        <label for="editPrecioVenta">Precio de Venta</label>
                        <input name="precioVenta" type="number" step="0.01" class="form-control" id="editPrecioVenta" placeholder="Ingrese el precio de venta" required>
                    </div>

                    <!-- Select para elegir estado -->
                    <div class="form-group">
                        <label for="selectEstado">Seleccione el estado</label>
                        <select name="estado" class="form-control" id="selectEstado" required>
                            <option value=''>Seleccione una categoría</option>
                            <option value='1'>Activo</option>
                            <option value='0'>Inactivo</option>
                        </select>
                    </div>

                    <button name="actualizar" type="submit" class="btn btn-primary mr-2">Actualizar</button>
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    function openEditModal(id, nombre, descripcion, idcategoria, umbral, precioCompra, precioVenta, estado) {
        document.getElementById('editId').value = id;
        document.getElementById('editNombre').value = nombre;
        document.getElementById('editDescripcion').value = descripcion;
        document.getElementById('editUmbral').value = umbral;
        document.getElementById('selectCategoria').value = idcategoria;
        document.getElementById('editPrecioCompra').value = precioCompra;
        document.getElementById('editPrecioVenta').value = precioVenta;
        document.getElementById('selectEstado').value = estado;

        var editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
    }

    function confirmarEliminacion(nombre) {
        return confirm('¿Estás seguro de que deseas eliminar al usuario ' + nombre + '? Esta acción no se puede deshacer.');
    }
</script>