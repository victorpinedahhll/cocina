<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

header("Content-Type: text/html;charset=UTF-8");

$areaLg = "PACIENTES"; // valida roles del usuario

require("security.php");
require("security_adv.php");
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
$medico        = $_POST['medico'];
$otromed       = $_POST['otromed'];
$observaciones = $_POST['observaciones'];
$alergias       = $_POST['alergias'];
$status        = $_POST['status'];

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

	$_SESSION["sessadd"] = $_POST;

 	$qry = "INSERT INTO `_pacientes`(`id`, `pnombre`, `snombre`, `papellido`, `sapellido`, `codigo`, `cod_medico`, `medico_tratante`, `observaciones`, `alergias`, `status`, `usuario`) VALUES ('0','$pnombre','$snombre','$papellido','$sapellido','$pcodigo','$medico','$medicotratante','$observaciones','$alergias','$status','$nmsession')";
 	$result = $conexion->query($qry);
	if($result){
		unset($_SESSION["sessadd"]);
	}

	$conexion->close();
	$conexion2->close();

	header("Location: pacientes.php");
	exit;

}

if($_POST['acceso']=="editar"){

	$qry = "UPDATE `_pacientes` SET pnombre='$pnombre', snombre='$snombre', papellido='$papellido', sapellido='$sapellido', codigo='$pcodigo', cod_medico='$medico', medico_tratante='$medicotratante', observaciones='$observaciones', alergias='$alergias', status='$status', usuario='$nmsession', actualizacion='$datenowfull' WHERE id='$id'";
	$conexion->query($qry);

	$conexion->close();
	$conexion2->close();

	header("Location: pacientes.php");
	exit;

}


?>