<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$areaLg = "MENUS";  // valida roles del usuario

require("security.php");
require("_private/_access.php");
require("logged.php");
include("parametros_generales.php");

if($nvsessiontemp!="A"){
	echo "<body>";
	echo "<script>alert('Acceso Denegado o a expirado su sesion');document.location='logout.php';</script>";
	echo "</body>";
	exit;
}

$id     = $_POST['id'];
$idopc  = $_POST['idopcion'];
$idopc2 = $_POST['idopcion2'];
$idmenu = $_POST['idmenu'];
$nombre = trim($_POST['nombre']);
$descri = $_POST['descripcion'];
$status = $_POST['status'];

if (isset($_POST['submitform']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$qry = "INSERT INTO `_menus_subopciones2`(`id`, `idmenu`, `idopcion`, `idopcion2`, `nombre`, `descripcion`, `status`) VALUES ('0','$idmenu','$idopc','$id','$nombre','$descri','$status')";

}

if (isset($_POST['submitformEdit']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$qry = "UPDATE `_menus_subopciones2` SET nombre='$nombre', descripcion='$descri', status='$status' WHERE id='$id' and idopcion='$idopc' and idmenu='$idmenu'";

}

if (isset($_POST['submitformDel']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$qry = "UPDATE `_menus_subopciones2` SET status='E' WHERE id='$id' and idopcion='$idopc2' and idmenu='$idmenu'";

}

$conexion->query($qry);

if (isset($_POST['submitform']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {
	echo "<script>document.location='platos_opciones2_editar.php?id=$id&idm=$idmenu&id2=$idopc';</script>";
	exit;
}else{
	if (isset($_POST['submitformEdit'])) {
		echo "<script>document.location='platos_opciones3_editar.php?id=$id&idm=$idmenu&id2=$idopc&id3=$idopc2';</script>";
	}else{
		echo "<script>document.location='platos_opciones2_editar.php?id=$idopc&idm=$idmenu&id2=$idopc2';</script>";
	}
	exit;
}
?>