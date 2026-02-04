<?php
/**
 * Clase que representa un Usuario del sistema.
 * * Esta clase se utiliza para el transporte de datos entre la base de datos
 * y la lógica de negocio, almacenando toda la información relativa al perfil de usuario.
 * * @package App\Model
 * @author Gonzalo Junquera Lorenzo
 * @since 18/12/2025
 * @version 1.0.0
 */
class Usuario {
    
    /** @var string Código único del usuario (ID) */
    private $codUsuario;

    /** @var string Contraseña cifrada del usuario */
    private $password;

    /** @var string Nombre completo */
    private $descUsuario;

    /** @var int Contador de veces que ha iniciado sesión */
    private $numAccesos;

    /** @var int|null Fecha de la conexión actual */
    private $fechaHoraUltimaConexion;

    /** @var int|null Fecha de la conexión anterior */
    private $fechaHoraUltimaConexionAnterior;

    /** @var string Tipo de perfil ('usuario', 'admin') */
    private $perfil;

    /** @var string|null Imagen de perfil en formato binario */
    private $imagenUsuario;

    /**
     * Constructor de la clase Usuario.
     * * @param string $codUsuario Código único.
     * @param string $password Contraseña.
     * @param string $descUsuario Nombre completo.
     * @param int $numAccesos Contador de veces que ha iniciado sesión.
     * @param int|null $fechaHoraUltimaConexion Fecha de la conexión actual.
     * @param int|null $fechaHoraUltimaConexionAnterior Fecha de la conexión anterior.
     * @param string $perfil Tipo de perfil ('usuario', 'admin').
     * @param string|null $imagenUsuario Imagen de perfil en formato binario.
     */
    public function __construct($codUsuario, $password, $descUsuario, $numAccesos, $fechaHoraUltimaConexion, $fechaHoraUltimaConexionAnterior, $perfil, $imagenUsuario){
        $this->codUsuario = $codUsuario;
        $this->password = $password;
        $this->descUsuario = $descUsuario;
        $this->numAccesos = $numAccesos;
        $this->fechaHoraUltimaConexion = $fechaHoraUltimaConexion;
        $this->fechaHoraUltimaConexionAnterior = $fechaHoraUltimaConexionAnterior;
        $this->perfil = $perfil;
        $this->imagenUsuario = $imagenUsuario;
    }

    /**
     * Obtiene el código del usuario.
     * @return string
     */
    public function getCodUsuario() {
        return $this->codUsuario;
    }

    /**
     * Obtiene la contraseña.
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Obtiene la descripción del usuario.
     * @return string
     */
    public function getDescUsuario() {
        return $this->descUsuario;
    }

    /**
     * Obtiene el número total de accesos realizados.
     * @return int
     */
    public function getNumAccesos() {
        return $this->numAccesos;
    }

    /**
     * Obtiene la fecha y hora de la última conexión.
     * @return int|null
     */
    public function getFechaHoraUltimaConexion() {
        return $this->fechaHoraUltimaConexion;
    }

    /**
     * Obtiene la fecha y hora de la conexión anterior.
     * @return int|null
     */
    public function getFechaHoraUltimaConexionAnterior() {
        return $this->fechaHoraUltimaConexionAnterior;
    }

    /**
     * Obtiene el perfil del usuario.
     * @return string
     */
    public function getPerfil() {
        return $this->perfil;
    }

    /**
     * Obtiene la imagen del usuario.
     * @return string|null
     */
    public function getImagenUsuario() {
        return $this->imagenUsuario;
    }

    /**
     * Establece el código del usuario.
     * @param string $codUsuario
     */
    public function setCodUsuario($codUsuario) {
        $this->codUsuario = $codUsuario;
    }

    /**
     * Establece la contraseña.
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * Establece la descripción del usuario.
     * @param string $descUsuario
     */
    public function setDescUsuario($descUsuario) {
        $this->descUsuario = $descUsuario;
    }

    /**
     * Establece el número de accesos.
     * @param int $numAccesos
     */
    public function setNumAccesos($numAccesos) {
        $this->numAccesos = $numAccesos;
    }

    /**
     * Establece la fecha y hora de la última conexión.
     * @param int|null $fechaHoraUltimaConexion
     */
    public function setFechaHoraUltimaConexion($fechaHoraUltimaConexion) {
        $this->fechaHoraUltimaConexion = $fechaHoraUltimaConexion;
    }

    /**
     * Establece la fecha y hora de la conexión anterior.
     * @param int|null $fechaHoraUltimaConexionAnterior
     */
    public function setFechaHoraUltimaConexionAnterior($fechaHoraUltimaConexionAnterior) {
        $this->fechaHoraUltimaConexionAnterior = $fechaHoraUltimaConexionAnterior;
    }

    /**
     * Establece el perfil del usuario.
     * @param string $perfil
     */
    public function setPerfil($perfil) {
        $this->perfil = $perfil;
    }

    /**
     * Establece la imagen del usuario.
     * @param string|null $imagenUsuario
     */
    public function setImagenUsuario($imagenUsuario) {
        $this->imagenUsuario = $imagenUsuario;
    }
}