<table class='table'>
    <thead class='table-dark'>
        <tr>
            <th class='fs-4 text-center' colspan='9'>Listado de Detalles</th>
        </tr>
    </thead>
</table>
<div id='Mensaje'></div>
<div class="table-responsive" id="Respuesta_PCH_Detalles">

    <form id='form_eliminar'>
        <table class='table table-striped table-hover table-borderless table-info align-middle' id='Mostrar_Ingreso_H' style='width: 100%;'>
            <thead>
                <th>ID</th>
                <th>Fecha de Ingreso</th>
                <th>Encargado</th>
                <th>Material Ingresado</th>
                <th>Cantidad Ingresada</th>
                <th>Proveedor</th>
            </thead>
            <tbody class='table-group-divider'>
                <?php
                if ($Herramienta_Controller->mostrar_ingresos() == NULL) {
                ?>
                    <div class='alert alert-primary text-center' role='alert'>
                        <strong>Sin datos que mostrar</strong>
                    </div>
                    <?php
                } else {
                    foreach ($Herramienta_Controller->mostrar_ingresos() as $fila_Herramienta) {
                    ?>
                        <tr>
                            <td class='text-center'><?= $fila_Herramienta->getIdHerramienta() ?></td>
                            <td class='text-center'><?= $fila_Herramienta->getId_SA() ?></td>
                            <td class='text-center'><?= $fila_Herramienta->getIdControlAdmin() ?></td>
                            <td class='text-center'><?= $fila_Herramienta->getNombreH() ?></td>
                            <td class='text-center'><?= $fila_Herramienta->getDescripcionH() ?></td>
                            <td class='text-center'><?= $fila_Herramienta->getCantidadH() ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </form>

    ";
</div>