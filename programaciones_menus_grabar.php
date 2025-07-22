<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$areaLg = "PROGRAMACION"; // valida roles del usuario

require("security.php");
require("_private/_access.php");
require("logged.php");
include("parametros_generales.php");

$idprogra = $_POST['idprogra'];
$idmenu   = $_POST['menus'];

if (isset($_POST['submitform']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$qry = "INSERT INTO `_menus_progra_enlace`(`id`, `idprogra`, `idmenu`) VALUES ('0','$idprogra','$idmenu')";

	foreach($_POST as $key => $value){
		if (substr($key,0,5) == 'prmg_'){
			$qryTO = "INSERT INTO `_menus_progra_enlace`(`id`, `idprogra`, `idmenu`) VALUES ('0','$idprogra','$value')";
			$conexion->query($qryTO);
		}
	}


}

if (isset($_POST['submitformEdit']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$id  = $_POST['id'];
	$qry = "UPDATE `_menus_progra_enlace` SET idmenu='$idmenu', idprogra='$idprogra' WHERE id='$id'";

}

if (isset($_POST['submitformDel']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$id  = $_POST['id'];
	$qry = "DELETE FROM `_menus_progra_enlace` WHERE id='$id'";

}

$conexion->query($qry);

header("Location: programaciones_editar.php?id=$idprogra");
?>