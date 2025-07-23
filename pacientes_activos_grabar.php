<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// if($nvsessiontemp!="A"){
// 	echo "<body>";
// 	echo "<script>alert('Acceso Denegado o a expirado su sesion');document.location='logout.php';</script>";
// 	echo "</body>";
// 	exit;
// }

header("Content-Type: text/html;charset=UTF-8");

$areaLg = "INGRESO_PAC"; // valida roles del usuario

require("security.php");
require("_private/_access.php");
include("logged.php");
include("parametros_generales.php");

$id            = $_POST['id'];
$fingreso      = $_POST['fingreso'];
$idpaciente    = $_POST['idpaciente'];
$pcodigo       = $_POST['pcodigo'];
$pnombre       = $_POST['pnombre'];
$snombre       = $_POST['snombre'];
$papellido     = $_POST['papellido'];
$sapellido     = $_POST['sapellido'];
$habitacion    = $_POST['habitacion'];
$medico        = $_POST['medico'];
$otromed       = $_POST['otromed'];
$motivo        = $_POST['motivo'];
$observaciones = $_POST['observaciones'];
$alergias       = $_POST['alergias'];
$status        = $_POST['status'];

$sql = "SELECT primer_nombre_med18,segundo_nombre_med22,primer_apellido_med29,segundo_apellido_med37 FROM web_medicos WHERE status_med37='A' and colegiado_med35  > '0' and cod_med12='$medico'";
$rs  = $conexion2->query($sql);
$row = $rs->fetch_assoc();

$medicotratante = $row["primer_nombre_med18"];
if($row["segundo_nombre_med22"] > "0"){
	$medicotratante = $medicotratante." ".$row["segundo_nombre_med22"];
}
$medicotratante = $medicotratante." ".$row["primer_apellido_med29"];
if($row["segundo_apellido_med37"] > "0"){
	$medicotratante = $medicotratante." ".$row["segundo_apellido_med37"];
}

if(isset($_POST['submitadd'])){

	$_SESSION["sessadd"] = $_POST;

 	$qry = "INSERT INTO `_ordenes_medicas`(`id`, `pnombre`, `snombre`, `papellido`, `sapellido`, `habitacion`, `codigo`, `cod_medico`, `medico_tratante`, `motivo_ingreso`, `observaciones`, `alergias`, `status`, `usuario`, `fecha_ingreso`) VALUES ('0','$pnombre','$snombre','$papellido','$sapellido','$habitacion','$pcodigo','$medico','$medicotratante','$motivo','$observaciones','$alergias','$status','$nmsession','$fingreso')";
 	$result = $conexion->query($qry);
	if($result){
		unset($_SESSION["sessadd"]);
	}

}

if(isset($_POST['submitedit'])){

	$qry = "UPDATE `_ordenes_medicas` SET pnombre='$pnombre', snombre='$snombre', papellido='$papellido', sapellido='$sapellido', habitacion='$habitacion', codigo='$pcodigo', cod_medico='$medico', medico_tratante='$medicotratante', motivo_ingreso='$motivo', observaciones='$observaciones', alergias='$alergias', status='$status', usuario='$nmsession', actualizacion='$datenowfull', fecha_ingreso='$fingreso' WHERE id='$id'";
	$conexion->query($qry);

}

$conexion->close();
$conexion2->close();

header("Location: pacientes_activos.php");
exit;
?>