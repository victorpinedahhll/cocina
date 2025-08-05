<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$areaLg = "TOMA_PEDIDOS";  // valida roles del usuario

require("security.php");
require("_private/_access.php");
require("logged.php");
include("parametros_generales.php");

if ($_POST['auxiliar'] <= 0){
	echo "<script>alert('Es obligatorio elegir un Auxiliar de Nutrición.');history.back();</script>";
    exit;
}

if ( $_POST["asignar"]=="SI" ) {

	$auxiliar = $_POST['auxiliar'];
    $id       = $_POST['id'];
	$paciente = $_POST['paciente'];

	$qry = "UPDATE _ordenes_medicas SET auxiliar_nutricion='$auxiliar' WHERE id='$id'";
	$conexion->query($qry);
	$conexion->close();
	// header ("Location: pedidos_formulario.php?id=$id&paciente=$paciente");
	header ("Location: pedidos_pacientes.php");
	exit;

}
?>