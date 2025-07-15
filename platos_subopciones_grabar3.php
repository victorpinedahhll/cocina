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
$idopc2 = $_POST['idopcion2'];
$idmenu = $_POST['idmenu'];
$nombre = trim($_POST['nombre']);
$descri = $_POST['descripcion'];
$status = $_POST['status'];

if (isset($_POST['submitform']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$qry = "INSERT INTO `_menus_subopciones2`(`id`, `idmenu`, `idopcion`, `idopcion2`, `nombre`, `descripcion`, `status`) VALUES ('0','$idmenu','$idopc','$idopc2','$nombre','$descri','$status')";

}

if (isset($_POST['submitformEdit']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$qry = "UPDATE `_menus_subopciones` SET nombre='$nombre', descripcion='$descri', status='$status' WHERE id='$idopc2' and idmenu='$idmenu' and idopcion='$idopc'";

}

if (isset($_POST['submitformDel']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$qry = "UPDATE `_menus_subopciones` SET status='E' WHERE id='$idopc2' and idmenu='$idmenu' and idopcion='$idopc'";

	$qry2 = "UPDATE `_menus_subopciones2` SET status='E' WHERE idmenu='$idmenu' and idopcion='$idopc' and idopcion2='$idopc2'";
	$conexion->query($qry2);

	$qry3 = "UPDATE `_menus_subopciones3` SET status='E' WHERE idmenu='$idmenu' and idopcion='$idopc' and idopcion2='$idopc2'";
	$conexion->query($qry3);

	$qry4 = "UPDATE `_menus_subopciones4` SET status='E' WHERE idmenu='$idmenu' and idopcion='$idopc' and idopcion2='$idopc2'";
	$conexion->query($qry4);

}
//echo $qry;
//exit;
$conexion->query($qry);

echo "<script>document.location='platos_editar.php?id=$idmenu';</script>";
exit;

?>