<?php
require_once("connection.php");

class CompraController extends Connection
{
    //funcion para agregar productos
    public function InsertIngreso($Ingreso)
    {
        $idUsuario = $Ingreso->getUsuario();
        $idproducto = $Ingreso->getProducto();
        $cantidad_ingreso = $Ingreso->getCantidad();
        $idproveedor = $Ingreso->getProveedor();
        $mensaje = "";
        //Consulta de Insercion
        $sql_insertar = "
        INSERT INTO Compra 
        (IdUsuario, IdProveedor, IdProducto, Cantidad)
        VALUES (?, ?, ?, ?)
        ";
        // Preparamos la consulta
        $stmt_insertar = $this->prepareStatement($sql_insertar);
        // Asociamos los parámetros a la consulta
        $stmt_insertar->bind_param(
            "iiii",
            $idUsuario,
            $idproveedor,
            $idproducto,
            $cantidad_ingreso
        );

        // Ejecutamos la consulta
        if ($stmt_insertar->execute()) {
            // Éxito
            $mensaje = "Ingreso agregado con exito";
        } else {
            // Error
            $mensaje = "Error al agregar ingreso: " . $stmt_insertar->error;
        }

        // Cerrar el statement
        $stmt_insertar->close();

        // Retornamos el mensaje
        return $mensaje;
    }

    //funcion para ver productos
    public function ShowIngresos()
    {

        $resultado = array();

        $sql = "
        SELECT I.IdCompra, U.nombre AS Nombre_Usuario, P.Nombre AS Nombre_Proveedor, Pr.Nombre AS Nombre_Producto, I.fechaRegistro, I.cantidad
        FROM Compra I JOIN usuario U ON I.IdUsuario = U.IdUsuario
        JOIN producto P ON I.idproducto = P.IdProducto
        JOIN proveedor Pr ON I.idproveedor = Pr.IdProveedor";
        $stm = $this->prepareStatement($sql);
        $stm->execute();

        $rs = $stm->get_result();

        while ($fila = $rs->fetch_assoc()) {
            $resultado[] = new Compra(
                $fila['IdCompra'],
                $fila['Nombre_Usuario'],
                $fila['Nombre_Proveedor'],
                $fila['Nombre_Producto'],
                $fila['fechaRegistro'],
                $fila['cantidad']
            );
        }
        return $resultado;
    }
}
