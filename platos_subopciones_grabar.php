<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

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

$idopc  = $_POST['idopcion'];
$idmenu = $_POST['idmenu'];
$nombre = trim($_POST['nombre']);
$descri = $_POST['descripcion'];
$status = $_POST['status'];

if (isset($_POST['submitform']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$qry = "INSERT INTO `_menus_subopciones`(`id`, `idmenu`, `idopcion`, `nombre`, `descripcion`, `status`) VALUES ('0','$idmenu','$idopc','$nombre','$descri','$status')";

}

if (isset($_POST['submitformEdit']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$id  = $_POST['id'];
	$qry = "UPDATE `_menus_subopciones` SET nombre='$nombre', descripcion='$descri', status='$status' WHERE id='$id' and idopcion='$idopc' and idmenu='$idmenu'";

}

if (isset($_POST['submitformDel']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$id  = $_POST['id'];
	$qry = "UPDATE `_menus_subopciones` SET status='E' WHERE id='$id' and idopcion='$idopc' and idmenu='$idmenu'";

}

$conexion->query($qry);

if (isset($_POST['submitform']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {
	echo "<script>document.location='platos_opciones_editar.php?id=$idopc&idm=$idmenu';</script>";
	exit;
}else{
	echo "<script>document.location='platos_opciones_editar.php?id=$idopc&idm=$idmenu';</script>";
	exit;
}
?>