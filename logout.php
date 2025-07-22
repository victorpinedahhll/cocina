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
	session_destroy();
	header("Location: index.php");

// }
?>