<?php

class Pages {

    //la funcion principal para visualizar las paginas
    public function ViewPage()
    {
        $pagina = "";
        $url = isset($_GET["url"]) ? $_GET["url"] : null;
        $url = explode('/', $url);

        if (isset($_SESSION["usuario"])) {
            if ($_SESSION["nivel"] == "admin") {
                $pagina = $this->CargarVistaAdmin($url);
            } else if ($_SESSION["nivel"] == "cajero") {
                $pagina = $this->CargarVistaCajero($url);
            }
        } else {
            require_once("View/login.php");
        }

        return $pagina;
    }

    //Aqui tienen que meter las vistas de administrador
    public function CargarVistaAdmin($url)
    {
        switch ($url[0]) {
            case "":
                return "View/admin/inicio.php";
            case "inicio":
                return "View/admin/inicio.php";
            default:
                return "e404.php";
        }
    }

    //aqui tienen que cargar las vistas de cajero
    public function CargarVistaCajero($url)
    {
        switch ($url[0]) {
            case "":
                return "View/cajero/inicio.php";
            case "inicio":
                return "View/cajero/inicio.php";
            default:
                return "View/e404.php"; 
        }
    }
}

?>
