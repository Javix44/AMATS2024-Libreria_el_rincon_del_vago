<?php
require_once("connection.php");

class ProveedorController extends Connection
{

    //funcion para agregar proveedores
    public function InsertProveedor($proveedor)
    {
        // Obtenemos los valores del objeto
        $nombre = $proveedor->getNombre();
        $correo = $proveedor->getCorreo();
        $telefono = $proveedor->getTelefono();
        $mensaje = "";

        $sql_insert = "INSERT INTO proveedor (Nombre,Correo,Telefono) VALUES (?,?,?)";

        $stmt_insert = $this->prepareStatement($sql_insert);

        $stmt_insert->bind_param(
            "sss",
            $nombre,
            $correo,
            $telefono
        );

        // Ejecutamos la consulta
        if ($stmt_insert->execute()) {
            // Éxito
            $mensaje = "Proveedor agregado exitosamente";
        } else {
            // Error
            $mensaje = "Error al agregar el proveedor: " . $stmt_insert->error;
        }

        // Cerrar el statement
        $stmt_insert->close();

        // Retornamos el mensaje
        return $mensaje;
    }

    //funcion para ver todos los proveedores
    public function ShowProveedores()
    {

        $resultado = array();

        $sql = "SELECT * FROM proveedor";
        $stm = $this->prepareStatement($sql);
        $stm->execute();

        $rs = $stm->get_result();

        while ($fila = $rs->fetch_assoc()) {
            $resultado[] = new Proveedor(
                $fila['IdProveedor'],
                $fila['Nombre'],
                $fila['Correo'],
                $fila['Telefono']
            );
        }
        return $resultado;
    }

    //funcion para actualizar los proveedores
    public function UpdateProveedor($proveedor)
    {
        $id = $proveedor->getIdProveedor();
        $nombre = $proveedor->getNombre();
        $correo = $proveedor->getCorreo();
        $telefono = $proveedor->getTelefono();
        $mensaje = "";

        $sql = "UPDATE proveedor SET Nombre = ?, Correo = ?, Telefono = ? WHERE IdProveedor = ?";

        $stmt = $this->prepareStatement($sql);

        $stmt->bind_param(
            "sssi",
            $nombre,
            $correo,
            $telefono,
            $id
        );

        // Ejecutamos la consulta
        if ($stmt->execute()) {
            // Éxito
            $mensaje = "Datos actualizados correctamente";
        } else {
            // Error
            $mensaje = "Error al actualizar proveedor: " . $stmt->error;
        }

        // Cerrar el statement
        $stmt->close();

        // Retornamos el mensaje
        return $mensaje;
    }

    //funcion para eliminar usuarios
    public function DeleteProvedor($idUsuario)
    {
        $mensaje = "";
        $sql = "DELETE FROM proveedor WHERE IdProveedor = ?";
        $stmt = $this->prepareStatement($sql);
        $stmt->bind_param("i", $idUsuario);
        if ($stmt->execute()) {
            $mensaje = "Proveedor eliminado con exito";
        } else {
            $mensaje = "Error al eliminar Proveedor: " . $stmt->error;
        }
        $stmt->close();
        return $mensaje;
    }
}
