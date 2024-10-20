<?php
require_once('pdf/tcpdf.php');
require_once("connection.php");
class PDF_Controller extends connection
{
    private function obtenerDatosEncabezadoFactura($id)
    {
        // Construye la consulta SQL
        $sql = "
            SELECT 
            V.IdVenta,
            U.nombre AS Nombre_Usuario, 
            V.nombre_cliente, 
            SUM(D.Cantidad * P.precioventa) AS Total_Venta,
            V.FechaRegistro
            FROM Venta V
            JOIN usuario U ON V.IdUsuario = U.IdUsuario
            JOIN detalle_venta D ON V.IdVenta = D.IdVenta
            JOIN producto P ON P.IdProducto = D.IdProducto
            WHERE V.IdVenta = '" . $id . "'
            GROUP BY V.IdVenta, U.nombre, V.nombre_cliente, V.FechaRegistro
            LIMIT 1;
        ";
        // Ejecuta la consulta y devuelve el resultado
        return $this->ejecutarSQL($sql)->fetch_assoc();
    }

    private function obtenerDatosCuerpoFactura($id)
    {
        $sql = "
            SELECT 
            V.cantidad,                     
            P.nombre,         
            P.precioventa, 
            (V.cantidad * P.precioventa) AS subtotal
            FROM 
            detalle_venta V
            INNER JOIN 
            Producto P ON P.IdProducto = V.IdProducto
            WHERE V.idventa = '" . $id . "'
        ";
        return $this->ejecutarSQL($sql)->fetch_all(MYSQLI_ASSOC);
    }
    public function generarPDFFacturaElectronica($id_prestamo)
    {
        // Obtén los datos del encabezado
        $datosEncabezado = $this->obtenerDatosEncabezadoFactura($id_prestamo);
        $date = date('Y-m-d');

        // Obtén los datos del cuerpo de la tabla
        $datosCuerpo = $this->obtenerDatosCuerpoFactura($id_prestamo);

        // Crea una nueva instancia de TCPDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Establece la información del documento
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Libreria Rincon del Estudiante');
        $pdf->SetTitle('Factura Electronica');
        $pdf->SetSubject('Factura de Venta');
        $pdf->SetKeywords('TCPDF, PDF, reporte, préstamo');

        // Establece las márgenes
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // Añade una página 
        $pdf->AddPage();
        $pdf->SetXY(5, 10);
        $pdf->SetFillColor(150, 150, 255); // Color de fondo
        $pdf->Cell(0, 25, 'LIBRERIA EL RINCON DEL ESTUDIANTE', 1, 1, 'C', 1);
        $pdf->SetFont('helvetica', 'I', 10); // Fuente en cursiva
        $pdf->Cell(0, 18, 'FACTURACIÓN ELECTRONICA DE COMPRA FINALIZADA', 0, 1, 'C');

        $pdf->SetFont('helvetica', '', 10);
        $html = '<h1 style="text-align:center;">Datos Factura</h1>';

        // Datos del encabezado
        $html .= '
        <div style="text-align: center;">
            <table border="1" cellpadding="2" style="width:100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 10px; font-weight: bold;" colspan="2">Cliente: ' . $datosEncabezado['nombre_cliente'] . '</td>
                </tr>
                <tr>
                    <td style="padding: 10px; font-weight: bold;" colspan="2">Encargado: ' . $datosEncabezado['Nombre_Usuario'] . '</td>
                </tr>
                <tr>
                    <td style="padding: 10px; font-weight: bold;">Fecha de Registro de Venta: ' . $datosEncabezado['FechaRegistro'] . '</td>
                    <td style="padding: 10px; font-weight: bold;">Fecha de Emisión: ' . $date . '</td>
                </tr>
          </table>
        </div>';

        // Título de la sección de productos vendidos
        $html .= '<h2 style="text-align:center; margin-top: 20px;">Detalle de Productos Vendidos</h2>';
        $html .= '<table border="1" cellpadding="4" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
              <tr style="background-color: #f2f2f2;">
                  <th style="text-align:center; padding: 10px;">Producto</th>
                  <th style="text-align:center; padding: 10px;">Cantidad</th>
                  <th style="text-align:center; padding: 10px;">Precio Unitario</th>
                  <th style="text-align:center; padding: 10px;">Subtotal</th>
              </tr>
          </thead>
          <tbody>';


        // Itera sobre los resultados y añade filas a la tabla
        $totalVenta = 0;
        foreach ($datosCuerpo as $fila) {
            $subtotal = $fila['cantidad'] * $fila['precioventa'];
            $totalVenta += $subtotal;

            $html .= '<tr>
                    <td style="text-align:center; padding: 8px;">' . $fila['nombre'] . '</td>
                    <td style="text-align:center; padding: 8px;">' . $fila['cantidad'] . '</td>
                    <td style="text-align:center; padding: 8px;">$' . number_format($fila['precioventa'], 2) . '</td>
                    <td style="text-align:center; padding: 8px;">$' . number_format($subtotal, 2) . '</td>
              </tr>';
        }


        // Cierra la tabla y muestra el total
        $html .= '</tbody>
            <tfoot>
            <tr style="background-color: #d9edf7;">
                <td colspan="3" style="text-align:right; padding: 10px; font-weight: bold;">Total:</td>
                <td style="text-align:center; padding: 10px; font-weight: bold;">$' . number_format($totalVenta, 2) . '</td>
            </tr>
            </tfoot>
            </table>';

        //CODIGO QUE ARREGLA EL ERROR DE TCPDF some data has alredy sent
        error_reporting(E_ALL & ~E_NOTICE);
        ini_set('display_errors', 0);
        ini_set('log_errors', 1);
        ob_end_clean();

        // Imprime el contenido HTML
        $pdf->writeHTML($html, true, false, false, false, '');

        // Cierra y genera el archivo PDF
        $pdf->Output('factura_electronica.pdf', 'I');
    }
}
