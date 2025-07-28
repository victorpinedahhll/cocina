<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$areaLg = "MENUS";  // valida roles del usuario

require("security.php");
require("_private/_access.php");
require("logged.php");
include("parametros_generales.php");

$nombre = trim($_POST['nombre']);
$descri = $_POST['descripcion'];
$status = $_POST['status'];

if (isset($_POST['submitformAdd']) && isset($_SESSION['logincook'])) {

	$qry = "INSERT INTO `_menus`(`id`, `nombre`, `descripcion`, `imagen`, `status`) VALUES ('0','$nombre','$descri','0','$status')";

	$qryMI = "SELECT max(id) as maxid FROM _menus";
	$rsMI  = $conexion->query($qryMI);
	$rowMI = $rsMI->fetch_assoc();
	$maxid = $rowMI["maxid"] + 1;

	foreach($_POST as $key => $value){
		if (substr($key,0,5) == 'tmen_'){
			$qryTO = "INSERT INTO `_menu_tipo_enlace`(`id`, `idmenu`, `idtipo`) VALUES ('0','$maxid','$value')";
			$conexion->query($qryTO);
		}
	}

	foreach($_POST as $key => $value){
		if (substr($key,0,5) == 'tdie_'){
			$qryTD = "INSERT INTO `_menu_dieta_enlace`(`id`, `idmenu`, `iddieta`) VALUES ('0','$maxid','$value')";
			$conexion->query($qryTD);
		}
	}

	$conexion->close();

	header("Location: platos.php");
	exit;

}

if (isset($_POST['submitformEdit']) && isset($_SESSION['logincook'])) {

	$id  = $_POST['id'];
	$qry = "UPDATE `_menus` SET nombre='$nombre', descripcion='$descri', status='$status' WHERE id='$id'";

	$qryDel = "DELETE FROM _menu_tipo_enlace WHERE idmenu='$id'";
	$conexion->query($qryDel);

	$qryDel2 = "DELETE FROM _menu_dieta_enlace WHERE idmenu='$id'";
	$conexion->query($qryDel2);

	foreach($_POST as $key => $value){
		if (substr($key,0,5) == 'tmen_'){
			$qryTO = "INSERT INTO `_menu_tipo_enlace`(`id`, `idmenu`, `idtipo`) VALUES ('0','$id','$value')";
			$conexion->query($qryTO);
		}
	}

	foreach($_POST as $key => $value){
		if (substr($key,0,5) == 'tdie_'){
			$qryTD = "INSERT INTO `_menu_dieta_enlace`(`id`, `idmenu`, `iddieta`) VALUES ('0','$id','$value')";
			$conexion->query($qryTD);
		}
	}

	$conexion->close();

	header("Location: platos.php");
	exit;

}

if (isset($_POST['submitformDel']) && isset($_SESSION['logincook'])) {

	$id  = $_POST['id'];
	$qry = "UPDATE `_menus` SET status='E' WHERE id='$id'";

	$conexion->close();

	header("Location: platos.php");
	exit;

}


?>