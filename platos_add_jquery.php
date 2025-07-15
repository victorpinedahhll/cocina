<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// foreach($_POST as $key => $value){
// 	echo $key.": ".$value."<br>";
// }
// exit;

 if( (isset($_POST['id']) && isset($_SESSION['keyun'])) || $_GET['sol']>"0" ){

 	require("security.php");
	require("_private/_access.php");
	include("parametros_generales.php");

	$idPr  = $_POST['id'];
	$idSes = $_SESSION['keyun'];
	if($_GET['sol'] > "0"){
		$idSes = "solicitud".$_GET['sol'];
	}
	$idpaciente = $_POST['pacienteid'];
	$idprogra = $_POST['idprogra'];

	$tipo = "opc";
	if($_POST['tipo']=="sub"){
		$tipo = "sub";
	}elseif($_POST['tipo']=="sub2"){
		$tipo = "sub2";
	}

 	$sql   = "SELECT idopcionmenu FROM _pacientes_menu_enlace WHERE idopcionmenu='$idPr' and keyunico='$idSes' and idprogra='$idprogra'";
 	$rs2   = $conexion->query($sql);

 	if($rs2->num_rows <= 0){

	 	$keyPr = $_POST['key'];
	 	$qry = "INSERT INTO `_pacientes_menu_enlace`(`id`, `idpaciente`, `idopcionmenu`, `idprogra`, `tipo`, `keyunico`, `usuario`, `actualizacion`) VALUES ('0','$idpaciente','$idPr','$idprogra','$tipo','$keyPr','$ussession','$datenowfull')";
	 	$conexion->query($qry);

	 	echo "se inserto el dato en el enlace";

	 }else{

	 	echo "La prueba ya existe";

	 }

 }
 ?>