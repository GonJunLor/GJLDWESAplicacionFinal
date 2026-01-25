<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 19/01/2026
*/

class FotoNasa {

    private $fecha;
    private $descripcion;
    private $urlHD;
    private $titulo;
    private $url;
    
    public function __construct($fecha, $descripcion, $urlHD, $titulo, $url) {
        $this->fecha = $fecha;  
        $this->descripcion = $descripcion;
        $this->urlHD = $urlHD;  
        $this->titulo = $titulo;
        $this->url = $url;
    }
    
    public function getfecha() { 
        return $this->fecha; 
    }
    public function getDescripcion() { 
        return $this->descripcion; 
    }
    public function getUrlHD() { 
        return $this->urlHD; 
    }
    public function getTitulo() { 
        return $this->titulo; 
    }
    public function getUrl() { 
        return $this->url; 
    }
    
}