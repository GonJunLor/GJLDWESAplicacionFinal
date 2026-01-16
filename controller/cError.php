<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 11/01/2026
*/

if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: indexLoginLogoff.php');
    exit;
}

//Se crea un array con la información de la clase ErrorApp
$avError=[
    'code' => $_SESSION['error']->getCode(),
    'message' => $_SESSION['error']->getMessage(),
    'file' => $_SESSION['error']->getFile(),
    'line' => $_SESSION['error']->getLine()
];

$estadoBarraNavegacion = 'oculto';
// cargamos el layout principal, ya éste cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];