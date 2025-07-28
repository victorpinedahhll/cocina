<?php
session_start();

// if(!empty($_SESSION['splitacc'])){
	
// 	if($_SESSION['splitacc']=="SI"){
// 		$_SESSION['nivelcooktemp']   = "";
// 		header("Location: dashboard.php");
// 	}

// }else{

	setcookie("logincook","");
	$_SESSION['logincook']       = "";
	$_SESSION['loggedcook']      = "";
	$_SESSION['clienteidcook']   = "";
	$_SESSION['clientenamecook'] = "";
	$_SESSION['nivelcook']       = "";
	$_SESSION['nivelcooktemp']   = "";
	// se desactivo session_destroy() pues elimina el session de pedidos pacientes
	// y ese se tiene que mantener hasta que se envie la solicitud
	// session_destroy(); 
	header("Location: index.php");

// }
?>