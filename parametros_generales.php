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

    $fechaInput = strtotime($fechaInput);

    $formatDia  = date("d",$fechaInput);
    $formatMes  = date("m",$fechaInput);
    if($formatMes=="01"){ $mesFinal = "enero"; }
    if($formatMes=="02"){ $mesFinal = "febrero"; }
    if($formatMes=="03"){ $mesFinal = "marzo"; }
    if($formatMes=="04"){ $mesFinal = "abril"; }
    if($formatMes=="05"){ $mesFinal = "mayo"; }
    if($formatMes=="06"){ $mesFinal = "junio"; }
    if($formatMes=="07"){ $mesFinal = "julio"; }
    if($formatMes=="08"){ $mesFinal = "agosto"; }
    if($formatMes=="09"){ $mesFinal = "septiembre"; }
    if($formatMes=="10"){ $mesFinal = "octubre"; }
    if($formatMes=="11"){ $mesFinal = "noviembre"; }
    if($formatMes=="12"){ $mesFinal = "diciembre"; }
    $formatAnio  = date("Y",$fechaInput);
    $formatHora  = date("H:i A",$fechaInput);

    if($formatHora=="" || $formatHora=="00:00"){
        $fecha   = $formatDia." de ".$mesFinal." ".$formatAnio;
    }else{
        $fecha   = $formatDia." de ".$mesFinal." ".$formatAnio." ".$formatHora;
    }

    return $fecha; 
    
}

// formatea fechas
function formatearFecha($fechanormal) {
    date_default_timezone_set('America/Guatemala');

    $fechanormal = strtotime($fechanormal);
    $fechanormalfinal  = date("d/m/Y",$fechanormal);

    return $fechanormalfinal; 
    
}
?>