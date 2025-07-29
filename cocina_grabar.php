<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
header("Content-Type: text/html;charset=UTF-8");

$areaLg = "PEDIDOS";  // valida roles del usuario

require("security.php");
require("security_adv.php");
require("_private/_access.php");
require("logged.php");
include("parametros_generales.php");

$id            = $_POST['id'];
$observaciones = $_POST['observaciones'];

$qryPac = "SELECT * FROM _pacientes_solicitudes WHERE id='$id'";
$rsPac  = $conexion->query($qryPac);
$rowPac = $rsPac->fetch_assoc();

// datos que se iran en correo
$fechain      = $rowPac["fecha_ingreso"];
$pnombre      = $rowPac["pnombre"];
$snombre      = $rowPac["snombre"];
$papellido    = $rowPac["papellido"];
$sapellido    = $rowPac["sapellido"];
$habitacion   = $rowPac["habitacion"];
$medico       = $rowPac["medico_tratante"];
$mediconombre = $rowPac["medico_nombre"];
$medicootro   = $rowPac["medico_otro"];
$status       = $rowPac["status"];
$codigo       = $rowPac["codigo"];
$motivo       = $rowPac["motivo_ingreso"];

$nameM  = "";
$nameO  = "";

// Obtengo datos del medico tratante
if($medico > "0" && $medico!="999999"){
    // Obtengo datos del medico tratante
    $qryM   = "SELECT * FROM web_medicos WHERE cod_med12='$medico'";
    $rsM    = $conexion2->query($qryM);
    $rowM   = $rsM->fetch_assoc();
    $nameM  = $rowM["primer_nombre_med18"]." ".$rowM["primer_apellido_med29"];

// otro medico
}elseif(!empty($otromed)){
    $nameO  = $otromed;
}

$fecHora = strtotime($datenowfull);
$anoEnv  = date("Y",$fecHora);
$mesEnv  = date("m",$fecHora);
if($mesEnv=="1"){ $mesElej = "ene"; }
if($mesEnv=="2"){ $mesElej = "feb"; }
if($mesEnv=="3"){ $mesElej = "mar"; }
if($mesEnv=="4"){ $mesElej = "abr"; }
if($mesEnv=="5"){ $mesElej = "may"; }
if($mesEnv=="6"){ $mesElej = "jun"; }
if($mesEnv=="7"){ $mesElej = "jul"; }
if($mesEnv=="8"){ $mesElej = "ago"; }
if($mesEnv=="9"){ $mesElej = "sep"; }
if($mesEnv=="10"){ $mesElej = "oct"; }
if($mesEnv=="11"){ $mesElej = "nov"; }
if($mesEnv=="12"){ $mesElej = "dic"; }
$diaEnv  = date("d",$fecHora);
$horEnv  = date("H",$fecHora);
$minEnv  = date("i",$fecHora);

$dateEmail = $diaEnv." de ".$mesElej." ".$anoEnv." ".$horEnv.":".$minEnv." hrs";

if(isset($_POST['submitfinal'])){

    // actualizo la solicitud a terminada por cocina
 	$sql = "UPDATE _pacientes_solicitudes SET observaciones_cocina='$observaciones', status='1' WHERE id='$id'";
 	$conexion->query($sql);

 	// asunto del finalizada
 	$asunto     = "Solicitud de cocina finalizada";

 }elseif(isset($_POST['submitcancelar'])){

    // actualizo la solicitud de cancelada por cocina
 	$sql = "UPDATE _pacientes_solicitudes SET observaciones_cocina='$observaciones', status='C' WHERE id='$id'";
 	$conexion->query($sql);

 	// asunto del finalizada
 	$asunto     = "Solicitud de cocina cancelada";

 }

// envio correo

// BODY CORREO A HOSPITAL
$contenidoMail = "<div style='border: 1px solid #C0C0C0; padding: 25px; max-width: 600px; background: #1a3a6c; border-top: 7px solid #8ec83e; border-bottom: 7px solid #8ec83e;'>\n";
$contenidoMail.= "<div style='padding: 0px; margin-bottom: 20px; text-align: center;'>\n";
$contenidoMail.="<img src='https://web.herrerallerandi.com/solicitudeslab/images/logo-herrerallerandi.png' height='60'>\n";
$contenidoMail.= "</div>\n";
$contenidoMail.= "<div style='padding: 25px; background: #fff; border: 1px solid #eee; text-align: center; font-size: 12pt;'>\n";
$contenidoMail.="<h2 style='margin: 0 0 12px 0; color: #002d59;'><b>$asunto</b></h2><br>\n";
$contenidoMail.="<table border='0' width='100%' cellpadding='5'>\n";
$contenidoMail.="<tr><td style='text-align: right;'><b style='color: #002d59;'>Solicitud No.</b>:</td><td style='color: #002d59; text-align: left;'>$id</td></tr>\n";
$contenidoMail.="<tr><td style='text-align: right;'><b style='color: #002d59;'>Fecha</b>:</td><td style='color: #002d59; text-align: left;'>$dateEmail</td></tr>\n";
$contenidoMail.="<tr><td style='text-align: right;'><b style='color: #002d59;'>Nombre paciente</b>:</td><td style='color: #002d59; text-align: left;'>$pnombre $snombre $papellido $sapellido</td></tr>\n";
$contenidoMail.="<tr><td style='text-align: right;'><b style='color: #002d59;'>Código paciente</b>:</td><td style='color: #002d59; text-align: left;'>$codigo</td></tr>\n";
if(!empty($nameM)){
    $contenidoMail.="<tr><td style='text-align: right;' valign='top'><b style='color: #002d59;'><nobr>Médico tratante</nobr></b>:</td><td style='color: #002d59; text-align: left;' valign='top'>Dr. $nameM</td></tr>\n";
}elseif(!empty($nameO)){
    $contenidoMail.="<tr><td style='text-align: right;' valign='top'><b style='color: #002d59;'><nobr>Médico tratante</nobr></b>:</td><td style='color: #002d59; text-align: left;' valign='top'>Dr. $nameO</td></tr>\n";
}
$contenidoMail.="</table>\n";
$contenidoMail.="</div>\n";
$contenidoMail.="<div style='padding: 20px; text-align: center; color: #fff; font-size: 10pt;'>\n";
$contenidoMail.="<a href='https://www.herrerallerandi.com' style='color: #fff; text-decoration: none; font-size: 16pt; font-weight: bold;'>www.herrerallerandi.com</a></div>\n";
$contenidoMail.="</div>\n";

header ("Location: cocina.php");
exit;
 ?>