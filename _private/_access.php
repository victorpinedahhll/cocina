<?php
$whost = "localhost";
$wuser = "hhllcocina22";
$wpass = "dN7zME!49@]3wF3Q";
$wdb   = "hhllcocina";

$conexion = mysqli_connect($whost,$wuser,$wpass,$wdb);
if(mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}
$conexion->set_charset('utf8');

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