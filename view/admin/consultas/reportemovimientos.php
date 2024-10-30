<?php
$VentaController = new VentaController();
$listaProducto = $VentaController->ShowEntradasSalidas();
?>
<div class="page-header">
    <h3 class="page-title"> Reporte de Movimientos </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"> Reporte de Movimientos</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center h2">Reporte de Movimientos de Productos</h4>
                <div class="table-responsive">
                    <table id="tableMovimiento" class="table" style="color: white;">
                        <thead>
                            <tr>
                                <th class='text-center'>Nombre de Encargado</th>
                                <th class='text-center'>Fecha de Registro</th>
                                <th class='text-center'>Producto</th>
                                <th class='text-center'>Cantidad</th>
                                <th class='text-center'>Movimento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($listaProducto as $pro) {
                                echo "
                                <tr>
                                <td class='text-center'>" . $pro->getIdVenta() . "</td>
                                <td class='text-center'>" . $pro->getUsuario() . "</td>
                                <td class='text-center'>" . $pro->getNombreCliente() . "</td>
                                <td class='text-center'>" . $pro->getCorreoCliente() . "</td>
                                <td class='text-center'>" . $pro->getEstado() . "</td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tableMovimiento').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            },
            "initComplete": function() {
                $('.paginate_button').addClass('btn btn-dark p-0');
            }
        });
    });
</script>