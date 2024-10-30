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
                <table class='table' id='Mostrar_Ventas' style='width: 100%; color: white;'>
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
                                // Serializamos los detalles de la venta en un formato JSON
                            ?>
                                <tr>
                                    <td class='text-center'><?= $fila_Venta->getUsuario() ?></td>
                                    <td class='text-center'><?= $fila_Venta->getNombreCliente() ?></td>
                                    <td class='text-center'><?= date('Y-m-d', strtotime($fila_Venta->getEstado())) ?></td>
                                    <td class='text-center'><?= $fila_Venta->getCorreoCliente() ?></td>
                                    <td class='text-center'>
                                        <button class="btn btn-primary" onclick="verDetalles(<?= $fila_Venta->getIdVenta() ?>)">Ver Detalles</button>
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

<!-- Modal para selección de producto -->
<div class="modal fade" id="modalSeleccion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles de la Venta</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="detalles-body">

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#Mostrar_Ventas').DataTable({
            language: {
                "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            }
        });
    });

    function verDetalles(idVenta) {
        $.ajax({
            url: 'ajax/detalle_ventas.php', // Ruta a tu archivo AJAX
            type: 'POST',
            data: {
                idVenta: idVenta
            },
            success: function(html) {
                // Llenar el contenido del modal con el HTML devuelto
                var detallesBody = document.getElementById('detalles-body');
                detallesBody.innerHTML = html; // Cargar el HTML en el modal

                // Mostrar el modal
                $('#modalSeleccion').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
            }
        });
    }
</script>