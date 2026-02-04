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

if (isset($_REQUEST['altaDepartamento'])) {
    $_SESSION['paginaEnCurso'] = 'altaDepartamento';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['exportar'])) {
    
    // recuperamos de la BBDD lo que ha buscado el usuario
    $aDepartamentosExportar = DepartamentoPDO::buscaDepartamentosPorDesc($_SESSION['descDepartamentoBuscadaEnCurso']??'');

    $avMtoDepartamentosExportar=[];
    if (!is_null($aDepartamentosExportar) && is_array($aDepartamentosExportar)) {
        foreach ($aDepartamentosExportar as $oDepartamentoExportar) {

            $avMtoDepartamentosExportar[] = [
                'codDepartamento'           => $oDepartamentoExportar->getCodDepartamento(),
                'descDepartamento'          => $oDepartamentoExportar->getDescDepartamento(),
                'fechaCreacionDepartamento' => $oDepartamentoExportar->getFechaCreacionDepartamento(),
                'volumenDeNegocio'          => $oDepartamentoExportar->getVolumenDeNegocio(),
                'fechaBajaDepartamento'     => $oDepartamentoExportar->getFechaBajaDepartamento()
            ];
        }
    }

    // Convertimos a JSON con un formato limpio
    $jsonContenido = json_encode($avMtoDepartamentosExportar, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    DBPDO::insertarTrazabilidad('exportar','T02_Departamento',
        'Exportó '.count($avMtoDepartamentosExportar).' departamentos.');

    // Cabecera para forzar la descarga del archivo
    header('Content-Disposition: attachment; filename="departamentos.json"');

    // Enviamos el contenido y finalizamos el script para que no cargue la vista
    echo $jsonContenido;
    exit;
}

if (isset($_REQUEST['editar'])) {

    // Guardamos el código del departamento en la sesión para que el controlador de la ventana de edición sepa qué cargar
    $_SESSION['codDepartamentoEnCurso'] = $_REQUEST['editar'];
    
    // Cambiamos la página en curso y redirigimos
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'modificarDepartamento';
    
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['mostrar'])) {
    
    // Guardamos el código del departamento en la sesión para que el controlador de la ventana de edición sepa qué cargar
    $_SESSION['codDepartamentoEnCurso'] = $_REQUEST['mostrar'];
    
    // Cambiamos la página en curso y redirigimos
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'consultarDepartamento';
    
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['borrar'])) {
    
    // Guardamos el código del departamento en la sesión para que el controlador de la ventana de edición sepa qué cargar
    $_SESSION['codDepartamentoEnCurso'] = $_REQUEST['borrar'];
    
    // Cambiamos la página en curso y redirigimos
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'eliminarDepartamento';
    
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['bajaAlta'])) {

    // buscamos el departamento en la BBDD
    $oDepartamentoAltaBaja = DepartamentoPDO::buscaDepartamentoPorCod($_REQUEST['bajaAlta']);

    // Comprobamos si esta de alta o de baja lógica en función de si la fecha de baja es null
    if (is_null($oDepartamentoAltaBaja->getFechaBajaDepartamento())) {
        // el departamento es de alta
        DepartamentoPDO::bajaLogicaDepartamento($_REQUEST['bajaAlta']);
    } else {
        // el departamento está de baja
        DepartamentoPDO::rehabilitaDepartamento($_REQUEST['bajaAlta']);
    }

    // Cambiamos la página en curso y redirigimos
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'mtoDepartamentos';
    
    header('Location: index.php');
    exit;
}

$entradaOK = true; //Variable que nos indica que todo va bien
$archivoOK = true; //Variable que nos indica que todo va bien en la importación
$aErrores = [  //Array donde recogemos los mensajes de error
    'DescDepartamentoBuscado' => '',
    'archivoDepartamentos' => ''
];
$aRespuestas=[ //Array donde recogeremos la respuestas correctas (si $entradaOK)
    'DescDepartamentoBuscado' => '',
    'archivoDepartamentos' => ''
]; 

if (isset($_REQUEST['importar'])){

    $aExtensiones = ['json'];
    $nombreArchivo = $_FILES['archivoDepartamentos']['name'] ?? '';
    $aErrores['archivoDepartamentos']= validacionFormularios::validarNombreArchivo($nombreArchivo,$aExtensiones,150,4,0);
    
    if(!empty($aErrores['archivoDepartamentos'])){ // Comprobar si el valor es válido
        $archivoOK = false;
    } 

    // Comprobar si el archivo realmente se ha enviado
    if ($_FILES['archivoDepartamentos']['error'] == UPLOAD_ERR_NO_FILE) {
        $aErrores['archivoDepartamentos'] = "Por favor, selecciona un archivo antes de importar.";
        $archivoOK = false;
    } else {
        // Comprobamos que la estrutura del json está bien, con todos los campos
        // Leemos el contenido del archivo subido
        $contenidoImagen = file_get_contents($_FILES['archivoDepartamentos']['tmp_name']);

        // lo convertimos a un array
        $aDepartamentos = json_decode($contenidoImagen,true);

        // Definimos los campos que DEBEN estar en cada departamento
        $camposObligatorios = [
            'codDepartamento', 
            'descDepartamento', 
            'fechaCreacionDepartamento', 
            'volumenDeNegocio', 
            'fechaBajaDepartamento'
        ];

        // comprobamos que existe cada campo en el archivo json
        foreach ($aDepartamentos as $indice => $departamento) {
            foreach ($camposObligatorios as $campo) {
                // array_key_exists es más preciso que isset por si el valor es NULL
                if (!array_key_exists($campo, $departamento)) {
                    $archivoOK = false;
                    $aErrores['archivoDepartamentos'] = "Error en la estructura del archivo json: <br> En el registro $indice: Falta el campo '$campo'.";
                    break 2; // Rompe el bucle de campos y el de departamentos
                }
            }
        }
        
    }
  
} else {//Código que se ejecuta antes de rellenar el formulario
    $archivoOK = false;
}

if ($archivoOK) {

    // Verificamos si se ha subido un archivo sin errores
    if (isset($_FILES['archivoDepartamentos']) && $_FILES['archivoDepartamentos']['error'] === UPLOAD_ERR_OK) {
        // Leemos el contenido del archivo subido
        $contenidoImagen = file_get_contents($_FILES['archivoDepartamentos']['tmp_name']);

        // lo convertimos a un array
        $aDepartamentos = json_decode($contenidoImagen,true);

        // lo guardamos en la BBDD
        if( DepartamentoPDO::insertarDepartamentos($aDepartamentos)){
            $aRespuestas['archivoDepartamentos'] = 'Departamentos insertados correctamente';
        } else {
            $aErrores['archivoDepartamentos'] = 'No se han insertado los registros en la BBDD';
        }
    } else {
        $aErrores['archivoDepartamentos']='Error al subir el archivo';
    }
}

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

    // Guardamos en la sesion el estado buscado para usarla 
    $_SESSION['estadoDepartamentoBuscadoEnCurso'] = $_REQUEST['radio'];

    // Reseteamos la paginación a 1 para evitar problemas de que salga pag 3 de 2 por ejemplo
    $_SESSION['paginaActualTablaDepartamentos'] = 1;
}

$criterioRadio = $_SESSION['estadoDepartamentoBuscadoEnCurso'] ?? 'radioTodos';

if ($criterioRadio == 'radioTodos') {
    $aDepartamentos = DepartamentoPDO::buscaDepartamentosPorDesc($_SESSION['descDepartamentoBuscadaEnCurso'] ?? '');
} else if ($criterioRadio == 'radioAlta') {
    $aDepartamentos = DepartamentoPDO::buscaDepartamentosPorDescEstado($_SESSION['descDepartamentoBuscadaEnCurso'] ?? '', 'alta');
} else if ($criterioRadio == 'radioBaja') {
    $aDepartamentos = DepartamentoPDO::buscaDepartamentosPorDescEstado($_SESSION['descDepartamentoBuscadaEnCurso'] ?? '', 'baja');
}

// variables para la gestión de la paginación
$resultadosPorPagina = 5;
$totalPaginas = ceil(count($aDepartamentos)/$resultadosPorPagina);

$paginaActual = $_SESSION['paginaActualTablaDepartamentos']??1;
if (isset($_REQUEST['paginaInicial'])){$paginaActual = 1;}
if (isset($_REQUEST['paginaAnterior'])){$paginaActual>1?$paginaActual--:'';}
if (isset($_REQUEST['paginaSiguiente'])){$paginaActual<$totalPaginas?$paginaActual++:'';}
if (isset($_REQUEST['paginaFinal'])){$paginaActual = $totalPaginas;}

// echo 'Pagina actual'.$paginaActual;
$_SESSION['paginaActualTablaDepartamentos'] = $paginaActual;

$avMtoDepartamentos=[];
if (!is_null($aDepartamentos) && is_array($aDepartamentos)) {

    $indiceActual = ($paginaActual-1)*$resultadosPorPagina;
    foreach ($aDepartamentos as $index=>$oDepartamento) {

        if ($index>=$indiceActual && $index<($indiceActual+$resultadosPorPagina)) {
            // echo 'el indice nuevo a ver que tiene: '.$index;
            // echo '<br>';

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
                'fechaBajaDepartamento'     => $fechaBajaFormateada,
                'estadoDepartamento'        => $fechaBajaFormateada==''?'baja':'alta',
            ];
        }
    }
}

$estadoBotonSalir = 'activo';
$estadoBotonIniciarSesion = 'inactivo';
// cargamos el layout principal, ya éste cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];