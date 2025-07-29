<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$areaLg = "TOMA_PEDIDOS";  // valida roles del usuario

require("security.php");
require("_private/_access.php");
require("logged.php");
include("parametros_generales.php");

if ( $_POST["id"] > 0 ) {

    $id    = $_POST['id'];
    $idPed = $_POST['idPed'];
	$qry = "UPDATE _pacientes_solicitudes SET status='2' WHERE id='$id'";
	$conexion->query($qry);

    $conexion->close();

	header ("Location: pedidos_historial.php?id=$idPed");
    exit;

}
?>