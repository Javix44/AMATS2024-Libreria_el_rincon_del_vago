<?php

class Proveedor {
    private $idProveedor;
    private $nombre;
    private $correo;
    private $telefono;

    public function __construct($idProveedor = null, $nombre = null, $correo = null, $telefono = null) {
        $this->idProveedor = $idProveedor;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->telefono = $telefono;
    }

    // Métodos Get
    public function getIdProveedor() {
        return $this->idProveedor;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    // Métodos Set
    public function setIdProveedor($idProveedor) {
        $this->idProveedor = $idProveedor;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }
}

?>
