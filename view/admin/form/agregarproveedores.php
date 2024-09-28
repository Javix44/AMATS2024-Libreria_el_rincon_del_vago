<?php
//llamado controladores
$proveedorController = new ProveedorController();

if (isset($_POST["agregar"])) {
    //creamos la variable mensaje y mandamos el objecto a la funcion 
    $mensaje = $proveedorController->InsertProveedor(new Proveedor(
        null,
        $_POST["nombre"],
        $_POST["email"],
        $_POST["telefono"]
    ));

    // Suponiendo que $mensaje contiene el resultado de la inserción
    if (!empty($mensaje)) {
        // Escribimos el mensaje en un alert y redirigimos a la misma página
        echo "<script>alert('$mensaje');</script>";
        echo "<script>location.href='agregarproveedores';</script>";
    } else {
        // Si no hay mensaje, mostramos un error genérico
        echo "<script>alert('Error al agregar proveedor');</script>";
        echo "<script>location.href='agregarproveedores';</script>";
    }
}

?>
<div class="page-header">
    <h3 class="page-title"> Proveedores </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="listaproveedores">Ver Proveedores</a></li>
            <li class="breadcrumb-item active" aria-current="page">Administrar Proveedores</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Agregar Proveedores</h4>
                <p class="card-description"> Ingrese la informacion </p>
                <!-- Aquie esta el formulario para agregar cliente -->
                <form class="forms-sample" method="post">
                    <div class="form-group">
                        <label for="exampleInputUsername1">Nombre completo</label>
                        <input name="nombre" type="text" class="form-control" placeholder="nombre completo" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input name="email" type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Telefono</label>
                        <input name="telefono" type="text" class="form-control" id="telefonoInput" placeholder="0000-0000" oninput="formatearTelefono(this)" maxlength="9" required>
                    </div>
                    <button name="agregar" type="submit" class="btn btn-primary mr-2">Agregar</button>
                    <button class="btn btn-dark">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function formatearTelefono(input) {
        let valor = input.value.replace(/\D/g, '');
        if (valor.length > 4) {
            valor = valor.slice(0, 4) + '-' + valor.slice(4);
        }
        input.value = valor;
    }
</script>