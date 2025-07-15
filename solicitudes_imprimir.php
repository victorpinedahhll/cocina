<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
header("Content-Type: text/html;charset=UTF-8");

require("security.php");
require("_private/_access.php");
include("parametros_generales.php");

$idSol  = $_GET["sol"];
$qryPac = "SELECT * FROM _pacientes_solicitudes WHERE id='$idSol'";
$rsPac  = $conexion->query($qryPac);
$rowPac = $rsPac->fetch_assoc();

$fechain       = $rowPac["fecha_ingreso"];
$pnombre       = $rowPac["pnombre"];
$snombre       = $rowPac["snombre"];
$papellido     = $rowPac["papellido"];
$sapellido     = $rowPac["sapellido"];
$habitacion    = $rowPac["habitacion"];
$observaciones = $rowPac["observaciones"];
$mediconombre  = $rowPac["medico_nombre"];
$codigo        = $rowPac["codigo"];
$key           = "solicitud".$idSol;

$pruebasList   = "";
$qryList = "
SELECT *
, (select nombre from _menus_opciones o where o.id=p.idopcion) as nmopt
, (select nombre from _menus m where m.id in (select idmenu from _menus_opciones o where o.idmenu=m.id and p.idopcion=o.id)) as nmmenu

FROM _pacientes_menu_enlace p 
WHERE keyunico='$key'";

$rsList  = $conexion->query($qryList);
while ($rowList = $rsList->fetch_assoc()){
	$pruebasList.= $rowList["nprogra"]." ".$rowList["nmmenu"]." (".$rowList["nmopt"].")<br>";
}

$fecHora = strtotime($datenowfull);
$diaEnv  = date("d",$fecHora);
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

$dateEmail = $diaEnv." / ".$mesElej." / ".$anoEnv;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Solicitud Imprimir</title>
	<!--Bootsrap 4 CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Quicksand:wght@300;400;500;600;700&family=Sansita+Swashed:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
    	label {
    		font-weight: bold;
    	}
    </style>
</head>
<body>
	<div class="pt-3" style="padding: 25px; max-width: 700px; margin: 0 auto;">
		<div class="row mb-4">
			<div class="col pt-2">
				<img src="images/logo-trans.png" height="45">
			</div>
			<div class="col pt-3 text-right">
				<h4 class="p-0 m-0">Solicitud Cocina #<?php echo $idSol; ?></h4>
			</div>
		</div>
		
		<div class="form-row">
			<div class="form-group col">
				<label>Fecha</label>
				<input type="text" class="form-control" value="<?php echo $dateEmail ?>">
			</div>
			<div class="form-group col">
				<label>Código paciente</label>
				<input type="text" class="form-control" value="<?php echo $codigo; ?>">
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col">
				<label>Nombre paciente</label>
				<input type="text" class="form-control" value="<?php echo $pnombre." ".$snombre." ".$papellido." ".$sapellido; ?>">
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col">
				<label>Habitación</label>
				<input type="text" class="form-control" value="<?php echo $habitacion ?>">
			</div>
			<div class="form-group col">
				<label>Médico Tratante</label>
				<input type="text" class="form-control" value="<?php echo $mediconombre; ?>">
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col">
				<label>Menú elegido</label>
				<p style="padding: 10px; border: 1px solid #d4d3d3; border-radius: 4px;"><?php echo $pruebasList; ?></p>
			</div>
		</div>
	</div>
</body>
</html>