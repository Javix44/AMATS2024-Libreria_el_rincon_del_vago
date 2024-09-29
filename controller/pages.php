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
            if ($_SESSION["nivel"] == "Administrador") {
                $pagina = $this->CargarVistaAdmin($url);
            } else if ($_SESSION["nivel"] == "Cajero") {
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
            case "inicio":
                return "view/admin/inicio.php";
            case "agregarusuario":
                return "view/admin/form/agregarusuario.php";
            case "agregarproveedores":
                return "view/admin/form/agregarproveedores.php";
            case "agregarcategorias":
                return "view/admin/form/agregarcategoria.php";
            case "agregarproducto":
                return "view/cajero/form/agregarproducto.php";
            case "listausuarios":
                return "view/admin/consultas/listausuarios.php";
            case "listaproveedores":
                return "view/admin/consultas/listaproveedores.php";
            case "listacategorias":
                return "view/admin/consultas/listacategorias.php";
            case "stock":
                return "view/cajero/consultas/stock.php";
            case "ingresoproducto":
                return "view/admin/form/agregarcompra.php";
            case "verregistro":
                return "view/admin/consultas/listaingresos.php";
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
            case "agregarproducto":
                return "view/cajero/form/agregarproducto.php";
            case "stock":
                return "view/cajero/consultas/stock.php";
            default:
                return "view/e404.php";
        }
    }
}
