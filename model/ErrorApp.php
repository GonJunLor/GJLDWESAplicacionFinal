<?php
/**
 * Clase que representa un error de la aplicación.
 * * Esta clase se utiliza para el transporte de errores dentro de la aplicación,
 * permitiendo capturar y mostrar información detallada sobre excepciones o fallos.
 * 
 * @package App\Model
 * @author Gonzalo Junquera Lorenzo
 * @since 11/01/2026
 * @version 1.1.0
 */
class ErrorApp {

    /** @var string|int Código identificador del error */
    private $Code;

    /** @var string Mensaje descriptivo del error */
    private $Message;

    /** @var string Ruta del archivo donde se originó el error */
    private $File;

    /** @var int Número de línea donde se produjo el error */
    private $Line;

    /**
     * Constructor de la clase ErrorApp.
     *
     * @param string|int $Code    Código del error.
     * @param string     $Message Mensaje de error.
     * @param string     $File    Archivo de origen.
     * @param int        $Line    Línea de origen.
     */
    public function __construct($Code, $Message, $File, $Line) {
        $this->Code = $Code;
        $this->Message = $Message;
        $this->File = $File;
        $this->Line = $Line;
    }

    /**
     * Obtiene el código del error.
     * * @return string|int
     */
    public function getCode() {
        return $this->Code;
    }

    /**
     * Obtiene el mensaje del error.
     * * @return string
     */
    public function getMessage() {
        return $this->Message;
    }

    /**
     * Obtiene la ruta del archivo del error.
     * * @return string
     */
    public function getFile() {
        return $this->File;
    }

    /**
     * Obtiene la línea donde ocurrió el error.
     * * @return int
     */
    public function getLine() {
        return $this->Line;
    }
}