<?php
require_once("connection.php");

class VentaController extends Connection
{

    //funcion para agregar ventas
    public function InsertVenta($Venta)
    {
        $idUsuario = $Venta->getUsuario();
        $nombre_cliente = $Venta->getNombreCliente();
        $correo_cliente = $Venta->getCorreoCliente();
        $mensaje = "";
        //Consulta de Insercion
        $sql_insertar = "
         INSERT INTO Venta 
         (IdUsuario, nombre_cliente, correo_cliente)
         VALUES (?, ?, ?)
         ";
        // Preparamos la consulta
        $stmt_insertar = $this->prepareStatement($sql_insertar);
        // Asociamos los parámetros a la consulta
        $stmt_insertar->bind_param(
            "iss",
            $idUsuario,
            $nombre_cliente,
            $correo_cliente
        );

        // Ejecutamos la consulta
        if ($stmt_insertar->execute()) {
            // Éxito
            $mensaje = "Venta creada con exito, por favor agregar detalles";
        } else {
            // Error
            $mensaje = "Error al crear venta: " . $stmt_insertar->error;
        }

        // Cerrar el statement
        $stmt_insertar->close();

        // Retornamos el mensaje
        return $mensaje;
    }

    //funcion para ver venta actual
    public function ShowVenta($id)
    {

        $resultado = array();

        $sql = "
         SELECT V.IdVenta,U.nombre AS Nombre_Usuario, V.nombre_cliente
         FROM Venta V 
         JOIN usuario U ON V.IdUsuario = U.IdUsuario
         where V.estado = 'I' AND V.IdUsuario = '" . $id . "'
         ";
        $stm = $this->prepareStatement($sql);
        $stm->execute();

        $rs = $stm->get_result();

        while ($fila = $rs->fetch_assoc()) {
            $resultado[] = new Venta(
                $fila['IdVenta'],
                $fila['Nombre_Usuario'],
                $fila['nombre_cliente'],
                null,
                null
            );
        }
        return $resultado;
    }
    //funcion para ver venta completada
    public function ShowVentaCompletada($id)
    {

        $resultado = array();

        $sql = "
          SELECT 
            V.IdVenta,
            U.nombre AS Nombre_Usuario, 
            V.nombre_cliente, 
            SUM(D.Cantidad * P.precioventa) AS Total_Venta,
            V.FechaRegistro
            FROM Venta V
            JOIN usuario U ON V.IdUsuario = U.IdUsuario
            JOIN detalle_venta D ON V.IdVenta = D.IdVenta
            JOIN producto P ON P.IdProducto = D.IdProducto
            WHERE V.estado = 'T' AND V.Idusuario = '" . $id . "'
            GROUP BY V.IdVenta, U.nombre, V.nombre_cliente, V.FechaRegistro;

          ";
        $stm = $this->prepareStatement($sql);
        $stm->execute();

        $rs = $stm->get_result();

        while ($fila = $rs->fetch_assoc()) {
            $resultado[] = new Venta(
                $fila['IdVenta'],
                $fila['Nombre_Usuario'],
                $fila['nombre_cliente'],
                $fila['Total_Venta'],
                $fila['FechaRegistro'],
                null
            );
        }
        return $resultado;
    }

    //fucnion para eliminar ventas
    public function DeleteVenta($idProducto)
    {
        $mensaje = "";
        $sql = "DELETE FROM Venta WHERE IdVenta = ?";
        $stmt = $this->prepareStatement($sql);
        $stmt->bind_param("i", $idProducto);
        if ($stmt->execute()) {
            $mensaje = "Venta actual eliminada con exito";
        } else {
            $mensaje = "Error al eliminar venta: " . $stmt->error;
        }
        $stmt->close();
        return $mensaje;
    }

    //funcion para agregar detalles de venta
    public function InsertDetalleVenta($DeVenta)
    {
        // Usar el modelo de producto para esto así que los nombres de los getter son diferentes
        $IdProducto = $DeVenta->getIdProducto();
        $Cantidad = $DeVenta->getCodigo();
        $IdVenta = $DeVenta->getNombre();
        $mensaje = "";

        // Verificar disponibilidad
        $sql_verificar = "
            SELECT stock FROM producto WHERE IdProducto = '" . $IdProducto . "'
        ";
        $rs = $this->ejecutarSQL($sql_verificar);
        $row = $rs->fetch_assoc();

        // Si no hay producto o la cantidad entregada es mayor a la cantidad disponible, no se realiza la inserción
        if (!$row || $Cantidad > $row["stock"]) {
            return $mensaje = "Error: No hay suficiente cantidad disponible. Stock disponible: " . $row["stock"];
        }

        // Consulta de Inserción
        $sql_insertar = "
            INSERT INTO detalle_venta 
            (IdProducto, Cantidad, IdVenta)
            VALUES (?, ?, ?)
        ";

        // Preparamos la consulta
        $stmt_insertar = $this->prepareStatement($sql_insertar);

        // Asociamos los parámetros a la consulta
        $stmt_insertar->bind_param(
            "iii",
            $IdProducto,
            $Cantidad,
            $IdVenta
        );
        // Ejecutamos la consulta
        if ($stmt_insertar->execute()) {
            // Éxito
            $mensaje = "Detalle de Venta creada con éxito";
            // Cerrar el statement
            $stmt_insertar->close();
            // Actualizar la cantidad en la tabla de productos
            $sql_actualizar = "
                UPDATE producto 
                SET stock = stock - '$Cantidad', Estado = CASE WHEN stock - '$Cantidad' > 0 THEN 1 ELSE 0 END 
                WHERE IdProducto = '$IdProducto'
            ";
            $this->ejecutarSQL($sql_actualizar);
        } else {
            // Error
            $mensaje = "Error al crear detalle de venta: " . $stmt_insertar->error;
            // Cerrar el statement
            $stmt_insertar->close();
        }

        // Retornamos el mensaje
        return $mensaje;
    }


    //funcion para ver venta actual
    public function ShowDetalleVenta($id)
    {

        $resultado = array();

        $sql = "
                SELECT 
                    V.Id_Detalle_Venta,
                    P.nombre, 
                    V.cantidad, 
                    P.precioventa, 
                    (V.cantidad * P.precioventa) AS subtotal
                FROM 
                    detalle_venta V
                INNER JOIN 
                    Producto P ON P.IdProducto = V.IdProducto
                WHERE V.idventa = '" . $id . "'
             ";
        $stm = $this->prepareStatement($sql);
        $stm->execute();

        $rs = $stm->get_result();

        while ($fila = $rs->fetch_assoc()) {
            $resultado[] = new Venta(
                $fila['Id_Detalle_Venta'],
                $fila['nombre'],
                $fila['cantidad'],
                $fila['precioventa'],
                $fila['subtotal']
            );
        }
        return $resultado;
    }

    // Función para eliminar detalles de venta
    public function DeleteDetalleVenta($idProducto)
    {
        $mensaje = "";

        // Verificar si el detalle de venta existe
        $sql_verificar = "SELECT COUNT(*) FROM detalle_venta WHERE id_detalle_venta = ?";
        $stmt = $this->prepareStatement($sql_verificar);
        $stmt->bind_param("i", $idProducto);
        $stmt->execute();
        $stmt->bind_result($existe);
        $stmt->fetch();
        $stmt->close();

        // Si no existe, retornar un mensaje
        if ($existe == 0) {
            return "Error: El ID del detalle de venta no existe.";
        }

        // Obtener la cantidad reservada del detalle de venta
        $sql_cantidad = "SELECT IdProducto, Cantidad FROM detalle_venta WHERE id_detalle_venta = ?";
        $stmt = $this->prepareStatement($sql_cantidad);
        $stmt->bind_param("i", $idProducto);
        $stmt->execute();
        $stmt->bind_result($idproductoactualizar, $cantidadReservada);
        $stmt->fetch();
        $stmt->close();

        // Eliminar el detalle de venta
        $sql_eliminar = "DELETE FROM detalle_venta WHERE id_detalle_venta = ?";
        $stmt = $this->prepareStatement($sql_eliminar);
        $stmt->bind_param("i", $idProducto);
        if ($stmt->execute()) {
            // Actualizar la cantidad en la tabla de productos
            $sql_actualizar = "UPDATE producto SET stock = stock + ?, Estado = '1' WHERE IdProducto = ? ";
            $stmt_actualizar = $this->prepareStatement($sql_actualizar);
            $stmt_actualizar->bind_param("ii", $cantidadReservada, $idproductoactualizar);
            $stmt_actualizar->execute();
            $stmt_actualizar->close();

            $mensaje = "Detalle de Venta eliminada con éxito y stock actualizado.";
        } else {
            $mensaje = "Error al eliminar detalle de venta: " . $stmt->error;
        }
        $stmt->close();
        return $mensaje;
    }


    //fucnion para Finalizar Detalles Venta
    public function FinalizarDetallesVenta($idventa)
    {
        $mensaje = "";
        $sql = "UPDATE venta SET estado = 'T' WHERE IdVenta = ?";
        $stmt = $this->prepareStatement($sql);
        $stmt->bind_param("i", $idventa);
        if ($stmt->execute()) {
            $mensaje = "Venta Finalizada con exito";
        } else {
            $mensaje = "Error al finalizar venta: " . $stmt->error;
        }
        $stmt->close();
        return $mensaje;
    }

    //funcion para ver venta actual
    public function ShowEntradasSalidas()
    {

        $resultado = array();

        $sql = "
                    SELECT u.Nombre AS NombreUsuario, C.FechaRegistro, p.Nombre AS NobreProducto, c.Cantidad, 'ENTRADA' AS Movimiento FROM compra C
                    INNER JOIN usuario u ON u.IdUsuario = C.IdUsuario
                    INNER JOIN producto p ON C.IdProducto= p.IdProducto
                    UNION 
                    SELECT u.Nombre AS NombreUsuario, vv.FechaRegistro, p.Nombre AS NobreProducto,v.Cantidad ,'SALIDA' AS Movimiento FROM detalle_venta V
                    INNER JOIN venta vv ON v.Idventa= vv.IdVenta
                    INNER JOIN usuario u ON u.IdUsuario =vv.IdUsuario
                    INNER JOIN producto p ON v.IdProducto= p.IdProducto
                 ";
        $stm = $this->prepareStatement($sql);
        $stm->execute();

        $rs = $stm->get_result();

        while ($fila = $rs->fetch_assoc()) {
            $resultado[] = new Venta(
                $fila['NombreUsuario'],
                $fila['FechaRegistro'],
                $fila['NobreProducto'],
                $fila['Cantidad'],
                $fila['Movimiento']
            );
        }
        return $resultado;
    }

    //funcion para ver venta completada
    public function ShowTodasVentaCompletada()
    {

        $resultado = array();

        $sql = "
          SELECT 
            V.IdVenta,
            U.nombre AS Nombre_Usuario, 
            V.nombre_cliente, 
            SUM(D.Cantidad * P.precioventa) AS Total_Venta,
            V.FechaRegistro
            FROM Venta V
            JOIN usuario U ON V.IdUsuario = U.IdUsuario
            JOIN detalle_venta D ON V.IdVenta = D.IdVenta
            JOIN producto P ON P.IdProducto = D.IdProducto
            WHERE V.estado = 'T'
            GROUP BY V.IdVenta, U.nombre, V.nombre_cliente, V.FechaRegistro;

          ";
        $stm = $this->prepareStatement($sql);
        $stm->execute();

        $rs = $stm->get_result();

        while ($fila = $rs->fetch_assoc()) {
            $resultado[] = new Venta(
                $fila['IdVenta'],
                $fila['Nombre_Usuario'],
                $fila['nombre_cliente'],
                $fila['Total_Venta'],
                $fila['FechaRegistro'],
                null
            );
        }
        return $resultado;
    }
}
