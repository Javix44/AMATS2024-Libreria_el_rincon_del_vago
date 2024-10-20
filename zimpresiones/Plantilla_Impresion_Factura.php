<?php
$url = isset($_GET["url"]) ? $_GET["url"] : null;
$url = explode('/', $url);
$idventa =  $url[1];
$PDF_Controller = new PDF_Controller();
$PDF_Controller->generarPDFFacturaElectronica($idventa);