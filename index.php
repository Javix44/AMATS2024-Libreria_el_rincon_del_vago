<?php
session_start();

if (!defined("URL")) define("URL", "http://localhost/AMATS2024-SOFT41B-REPO-GRUPO-01/");

//modelos
require_once('model/categoria.php');
require_once('model/compra.php');
require_once('model/producto.php');
require_once('model/proveedor.php');
require_once('model/usuario.php');
require_once('model/venta.php');

//controladores
require_once('controller/categoriacontroller.php');
require_once('controller/compracontroller.php');
require_once('controller/connection.php');
require_once('controller/pages.php');
require_once('controller/productocontroller.php');
require_once('controller/proveedorcontroller.php');
require_once('controller/usuariocontroller.php');
require_once('controller/ventacontroller.php');
require_once('controller/emailcontroller.php');
require_once('controller/pdfcontroller.php');

// Control de Acceso y Redirección

if (isset($_SESSION["nivel"])) {
    if ($_SESSION["nivel"] == "Administrador") {
        require_once("view/admin/index.php");
    } elseif ($_SESSION["nivel"] == "Cajero") {
        require_once("view/cajero/index.php");
    }
} else {
    require_once("view/login.php");
}


//Vistas
$info = isset($_GET["url"]) ? $_GET["url"] : null;
$info = explode("/", $info);
if ($info[0] == 'Imprimir_Factura') {
    require_once('ZImpresiones/Plantilla_Impresion_Factura.php');
}
