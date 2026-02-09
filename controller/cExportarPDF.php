<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since:05/02/2026
*/

if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'mtoDepartamentos';
    header('Location: index.php');
    exit;
}

$aDepartamentos = DepartamentoPDO::buscaDepartamentosPorDescEstado(
    $_SESSION['descDepartamentoBuscadaEnCurso'] ?? '',
    $_SESSION['estadoDepartamentoBuscadoEnCurso'] ?? 'radioTodos'
);

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
            'fechaBajaDepartamento'     => $fechaBajaFormateada,
            'estadoDepartamento'        => $fechaBajaFormateada==''?'baja':'alta',
        ];
    }
}

$estadoBotonSalir = 'inactivo';
$estadoBotonIniciarSesion = 'inactivo';
// cargamos el layout principal, ya éste cargará cada página a parte de la estructura principal de la web
require_once $view['layout'];