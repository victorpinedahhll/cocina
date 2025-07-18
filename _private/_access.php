<?php
$whost = "localhost";
$wuser = "sandbcocina";
$wpass = ")eGL9EdN3_bzxL[S";
$wdb   = "sandboxcocina";

$conexion = mysqli_connect($whost,$wuser,$wpass,$wdb);
if(mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}
$conexion->set_charset('utf8');

// conexion PDO
try {
    $pdo = new PDO("mysql:host=$whost;dbname=$wdb", $wuser, $wpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Error DB: " . $e->getMessage());
    die("Lo sentimos, hubo un problema de conexión.");
}

$wuser2 = "hhllreservaciones";
$wpass2 = "PkV2!hrRP8dF6MPw";
$wdb2   = "hhllreservaciones";

$conexion2 = mysqli_connect($whost,$wuser2,$wpass2,$wdb2);
if(mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}
$conexion2->set_charset('utf8');
?>