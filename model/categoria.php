<?php

class Categoria {
    // Propiedades privadas
    private $idCategoria;
    private $nombre;
    private $descripcion;
    private $estado;

    // Constructor
    public function __construct($idCategoria = null, $nombre = null, $descripcion = null, $estado = true) {
        $this->idCategoria = $idCategoria;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->estado = $estado;
    }

    // Métodos get
    public function getIdCategoria() {
        return $this->idCategoria;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getEstado() {
        return $this->estado;
    }

    // Métodos set
    public function setIdCategoria($idCategoria) {
        $this->idCategoria = $idCategoria;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }
}

?>
