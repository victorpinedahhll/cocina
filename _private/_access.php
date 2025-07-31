<?php
$whost = "localhost";
$wuser = "hhllcocina22";
$wpass = "MwDG6K-5QgqFMz_7";
$wdb   = "hhllcocina";

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
?>