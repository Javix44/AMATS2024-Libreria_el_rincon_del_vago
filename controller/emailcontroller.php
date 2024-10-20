<?php
require_once('PHPMailer/vendor/autoload.php');
require_once("connection.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class email_controller extends Connection
{
    // Obtener correos de los administradores
    public function EncabezadoEmail_StockBajo()
    {
        $sql = "
        SELECT nombre, correo FROM usuario
        WHERE EsAdmin = 1
        ";
        return $this->ejecutarSQL($sql);
    }

    // Obtener el cuerpo del email con los productos bajo stock
    public function obtenerCuerpoEmailStockBajo()
    {
        $sql = "
        SELECT Nombre, Stock AS Cantidad_Actual, Umbral FROM producto 
        WHERE Stock < Umbral ORDER BY Cantidad_Actual ASC LIMIT 10
        ";
        return $this->ejecutarSQL($sql);
    }

    // Enviar correo de Stock Bajo
    public function sendStockBajoEmail()
    {
        $mail = new PHPMailer(true);
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'lindazularte@gmail.com'; // Tu correo de Gmail
            $mail->Password = 'ucfcrmnirorahtbl'; // Tu contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Obtener los datos del email (encabezado y cuerpo)
            $DatosEncabezado = $this->EncabezadoEmail_StockBajo(); // Obtén todos los administradores
            if ($DatosEncabezado && $DatosEncabezado->num_rows > 0) {
                // Obtener los detalles del cuerpo del correo
                $DatosCuerpo = $this->obtenerCuerpoEmailStockBajo();
                $detallePrestamo = '<table border="1" cellpadding="5" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Cantidad Actual</th>
                                                <th>Umbral Minimo</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                while ($row = $DatosCuerpo->fetch_assoc()) {
                    $detallePrestamo .= "
                    <tr>
                        <td>{$row['Nombre']}</td>
                        <td>{$row['Cantidad_Actual']}</td>
                        <td>{$row['Umbral']}</td>
                    </tr>";
                }
                $detallePrestamo .= '</tbody></table>';

                // Configuración del remitente
                $mail->setFrom('lindazularte@gmail.com', 'Libreria Rincon del Estudiante');

                // Agregar destinatarios y enviar el correo a todos los administradores
                while ($Datos = $DatosEncabezado->fetch_assoc()) {
                    $nombreAdmin = mb_convert_encoding($Datos['nombre'], 'UTF-8', 'ISO-8859-1');
                    $mail->addAddress($Datos['correo'], $nombreAdmin);  // Agregar a cada admin

                    // Configurar correo HTML
                    $mail->isHTML(true);
                    $mail->CharSet = 'UTF-8';
                    $mail->Subject = 'Notificación: Stock Bajo en Inventario';
                    $mail->Body    = "
                        <html lang='es'>
                        <head>
                            <title>Stock Bajo</title>
                        </head>
                        <body>
                            <p>Estimado/a <strong>{$nombreAdmin}</strong>,</p>
                            <p>Le informamos que los siguientes productos están por debajo del stock mínimo:</p>
                            {$detallePrestamo}
                            <br>
                            <p>Atentamente,</p>
                            <p><strong>Libreria Rincon del Estudiante</strong></p>
                        </body>
                        </html>";

                    $mail->send();  // Enviar el correo a cada administrador
                    $mail->clearAddresses(); // Limpiar para el próximo correo
                }

                return "El correo de notificación fue enviado correctamente.";  // Mensaje de éxito
            } else {
                return "No se encontraron administradores para enviar el correo.";  // Si no hay administradores, devuelve este mensaje
            }
        } catch (Exception $e) {
            return "Error al enviar el correo: {$mail->ErrorInfo}";  // Mensaje de error
        }
    }


    // encabezado de factura electronica a cliente
    public function EncabezadoEmail_ComprobanteElectronico($id)
    {
        $sql = "
        SELECT nombre_cliente, correo_cliente FROM venta
        WHERE IdVenta = '" . $id . "'
        ";
        return $this->ejecutarSQL($sql);
    }

    // Obtener el cuerpo del email con los productos de factura electronica a cliente
    public function obtenerCuerpoEmail_ComprobanteElectronico($id)
    {
        $sql = "
            SELECT 
                P.nombre, 
                V.cantidad, 
                P.precioventa,
                (V.cantidad * P.precioventa) AS subtotal,
                (SELECT SUM(V2.cantidad * P2.precioventa) 
                FROM detalle_venta V2 
                INNER JOIN Producto P2 ON P2.IdProducto = V2.IdProducto 
                WHERE V2.idventa = V.idventa) AS total_venta
            FROM 
                detalle_venta V
            INNER JOIN 
                Producto P ON P.IdProducto = V.IdProducto
            WHERE 
                V.idventa = '" . $id . "';
        ";
        return $this->ejecutarSQL($sql);
    }

    // Enviar factura electronica a cliente
    public function sendComprobanteElectronicoEmail($id)
    {
        $mail = new PHPMailer(true);
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'lindazularte@gmail.com'; // Tu correo de Gmail
            $mail->Password = 'ucfcrmnirorahtbl'; // Tu contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Obtener los datos del email (encabezado y cuerpo)
            $DatosEncabezado = $this->EncabezadoEmail_ComprobanteElectronico($id); // Obtén todos los administradores
            if ($DatosEncabezado && $DatosEncabezado->num_rows > 0) {
                // Obtener los detalles del cuerpo del correo
                $DatosCuerpo = $this->obtenerCuerpoEmail_ComprobanteElectronico($id);
                $detallePrestamo = '<table border="1" cellpadding="5" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                <th>Precio Unitario</th>
                                                <th>SubTotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                while ($row = $DatosCuerpo->fetch_assoc()) {
                    $total_venta = $row['total_venta'];
                    $detallePrestamo .= "
                    <tr>
                        <td>{$row['nombre']}</td>
                        <td>{$row['cantidad']}</td>
                        <td>{$row['precioventa']}</td>
                        <td>{$row['subtotal']}</td>
                    </tr>";
                }
                $detallePrestamo .= '
                </tbody>
                </table>';
                // Mostrar el total de la venta fuera del ciclo, solo una vez
                $detallePrestamo .= "
                <p><strong>Total de la venta: {$total_venta}</strong></p>";
                // Configuración del remitente
                $mail->setFrom('lindazularte@gmail.com', 'Libreria Rincon del Estudiante');


                foreach ($DatosEncabezado as $Datos) {
                    // Agregar destinatarios y enviar el correo a todos los administradores
                    $nombre_Cliente = mb_convert_encoding($Datos['nombre_cliente'], 'UTF-8', 'ISO-8859-1');
                    $mail->addAddress($Datos['correo_cliente'], $nombre_Cliente);  // Agregar a cada admin
                }

                // Configurar correo HTML
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Factura Electronica';
                $mail->Body    = "
                        <html lang='es'>
                        <head>
                            <title>Factura Electronica</title>
                        </head>
                        <body>
                            <p>Estimado/a <strong>{$nombre_Cliente}</strong>,</p>
                            <p>Le proporcionamos el listado completo de los productos adquiridos en su visita:</p>
                            {$detallePrestamo}
                            <br>
                            <p>Atentamente,</p>
                            <p><strong>Libreria Rincon del Estudiante</strong></p>
                        </body>
                        </html>";

                $mail->send();  // Enviar el correo a cada administrador
                $mail->clearAddresses(); // Limpiar para el próximo correo

                return "El correo de notificación fue enviado correctamente.";  // Mensaje de éxito
            } else {
            }
        } catch (Exception $e) {
            return "Error al enviar el correo: {$mail->ErrorInfo}";  // Mensaje de error
        }
    }
}
