<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
date_default_timezone_set('America/Guatemala');
$usuario  = htmlentities(addslashes($_POST["usuario"]));
$password = htmlentities(addslashes($_POST["clave"]));

$remember = $_POST["recuerdame"];

require("security.php");
require("_private/_access.php");

$qry = "SELECT * FROM _usuarios_admin WHERE usuario_us13='$usuario' and status_wua32='1'";
$rs  = $conexion->query($qry);
$row = $rs->fetch_assoc();

if(isset($_POST["submitlogin"]) && $row > 0 && password_verify($password, $row["clave_us20"])){
	session_start();

	$cookieValue = mt_rand() ."_cook_$usuario";
	setcookie("logincook",$cookieValue,time()+86400);
	$_SESSION['logincook'] = $cookieValue;

	if(!empty($remember)){
		setcookie("usuario_cook",$usuario,time()+86400);
		setcookie("recuerdame_cook",$remember,time()+86400);
	}else{
		if(isset($_COOKIE["usuario_cook"])){
			setcookie("usuario_cook","");
		}
		if(isset($_COOKIE["usuario_cook"])){
			setcookie("recuerdame_cook","");
		}
	}
	$_SESSION['loggedcook']      = $row["usuario_us13"];
	$_SESSION['clienteidcook']   = $row["id_us00"];
	$_SESSION['clientenamecook'] = $row["nombre_us07"];
	$_SESSION['nivelcook']       = $row["nivel_wua67"];

	if($row["nivel_wua67"]=="ADMIN"){
		$_SESSION['nivelcooktemp'] = "A";
		header("Location: usuarios.php");
		exit;
	}elseif($row["nivel_wua67"]=="COCINA"){
		$_SESSION['nivelcooktemp'] = "C";
		header("Location: cocina.php");
		exit;
	}elseif($row["nivel_wua67"]=="ENFERMERIA"){
		$_SESSION['nivelcooktemp'] = "E";
		header("Location: _ordenes_medicas.php");
		exit;
	}elseif($row["nivel_wua67"]=="AUXILIAR"){
		$_SESSION['nivelcooktemp'] = "U";
		header("Location: pedidos_pacientes.php");
		exit;
	}
	

}else{

	$fechac = date("Y-m-d H:i:s");
	$iphost = getenv('REMOTE_ADDR');
	$qryLog = "INSERT INTO web_intentos_login (id_lg, fecha_lg, usuario_lg, iphost_lg) VALUES ('0','$fechac','$usuario','$iphost')";
	$conexion->query($qryLog);
?>

	<body>
		<script>
			alert("El USUARIO o CLAVE no es valido, ingreselo de nuevo");document.location="index.php";
		</script>
	</body>

<?php
}
?>