<?php
date_default_timezone_set("America/El_Salvador");
if (!defined("Servidor")) define("SERVIDOR", "localhost");
if (!defined("USUARIO")) define("USUARIO", "root");
if (!defined("PASSWORD")) define("PASSWORD", "");
if (!defined("BD")) define("BD", "libreriawed");

//creamos la clase para la conexion
class Connection
{
    private $connect;

    //creamos el constructor para la conexion
    public function __construct()
    {
        try {
            $this->connect = new mysqli(SERVIDOR, USUARIO, PASSWORD, BD);
        } catch (Exception $e) {
            //echo $e -> errorMessage();
        }
    }
    //creamos el metodo para la conexion - para que devuelva la connexion
    public function cn()
    {
        return $this->connect;
    }
    //recordar que la funcion cn hay que llamarlay y el constructor al instanciar la clase se ejecuta

    //creamos un procedimiento para ejecutar cualquier sentencia
    public function ejecutarSQL($sql)
    {
        return $this->cn()->query($sql);
    }
}
