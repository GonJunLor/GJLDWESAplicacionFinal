<?php
/**
 * Clase que representa la foto de la API de la NASA.
 * * Esta clase se utiliza para el transporte de datos entre la base de datos
 * y la lógica de negocio, almacenando toda la información relativa a la foto de la NASA.
 * 
 * @package App\Model
 * @author Gonzalo Junquera Lorenzo
 * @since 19/01/2026
 * @version 1.0.0
 */
class FotoNasa {

    /** @var string Fecha de la fotografía */
    private $fecha;

    /** @var string Descripción detallada de la imagen proporcionada por la NASA */
    private $descripcion;

    /** @var string URL de la imagen en alta resolución */
    private $urlHD;

    /** @var string Título de la fotografía */
    private $titulo;

    /** @var string URL de la imagen en resolución estándar */
    private $url;
    
    /**
     * Constructor de la clase FotoNasa.
     *
     * @param string $fecha       Fecha de la fotografía.
     * @param string $descripcion Descripción detallada de la imagen proporcionada por la NASA.
     * @param string $urlHD       URL de la imagen en alta resolución.
     * @param string $titulo      Título de la fotografía.
     * @param string $url         URL de la imagen en resolución estándar.
     */
    public function __construct($fecha, $descripcion, $urlHD, $titulo, $url) {
        $this->fecha = $fecha;  
        $this->descripcion = $descripcion;
        $this->urlHD = $urlHD;  
        $this->titulo = $titulo;
        $this->url = $url;
    }
    
    /**
     * Obtiene la fecha de la fotografía.
     * * @return string
     */
    public function getfecha() { 
        return $this->fecha; 
    }

    /**
     * Obtiene la descripción de la fotografía.
     * * @return string
     */
    public function getDescripcion() { 
        return $this->descripcion; 
    }

    /**
     * Obtiene la URL en alta resolución.
     * * @return string
     */
    public function getUrlHD() { 
        return $this->urlHD; 
    }

    /**
     * Obtiene el título de la fotografía.
     * * @return string
     */
    public function getTitulo() { 
        return $this->titulo; 
    }

    /**
     * Obtiene la URL en resolución estándar.
     * * @return string
     */
    public function getUrl() { 
        return $this->url; 
    }
}