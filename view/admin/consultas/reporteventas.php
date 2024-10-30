<?php
$VentaController = new VentaController();
$listaProducto = $VentaController->ShowEntradasSalidas();
?>
<div class="page-header">
    <h3 class="page-title">Listado de Ventas</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Ver Registros</li>
            <li class="breadcrumb-item"><a href="agregarventa">Agregar Venta</a></li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <table class='table' id='Mostrar_Ve' style='width: 100%; color: white;'>
                    <thead>
                        <th class="text-center">Encargado</th>
                        <th class="text-center">Cliente</th>
                        <th class="text-center">Fecha de Venta</th>
                        <th class="text-center">Total Venta</th>
                        <th class="text-center">Acciones</th>
                    </thead>
                    <tbody class='table-group-divider'>
                        <?php
                        if ($VentaController->ShowTodasVentaCompletada() == NULL) {
                        ?>
                            <div class='alert alert-primary text-center' role='alert'>
                                <strong>Sin datos que mostrar</strong>
                            </div>
                            <?php
                        } else {
                            foreach ($VentaController->ShowTodasVentaCompletada() as $fila_Venta) {
                            ?>
                                <tr>
                                    <td class='text-center'><?= $fila_Venta->getUsuario() ?></td>
                                    <td class='text-center'><?= $fila_Venta->getNombreCliente() ?></td>
                                    <td class='text-center'><?= date('Y-m-d', strtotime($fila_Venta->getEstado())) ?></td>
                                    <td class='text-center'><?= $fila_Venta->getCorreoCliente() ?></td>
                                    <td class='text-center'>
                                        <button class="btn btn-primary" onclick="verDetalles(<?= $fila_Venta->getIdVenta() ?>)">Generar Reporte</button>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#Mostrar_Ve').DataTable({
            language: {
                "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            }
        });
    });
</script>