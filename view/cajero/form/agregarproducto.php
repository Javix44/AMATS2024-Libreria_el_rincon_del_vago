<?php

$categoriaController = new CategoriaController();
$productoController = new ProductoController();
$listaCategoria = $categoriaController->ShowCategorias();

if (isset($_POST["agregar"])) {
    // Verificar que los precios de compra y venta sean mayores a 0
    if ($_POST["precioCompra"] > 0 && $_POST["precioVenta"] > 0 && $_POST["umbral"] >= 0) {
        // Obtener los datos del formulario
        $nombreProducto = $_POST["nombre"];
        $idCategoria = $_POST["categoria"];

        // Generar código de producto combinando las primeras 3 letras del nombre y el ID de la categoría
        $codigo = strtoupper(substr($nombreProducto, 0, 3)) . $idCategoria;

        // Generar tres letras aleatorias
        $letrasAleatorias = '';
        for ($i = 0; $i < 3; $i++) {
            $letrasAleatorias .= chr(rand(65, 90)); // Genera letras aleatorias entre 'A' y 'Z'
        }

        // Agregar las letras aleatorias al final del código
        $codigo .= $letrasAleatorias;

        // Ejemplo: si el nombre es "Laptop" y la categoría es 12, el código sería algo como "LAP12XYZ"

        // Insertar el producto usando el código generado
        $mensaje = $productoController->InsertProducto(new Producto(
            null,
            $codigo,  
            $_POST["nombre"], 
            $_POST["descripcion"],
            new Categoria($idCategoria),
            null,
            $_POST["umbral"],
            $_POST["precioCompra"],
            $_POST["precioVenta"],
            null
        ));

        // Mostrar mensaje de éxito o error
        if (!empty($mensaje)) {
            echo "<script>alert('$mensaje');</script>";
            echo "<script>location.href='agregarproducto';</script>";
        }
    } else {
        // Mostrar alerta si los precios no son válidos
        echo "<script>alert('Verifique que el precio de compra, venta y la cantidad del umbral sea mayor que cero');</script>";
        echo "<script>location.href='agregarproducto';</script>";
    }
}

?>

<div class="page-header">
    <h3 class="page-title"> Productos </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="stock">Ver Stock</a></li>
            <li class="breadcrumb-item active" aria-current="page">Administrar Productos</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Registrar Producto</h4>
                <p class="card-description">Ingrese la información del producto</p>
                <!-- Aquí está el formulario para registrar un producto -->
                <form class="forms-sample" method="post">
                    <!-- Campo para ingresar el nombre -->
                    <div class="form-group">
                        <label for="inputNombre">Nombre</label>
                        <input name="nombre" type="text" class="form-control" id="inputNombre" placeholder="Ingrese el nombre del producto" required>
                    </div>
                    <!-- Campo para ingresar la descripción -->
                    <div class="form-group">
                        <label for="inputDescripcion">Descripción</label>
                        <textarea name="descripcion" class="form-control" id="inputDescripcion" rows="3" placeholder="Ingrese la descripción del producto" required></textarea>
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
                            <!-- Añadir más categorías según tu base de datos -->
                        </select>
                    </div>
                    <!-- Campo para ingresar el umbral -->
                    <div class="form-group">
                        <label for="inputUmbral">Umbral</label>
                        <input name="umbral" type="number" class="form-control" id="inputUmbral" placeholder="Ingrese el umbral mínimo" required>
                    </div>
                    <!-- Campo para ingresar el precio de compra -->
                    <div class="form-group">
                        <label for="inputPrecioCompra">Precio de Compra</label>
                        <input name="precioCompra" type="number" step="0.01" class="form-control" id="inputPrecioCompra" placeholder="Ingrese el precio de compra" required>
                    </div>
                    <!-- Campo para ingresar el precio de venta -->
                    <div class="form-group">
                        <label for="inputPrecioVenta">Precio de Venta</label>
                        <input name="precioVenta" type="number" step="0.01" class="form-control" id="inputPrecioVenta" placeholder="Ingrese el precio de venta" required>
                    </div>
                    <!-- Botones para agregar o cancelar -->
                    <button name="agregar" type="submit" class="btn btn-primary mr-2">Registrar Producto</button>
                    <button type="reset" class="btn btn-dark">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>