<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$areaLg = "PROGRAMACION"; // valida roles del usuario

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

$nombre = trim($_POST['nombre']);
$inicio = "0000-00-00";
if($_POST['inicio'] > "0000-00-00"){
	$inicio = $_POST['inicio'];
}
$final = "0000-00-00";
if($_POST['final'] > "0000-00-00"){
	$final  = $_POST['final'];
}
$descri = $_POST['descripcion'];
$status = $_POST['status'];

if (isset($_POST['submitformAdd']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$qry = "INSERT INTO `_programaciones`(`id`, `nombre`, `inicio`, `final`, `descripcion`, `status`) VALUES ('0','$nombre','$inicio','$final','$descri','$status')";


}

if (isset($_POST['submitformEdit']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$id  = $_POST['id'];
	$qry = "UPDATE `_programaciones` SET nombre='$nombre', inicio='$inicio', final='$final', descripcion='$descri', status='$status' WHERE id='$id'";

}

if (isset($_POST['submitformDel']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$id  = $_POST['id'];
	$qry = "UPDATE `_programaciones` SET status='E' WHERE id='$id'";

}

$conexion->query($qry);

header("Location: programaciones.php");
?>