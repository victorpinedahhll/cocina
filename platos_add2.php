<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$page = "platosadd";

require("security.php");
require("security_adv.php");
require("_private/_access.php");
include("logged.php");
include("parametros_generales.php");

$idPac  = $_GET['idpac'];
$idMen  = $_GET['idmenu'];
$idPro  = $_GET['idprogra'];
$tipo   = $_GET['tipo'];
$van    = $_GET['van'];
$idtp   = $_GET['idtp'];
$idSol  = $_GET['sol'];
$codPac = $_GET['codpac'];
$pacval = $_REQUEST['paciente'];

$keyUn  = $_SESSION["keyun$idPac"];
if($pacval=="NO"){
	$keyUn  = $_SESSION["keyunvisit$idPac"];
}

// foreach($_GET as $key => $value){
// 	echo $key.": ".$value."<br>";
// }
// exit;

 if( isset($keyUn) ){
	
 	$sql   = "SELECT * FROM _pacientes_menu_enlace WHERE idpaciente='$idPac' and idmenu='$idMen' and idopcion='$idPro' and tipo='$tipo' and paciente='$pacval' and keyunico='$keyUn'";
 	$rs2   = $conexion->query($sql);

 	if($rs2->num_rows <= 0){
		// NOTA: la descripcion de los platos en esta tabla se agregan cuando se pasa el pedido a cocina
	 	$qry = "INSERT INTO `_pacientes_menu_enlace`(`id`, `codigo_pac`, `idpaciente`, `idmenu`, `idopcion`, `tipo`, `paciente`, `keyunico`, `usuario`, `actualizacion`) VALUES ('0','$codPac','$idPac','$idMen','$idPro','$tipo','$pacval','$keyUn','$ussession','$datenowfull')";
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