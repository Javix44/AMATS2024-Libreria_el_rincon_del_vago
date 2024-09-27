<?php

//modelos
require_once('../model/categoria.php');
require_once('../model/compra.php');
require_once('../model/producto.php');
require_once('../model/proveedor.php');
require_once('../model/usuario.php');
require_once('../model/venta.php');

//controladores
require_once('../controller/categoria../controller.php');
require_once('../controller/compra../controller.php');
require_once('../controller/connection.php');
require_once('../controller/pages.php');
require_once('../controller/producto../controller.php');
require_once('../controller/proveedor../controller.php');
require_once('../controller/usuario../controller.php');
require_once('../controller/venta../controller.php');

//librerias
require_once('../library/TCPDF-main/tcpdf.php');
require_once('../library/PHPMailer/vendor/autoload.php');

?>