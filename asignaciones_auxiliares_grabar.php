<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$areaLg = "ASIGNACIONES"; // valida roles del usuario

require("security.php");
require("_private/_access.php");
require("logged.php");
include("parametros_generales.php");

$auxiliar = $_POST['auxiliar'];
$area     = $_POST['area'];
$inicio   = $_POST['inicio'];
$final    = $_POST['final'];

if($final < $inicio){
    echo "<script>alert('La fecha final no puede ser menor a la fecha inicial, intentelo de nuevo');document.location='asignaciones_auxiliares.php';</script>";
	exit;
}

$qryS = "
SELECT * 
FROM _auxiliar_asignaciones 
WHERE 
    id_area = '$area' 
    AND '$datenow' BETWEEN '$inicio' AND '$final'
";
$resS = $conexion->query($qryS);
if($resS->num_rows > 0){
    echo "<script>alert('Lo sentimos, ya existe un Auxiliar asignado a esta fecha y a esta área');document.location='asignaciones_auxiliares.php';</script>";
	exit;
}

if ( $_POST['acc'] == "add" ){

	$qry = "INSERT INTO `_auxiliar_asignaciones`(`id`, `id_aux`, `id_area`, `fecha_inicio`, `fecha_final`, `status`, `usuario`) VALUES  ('0','$auxiliar','$area','$inicio','$final','A','$ussession')";
    $conexion->query($qry);
    $conexion->close();
    header("Location: asignaciones_auxiliares.php");
    exit;

}

if ( $_POST['acc'] == "edit" ){

	$id  = $_POST['id'];
	$qry = "UPDATE `_auxiliar_asignaciones` SET id_aux='$auxiliar', id_area='$area', fecha_inicio='$inicio', fecha_final='$final' WHERE id='$id'";
    $conexion->query($qry);
    $conexion->close();
    header("Location: asignaciones_auxiliares.php");
    exit;

}

if ( $_POST['acc'] == "borrar" ){

	$id  = $_POST['id'];
	$qry = "UPDATE `_auxiliar_asignaciones` SET status = 'E' WHERE id=$id";
    $conexion->query($qry);
    $conexion->close();
    header("Location: asignaciones_auxiliares.php");
    exit;

}
?>