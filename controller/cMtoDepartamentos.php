<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 26/01/2026
*/

if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['editar'])) {
    // Guardamos el código del departamento que queremos editar
    $codDepartamentoAEditar = $_REQUEST['editar'];
    
    // Lo guardamos en la sesión para que el controlador de la ventana de edición sepa qué cargar
    $_SESSION['codDepartamentoEnCurso'] = $codDepartamentoAEditar;
    
    // Cambiamos la página en curso y redirigimos
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    // $_SESSION['paginaEnCurso'] = 'consultarModificarDepartamento';
    $_SESSION['paginaEnCurso'] = 'consultarModificarDepartamento';
    
    header('Location: index.php');
    exit;
}

// $terminoBusqueda = '%%'; // termino de busqueda explicado al usarlo
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
    
    // Guardamos la descripción buscada en la sesión para usarla cuando volvamos a cargar el controlador
    $_SESSION['descDepartamentoBuscadaEnCurso'] = $aRespuestas['DescDepartamentoBuscado'];

}
 

// Objeto para guardar el departamento que viene de la BBDD 
$aDepartamentos = DepartamentoPDO::buscaDepartamentosPorDesc($_SESSION['descDepartamentoBuscadaEnCurso']??'');

$avMtoDepartamentos=[];
if (!is_null($aDepartamentos) && is_array($aDepartamentos)) {
    foreach ($aDepartamentos as $oDepartamento) {

        // Creamos las fechas que vienen del objeto Departamento para formatearlas antes de pasarlas a la vista
        $fechaCreacion = new DateTime($oDepartamento->getFechaCreacionDepartamento());
        $fechaBajaFormateada = '';
        if (!is_null($oDepartamento->getFechaBajaDepartamento())) {
            $fechaBaja = new DateTime($oDepartamento->getFechaBajaDepartamento());
            $fechaBajaFormateada = $fechaBaja->format('d/m/Y');
        }

        $avMtoDepartamentos[] = [
            'codDepartamento'           => $oDepartamento->getCodDepartamento(),
            'descDepartamento'          => $oDepartamento->getDescDepartamento(),
            'fechaCreacionDepartamento' => $fechaCreacion->format('d/m/Y'),
            'volumenDeNegocio'          => (number_format($oDepartamento->getVolumenDeNegocio(), 2, ',', '.') . ' €'),
            'fechaBajaDepartamento'     => $fechaBajaFormateada
        ];
    }
}


$estadoBotonSalir = 'activo';
$estadoBotonIniciarSesion = 'inactivo';
// cargamos el layout principal, ya éste cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];