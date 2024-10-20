<?php
require_once('pdf/tcpdf.php');
require_once("connection.php");

class PDF_Controller extends connection
{
    private function obtenerNombreUsuario($id)
    {
        $sql = "
        SELECT
        Nombre_Usuario
        FROM (
        SELECT
            CONCAT(A.nombre, IFNULL(CONCAT(' ', A.apellido), '')) AS Nombre_Usuario
        FROM
            .alumno A
        WHERE
            A.carnet = '" . $id . "'
        UNION
        SELECT
            CONCAT(D.nom_usuario, IFNULL(CONCAT(' ', D.ape_usuario), '')) AS Nombre_Usuario
        FROM
            .docente D
        WHERE
            D.carnet = '" . $id . "'
        ) AS Resultado
        LIMIT 1;
     ";

        try {
            // Ejecutar la consulta SQL
            $rs = $this->ejecutarSQL($sql);
            // Establecer el conjunto de caracteres UTF-8 para los resultados
            if ($rs) {
                $row = $rs->fetch_assoc();
                if ($row) {
                    return mb_convert_encoding($row["Nombre_Usuario"], 'UTF-8', 'ISO-8859-1');
                } else {
                    return "No encontrado";
                }
            } else {
                return "Error en la consulta";
            }
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
    private function obtenerDatosEncabezadoH($id_prestamo)
    {
        // Construye la consulta SQL
        $sql = "
         	  SELECT 
         	   Carnet_Recibidor_H, 
         	   Carnet_Encargado_H, 
		    Fecha_Requisicion_H, 
		    Fecha_Inicio_H, 
		    Fecha_Fin_H, 
		    Fecha_Entrega,
		    Carrera,
		    CASE 
			WHEN Estado_H = 'A' THEN 'Aceptado' 
			WHEN Estado_H = 'R' THEN 'Rechazado' 
			WHEN Estado_H = 'P' THEN 'Pendiente'
			WHEN Estado_H = 'I' THEN 'Iniciado'
			WHEN Estado_H = 'D' THEN 'Finalizado'
			ELSE Estado_H 
		    END AS Estado_H
            FROM pem_prestamo_h T1
            LEFT JOIN Docente D1 ON T1.Carnet_Recibidor_H = D1.carnet
            LEFT JOIN Alumno A1 ON T1.Carnet_Recibidor_H = A1.carnet
            LEFT JOIN Docente D2 ON T1.Carnet_Encargado_H = D2.carnet
            LEFT JOIN Alumno A2 ON T1.Carnet_Encargado_H = A2.carnet
            WHERE Id_Prestamo_H = '$id_prestamo'
            LIMIT 1;
        ";
        // Ejecuta la consulta y devuelve el resultado
        return $this->ejecutarSQL($sql)->fetch_assoc();
    }

    private function obtenerDatosCuerpoH($id_prestamo)
    {
        $sql = "
            SELECT 
                H.Nombre_H AS Elemento_Entregado_H, 
                Cantidad_Prestamo_H, Observaciones_Entrega_H, Observaciones_Recibido, Id_Prestamo_H
            FROM pem_pch_detalles 
            LEFT JOIN pem_herramienta H ON pem_pch_detalles.Elemento_Entregado_H = H.Id_Herramienta
            WHERE Id_Prestamo_H = '" . $id_prestamo . "'
        ";
        return $this->ejecutarSQL($sql)->fetch_all(MYSQLI_ASSOC);
    }
    public function generarPDFH($id_prestamo)
    {
        // Obtén los datos del encabezado
        $datosEncabezado = $this->obtenerDatosEncabezadoH($id_prestamo);
        $date = date('Y-m-d');

        // Obtén los datos del cuerpo de la tabla
        $datosCuerpo = $this->obtenerDatosCuerpoH($id_prestamo);

        // Crea una nueva instancia de TCPDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Establece la información del documento
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Javier Martinez');
        $pdf->SetTitle('Reporte de Préstamo Herramientas');
        $pdf->SetSubject('Reporte generado con TCPDF');
        $pdf->SetKeywords('TCPDF, PDF, reporte, préstamo');
        // Establece las márgenes
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        // Establece las encabezado
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // Añade una página 
        $pdf->AddPage();

        $pdf->SetXY(0, 0); // Ajusta las coordenadas X e Y según necesites
        $pdf->Cell(0, 20, 'Fecha de Emision: ' . $date . ' ', 0, 1, 'R');
        foreach ($datosCuerpo as $fila) {
            $pdf->SetXY(0, 0); // Ajusta las coordenadas X e Y según necesites
            $pdf->Cell(0, 10, 'SA-H: ' . $fila['Id_Prestamo_H'] . ' ', 0, 1, 'R');
        }
        // Agregar imagen de cabecera
        $pdf->Image('Recursos/img/Reporte.png', 1, 12.5, 30, '', 'jpg', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $pdf->Image('Recursos/img/cda.png', 180, 12, 30, '', 'png', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Establecer la fuente y agregar título y subtítulo centrados
        $pdf->SetFont('helvetica', 'B', 10.5);
        $pdf->SetXY(0, 10); // Ajusta las coordenadas X e Y según necesites
        $pdf->Cell(0, 10, 'ESCUELA ESPECIALIZADA EN INGENIERÍA ITCA-FEPADE REGIONAL SANTA ANA', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 18, 'PLANILLA CONTROL DE ENTREGA DE HERRAMIENTAS Y EQUIPOS INSTITUCIONALES', 0, 1, 'C');

        // Establece la fuente
        $pdf->SetFont('helvetica', '', 10);

        // Título del reporte
        $html = '<h1 style="text-align:center;">Reporte de Préstamo de Herramientas</h1>';

        // Datos del encabezado
        $html .= '<table border="1" cellpadding="2" >
                    <tr>
                        <th>Nombre Solicitante:' .  $this->obtenerNombreUsuario($datosEncabezado['Carnet_Recibidor_H']) . '</th>
                        <th>Nombre Encargado: ' .  $this->obtenerNombreUsuario($datosEncabezado['Carnet_Encargado_H']) . '</th>
                    </tr>
                    <tr>
                        <th>Fecha Requisición: ' . $datosEncabezado['Fecha_Requisicion_H'] . '</th>
                        <th>Fecha Inicio: ' . $datosEncabezado['Fecha_Inicio_H'] . '</th>
                    </tr>
                    <tr>
                        <th>Fecha Fin: ' . $datosEncabezado['Fecha_Fin_H'] . '</th>
                        <th>Fecha Revision: ' . $datosEncabezado['Fecha_Entrega'] . '</th>
                    </tr>
                    <tr>
                        <th style="text-align:center;" >Estado: ' . $datosEncabezado['Estado_H'] . '</th>
                        <th style="text-align:center;" >Carrera: ' . $datosEncabezado['Carrera'] . '</th>
                    </tr>
                  </table>';

        // Abre la tabla del cuerpo
        $html .= '<h2 style="text-align:center;">Elementos Entregados</h2>';
        $html .= '<table border="1" cellpadding="4">
                    <thead>
                        <tr>
                            <th style="text-align:center;">Elemento Entregado</th>
                            <th style="text-align:center;">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>';

        // Itera sobre los resultados y añade filas a la tabla
        foreach ($datosCuerpo as $fila) {
            $html .= '<tr>
                        <td style="text-align:center;">' . $fila['Elemento_Entregado_H'] . '</td>
                        <td style="text-align:center;">' . $fila['Cantidad_Prestamo_H'] . '</td>
                      </tr>';
        }

        // Cierra la tabla
        $html .= '</tbody></table>';
        // Agrega las líneas de separación
        $html .= '<br><br><br><br><table style="width: 100%;"><tr>';
        $html .= '<td style="text-align:center;"><div style="width: 20%; border-top: 1px solid black; display: inline-block;">F. Encargado: ' .  $this->obtenerNombreUsuario($datosEncabezado['Carnet_Encargado_H']) . '</div></td>';
        $html .= '<td style="text-align:center;"><div style="width: 20%; border-top: 1px solid black; display: inline-block;">F. Solicitante: ' .  $this->obtenerNombreUsuario($datosEncabezado['Carnet_Recibidor_H']) . '</div></td>';
        $html .= '</tr>';
        $html .= '</table>';



        // Imprime el contenido HTML
        $pdf->writeHTML($html, true, false, true, false, '');

        // Cierra y genera el archivo PDF
        $pdf->Output('reporte_prestamo.pdf', 'I');
    }
}
