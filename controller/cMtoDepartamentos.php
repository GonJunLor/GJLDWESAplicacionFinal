<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 24/01/2026
*/

if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

// Volvemos al inicio público pero sin cerrar sesión
if (isset($_REQUEST['inicio'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: index.php');
    exit;
}

// comprueba si existe una cookie de idioma y si no existe la crea en español
if (!isset($_COOKIE['idioma'])) {
    setcookie("idioma", "ES", time()+604.800); // caducidad 1 semana
    header('Location: ./index.php');
    exit;
}

// comprueba si se ha pulsado cualquier botón de idioma y pone en la cookie su valor para establecer el idioma
if (isset($_REQUEST['idioma'])) {
    setcookie("idioma", $_REQUEST['idioma'], time()+604.800); // caducidad 1 semana
    header('Location: ./index.php');
    exit;
}

// Volvemos al índice general destruyendo la sesión
if (isset($_REQUEST['cerrarSesion'])) {
    $_SESSION['paginaAnterior'] = '';
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    // Destruye la sesión
    session_destroy();
    header('Location: index.php');
    exit;
}

$terminoBusqueda = '%%'; // termino de busqueda explicado al usarlo
$entradaOK = true; //Variable que nos indica que todo va bien
$aErrores = [  //Array donde recogemos los mensajes de error
    'DescDepartamentoBuscado' => ''
];
$aRespuestas=[ //Array donde recogeremos la respuestas correctas (si $entradaOK)
    'DescDepartamentoBuscado' => ''
]; 

//Para cada campo del formulario: Validar entrada y actuar en consecuencia
if (isset($_REQUEST["buscar"])) {//Código que se ejecuta cuando se envía el formulario

    // Solo queremos validar se introduce algo, sino mostraremos despues todos los registros
    if (!empty($_REQUEST['DescDepartamentoBuscado'])) {
        // Validamos los datos del formulario
        $aErrores['DescDepartamentoBuscado']= validacionFormularios::comprobarAlfabetico($_REQUEST['DescDepartamentoBuscado'],255,0,1);
        
        foreach($aErrores as $campo => $valor){
            if(!empty($valor)){ // Comprobar si el valor es válido
                $entradaOK = false;
            } 
        }
    }
    
} else {//Código que se ejecuta antes de rellenar el formulario
    $entradaOK = false;
}


//Tratamiento del formulario
if($entradaOK){ //Cargar la variable $aRespuestas y tratamiento de datos OK
    
    // Recuperar los valores del formulario
    $aRespuestas['DescDepartamentoBuscado'] = $_REQUEST['DescDepartamentoBuscado'] ?? ''; // Usamos el operador ?? para asegurar un valor si no existe
    
    // Preparamos el término de búsqueda con comodines y en minúsculas para la búsqueda LIKE. 
    // Los % indica que puede tener cualquier cosa antes y después.
    // Si la descripción está vacía, el término será '%%', devolviendo todos los resultados.
    $terminoBusqueda = '%'.strtolower($aRespuestas['DescDepartamentoBuscado']).'%';
    // Usamos LOWER() en el campo de la DB y en el término de búsqueda para garantizar que la búsqueda sea insensible a mayúsculas/minúsculas.
}
 

// Objeto para guardar el departamento que viene de la BBDD 
$oDepartamentos = DepartamentoPDO::buscaDepartamentosPorDesc($terminoBusqueda);

$avMtoDepartamentos=[];
if (!is_null($oDepartamentos) && is_array($oDepartamentos)) {
    foreach ($oDepartamentos as $departamento) {

        // Creamos las fechas que vienen del objeto Departamento para formatearlas antes de pasarlas a la vista
        $fechaCreacion = new DateTime($departamento->getFechaCreacionDepartamento());
        $fechaBajaFormateada = '';
        if (!is_null($departamento->getFechaBajaDepartamento())) {
            $fechaBaja = new DateTime($departamento->getFechaBajaDepartamento());
            $fechaBajaFormateada = $fechaBaja->format('d/m/Y');
        }

        $avMtoDepartamentos[] = [
            'codDepartamento'           => $departamento->getCodDepartamento(),
            'descDepartamento'          => $departamento->getDescDepartamento(),
            'fechaCreacionDepartamento' => $fechaCreacion->format('d/m/Y'),
            'volumenDeNegocio'          => (number_format($departamento->getVolumenDeNegocio(), 2, ',', '.') . ' €'),
            'fechaBajaDepartamento'     => $fechaBajaFormateada
        ];
    }
}


$estadoBotonSalir = 'activo';
$estadoBotonIniciarSesion = 'inactivo';
// cargamos el layout principal, ya éste cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];