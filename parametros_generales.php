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
?>