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
                null,
                null,
                $fila["NombreUsu"],
                $fila["Clave"],
                null,
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
}
