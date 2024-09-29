<?php
require_once("connection.php");

class CompraController extends Connection
{
    //funcion para agregar productos
    public function InsertIngreso($Ingreso)
    {
        $idUsuario = $Ingreso->getUsuario();
        $fecha_ingreso = $Ingreso->getFechaRegistro();
        $idproducto = $Ingreso->getProducto();
        $cantidad_ingreso = $Ingreso->getCantidad();
        $idproveedor = $Ingreso->getProveedor();
        $mensaje = "";
        //Consulta de Insercion
        $sql_insertar = "
        INSERT INTO ingresos 
        (idUsuario, fecha_ingreso, idproducto, cantidad_ingreso, idproveedor)
        VALUES (?, ?, ?, ?, ?)
        ";
        // Preparamos la consulta
        $stmt_insertar = $this->prepareStatement($sql_insertar);
        // Asociamos los parámetros a la consulta
        $stmt_insertar->bind_param(
            "isiii",
            $idUsuario,
            $fecha_ingreso,
            $idproducto,
            $cantidad_ingreso,
            $idproveedor
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
        SELECT I.Id_ingreso, U.nombre as Nombre_Usuario, I.fecha_ingreso, P.Nombre as Nombre_Proveedor, I.cantidad_ingreso, Pr.Nombre as Nombre_Producto
        FROM ingresos I JOIN usuario U ON I.IdUsuario = U.IdUsuario
        JOIN producto P ON I.idproducto = P.IdProducto
        JOIN proveedor Pr ON I.idproveedor = Pr.IdProveedor";
        $stm = $this->prepareStatement($sql);
        $stm->execute();

        $rs = $stm->get_result();

        while ($fila = $rs->fetch_assoc()) {
            $resultado[] = new Compra(
                $fila['Id_ingreso'],
                $fila['Nombre_Usuario'],
                $fila['fecha_ingreso'],
                $fila['Nombre_Proveedor'],
                $fila['cantidad_ingreso'],
                $fila['Nombre_Producto']
            );
        }
        return $resultado;
    }
}
