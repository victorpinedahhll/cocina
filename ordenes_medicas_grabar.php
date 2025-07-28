<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

header("Content-Type: text/html;charset=UTF-8");

$areaLg = "ORDENES"; // valida roles del usuario

require("security.php");
require("_private/_access.php");
include("logged.php");
include("parametros_generales.php");

$pcodigo       = $_POST['pcodigo'];
$pnombre       = $_POST['pnombre'];
$snombre       = $_POST['snombre'];
$dieta         = $_POST["dieta"];
$papellido     = $_POST['papellido'];
$sapellido     = $_POST['sapellido'];
$habitacion    = $_POST['habitacion'];
$medico        = $_POST['medico'];
$otromed       = $_POST['otromed'];
$motivo        = $_POST['motivo'];
$observaciones = $_POST['observaciones'];

$medicotratante = 0;

if($medico > 0 && $medico != "999999"){

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

}elseif($medico=="999999" && !empty($otromed)){

	$medicotratante = $otromed;

}

if($_POST['acceso']=="agregar"){

	$_SESSION["sessordenadd"] = $_POST;

	// ingreso a tabla pacientes si no existe
	$qryVal = "SELECT codigo FROM _pacientes WHERE codigo = '$pcodigo'";
	$resVal = $conexion->query($qryVal);
	if($resVal->numb_rows <= 0){
		$qryPac = "INSERT INTO `_pacientes`(`id`, `pnombre`, `snombre`, `papellido`, `sapellido`, `codigo`, `cod_medico`, `medico_tratante`, `observaciones`, `status`, `usuario`, `fecha_ingreso`) VALUES ('0','$pnombre','$snombre','$papellido','$sapellido','$pcodigo','$medico','$medicotratante','$observaciones','A','$nmsession','$datenow')";
		$conexion->query($qryPac);
	}

 	$qry    = "INSERT INTO `_ordenes_medicas`(`id`, `pnombre`, `snombre`, `papellido`, `sapellido`, `dieta`, `habitacion`, `codigo`, `cod_medico`, `medico_tratante`, `motivo_ingreso`, `observaciones`, `status`, `usuario`) VALUES ('0','$pnombre','$snombre','$papellido','$sapellido','$dieta','$habitacion','$pcodigo','$medico','$medicotratante','$motivo','$observaciones','A','$nmsession')";
 	$result = $conexion->query($qry);
	if($result){
		unset($_SESSION["sessordenadd"]);
	}

	$conexion->close();
	$conexion2->close();

	header("Location: ordenes_medicas.php");
	exit;

}

if($_POST['acceso']=="editar"){

	$id            = $_POST['id'];
	$idpaciente    = $_POST['idpaciente'];
	$status        = $_POST['status'];

	$qry = "UPDATE `_ordenes_medicas` SET pnombre='$pnombre', snombre='$snombre', papellido='$papellido', sapellido='$sapellido', dieta='$dieta', habitacion='$habitacion', codigo='$pcodigo', cod_medico='$medico', medico_tratante='$medicotratante', motivo_ingreso='$motivo', observaciones='$observaciones', status='$status', usuario='$nmsession' WHERE id='$id'";
	$conexion->query($qry);

	$conexion->close();
	$conexion2->close();

	header("Location: ordenes_medicas.php");
	exit;

}
?>