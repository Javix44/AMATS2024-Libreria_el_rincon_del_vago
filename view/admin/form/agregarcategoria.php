<?php
//llamado controladores
$categoriaController = new CategoriaController();

if (isset($_POST["agregar"])) {
    //creamos la variable mensaje y mandamos el objecto a la funcion 
    $mensaje = $categoriaController->IntertCategoria(new Categoria(
        null,
        $_POST["nombre"],
        $_POST["descripcion"],
        null
    ));

    // Suponiendo que $mensaje contiene el resultado de la inserción
    if (!empty($mensaje)) {
        // Escribimos el mensaje en un alert y redirigimos a la misma página
        echo "<script>alert('$mensaje');</script>";
        echo "<script>location.href='agregarcategorias';</script>";
    } else {
        // Si no hay mensaje, mostramos un error genérico
        echo "<script>alert('Error al agregar proveedor');</script>";
        echo "<script>location.href='agregarcategorias';</script>";
    }
}
?>
<div class="page-header">
    <h3 class="page-title"> Categorias </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="listacategorias">Ver Categorias</a></li>
            <li class="breadcrumb-item active" aria-current="page">Administrar Usuarios</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Agregar Categoria</h4>
                <p class="card-description"> Ingrese la informacion </p>
                <!-- Aquie esta el formulario para agregar cliente -->
                <form class="forms-sample" method="post">
                    <div class="form-group">
                        <label for="exampleInputUsername1">Nombre</label>
                        <input name="nombre" type="text" class="form-control" placeholder="nombre completo" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleTextarea1">Descripcion</label>
                        <textarea name="descripcion" class="form-control" id="exampleTextarea1" rows="4"></textarea>
                    </div>
                    <button name="agregar" type="submit" class="btn btn-primary mr-2">Agregar</button>
                    <button class="btn btn-dark">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>