<?php

// Incluye la clase TCPDF
require_once('pdf/tcpdf.php');
// Incluye tu clase de conexión
require_once('controladores/cn.php');

// Crea una instancia de la clase de conexión
$conexion = new Cn();

// Crea una consulta para obtener los datos de la tabla `carrera`
$sql = "SELECT idcarrera, carrera FROM carrera";
$resultado = $conexion->ejecutarSQL($sql);

// Crea una nueva instancia de TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establece la información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tu Nombre');
$pdf->SetTitle('Reporte de Carreras');
$pdf->SetSubject('Reporte generado con TCPDF');
$pdf->SetKeywords('TCPDF, PDF, reporte, carreras');

// Elimina el encabezado y pie de página predeterminados
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Establece las márgenes
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// Establece el salto de página automático
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Añade una página
$pdf->AddPage();

// Establece la fuente
$pdf->SetFont('helvetica', '', 12);

// Título del reporte
$html = '<h1>Reporte de Carreras</h1>';

// Abre la tabla
$html .= '<table border="1" cellpadding="4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Carrera</th>
                </tr>
            </thead>
            <tbody>';

// Itera sobre los resultados y añade filas a la tabla
while ($fila = $resultado->fetch_assoc()) {
    $html .= '<tr>
                <td>' . $fila['idcarrera'] . '</td>
                <td>' . $fila['carrera'] . '</td>
              </tr>';
}

// Cierra la tabla
$html .= '</tbody></table>';

// Imprime el contenido HTML
$pdf->writeHTML($html, true, false, true, false, '');

// Cierra y genera el archivo PDF
$pdf->Output('reporte_carreras.pdf', 'I');

?>