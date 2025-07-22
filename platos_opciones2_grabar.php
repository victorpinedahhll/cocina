<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$areaLg = "MENUS";  // valida roles del usuario

require("security.php");
require("_private/_access.php");
require("logged.php");
include("parametros_generales.php");

$id     = $_POST['id'];
$idmenu = $_POST['idmenu'];
$idopcion = $_POST['idopcion'];
$nombre = trim($_POST['nombre']);
$descri = $_POST['descripcion'];
$status = $_POST['status'];

if (isset($_POST['submitform']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$qry = "INSERT INTO `_menus_subopciones`(`id`, `idmenu`, `idopcion`, `nombre`, `descripcion`, `status`) VALUES ('0','$idmenu','$idopcion','$nombre','$descri','$status')";

}

if (isset($_POST['submitformEdit']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	
	$qry = "UPDATE `_menus_subopciones` SET nombre='$nombre', descripcion='$descri', status='$status' WHERE id='$id'";

}

if (isset($_POST['submitformDel']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$id  = $_POST['id'];
	$qry = "UPDATE `_menus_subopciones` SET status='E' WHERE id='$id'";

}

$conexion->query($qry);

echo "<script>document.location='platos_opciones2_editar.php?id=$id&idm=$idmenu&id2=$idopcion';</script>";
exit;

?>