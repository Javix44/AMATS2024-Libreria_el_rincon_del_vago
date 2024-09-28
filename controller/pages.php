<?php

class Pages
{

    //la funcion principal para visualizar las paginas
    public function ViewPage()
    {
        $pagina = "";
        $url = isset($_GET["url"]) ? $_GET["url"] : null;
        $url = explode('/', $url);

        //por el momneto cambien el nombre de la seccion usuario por login
        //necesito seccion usuario se guarde todos los datos de la base de datos, nombre, id, correo, etc.
        if (isset($_SESSION["login"])) {
            if ($_SESSION["nivel"] == "admin") {
                $pagina = $this->CargarVistaAdmin($url);
            } else if ($_SESSION["nivel"] == "cajero") {
                $pagina = $this->CargarVistaCajero($url);
            }
        } else {
            require_once("view/login.php");
        }

        return $pagina;
    }

    //Aqui tienen que meter las vistas de administrador
    public function CargarVistaAdmin($url)
    {
        switch ($url[0]) {
            case "":
                return "view/admin/inicio.php";
            case "agregarusuario":
                return "view/admin/form/agregarusuario.php";
            case "listausuarios":
                return "view/admin/consultas/listausuarios.php";
            default:
                return "view/e404.php";
        }
    }

    //aqui tienen que cargar las vistas de cajero
    public function CargarVistaCajero($url)
    {
        switch ($url[0]) {
            case "":
                return "view/cajero/inicio.php";
            case "inicio":
                return "view/cajero/inicio.php";
            case "agregarventa":
                    return "view/cajero/form/agregarventa.php";
            default:
                return "view/e404.php";
        }
    }
}
