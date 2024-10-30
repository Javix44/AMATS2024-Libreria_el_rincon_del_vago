<?php
$CompraController = new CompraController();
?>
<div class="page-header">
    <h3 class="page-title">Listado de Ingresos</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Ver Registros</li>
            <li class="breadcrumb-item"><a href="ingresoproducto">Ingreso de Productos</a></li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <table class='table' id='Mostrar_Ingresos' style='width: 100%;color: white;'>
                    <thead>
                        <th class="text-center">Encargado</th>
                        <th class="text-center">Fecha de Ingreso</th>
                        <th class="text-center">Material Ingresado</th>
                        <th class="text-center">Cantidad Ingresada</th>
                        <th class="text-center">Proveedor</th>
                    </thead>
                    <tbody class='table-group-divider'>
                        <?php
                        if ($CompraController->ShowIngresos() == NULL) {
                        ?>
                            <div class='alert alert-primary text-center' role='alert'>
                                <strong>Sin datos que mostrar</strong>
                            </div>
                            <?php
                        } else {
                            foreach ($CompraController->ShowIngresos() as $fila_Ingreso) {
                            ?>
                                <tr>
                                    <td class='text-center'><?= $fila_Ingreso->getUsuario() ?></td>
                                    <td class='text-center'><?= date('Y-m-d', strtotime($fila_Ingreso->getFechaRegistro())) ?></td>
                                    <td class='text-center'><?= $fila_Ingreso->getProveedor() ?></td>
                                    <td class='text-center'><?= $fila_Ingreso->getCantidad() ?></td>
                                    <td class='text-center'><?= $fila_Ingreso->getProducto() ?></td>
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
        $('#Mostrar_Ingresos').DataTable({
            language: {
                "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            }
        });
    });
</script>