<?php
//llamado controladores
$usuarioController = new UsuarioController();

if (isset($_POST["agregar"]) && $_POST["pass"] == $_POST["pass2"]) {
    //creamos la variable mensaje y mandamos el objecto a la funcion 
    $mensaje = $usuarioController->InsertUsuario(new Usuario(
        null,
        $_POST["nombre"],
        $_POST["nomUsu"],
        $_POST["pass"],
        $_POST["email"],
        $_POST["cargo"]
    ));

    // Suponiendo que $mensaje contiene el resultado de la inserción
    if (!empty($mensaje)) {
        // Escribimos el mensaje en un alert y redirigimos a la misma página
        echo "<script>alert('$mensaje');</script>";
        echo "<script>location.href='agregarusuario';</script>";
    } else {
        // Si no hay mensaje, mostramos un error genérico
        echo "<script>alert('Error al agregar usuario');</script>";
        echo "<script>location.href='agregarusuario';</script>";
    }
}

?>
<div class="page-header">
    <h3 class="page-title"> Usuarios </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Formulario</a></li>
            <li class="breadcrumb-item active" aria-current="page">Agregar Usuario</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Agregar usuarios</h4>
                <p class="card-description"> Ingrese la informacion </p>
                <!-- Aquie esta el formulario para agregar cliente -->
                <form class="forms-sample" method="post">
                    <div class="form-group">
                        <label for="exampleInputUsername1">Nombre completo</label>
                        <input name="nombre" type="text" class="form-control" placeholder="nombre completo" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Nombre de Usuario</label>
                        <input name="nomUsu" type="text" class="form-control" placeholder="nombre de usuario" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input name="email" type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" required autocomplete="username">
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
                        <label for="exampleInputPassword1">Contraseña</label>
                        <input name="pass" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required autocomplete="new-password">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputConfirmPassword1">Confirme Contraseña</label>
                        <input name="pass2" type="password" class="form-control" id="exampleInputConfirmPassword1" placeholder="Password" required autocomplete="new-password">
                    </div>
                    <button name="agregar" type="submit" class="btn btn-primary mr-2">Agregar</button>
                    <button class="btn btn-dark">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>