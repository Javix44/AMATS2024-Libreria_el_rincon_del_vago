<?php
require_once("connection.php");

class ProductoController extends Connection
{

    public function Stock_Minimo()
    {
        $sql = "
        SELECT  Nombre,
            Stock AS Cantidad_Actual, 
            Umbral
        FROM 
            producto
        WHERE Stock < Umbral
        ORDER BY Cantidad_Actual ASC
        LIMIT 10
        ";
        $rs = $this->ejecutarSQL($sql);
        $Datos = array();
        while ($row = $rs->fetch_assoc()) {
            $Datos[] = new Producto(
                null,
                null,
                $row["Nombre"],
                null,
                null,
                $row["Cantidad_Actual"],
                $row["Umbral"],
                null,
                null,
                null
            );
        }

        return $Datos;
    }
}
