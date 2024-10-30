<?php

$categoriaController = new CategoriaController();

//logica para actualizar
if (isset($_POST["actualizar"])) {
    $mensaje = "";
    $mensaje = $categoriaController->UpdateCategoria(new Categoria(
        $_POST["id"],
        $_POST["nombre"],
        $_POST["descripcion"],
        $_POST["estado"]
    ));

    // Suponiendo que $mensaje contiene el resultado de la inserción
    if (!empty($mensaje)) {
        // Escribimos el mensaje en un alert y redirigimos a la misma página
        echo "<script>alert('$mensaje');</script>";
        echo "<script>location.href='listacategorias';</script>";
    } else {
        // Si no hay mensaje, mostramos un error genérico
        echo "<script>alert('Error al actualizar usuario');</script>";
        echo "<script>location.href='listacategorias';</script>";
    }
}

//logica para eliminar
if (isset($_POST["eliminar"])) {
    $mensaje = "";
    $mensaje = $categoriaController->DeleteCategoria($_POST["id"]);
    // Suponiendo que $mensaje contiene el resultado de la eliminación
    if (!empty($mensaje)) {
        echo "<script>alert('$mensaje');</script>";
        echo "<script>location.href='listacategorias';</script>";
    } else {
        echo "<script>alert('Error al eliminar Proveedor');</script>";
        echo "<script>location.href='listacategorias';</script>";
    }
}
$listaCategoria = $categoriaController->ShowCategorias();
?>
<div class="page-header">
    <h3 class="page-title"> Usuarios </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="agregarcategorias">Agregar Categori</a></li>
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
                    <table id="table" class="table table-hover" style="color: white;">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($listaCategoria as $cat) {
                                $verEstado = $cat->getEstado() == 1 ? "Activo" : "Inactivo";

                                echo "
                                <tr>
                                <td>" . htmlspecialchars($cat->getNombre()) . "</td>
                                <td>" . htmlspecialchars($cat->getDescripcion()) . "</td>
                                <td>" . $verEstado . "</td>
                                <td>
        <form method='post' onsubmit='return confirmarEliminacion(\"" . addslashes($cat->getNombre()) . "\");'>
            <input type='hidden' name='id' value='" . $cat->getIdCategoria() . "'>
            <button type='submit' name='eliminar' class='btn btn-outline-danger btn-icon-text'>
                <i class='mdi mdi-delete-forever btn-icon-append'></i> Eliminar
            </button>
        
<button type='button' class='btn btn-outline-secondary btn-icon-text' 
onclick='openEditModal(" . $cat->getIdCategoria() . ", 
\"" . addslashes($cat->getNombre()) . "\",
\"" . addslashes($cat->getDescripcion()) . "\", 
\"" . $cat->getEstado() . "\")'>
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
                <h5 class="modal-title" id="editModalLabel">Editar Categoría</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" method="post">
                    <input name="id" type="hidden" class="form-control" id="editId" required>
                    <div class="form-group">
                        <label for="editNombre">Nombre </label>
                        <input name="nombre" type="text" class="form-control" placeholder="Nombre de la categoría" id="editNombre" required>
                    </div>
                    <div class="form-group">
                        <label for="editDescripcion">Descripción</label>
                        <textarea name="descripcion" class="form-control" id="editDescripcion" rows="4" required></textarea>
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

    function openEditModal(id, nombre, descripcion, estado) {
        document.getElementById('editId').value = id;
        document.getElementById('editNombre').value = nombre;
        document.getElementById('editDescripcion').value = descripcion;
        document.getElementById('selectEstado').value = estado;

        var editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
    }

    function confirmarEliminacion(nombre) {
        return confirm('¿Estás seguro de que deseas eliminar la categoría ' + nombre + '? Esta acción no se puede deshacer.');
    }
</script>