<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 18/12/2025
*/
class Usuario {
    private $codUsuario;
    private $password;
    private $descUsuario;
    private $numAccesos;
    private $fechaHoraUltimaConexion;
    private $fechaHoraUltimaConexionAnterior;
    private $perfil;

    public function __construct($codUsuario, $password, $descUsuario, $numAccesos, $fechaHoraUltimaConexion, $fechaHoraUltimaConexionAnterior, $perfil){
        $this->codUsuario = $codUsuario;
        $this->password = $password;
        $this->descUsuario = $descUsuario;
        $this->numAccesos = $numAccesos;
        $this->fechaHoraUltimaConexion = $fechaHoraUltimaConexion;
        $this->fechaHoraUltimaConexionAnterior = $fechaHoraUltimaConexionAnterior;
        $this->perfil = $perfil;
    }

    public function getCodUsuario() {
        return $this->codUsuario;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getDescUsuario() {
        return $this->descUsuario;
    }

    public function getNumAccesos() {
        return $this->numAccesos;
    }

    public function getFechaHoraUltimaConexion() {
        return $this->fechaHoraUltimaConexion;
    }

    public function getFechaHoraUltimaConexionAnterior() {
        return $this->fechaHoraUltimaConexionAnterior;
    }

    public function getPerfil() {
        return $this->perfil;
    }

    public function setCodUsuario($codUsuario) {
        $this->codUsuario = $codUsuario;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setDescUsuario($descUsuario) {
        $this->descUsuario = $descUsuario;
    }

    public function setNumAccesos($numAccesos) {
        $this->numAccesos = $numAccesos;
    }

    public function setFechaHoraUltimaConexion($fechaHoraUltimaConexion) {
        $this->fechaHoraUltimaConexion = $fechaHoraUltimaConexion;
    }

    public function setFechaHoraUltimaConexionAnterior($fechaHoraUltimaConexionAnterior) {
        $this->fechaHoraUltimaConexionAnterior = $fechaHoraUltimaConexionAnterior;
    }

    public function setPerfil($perfil) {
        $this->perfil = $perfil;
    }
}
