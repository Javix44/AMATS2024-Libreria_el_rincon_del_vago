<?php
require_once("connection.php");

class CategoriaController extends Connection
{
    //funcion para agregar categorias
    public function IntertCategoria($categoria)
    {
        $nombre = $categoria->getNombre();
        $descripcion = $categoria->getDescripcion();
        $mensaje = "";

        $sql_insertar  = "INSERT INTO categoria (Nombre,Descripcion) VALUES (?,?)";

        // Preparamos la consulta
        $stmt_insertar = $this->prepareStatement($sql_insertar);

        // Asociamos los parámetros a la consulta
        $stmt_insertar->bind_param(
            "ss",
            $nombre,
            $descripcion
        );

        // Ejecutamos la consulta
        if ($stmt_insertar->execute()) {
            // Éxito
            $mensaje = "Categoria agregada con exito";
        } else {
            // Error
            $mensaje = "Error al agregar categoria: " . $stmt_insertar->error;
        }

        // Cerrar el statement
        $stmt_insertar->close();

        // Retornamos el mensaje
        return $mensaje;
    }

    //funcion para listar las categorias
    public function ShowCategorias()
    {

        $resultado = array();

        $sql = "SELECT * FROM categoria";
        $stm = $this->prepareStatement($sql);
        $stm->execute();

        $rs = $stm->get_result();

        while ($fila = $rs->fetch_assoc()) {
            $resultado[] = new Categoria(
                $fila['IdCategoria'],
                $fila['Nombre'],
                $fila['Descripcion'],
                $fila['Estado']
            );
        }
        return $resultado;
    }

    //funcion para actualizar las categorias
    public function UpdateCategoria($categoria)
    {
        $id = $categoria->getIdCategoria();
        $nombre = $categoria->getNombre();
        $descripcion = $categoria->getDescripcion();
        $estado = $categoria->getEstado();
        $mensaje = "";

        $sql = "UPDATE categoria SET Nombre = ?, Descripcion = ?, Estado = ? WHERE IdCategoria = ?";

        $stmt = $this->prepareStatement($sql);

        $stmt->bind_param(
            "sssi",
            $nombre,
            $descripcion,
            $estado,
            $id
        );

        // Ejecutamos la consulta
        if ($stmt->execute()) {
            // Éxito
            $mensaje = "Categoria actualizada con exito";
        } else {
            // Error
            $mensaje = "Error al actualizar categoria: " . $stmt->error;
        }

        // Cerrar el statement
        $stmt->close();

        // Retornamos el mensaje
        return $mensaje;
    }

    //funcion para eliminar categorias
    public function DeleteCategoria($idCategorias)
    {
        $mensaje = "";
        $sql = "DELETE FROM categoria WHERE IdCategoria = ?";
        $stmt = $this->prepareStatement($sql);
        $stmt->bind_param("i", $idCategorias);
        if ($stmt->execute()) {
            $mensaje = "Categoria eliminada con exito";
        } else {
            $mensaje = "Error al eliminar Categoria: " . $stmt->error;
        }
        $stmt->close();
        return $mensaje;
    }
}
