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
$idopc3 = $_POST['idopcion3'];
$idmenu = $_POST['idmenu'];
$nombre = trim($_POST['nombre']);
$descri = $_POST['descripcion'];
$status = $_POST['status'];

if (isset($_POST['submitform']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$qry = "INSERT INTO `_menus_subopciones3`(`id`, `idmenu`, `idopcion`, `idopcion2`, `idopcion3`, `nombre`, `descripcion`, `status`) VALUES ('0','$idmenu','$idopc','$idopc2','$id','$nombre','$descri','$status')";

}

if (isset($_POST['submitformEdit']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$qry = "UPDATE `_menus_subopciones3` SET nombre='$nombre', descripcion='$descri', status='$status' WHERE id='$id' and idmenu='$idmenu' and idopcion='$idopc' and idopcion2='$idopc2' and idopcion3='$idopc3'";

}

if (isset($_POST['submitformDel']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$qry = "UPDATE `_menus_subopciones3` SET status='E' WHERE id='$id' and idmenu='$idmenu' and idopcion='$idopc' and idopcion2='$idopc2' and idopcion3='$idopc3'";

}

$conexion->query($qry);

if (isset($_POST['submitform']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {
	echo "<script>document.location='platos_opciones3_editar.php?id=$id&idm=$idmenu&id2=$idopc&id3=$idopc2';</script>";
	exit;
}else{
	echo "<script>document.location='platos_opciones3_editar.php?id=$idopc3&idm=$idmenu&id2=$idopc&id3=$idopc2';</script>";
	exit;
}
?>