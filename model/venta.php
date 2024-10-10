<?php

class Venta {
    private $idVenta;
    private $usuario;  
    private $nombrecliente;  
    private $correocliente;  
    private $estado;

    public function __construct($idVenta, $usuario, $nombrecliente, $correocliente, $estado) {
        $this->idVenta = $idVenta;
        $this->usuario = $usuario;
        $this->nombrecliente = $nombrecliente;
        $this->correocliente = $correocliente;
        $this->estado = $estado;
    }

    public function getIdVenta() {
        return $this->idVenta;
    }

    public function setIdVenta($idVenta) {
        $this->idVenta = $idVenta;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function getNombreCliente() {
        return $this->nombrecliente;
    }

    public function setNombreCliente($nombrecliente) {
        $this->nombrecliente = $nombrecliente;
    }

    public function getCorreoCliente() {
        return $this->correocliente;
    }

    public function setCorreoCliente($correocliente) {
        $this->correocliente = $correocliente;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }
}

?>
