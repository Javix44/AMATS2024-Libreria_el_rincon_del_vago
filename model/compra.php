<?php

class Compra
{
    private $idCompra;
    private $usuario;
    private $proveedor;
    private $producto;
    private $fechaRegistro;
    private $cantidad;

    public function __construct($idCompra = null, $usuario = null, $proveedor = null, $producto = null, $fechaRegistro = null, $cantidad = null)
    {
        $this->idCompra = $idCompra;
        $this->usuario = $usuario;
        $this->proveedor = $proveedor;
        $this->producto = $producto;
        $this->fechaRegistro = $fechaRegistro;
        $this->cantidad = $cantidad;
    }

    // Métodos Get
    public function getIdCompra()
    {
        return $this->idCompra;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getProveedor()
    {
        return $this->proveedor;
    }

    public function getProducto()
    {
        return $this->producto;
    }

    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    // Métodos Set
    public function setIdCompra($idCompra)
    {
        $this->idCompra = $idCompra;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function setProveedor($proveedor)
    {
        $this->proveedor = $proveedor;
    }

    public function setProducto($producto)
    {
        $this->producto = $producto;
    }

    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }
}
