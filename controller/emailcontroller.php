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
}
