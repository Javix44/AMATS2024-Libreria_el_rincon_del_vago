<?php

class Usuario {
    private $idUsuario;
    private $nombre;
    private $nombreUsu;
    private $clave;
    private $correo;
    private $esAdmin; 
    private $estado;  

    public function __construct($idUsuario = null, $nombre = null, $nombreUsu = null, $clave = null, $correo = null, $esAdmin = null, $estado = null) {
        $this->idUsuario = $idUsuario;
        $this->nombre = $nombre;
        $this->nombreUsu = $nombreUsu;
        $this->clave = $clave;
        $this->correo = $correo;
        $this->esAdmin = $esAdmin; 
        $this->estado = $estado;   
    }

    // Métodos Get
    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getNombreUsu() {
        return $this->nombreUsu;
    }

    public function getClave() {
        return $this->clave;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function getEsAdmin() {
        return $this->esAdmin;
    }

    public function getEstado() {
        return $this->estado;
    }

    // Métodos Set
    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setNombreUsu($nombreUsu) {
        $this->nombreUsu = $nombreUsu;
    }

    public function setClave($clave) {
        $this->clave = $clave;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function setEsAdmin($esAdmin) {
        $this->esAdmin = $esAdmin;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }
}

?>
