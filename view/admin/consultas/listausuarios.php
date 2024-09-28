<?php

$usuarioController = new UsuarioController();


//logica para actualizar
if (isset($_POST["actualizar"])) {
    $mensaje = "";
    $mensaje = $usuarioController->UpdateUsuario(new Usuario(
        $_POST["id"],
        $_POST["nombre"],
        $_POST["nomUsu"],
        null,
        $_POST["email"],
        $_POST["cargo"],
        $_POST["estado"]
    ));

    // Suponiendo que $mensaje contiene el resultado de la inserción
    if (!empty($mensaje)) {
        // Escribimos el mensaje en un alert y redirigimos a la misma página
        echo "<script>alert('$mensaje');</script>";
        echo "<script>location.href='listausuarios';</script>";
    } else {
        // Si no hay mensaje, mostramos un error genérico
        echo "<script>alert('Error al actualizar usuario');</script>";
        echo "<script>location.href='listausuarios';</script>";
    }
}

//logica para eliminar
if (isset($_POST["eliminar"])) {
    $mensaje = "";
    $mensaje = $usuarioController->DeleteUsuario($_POST["id"]);
    // Suponiendo que $mensaje contiene el resultado de la eliminación
    if (!empty($mensaje)) {
        echo "<script>alert('$mensaje');</script>";
        echo "<script>location.href='listausuarios';</script>";
    } else {
        echo "<script>alert('Error al eliminar usuario');</script>";
        echo "<script>location.href='listausuarios';</script>";
    }
}
$listaUsuarios = $usuarioController->ShowUsuarios();
?>
<div class="page-header">
    <h3 class="page-title"> Usuarios </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Ver Usuarios</a></li>
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
                                <th>Nombre Usuario</th>
                                <th>Correo</th>
                                <th>Cargo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($listaUsuarios as $usu) {
                                $verCargo = $usu->getEsAdmin() == 1 ? "Administrador" : "Cajero";
                                $verEstado = $usu->getEstado() == 1 ? "Activo" : "Inactivo";

                                echo "
                                <tr>
                                <td>" . htmlspecialchars($usu->getNombre()) . "</td>
                                <td>" . htmlspecialchars($usu->getNombreUsu()) . "</td>
                                <td>" . htmlspecialchars($usu->getCorreo()) . "</td>
                                <td>" . htmlspecialchars($verCargo) . "</td>
                                <td>" . htmlspecialchars($verEstado) . "</td>
                                <td>
        <form method='post'>
            <input type='hidden' name='id' value='" . $usu->getIdUsuario() . "'>
            <button type='submit' name='eliminar' class='btn btn-outline-danger btn-icon-text'>
                <i class='mdi mdi-delete-forever btn-icon-append'></i> Eliminar
            </button>
        
<button type='button' class='btn btn-outline-secondary btn-icon-text' onclick='openEditModal(" . $usu->getIdUsuario() . ", 
\"" . addslashes($usu->getNombre()) . "\",
\"" . addslashes($usu->getNombreUsu()) . "\", 
\"" . addslashes($usu->getCorreo()) . "\", 
\"" . ($usu->getEsAdmin() == 1 ? '1' : '0') . "\", 
\"" . ($usu->getEstado() == 1 ? '1' : '0') . "\")'>
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
                <h5 class="modal-title" id="editModalLabel">Editar Usuario</h5>
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
                        <label for="editNombre">Nombre completo</label>
                        <input name="nombre" type="text" class="form-control" id="editNombre" placeholder="nombre completo" required>
                    </div>
                    <div class="form-group">
                        <label for="editNomUsu">Nombre de Usuario</label>
                        <input name="nomUsu" type="text" class="form-control" id="editNomUsu" placeholder="nombre de usuario" required>
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email address</label>
                        <input name="email" type="email" class="form-control" id="editEmail" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="selectCargo">Cargo</label>
                        <select name="cargo" class="form-control" id="selectCargo" required>
                            <option value="">Seleccione un cargo</option>
                            <option value="1">Administrador</option>
                            <option value="0">Cajero</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="selectEstado">Estado</label>
                        <select name="estado" class="form-control" id="selectEstado" required>
                            <option value="">Seleccione un estado</option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
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

    function openEditModal(id, nombre, nombreUsu, email, cargo, estado) {
        document.getElementById('editId').value = id;
        document.getElementById('editNombre').value = nombre;
        document.getElementById('editNomUsu').value = nombreUsu;
        document.getElementById('editEmail').value = email;
        document.getElementById('selectCargo').value = cargo;
        document.getElementById('selectEstado').value = estado;

        var editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
    }
</script>