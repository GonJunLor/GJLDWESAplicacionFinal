<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 14/01/2026
*/

if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: indexLoginLogoff.php');
    exit;
}

$estadoBarraNavegacion = 'oculto';
// cargamos el layout principal, ya éste cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];