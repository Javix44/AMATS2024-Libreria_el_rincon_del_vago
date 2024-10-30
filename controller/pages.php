<?php
class Pages
{

    //la funcion principal para visualizar las paginas
    public function ViewPage()
    {
        $pagina = "";
        $url = isset($_GET["url"]) ? $_GET["url"] : null;
        $url = explode('/', $url);
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
                return "view/admin/index.php";
            case "index.php":
                return "view/admin/index.php";
            case "index":
                return "view/admin/index.php";
            case "agregarusuario":
                return "view/admin/form/agregarusuario.php";
            case "agregarproveedores":
                return "view/admin/form/agregarproveedores.php";
            case "agregarcategorias":
                return "view/admin/form/agregarcategoria.php";
            case "agregarproducto":
                return "view/cajero/form/agregarproducto.php";
            case "agregarventa":
                return "view/cajero/form/agregarventa.php";
            case "agregardetalles":
                return "view/cajero/form/agregar_detalleventa.php";
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
            case "listaingresos":
                return "view/admin/consultas/listaingresos.php";
            case "listaventa":
                return "view/cajero/consultas/listaventa.php";
            case "ReporteVe":
                return "view/admin/consultas/reporteventas.php";
            case "ReportePro":
                return "view/admin/consultas/reportemovimientos.php";
            case "Imprimir_Factura":
                return "ZImpresiones/Plantilla_Impresion_Factura.php";
            default:
                return "view/e404.php";
        }
    }

    //aqui tienen que cargar las vistas de cajero
    public function CargarVistaCajero($url)
    {
        switch ($url[0]) {
            case "":
                return "view/cajero/index.php";
            case "index.php":
                return "view/cajero/index.php";
            case "index":
                return "view/cajero/index.php";
            case "agregarventa":
                return "view/cajero/form/agregarventa.php";
            case "agregardetalles":
                return "view/cajero/form/agregar_detalleventa.php";
            case "agregarproducto":
                return "view/cajero/form/agregarproducto.php";
            case "stock":
                return "view/cajero/consultas/stock.php";
            case "ingresoproducto":
                return "view/admin/form/agregarcompra.php";
            case "listaingresos":
                return "view/admin/consultas/listaingresos.php";
            case "listaventa":
                return "view/admin/consultas/listaventa.php";
            case "ReporteVe":
                return "view/admin/consultas/reporteventas.php";
            case "ReportePro":
                return "view/admin/consultas/reportemovimientos.php";
            case "Imprimir_Factura":
                return "ZImpresiones/Plantilla_Impresion_Factura.php";
            default:
                return "view/e404.php";
        }
    }
}
