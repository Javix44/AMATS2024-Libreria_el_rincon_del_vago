<?php
require_once 'allrequire.php'; // Asegúrate de incluir tu controlador

if (isset($_POST['idVenta'])) {
    $idVenta = $_POST['idVenta'];
    $VentaController = new VentaController();
    $detallesVenta = $VentaController->ShowDetalleVenta($idVenta);
?>
    <table class="table">
        <thead>
            <tr>
                <th class="text-center">Nombre Producto</th>
                <th class="text-center">Cantidad</th>
                <th class="text-center">Precio Unitario</th>
                <th class="text-center">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detallesVenta as $detalle): ?>
                <tr>
                    <td class="text-center"><?= htmlspecialchars($detalle->getUsuario()) ?></td>
                    <td class="text-center"><?= htmlspecialchars($detalle->getNombreCliente()) ?></td>
                    <td class="text-center"><?= number_format($detalle->getCorreoCliente(), 2) ?></td>
                    <td class="text-center"><?= number_format($detalle->getEstado(), 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="Imprimir_Factura/" target="_blank" class="btn btn-success">
        Generar factura PDF <i class="fa-solid fa-file-pdf"></i>
    </a>
<?php
}
?>