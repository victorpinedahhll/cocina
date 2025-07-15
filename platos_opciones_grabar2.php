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

$id     = $_POST['id'];
$idmenu = $_POST['idmenu'];
$nombre = trim($_POST['nombre']);
$descri = $_POST['descripcion'];
$status = $_POST['status'];

if (isset($_POST['submitform']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$qry = "INSERT INTO `_menus_opciones`(`id`, `idmenu`, `nombre`, `descripcion`, `status`) VALUES ('0','$idmenu','$nombre','$descri','$status')";

}

if (isset($_POST['submitformEdit']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {
	
	$qry = "UPDATE `_menus_opciones` SET nombre='$nombre', descripcion='$descri', status='$status' WHERE id='$id'";

}

if (isset($_POST['submitformDel']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$id  = $_POST['id'];
	$qry = "UPDATE `_menus_opciones` SET status='E' WHERE id='$id'";

	$qry1 = "UPDATE `_menus_subopciones` SET status='E' WHERE idopcion='$id' and idmenu='$idmenu'";
	$conexion->query($qry1);

	$qry2 = "UPDATE `_menus_subopciones2` SET status='E' WHERE idopcion='$id' and idmenu='$idmenu'";
	$conexion->query($qry2);

	$qry3 = "UPDATE `_menus_subopciones3` SET status='E' WHERE idopcion='$id' and idmenu='$idmenu'";
	$conexion->query($qry3);

	$qry4 = "UPDATE `_menus_subopciones4` SET status='E' WHERE idopcion='$id' and idmenu='$idmenu'";
	$conexion->query($qry4);

}

$conexion->query($qry);

echo "<body><script>document.location='platos_editar.php?id=$idmenu';</script></body>";
exit;
?>