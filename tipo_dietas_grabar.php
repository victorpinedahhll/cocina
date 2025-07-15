<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("security.php");
require("_private/_access.php");
require("logged.php");
include("parametros_generales.php");

$nombre = $_POST['nombre'];
$descri = $_POST['descripcion'];
$status = $_POST['status'];

if($nvsessiontemp!="A"){
	echo "<body>";
	echo "<script>alert('Acceso Denegado o a expirado su sesion');document.location='logout.php';</script>";
	echo "</body>";
	exit;
}

if (isset($_POST['submitformAdd']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$qry = "INSERT INTO `_tipo_dieta`(`id`, `nombre`, `descripcion`, `status`) VALUES ('0','$nombre','$descri','$status')";

}

if (isset($_POST['submitformEdit']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$id  = $_POST['id'];
	$qry = "UPDATE `_tipo_dieta` SET nombre='$nombre', descripcion='$descri', status='$status' WHERE id='$id'";

}

if (isset($_POST['submitformDel']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$id  = $_POST['id'];
	$qry = "UPDATE `_tipo_dieta` SET status='E' WHERE id='$id'";

}

$conexion->query($qry);

header("Location: tipo_dietas.php");
?>