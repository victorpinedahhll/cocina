<?php
date_default_timezone_set('America/Guatemala');
// MESES
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$mesesshort = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");

// DIA
$diasemana  = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");

$datenow     = date("Y-m-d");
$datenowfull = date("Y-m-d H:i:s");
$dia         = date("d");
$mes         = date("m");
$anio        = date("Y");

$ussession   = $_SESSION['loggedcook'];
$idsession   = $_SESSION['clienteidcook'];
$nmsession   = $_SESSION['clientenamecook'];
$nvsession   = $_SESSION['nivelcook'];
if(!empty($_SESSION['nivelcooktemp'])){
	$nvsessiontemp = $_SESSION['nivelcooktemp'];
}

// formatea fechas
function formatearFechaEs($fechaInput) {
    date_default_timezone_set('America/Guatemala');

    // Establecer el locale en español (compatible con Windows)
    setlocale(LC_TIME, 'Spanish_Spain.1252');

    // Si ya es DateTime, lo usamos directo
    if ($fechaInput instanceof DateTime) {
        $fecha = $fechaInput;
    }
    // Si es string y strtotime lo reconoce como fecha válida
    elseif (is_string($fechaInput) && strtotime($fechaInput) !== false) {
        $fecha = new DateTime($fechaInput);
    } else {
        // Si no es fecha válida, devolver el valor original
        return $fechaInput;
    }

    // Formatear con strftime (requiere timestamp)
    return strftime("%d de %B %Y", $fecha->getTimestamp());
}
?>