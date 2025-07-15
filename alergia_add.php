<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("security.php");
require("_private/_access.php");
include("parametros_generales.php");

$idPac  = $_POST['pacienteid'];
$alerg  = $_POST['alergia'];

// foreach($_POST as $key => $value){
// 	echo $key.": ".$value."<br>";
// }
// exit;

 $qry = "UPDATE _pacientes_activos SET alergias='$alerg' WHERE id='$idPac'";
 $conexion->query($qry);

echo "alergia grabada";

 ?>