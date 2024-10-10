<?php
$VentaController = new VentaController(); // Asegúrate de tener este controlador para las ventas
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

                <table class='table' id='Mostrar_Ventas' style='width: 100%;'>
                    <thead>
                        <th class="text-center">ID Venta</th>
                        <th class="text-center">Encargado</th>
                        <th class="text-center">Fecha de Venta</th>
                        <!-- Agregar total en un futuro? -->
                        <!-- <th class="text-center">Total</th> -->
                        <th class="text-center">Acciones</th>
                    </thead>
                    <tbody class='table-group-divider'>
                        <?php
                        if ($VentaController->ShowVentaCompletada() == NULL) {
                        ?>
                            <div class='alert alert-primary text-center' role='alert'>
                                <strong>Sin datos que mostrar</strong>
                            </div>
                            <?php
                        } else {
                            foreach ($VentaController->ShowVentaCompletada() as $fila_Venta) {
                            ?>
                                <tr>
                                    <td class='text-center'><?= $fila_Venta->getIdVenta() ?></td>
                                    <td class='text-center'><?= $fila_Venta->getUsuario() ?></td>
                                    <td class='text-center'><?= date('Y-m-d', strtotime($fila_Venta->getEstado())) ?></td>
                                    <td class='text-center'>
                                        <button class="btn btn-primary" data-id="<?= $fila_Venta->getIdVenta() ?>" data-bs-toggle="modal" data-bs-target="#detallesModal">Ver Detalles</button>
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

<!-- Modal para Detalles de Venta -->
<div class="modal fade" id="detallesModal" tabindex="-1" aria-labelledby="detallesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detallesModalLabel">Detalles de la Venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalDetallesBody">
                <!-- Aquí se cargarán los detalles de la venta -->
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

        // Evento al hacer clic en el botón "Ver Detalles"
        $('#detallesModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var idVenta = button.data('id'); // Extraer ID de venta del botón

            // Realizar una solicitud AJAX para obtener los detalles
            $.ajax({
                url: 'getDetallesVenta.php', // Cambia a la URL que gestiona la consulta
                method: 'GET',
                data: {
                    id: idVenta
                },
                success: function(data) {
                    $('#modalDetallesBody').html(data); // Cargar los detalles en el modal
                },
                error: function() {
                    $('#modalDetallesBody').html('<p>Error al cargar los detalles.</p>');
                }
            });
        });
    });
</script>