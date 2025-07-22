<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("security.php");
require("_private/_access.php");
// include("logged.php");
include("parametros_generales.php");

// creo una sesion para identificar que el usuario tiene acceso a los dos modulos
$_SESSION['splitacc'] = "SI";

// modifico la sesion NIVEL segun el ingreso seleccionado
if($_POST['submitsolicitud']){
	$_SESSION['nivelcooktemp'] = "S";
}elseif($_POST['submitcocina']){
	$_SESSION['nivelcooktemp'] = "C";
}elseif($_POST['submitadmin'] || $_POST['submitusuarios']){
	$_SESSION['nivelcooktemp'] = "A";
}

if($_POST['submitclose']){
	$_SESSION['splitacc'] = "";
	$_SESSION['nivelcooktemp'] = "";
	header("Location: logout.php");
}else{
	if($_POST['submitsolicitud']){
		header("Location: pacientes.php");
	}elseif($_POST['submitcocina']){
		header("Location: cocina.php");
	}elseif($_POST['submitadmin']){
		header("Location: platos.php");
	}elseif($_POST['submitusuarios']){
		header("Location: usuarios.php");
	}
}

?>