<?php
$logged = "false";

if (isset($_SESSION['logincook'])){
	$logged = "true";
}

if($logged == "false"){

	setcookie("logincook","");
	if(isset($_SESSION)){
		foreach ($_SESSION as $keylog => $valuelog) {
			unset($_SESSION[$keylog]);
		}
		session_destroy();
	}
	
	header("location: index.php?iniciarSesion=SI");
	exit;

}
?>