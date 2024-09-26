<?php

class Producto {
    private $idProducto;
    private $codigo;
    private $nombre;
    private $descripcion;
    private $categoria; 
    private $stock;
    private $umbral;
    private $precioCompra;
    private $precioVenta;
    private $estado; 

    public function __construct($idProducto = null, $codigo = null, $nombre = null, $descripcion = null, $categoria = null, $stock = null, $umbral = null, $precioCompra = null, $precioVenta = null, $estado = null) {
        $this->idProducto = $idProducto;
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->categoria = $categoria; 
        $this->stock = $stock;
        $this->umbral = $umbral;
        $this->precioCompra = $precioCompra;
        $this->precioVenta = $precioVenta;
        $this->estado = $estado; 
    }

    // Métodos Get
    public function getIdProducto() {
        return $this->idProducto;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getCategoria() {
        return $this->categoria; 
    }

    public function getStock() {
        return $this->stock;
    }

    public function getUmbral() {
        return $this->umbral;
    }

    public function getPrecioCompra() {
        return $this->precioCompra;
    }

    public function getPrecioVenta() {
        return $this->precioVenta;
    }

    public function getEstado() {
        return $this->estado;
    }

    // Métodos Set
    public function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setCategoria($categoria) {
        $this->categoria = $categoria; 
    }

    public function setStock($stock) {
        $this->stock = $stock;
    }

    public function setUmbral($umbral) {
        $this->umbral = $umbral;
    }

    public function setPrecioCompra($precioCompra) {
        $this->precioCompra = $precioCompra;
    }

    public function setPrecioVenta($precioVenta) {
        $this->precioVenta = $precioVenta;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }
}

?>
