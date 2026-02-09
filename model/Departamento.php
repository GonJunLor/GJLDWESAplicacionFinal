<?php
/**
 * Clase que representa un departamento del sistema.
 * * Esta clase se utiliza para el transporte de datos entre la base de datos
 * y la lógica de negocio, almacenando toda la información relativa a los departamentos.
 * 
 * @package App\Model
 * @author Gonzalo Junquera Lorenzo
 * @since 23/01/2026
 * @version 1.0.0
 */
class Departamento {

    /** @var string Código único del departamento */
    private $codDepartamento;

    /** @var string Descripción del departamento */
    private $descDepartamento;

    /** @var int|string Fecha de creación del departamento */
    private $fechaCreacionDepartamento;

    /** @var float|int Volumen de negocio del departamento */
    private $volumenDeNegocio;

    /** @var null|int|string Fecha de baja del departamento (null si está activo) */
    private $fechaBajaDepartamento;

    /**
     * Constructor de la clase Departamento.
     *
     * @param string $codDepartamento           Código del departamento.
     * @param string $descDepartamento          Descripción del departamento.
     * @param int|string $fechaCreacionDepartamento Fecha de creación.
     * @param float|int $volumenDeNegocio       Cifra de negocio inicial.
     * @param null|int|string $fechaBajaDepartamento Fecha de baja (null si está activo).
     */
    public function __construct($codDepartamento, $descDepartamento, $fechaCreacionDepartamento, $volumenDeNegocio, $fechaBajaDepartamento) {
        $this->codDepartamento = $codDepartamento;
        $this->descDepartamento = $descDepartamento;
        $this->fechaCreacionDepartamento = $fechaCreacionDepartamento;
        $this->volumenDeNegocio = $volumenDeNegocio;
        $this->fechaBajaDepartamento = $fechaBajaDepartamento;
    }

    /**
     * Obtiene el código del departamento.
     * @return string
     */
    public function getCodDepartamento() {
        return $this->codDepartamento;
    }

    /**
     * Define el código del departamento.
     * @param string $codDepartamento
     */
    public function setCodDepartamento($codDepartamento) {
        $this->codDepartamento = $codDepartamento;
    }

    /**
     * Obtiene la descripción del departamento.
     * @return string
     */
    public function getDescDepartamento() {
        return $this->descDepartamento;
    }

    /**
     * Define la descripción del departamento.
     * @param string $descDepartamento
     */
    public function setDescDepartamento($descDepartamento) {
        $this->descDepartamento = $descDepartamento;
    }

    /**
     * Obtiene la fecha de creación.
     * @return int|string
     */
    public function getFechaCreacionDepartamento() {
        return $this->fechaCreacionDepartamento;
    }

    /**
     * Define la fecha de creación.
     * @param int|string $fechaCreacionDepartamento
     */
    public function setFechaCreacionDepartamento($fechaCreacionDepartamento) {
        $this->fechaCreacionDepartamento = $fechaCreacionDepartamento;
    }

    /**
     * Obtiene el volumen de negocio.
     * @return float|int
     */
    public function getVolumenDeNegocio() {
        return $this->volumenDeNegocio;
    }

    /**
     * Define el volumen de negocio.
     * @param float|int $volumenDeNegocio
     */
    public function setVolumenDeNegocio($volumenDeNegocio) {
        $this->volumenDeNegocio = $volumenDeNegocio;
    }

    /**
     * Obtiene la fecha de baja del departamento.
     * @return null|int|string
     */
    public function getFechaBajaDepartamento() {
        return $this->fechaBajaDepartamento;
    }

    /**
     * Define la fecha de baja del departamento.
     * @param null|int|string $fechaBajaDepartamento
     */
    public function setFechaBajaDepartamento($fechaBajaDepartamento) {
        $this->fechaBajaDepartamento = $fechaBajaDepartamento;
    }
}