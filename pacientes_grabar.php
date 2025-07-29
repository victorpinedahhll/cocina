<?php 
session_start();
// error_reporting(E_ERROR | E_WARNING | E_PARSE);
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

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

 	$qry = "INSERT INTO `_pacientes`(`id`, `pnombre`, `snombre`, `papellido`, `sapellido`, `codigo`, `cod_medico`, `medico_tratante`, `observaciones`, `status`, `usuario`) VALUES ('0','$pnombre','$snombre','$papellido','$sapellido','$pcodigo','$medico','$medicotratante','$observaciones','$status','$nmsession')";
 	$result = $conexion->query($qry);
	if($result){
		
		unset($_SESSION["sessadd"]);

		// ingreso los roles del usuario
        $rolesSeleccionados = $_POST['alergias'];

        foreach ($rolesSeleccionados as $rol) {

			$qryA = "SELECT _id FROM _alergias WHERE _id = '$rol'";
			$resA = $conexion->query($qryA);
			$rowA = $resA->fetch_assoc();
			$nalergia = $rowA["_id"];

            $qryRol = "INSERT INTO `_pacientes_alergias`(`_id`, `_paciente_cod`, `_alergia_id`, `_alergia`, `_usuario`) VALUES (?, ?, ?, ?, ?)";
            $stmt   = $pdo->prepare($qryRol);
            $stmt->execute(['0',$pcodigo,$nalergia,$rol,$ussession]);

        }
	}

	$conexion->close();
	$conexion2->close();

	header("Location: pacientes.php");
	exit;

}

if($_POST['acceso']=="editar"){

	$qry = "UPDATE `_pacientes` SET pnombre='$pnombre', snombre='$snombre', papellido='$papellido', sapellido='$sapellido', codigo='$pcodigo', cod_medico='$medico', medico_tratante='$medicotratante', observaciones='$observaciones', status='$status', usuario='$nmsession', actualizacion='$datenowfull' WHERE id='$id'";
	$conexion->query($qry);

	$qryD = "DELETE FROM `_pacientes_alergias` WHERE _paciente_cod='$pcodigo'";
	$conexion->query($qryD);

	// ingreso los roles del usuario
	$rolesSeleccionados = $_POST['alergias'];

	foreach ($rolesSeleccionados as $rol) {

		$qryA = "SELECT _id FROM _alergias WHERE _nombre = '$rol'";
		$resA = $conexion->query($qryA);
		$rowA = $resA->fetch_assoc();
		$nalergia = $rowA["_id"];

		$qryRol = "INSERT INTO `_pacientes_alergias`(`_id`, `_paciente_cod`, `_alergia_id`, `_alergia`, `_usuario`) VALUES (?, ?, ?, ?, ?)";
		$stmt   = $pdo->prepare($qryRol);
		$stmt->execute(['0',$pcodigo,$nalergia,$rol,$ussession]);

	}

	$conexion->close();
	$conexion2->close();

	header("Location: pacientes.php");
	exit;

}


?>