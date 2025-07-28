<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$areaLg = "MENUS";  // valida roles del usuario

require("security.php");
require("security_adv.php");
require("_private/_access.php");
include("logged.php");
include("parametros_generales.php");

$idPac  = $_GET['idpac'];
$idMen  = $_GET['idmenu'];
$keyUn  = $_SESSION['keyun'];
$idPro  = $_GET['idprogra'];
$tipo   = $_GET['tipo'];
$van    = $_GET['van'];
$idtp   = $_GET['idtp'];
$idSol  = $_GET['sol'];
$pacval = $_REQUEST['paciente'];

// foreach($_GET as $key => $value){
// 	echo $key.": ".$value."<br>";
// }
// exit;

 if( isset($_SESSION['keyun']) ){
	
 	$sql   = "SELECT * FROM _pacientes_menu_enlace WHERE idpaciente='$idPac' and idmenu='$idMen' and idopcion='$idPro' and tipo='$tipo' and paciente='$pacval' and keyunico='$keyUn'";
 	$rs2   = $conexion->query($sql);

 	if($rs2->num_rows <= 0){
	 	$qry = "INSERT INTO `_pacientes_menu_enlace`(`id`, `idpaciente`, `idmenu`, `idopcion`, `tipo`, `paciente`, `keyunico`, `usuario`, `actualizacion`) VALUES ('0','$idPac','$idMen','$idPro','$tipo','$pacval','$keyUn','$ussession','$datenowfull')";
	 	$conexion->query($qry);

	 	echo "se inserto el dato en el enlace";

	 }
	 
 }

if($idSol > "0"){
	header("Location: pedidos_formulario_editar.php?sol=$idSol&id=$idPac&idtp=$idtp&opt1=SI&paciente=$pacval&van=$van");
	exit;
}else{
	header("Location: pedidos_formulario.php?id=$idPac&idtp=$idtp&opt1=SI&paciente=$pacval&van=$van");
	exit;
}


 ?>