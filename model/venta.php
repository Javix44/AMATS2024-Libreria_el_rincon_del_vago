<?php

class Venta {
    private $idVenta;
    private $producto; 
    private $usuario;  
    private $cantidad;

    public function __construct($idVenta = null, $producto = null, $usuario = null, $cantidad = null) {
        $this->idVenta = $idVenta;
        $this->producto = $producto; 
        $this->usuario = $usuario;    
        $this->cantidad = $cantidad;
    }

    // Métodos Get
    public function getIdVenta() {
        return $this->idVenta;
    }

    public function getProducto() {
        return $this->producto; 
    }

    public function getUsuario() {
        return $this->usuario;  
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    // Métodos Set
    public function setIdVenta($idVenta) {
        $this->idVenta = $idVenta;
    }

    public function setProducto($producto) {
        $this->producto = $producto; 
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario; 
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }
}

?>
