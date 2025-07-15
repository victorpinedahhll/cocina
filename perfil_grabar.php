<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("security.php");
require("_private/_access.php");
require("logged.php");
include("parametros_generales.php");

if (isset($_POST['submitform']) && isset($_SESSION['logincook'])) {

	$nombre = $_POST['nombre'];
	$email  = $_POST["email"];
	$clave1 = htmlentities(addslashes($_POST["clave1"]));
	$clave2 = htmlentities(addslashes($_POST["clave2"]));

	if(!empty($clave1)){
		if(strlen($clave1) >= 6){
			if($clave1==$clave2){
				$contrasena = password_hash($clave1, PASSWORD_DEFAULT);
				$veriok     = "SI";
			}else{
				echo "<script>alert('Las contraseñas no coinciden, intentelo de nuevo');history.back();</script>";
				exit;
			}
		}else{
			echo "<script>alert('La contraseña tiene que tener un mínimo de 6 caracteres, intentelo de nuevo');history.back();</script>";
			exit;
		}
	}

	if($veriok=="SI"){
		$qry = "UPDATE _usuarios_admin SET nombre_us07='$nombre', clave_us20='$contrasena', email_wua25='$email' WHERE id_us00='$idsession' and usuario_us13='$ussession'";
	}else{
		$qry = "UPDATE _usuarios_admin SET nombre_us07='$nombre', email_wua25='$email' WHERE id_us00='$idsession' and usuario_us13='$ussession'";
	}
	$conexion->query($qry);

	header ("Location: perfil_editar.php?ch=SI");

}
?>