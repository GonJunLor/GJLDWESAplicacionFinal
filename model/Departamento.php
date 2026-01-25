<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 23/01/2026
*/
class Departamento {
    private $codDepartamento;
    private $descDepartamento;
    private $fechaCreacionDepartamento;
    private $volumenDeNegocio;
    private $fechaBajaDepartamento;

    public function __construct($codDepartamento, $descDepartamento, $fechaCreacionDepartamento, $volumenDeNegocio, $fechaBajaDepartamento){
        $this->codDepartamento = $codDepartamento;
        $this->descDepartamento = $descDepartamento;
        $this->fechaCreacionDepartamento = $fechaCreacionDepartamento;
        $this->volumenDeNegocio = $volumenDeNegocio;
        $this->fechaBajaDepartamento = $fechaBajaDepartamento;
    }

    public function getCodDepartamento() {
        return $this->codDepartamento;
    }

    public function setCodDepartamento($codDepartamento) {
        $this->codDepartamento = $codDepartamento;
    }

    public function getDescDepartamento() {
        return $this->descDepartamento;
    }

    public function setDescDepartamento($descDepartamento) {
        $this->descDepartamento = $descDepartamento;
    }

    public function getFechaCreacionDepartamento() {
        return $this->fechaCreacionDepartamento;
    }

    public function setFechaCreacionDepartamento($fechaCreacionDepartamento) {
        $this->fechaCreacionDepartamento = $fechaCreacionDepartamento;
    }

    public function getVolumenDeNegocio() {
        return $this->volumenDeNegocio;
    }

    public function setVolumenDeNegocio($volumenDeNegocio) {
        $this->volumenDeNegocio = $volumenDeNegocio;
    }

    public function getFechaBajaDepartamento() {
        return $this->fechaBajaDepartamento;
    }

    public function setFechaBajaDepartamento($fechaBajaDepartamento) {
        $this->fechaBajaDepartamento = $fechaBajaDepartamento;
    }

}