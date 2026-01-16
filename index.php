<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 15/12/2025
*/

// cargamos los archivos de configuración
require_once  'conf/confApp.php';


// iniciamos session
session_start();

// si no esta la página en curso en la sesión la creamos con inicio público
if (!isset($_SESSION['paginaEnCurso'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
}

// cargamos el controlador de la pagina en curso
require_once $controller[$_SESSION['paginaEnCurso']];

