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
    <h3 class="page-title"> Agregar venta</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="listaventa">Ver Registros</a></li>
            <li class="breadcrumb-item active" aria-current="page">Agregar Ventas</li>
        </ol>
    </nav>
</div>