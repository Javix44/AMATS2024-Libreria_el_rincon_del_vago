<?php
require_once("connection.php");

class ProductoController extends Connection
{

    public function Stock_Minimo()
    {
        $sql = "
        SELECT  Nombre,
            Stock AS Cantidad_Actual, 
            Umbral
        FROM 
            producto
        WHERE Stock < Umbral
        ORDER BY Cantidad_Actual ASC
        LIMIT 10
        ";
        $rs = $this->ejecutarSQL($sql);
        $Datos = array();
        while ($row = $rs->fetch_assoc()) {
            $Datos[] = new Producto(
                null,
                null,
                $row["Nombre"],
                null,
                null,
                $row["Cantidad_Actual"],
                $row["Umbral"],
                null,
                null,
                null
            );
        }

        return $Datos;
    }

    //funcion para agregar productos
    public function InsertProducto($producto)
    {
        $codigo = $producto->getCodigo();
        $nombre = $producto->getNombre();
        $descripcion = $producto->getDescripcion();
        $idCategoria = $producto->getCategoria()->getIdCategoria();
        $umbral = $producto->getUmbral();
        $precioCompra = $producto->getPrecioCompra();
        $precioVenta = $producto->getPrecioVenta();
        $mensaje = "";

        // Verificar si el nombre de usuario ya existe
        $sql_verificar = "SELECT COUNT(*) as total FROM producto WHERE Codigo = ?";
        $stmt_verificar = $this->prepareStatement($sql_verificar);
        $stmt_verificar->bind_param("s", $codigo);
        $stmt_verificar->execute();
        $resultado_verificar = $stmt_verificar->get_result()->fetch_assoc();

        if ($resultado_verificar['total'] > 0) {
            // El nombre de usuario ya existe, devolver un mensaje de error
            return "El codigo del producto ya está registrado.";
        }

        // Si no existe, hacemos la inserción SQL
        $sql_insertar = "INSERT INTO producto (Codigo,Nombre, Descripcion, IdCategoria, Umbral, PrecioCompra,PrecioVenta) VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Preparamos la consulta
        $stmt_insertar = $this->prepareStatement($sql_insertar);

        // Asociamos los parámetros a la consulta
        $stmt_insertar->bind_param(
            "sssiidd",
            $codigo,
            $nombre,
            $descripcion,
            $idCategoria,
            $umbral,
            $precioCompra,
            $precioVenta
        );

        // Ejecutamos la consulta
        if ($stmt_insertar->execute()) {
            // Éxito
            $mensaje = "Producto agregado con exito";
        } else {
            // Error
            $mensaje = "Error al agregar producto: " . $stmt_insertar->error;
        }

        // Cerrar el statement
        $stmt_insertar->close();

        // Retornamos el mensaje
        return $mensaje;
    }

    //funcion para ver productos
    public function ShowProductos()
    {

        $resultado = array();

        $sql = "SELECT * FROM producto";
        $stm = $this->prepareStatement($sql);
        $stm->execute();

        $rs = $stm->get_result();

        while ($fila = $rs->fetch_assoc()) {
            $resultado[] = new Producto(
                $fila['IdProducto'],
                $fila['Codigo'],
                $fila['Nombre'],
                $fila['Descripcion'],
                new Categoria(
                    $fila['IdCategoria'],
                    $fila['Nombre']
                ),
                $fila['Stock'],
                $fila['Umbral'],
                $fila['PrecioCompra'],
                $fila['PrecioVenta'],
                $fila['Estado'],
            );
        }
        return $resultado;
    }

    //funcion para actualizar producto
    public function UpdateUsuario($producto)
    {
        // Obtenemos los valores del objeto
        $idProducto = $producto->getIdProducto();
        $codigo = $producto->getCodigo();
        $nombre = $producto->getNombre();
        $descripcion = $producto->getDescripcion();
        $idCategoria = $producto->getCategoria()->getIdCategoria();
        $umbral = $producto->getUmbral();
        $precioCompra = $producto->getPrecioCompra();
        $precioVenta = $producto->getPrecioVenta();
        $estado = $producto->getEstado();
        $mensaje = "";

        // Verificar si el nombre de usuario ya existe
        $sqlVerificar = "SELECT COUNT(*) as total FROM producto WHERE Codigo = ? AND IdProducto != ?";
        $stmtVerificar = $this->prepareStatement($sqlVerificar);
        $stmtVerificar->bind_param("si", $codigo, $idCategoria);
        $stmtVerificar->execute();
        $resultadoVerificar = $stmtVerificar->get_result()->fetch_assoc();

        if ($resultadoVerificar['total'] > 0) {
            // El nombre de usuario ya existe, devolver un mensaje de error
            return "El nombre de usuario ya está registrado.";
        }

        $sql = "UPDATE producto SET Codigo = ?, Nombre = ?, Descripcion = ?, IdCategoria = ?,
        Umbral = ?, PrecioCompra = ? , PrecioVenta = ?, Estado = ?  WHERE IdProducto = ?";

        // Preparamos la consulta
        $stmt = $this->prepareStatement($sql);

        // Asociamos los parámetros a la consulta
        $stmt->bind_param(
            "sssiiddi",
            $codigo,
            $nombre,
            $descripcion,
            $idCategoria,
            $umbral,
            $precioCompra,
            $precioVenta,
            $estado
        );

        // Ejecutamos la consulta
        if ($stmt->execute()) {
            // Éxito
            $mensaje = "Producto actualizado con exito";
        } else {
            // Error
            $mensaje = "Error al agregar producto: " . $stmt->error;
        }

        // Cerrar el statement
        $stmt->close();

        // Retornamos el mensaje
        return $mensaje;
    }

    //fucnion para eliminar productos
    public function DeleteProducto($idProducto)
    {
        $mensaje = "";
        $sql = "DELETE FROM producto WHERE IdProducto = ?";
        $stmt = $this->prepareStatement($sql);
        $stmt->bind_param("i", $idProducto);
        if ($stmt->execute()) {
            $mensaje = "Producto eliminado con exito";
        } else {
            $mensaje = "Error al eliminar producto: " . $stmt->error;
        }
        $stmt->close();
        return $mensaje;
    }
}
