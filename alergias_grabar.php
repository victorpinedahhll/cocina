<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$areaLg = "ALERGIAS"; // valida roles del usuario

require("security.php");
require("_private/_access.php");
require("logged.php");
include("parametros_generales.php");

$nombre = $_POST['nombre'];
$status = $_POST['status'];

if (isset($_POST['submitformAdd']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$qry = "INSERT INTO `_alergias`(`_id`, `_nombre`, `_status`) VALUES ('0','$nombre','$status')";

}

if (isset($_POST['submitformEdit']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$id  = $_POST['id'];
	$qry = "UPDATE `_alergias` SET _nombre='$nombre', _status='$status' WHERE _id='$id'";

}

if (isset($_POST['submitformDel']) && isset($_SESSION['logincook']) && $nvsessiontemp=="A") {

	$id  = $_POST['id'];
	$qry = "UPDATE `_alergias` SET _status='E' WHERE _id='$id'";

}

$conexion->query($qry);

header("Location: alergias.php");
?>