<?php

$proveedorController = new ProveedorController();


//logica para actualizar
if (isset($_POST["actualizar"])) {
    $mensaje = "";
    $mensaje = $proveedorController->UpdateProveedor(new Proveedor(
        $_POST["id"],
        $_POST["nombre"],
        $_POST["email"],
        $_POST["telefono"]
    ));

    // Suponiendo que $mensaje contiene el resultado de la inserción
    if (!empty($mensaje)) {
        // Escribimos el mensaje en un alert y redirigimos a la misma página
        echo "<script>alert('$mensaje');</script>";
        echo "<script>location.href='listaproveedores';</script>";
    } else {
        // Si no hay mensaje, mostramos un error genérico
        echo "<script>alert('Error al actualizar usuario');</script>";
        echo "<script>location.href='listaproveedores';</script>";
    }
}

//logica para eliminar
if (isset($_POST["eliminar"])) {
    $mensaje = "";
    $mensaje = $proveedorController->DeleteProvedor($_POST["id"]);
    // Suponiendo que $mensaje contiene el resultado de la eliminación
    if (!empty($mensaje)) {
        echo "<script>alert('$mensaje');</script>";
        echo "<script>location.href='listaproveedores';</script>";
    } else {
        echo "<script>alert('Error al eliminar Proveedor');</script>";
        echo "<script>location.href='listaproveedores';</script>";
    }
}
$listaProveedor = $proveedorController->ShowProveedores();
?>
<div class="page-header">
    <h3 class="page-title"> Usuarios </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="agregarproveedores">Agregar Proveedores</a></li>
            <li class="breadcrumb-item active" aria-current="page">Administrar Usuarios</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Lista de usuarios</h4>
                <p class="card-description"> Información de usuarios</p>
                <div class="table-responsive">
                    <table id="table" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Telefono</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($listaProveedor as $pro) {
                                // $verEstado = $usu->getEstado() == 1 ? "Activo" : "Inactivo";

                                echo "
                                <tr>
                                <td>" . htmlspecialchars($pro->getNombre()) . "</td>
                                <td>" . htmlspecialchars($pro->getCorreo()) . "</td>
                                <td>" . htmlspecialchars($pro->getTelefono()) . "</td>
                                <td>
        <form method='post' onsubmit='return confirmarEliminacion(\"" . addslashes($pro->getNombre()) . "\");'>
            <input type='hidden' name='id' value='" . $pro->getIdProveedor() . "'>
            <button type='submit' name='eliminar' class='btn btn-outline-danger btn-icon-text'>
                <i class='mdi mdi-delete-forever btn-icon-append'></i> Eliminar
            </button>
        
<button type='button' class='btn btn-outline-secondary btn-icon-text' onclick='openEditModal(" . $pro->getIdProveedor() . ", 
\"" . addslashes($pro->getNombre()) . "\",
\"" . addslashes($pro->getCorreo()) . "\", 
\"" . addslashes($pro->getTelefono()) . "\")'>
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
                <h5 class="modal-title" id="editModalLabel">Editar Proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" method="post">
                    <!-- <div class="form-group"> -->
                    <!-- <label for="editId">ID</label> -->
                    <input name="id" type="hidden" class="form-control" id="editId" required>
                    <!-- </div> -->
                    <div class="form-group">
                        <label for="exampleInputUsername1">Nombre </label>
                        <input name="nombre" type="text" class="form-control" placeholder="nombre completo" id="editNombre" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input name="email" type="email" class="form-control" id="editEmail" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Telefono</label>
                        <input name="telefono" type="text" class="form-control" id="editTelefono" placeholder="0000-0000" oninput="formatearTelefono(this)" maxlength="9" required>
                    </div>
                    <!-- <div class="form-group">
                        <label for="selectEstado">Estado</label>
                        <select name="estado" class="form-control" id="selectEstado" required>
                            <option value="">Seleccione un estado</option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div> -->
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

    function openEditModal(id, nombre, email, telefono) {
        document.getElementById('editId').value = id;
        document.getElementById('editNombre').value = nombre;
        document.getElementById('editEmail').value = email;
        document.getElementById('editTelefono').value = telefono;
        // document.getElementById('selectEstado').value = estado;

        var editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
    }

    function formatearTelefono(input) {
        let valor = input.value.replace(/\D/g, '');
        if (valor.length > 4) {
            valor = valor.slice(0, 4) + '-' + valor.slice(4);
        }
        input.value = valor;
    }

    function confirmarEliminacion(nombre) {
        return confirm('¿Estás seguro de que deseas eliminar al proveedor ' + nombre + '? Esta acción no se puede deshacer.');
    }
</script>