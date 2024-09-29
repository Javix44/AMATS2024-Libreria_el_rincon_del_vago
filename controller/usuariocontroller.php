<?php
require_once("connection.php");

class UsuarioController extends Connection
{

    public function login($usuario)
    {
        $NombreUsu = $usuario->getNombreUsu();
        $clave = $usuario->getClave();
        $clave_encriptada = $this->encriptar("encriptar", $clave);
        // Inicializar el array de resultados
        $resultado = array();
        // Consultar en la tabla usuario
        $sql_alumno = "SELECT * FROM usuario WHERE NombreUsu = ? AND (Clave = ? OR Clave = ?)";
        $stmt_alumno = $this->prepareStatement($sql_alumno);
        $stmt_alumno->bind_param("sss", $NombreUsu, $clave, $clave_encriptada);
        $stmt_alumno->execute();
        $rs_alumno = $stmt_alumno->get_result();

        while ($fila = $rs_alumno->fetch_assoc()) {
            $resultado[] = new Usuario(
                $fila["IdUsuario"],
                $fila["Nombre"],
                $fila["NombreUsu"],
                $fila["Clave"],
                $fila["Correo"],
                $fila["EsAdmin"],
                $fila["Estado"]
            );
        }
        return $resultado;
    }

    public function encriptar($accion, $texto)
    {
        $output = false;
        $encriptarmetodo = "AES-256-CBC";
        $palabrasecreta = "Luffy";
        $iv = "C9FBL1EWSD/M8JFTGS";
        $key = hash("sha256", $palabrasecreta);
        $siv = substr(hash("sha256", $iv), 0, 16);
        if ($accion == "encriptar") {
            $salida = openssl_encrypt($texto, $encriptarmetodo, $key, 0, $siv);
        } else if ($accion == "desencriptar") {
            $salida = openssl_decrypt($texto, $encriptarmetodo, $key, 0, $siv);
        }
        return $salida;
    }

    public function InsertUsuario($usuario)
    {
        // Obtenemos los valores del objeto
        $nombre = $usuario->getNombre();
        $nombreUsu = $usuario->getNombreUsu();
        $clave = $this->encriptar("encriptar", $usuario->getClave());
        $correo = $usuario->getCorreo();
        $esAdmin = $usuario->getEsAdmin(); // Booleano, 1 o 0
        $mensaje = "";

        // Verificar si el nombre de usuario ya existe
        $sql_verificar = "SELECT COUNT(*) as total FROM usuario WHERE NombreUsu = ?";
        $stmt_verificar = $this->prepareStatement($sql_verificar);
        $stmt_verificar->bind_param("s", $nombreUsu);
        $stmt_verificar->execute();
        $resultado_verificar = $stmt_verificar->get_result()->fetch_assoc();

        if ($resultado_verificar['total'] > 0) {
            // El nombre de usuario ya existe, devolver un mensaje de error
            return "El nombre de usuario ya está registrado.";
        }

        // Si no existe, hacemos la inserción SQL
        $sql_insertar = "INSERT INTO usuario (Nombre, NombreUsu, Clave, Correo, EsAdmin) VALUES (?, ?, ?, ?, ?)";

        // Preparamos la consulta
        $stmt_insertar = $this->prepareStatement($sql_insertar);

        // Asociamos los parámetros a la consulta
        $stmt_insertar->bind_param(
            "ssssi",
            $nombre,
            $nombreUsu,
            $clave,
            $correo,
            $esAdmin
        );

        // Ejecutamos la consulta
        if ($stmt_insertar->execute()) {
            // Éxito
            $mensaje = "Usuario agregado con exito";
        } else {
            // Error
            $mensaje = "Error al agregar usuario: " . $stmt_insertar->error;
        }

        // Cerrar el statement
        $stmt_insertar->close();

        // Retornamos el mensaje
        return $mensaje;
    }

    //funcion para ver todos los usuarios
    public function ShowUsuarios()
    {

        $resultado = array();

        $sql = "SELECT * FROM usuario";
        $stm = $this->prepareStatement($sql);
        $stm->execute();

        $rs = $stm->get_result();

        while ($fila = $rs->fetch_assoc()) {
            $resultado[] = new Usuario(
                $fila['IdUsuario'],
                $fila['Nombre'],
                $fila['NombreUsu'],
                $fila['Clave'],
                $fila['Correo'],
                $fila['EsAdmin'],
                $fila['Estado'],
            );
        }
        return $resultado;
    }

    //funcion para actualizar usuarios
    public function UpdateUsuario($usuario)
    {
        // Obtenemos los valores del objeto
        $idUsuario = $usuario->getIdUsuario();
        $nombre = $usuario->getNombre();
        $nombreUsu = $usuario->getNombreUsu();
        $correo = $usuario->getCorreo();
        $esAdmin = $usuario->getEsAdmin();
        $estado = $usuario->getEstado();
        $mensaje = "";

        // Verificar si el nombre de usuario ya existe
        $sqlVerificar = "SELECT COUNT(*) as total FROM usuario WHERE NombreUsu = ? AND IdUsuario != ?";
        $stmtVerificar = $this->prepareStatement($sqlVerificar);
        $stmtVerificar->bind_param("si", $nombreUsu, $idUsuario);
        $stmtVerificar->execute();
        $resultadoVerificar = $stmtVerificar->get_result()->fetch_assoc();

        if ($resultadoVerificar['total'] > 0) {
            // El nombre de usuario ya existe, devolver un mensaje de error
            return "El nombre de usuario ya está registrado.";
        }

        $sql = "UPDATE usuario SET Nombre = ?, NombreUsu = ?, Correo = ?, EsAdmin = ?, Estado = ? WHERE IdUsuario = ?";

        // Preparamos la consulta
        $stmt = $this->prepareStatement($sql);

        // Asociamos los parámetros a la consulta
        $stmt->bind_param(
            "sssiii",
            $nombre,
            $nombreUsu,
            $correo,
            $esAdmin,
            $estado,
            $idUsuario
        );

        // Ejecutamos la consulta
        if ($stmt->execute()) {
            // Éxito
            $mensaje = "Usuario actualizado";
        } else {
            // Error
            $mensaje = "Error al agregar usuario: " . $stmt->error;
        }

        // Cerrar el statement
        $stmt->close();

        // Retornamos el mensaje
        return $mensaje;
    }

    //funcion para eliminar usuarios
    public function DeleteUsuario($idUsuario)
    {
        $mensaje = "";
        $sql = "DELETE FROM usuario WHERE IdUsuario = ?";
        $stmt = $this->prepareStatement($sql);
        $stmt->bind_param("i", $idUsuario);
        if ($stmt->execute()) {
            $mensaje = "Usuario eliminado con exito";
        } else {
            $mensaje = "Error al eliminar usuario: " . $stmt->error;
        }
        $stmt->close();
        return $mensaje;
    }

    //funcion para Obtener Nombre
    public function ObtenerNombre($nomUsu)
    {
        $sql = "Select Nombre from usuario WHERE NombreUsu = " . $nomUsu . " ";
        // Ejecutar la consulta
        $result = $this->ejecutarSQL($sql);

        // Verificar si se obtuvo algún resultado
        if ($result && $fila = $result->fetch_assoc()) {
            return $fila['Nombre']; // Retornar el nombre
        } else {
            return null; // O retornar null si no se encuentra el usuario
        }
    }
}
