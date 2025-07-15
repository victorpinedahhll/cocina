<?php
$titulo = "Solicitudes Cocina";
$nologg = "SI";
$page   = "solicitud";

include("header.php");

if($nvsessiontemp!="S"){
	echo "<body>";
	echo "<script>alert('Acceso Denegado o a expirado su sesion');document.location='logout.php';</script>";
	echo "</body>";
	exit;
}

$idSol  = $_GET["sol"];
$qryPac = "SELECT * FROM _pacientes_solicitudes WHERE id='$idSol'";
$rsPac  = $conexion->query($qryPac);
$rowPac = $rsPac->fetch_assoc();

$fechain = $rowPac["fecha_ingreso"];
$pnombre = $rowPac["pnombre"];
$snombre = $rowPac["snombre"];
$papellido = $rowPac["papellido"];
$sapellido = $rowPac["sapellido"];
$habitacion = $rowPac["habitacion"];
$pcodigo    = $rowPac["codigo"];
$medico     = $rowPac["medico_tratante"];
$mediconombre  = $rowPac["medico_nombre"];
$medicootro  = $rowPac["medico_otro"];
$observaciones = $rowPac["observaciones"];
$motivo      = $rowPac["motivo"];
$status  = $rowPac["status"];
$keyForm = "solicitud".$rowPac["id"];
$idPaciente = $rowPac["id_paciente"];

$fecHora = strtotime($fechain);
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
<style>
	body {
	  background: #f4f6f9 url('images/bg-cocina.jpg') no-repeat top center fixed; background-size: cover;
	  }
	.logout {
        position: fixed;
    }
	.content-text {
		margin: 160px 21px 0 21px;
	}
	header {
		height: 160px;
	}
</style>

<div class="row pt-0 mb-4">
	<div class="col-md-12 content-box position-relative">
		<header>
		<div class="row">
			<div class="col-md-3 pt-2">
				<img src="images/logo-trans.png" height="60">
			</div>
			<div class="col-md-2 pt-4 esconder-tablet text-center">
				<h1 class="pb-0 mb-0" style="font-size: 16pt !important;"></h1>
			</div>
			<div class="col-md-7 pt-5 text-right" style="padding-top: 33px;">
				<a href="#" class="btn">&nbsp;</a>
			</div>
		</div>
		
		<div class="row mb-5">
			<div class="col-md-12">
				<div class="esconder-movil">
					<div class="mb-3 h4-sidebar-nobg text-center" style="height: 43px; font-size: 16pt; padding-top: 2px; background: #17a2b8; text-shadow: 0px 1px 1px #1d527d;">
						<?php echo $titulo;?>
					</div>
				</div>
			</div>
		</div>

		<style>
			.colores {
				margin: -12px 0 12px 0;
				font-size: 10pt;
			}
			.colores i {
				border:  1px solid #808080;
			}
		</style>
		
		</header>

		<div style="width: 90%; margin: 175px auto 50px auto;">
			<?php if($status=="0"){ ?>
			<form id="form-prueba" action="pacientes_formulario_grabar.php" method="POST" autocomplete="off">
			<input type="hidden" name="key" id="key" value="<?php echo $keyForm; ?>">
			<input type="hidden" name="idsol" id="idsol" value="<?php echo $idSol; ?>">
			<input type="hidden" name="paciente" id="idpaciente" value="<?php echo $idPaciente; ?>">
			<?php }else{ ?>
			<form>
			<?php } ?>
			<?php if($status=="2"){ ?>
			<div class="row mb-3">
				<div class="col bg-success text-light text-center" style="border-radius: 7px; font-size: 20pt; padding-top: 5px; padding-bottom: 5px;">
					<b>Solicitud Finalizada</b>
				</div>
			</div>
			<?php } ?>
			<div class="row">
				<div class="col-md-4">
					<div class="box-admin-opt">
						<h5 class="pt-0 mt-0">Datos del paciente</h5>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label>Fecha Ingreso</label>
								<input type="text" name="pnombre" id="pnombre" class="form-control" required="required" value="<?php echo $dateEmail; ?>" disabled>
							</div>
							<div class="form-group col-md-6">
								<label>Código</label>
								<input type="text" class="form-control" value="<?php echo $pcodigo; ?>" disabled>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label>Primer Nombre *</label>
								<input type="text" name="pnombre" id="pnombre" class="form-control" required="required" value="<?php echo $pnombre; ?>" disabled>
							</div>
							<div class="form-group col-md-6">
								<label>Segundo Nombre</label>
								<input type="text" name="snombre" id="snombre" class="form-control" value="<?php echo $snombre; ?>" disabled>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label>Primer Apellido *</label>
								<input type="text" name="papellido" id="papellido" class="form-control" required="required" value="<?php echo $papellido; ?>" disabled>
							</div>
							<div class="form-group col-md-6">
								<label>Segundo Apellido</label>
								<input type="text" name="sapellido" id="sapellido" class="form-control" value="<?php echo $sapellido; ?>" disabled>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-12">
								<label>Habitacion/Cama *</label>
								<select name="habitacion" class="form-control" disabled>
									<option value="0">Elija una</option>
									<option value="PEDIATRIA-1 CAMA 1" <?php if($habitacion=="PEDIATRIA-1 CAMA 1"){ echo "selected"; } ?>>PEDIATRIA-1 &nbsp;&nbsp;(cama 1)</option>
									<option value="PEDIATRIA-2 CAMA 1" <?php if($habitacion=="PEDIATRIA-2 CAMA 1"){ echo "selected"; } ?>>PEDIATRIA-2 &nbsp;&nbsp;(cama 1)</option>
									<option value="PEDIATRIA-3 CAMA 1" <?php if($habitacion=="PEDIATRIA-3 CAMA 1"){ echo "selected"; } ?>>PEDIATRIA-3 &nbsp;&nbsp;(cama 1)</option>
									<option value="PEDIATRIA-4 CAMA 1" <?php if($habitacion=="PEDIATRIA-4 CAMA 1"){ echo "selected"; } ?>>PEDIATRIA-4 &nbsp;&nbsp;(cama 1)</option>
									<option value="PEDIATRIA-4 CAMA 2" <?php if($habitacion=="PEDIATRIA-4 CAMA "){ echo "selected"; } ?>>PEDIATRIA-4 &nbsp;&nbsp;(cama 2)</option>
									<option value="PEDIATRIA-5 CAMA 1" <?php if($habitacion=="PEDIATRIA-5 CAMA 1"){ echo "selected"; } ?>>PEDIATRIA-5 &nbsp;&nbsp;(cama 1)</option>
									<option value="PEDIATRIA-5 CAMA 2" <?php if($habitacion=="PEDIATRIA-5 CAMA 2"){ echo "selected"; } ?>>PEDIATRIA-5 &nbsp;&nbsp;(cama 2)</option>
									<option value="PEDIATRIA-6 CAMA 1" <?php if($habitacion=="PEDIATRIA-6 CAMA 1"){ echo "selected"; } ?>>PEDIATRIA-6 &nbsp;&nbsp;(cama 1)</option>
									<option value="PEDIATRIA-6 CAMA 2" <?php if($habitacion=="PEDIATRIA-6 CAMA 2"){ echo "selected"; } ?>>PEDIATRIA-6 &nbsp;&nbsp;(cama 2)</option>

									<option value="MEDICINA-5 CAMA 1" <?php if($habitacion=="MEDICINA-5 CAMA 1"){ echo "selected"; } ?>>MEDICINA-5 &nbsp;&nbsp;(cama 1)</option>
									<option value="MEDICINA-6 CAMA 1" <?php if($habitacion=="MEDICINA-6 CAMA 1"){ echo "selected"; } ?>>MEDICINA-6 &nbsp;&nbsp;(cama 1)</option>
									<option value="MEDICINA-7 CAMA 1" <?php if($habitacion=="MEDICINA-7 CAMA 1"){ echo "selected"; } ?>>MEDICINA-7 &nbsp;&nbsp;(cama 1)</option>
									<option value="MEDICINA-8 CAMA 1" <?php if($habitacion=="MEDICINA-8 CAMA 1"){ echo "selected"; } ?>>MEDICINA-8 &nbsp;&nbsp;(cama 1)</option>
									<option value="MEDICINA-9 CAMA 1" <?php if($habitacion=="MEDICINA-9 CAMA 1"){ echo "selected"; } ?>>MEDICINA-9 &nbsp;&nbsp;(cama 1)</option>
									<option value="MEDICINA-10 CAMA 1" <?php if($habitacion=="MEDICINA-10 CAMA 1"){ echo "selected"; } ?>>MEDICINA-10 &nbsp;&nbsp;(cama 1)</option>
									<option value="MEDICINA-23 CAMA 1" <?php if($habitacion=="MEDICINA-23 CAMA 1"){ echo "selected"; } ?>>MEDICINA-23 &nbsp;&nbsp;(cama 1)</option>
									<option value="MEDICINA-23 CAMA 2" <?php if($habitacion=="MEDICINA-23 CAMA 2"){ echo "selected"; } ?>>MEDICINA-23 &nbsp;&nbsp;(cama 2)</option>
									<option value="MEDICINA-24 CAMA 1" <?php if($habitacion=="MEDICINA-24 CAMA 1"){ echo "selected"; } ?>>MEDICINA-24 &nbsp;&nbsp;(cama 1)</option>
									<option value="MEDICINA-24 CAMA 2" <?php if($habitacion=="MEDICINA-24 CAMA 2"){ echo "selected"; } ?>>MEDICINA-24 &nbsp;&nbsp;(cama 2)</option>
									<option value="MEDICINA-25 CAMA 1" <?php if($habitacion=="MEDICINA-25 CAMA 1"){ echo "selected"; } ?>>MEDICINA-25 &nbsp;&nbsp;(cama 1)</option>
									<option value="MEDICINA-25 CAMA 2" <?php if($habitacion=="MEDICINA-25 CAMA 2"){ echo "selected"; } ?>>MEDICINA-25 &nbsp;&nbsp;(cama 2)</option>
									<option value="MEDICINA-26 CAMA 1" <?php if($habitacion=="MEDICINA-26 CAMA 1"){ echo "selected"; } ?>>MEDICINA-26 &nbsp;&nbsp;(cama 1)</option>
									<option value="MEDICINA-26 CAMA 2" <?php if($habitacion=="MEDICINA-26 CAMA 2"){ echo "selected"; } ?>>MEDICINA-26 &nbsp;&nbsp;(cama 2)</option>

									<option value="NEONATOS-1 CAMA 1" <?php if($habitacion=="NEONATOS-1 CAMA 1"){ echo "selected"; } ?>>NEONATOS-1 &nbsp;&nbsp;(cama 1)</option>
									<option value="NEONATOS-2 CAMA 1" <?php if($habitacion=="NEONATOS-2 CAMA 1"){ echo "selected"; } ?>>NEONATOS-2 &nbsp;&nbsp;(cama 1)</option>

									<option value="MATERNIDAD-1 CAMA 1" <?php if($habitacion=="MATERNIDAD-1 CAMA 1"){ echo "selected"; } ?>>MATERNIDAD-1 &nbsp;&nbsp;(cama 1)</option>
									<option value="MATERNIDAD-2 CAMA 1" <?php if($habitacion=="MATERNIDAD-2 CAMA 1"){ echo "selected"; } ?>>MATERNIDAD-2 &nbsp;&nbsp;(cama 1)</option>
									<option value="MATERNIDAD-3 CAMA 1" <?php if($habitacion=="MATERNIDAD-3 CAMA 1"){ echo "selected"; } ?>>MATERNIDAD-3 &nbsp;&nbsp;(cama 1)</option>
									<option value="MATERNIDAD-4 CAMA 1" <?php if($habitacion=="MATERNIDAD-4 CAMA 1"){ echo "selected"; } ?>>MATERNIDAD-4 &nbsp;&nbsp;(cama 1)</option>
									<option value="MATERNIDAD-5 CAMA 1" <?php if($habitacion=="MATERNIDAD-5 CAMA 1"){ echo "selected"; } ?>>MATERNIDAD-5 &nbsp;&nbsp;(cama 1)</option>
									<option value="MATERNIDAD-6 CAMA 1" <?php if($habitacion=="MATERNIDAD-6 CAMA 1"){ echo "selected"; } ?>>MATERNIDAD-6 &nbsp;&nbsp;(cama 1)</option>
									<option value="MATERNIDAD-7 CAMA 1" <?php if($habitacion=="MATERNIDAD-7 CAMA 1"){ echo "selected"; } ?>>MATERNIDAD-7 &nbsp;&nbsp;(cama 1)</option>
									<option value="MATERNIDAD-8 CAMA 1" <?php if($habitacion=="MATERNIDAD-8 CAMA 1"){ echo "selected"; } ?>>MATERNIDAD-8 &nbsp;&nbsp;(cama 1)</option>
									<option value="MATERNIDAD-9 CAMA 1" <?php if($habitacion=="MATERNIDAD-9 CAMA 1"){ echo "selected"; } ?>>MATERNIDAD-9 &nbsp;&nbsp;(cama 1)</option>
									<option value="MATERNIDAD-10 CAMA 1" <?php if($habitacion=="MATERNIDAD-10 CAMA 1"){ echo "selected"; } ?>>MATERNIDAD-10 &nbsp;&nbsp;(cama 1)</option>

									<option value="INTENSIVO NEONATOS-1 CAMA 1" <?php if($habitacion=="INTENSIVO NEONATOS-1 CAMA 1"){ echo "selected"; } ?>>INTENSIVO NEONATOS-1 &nbsp;&nbsp;(cama 1)</option>

									<option value="INTENSIVO-1 CAMA 1" <?php if($habitacion=="INTENSIVO-1 CAMA 1"){ echo "selected"; } ?>>INTENSIVO-1 &nbsp;&nbsp;(cama 1)</option>
									<option value="INTENSIVO-2 CAMA 1" <?php if($habitacion=="INTENSIVO-2 CAMA 1"){ echo "selected"; } ?>>INTENSIVO-2 &nbsp;&nbsp;(cama 1)</option>
									<option value="INTENSIVO-3 CAMA 1" <?php if($habitacion=="INTENSIVO-3 CAMA 1"){ echo "selected"; } ?>>INTENSIVO-3 &nbsp;&nbsp;(cama 1)</option>
									<option value="INTENSIVO-4 CAMA 1" <?php if($habitacion=="INTENSIVO-4 CAMA 1"){ echo "selected"; } ?>>INTENSIVO-4 &nbsp;&nbsp;(cama 1)</option>
									<option value="INTENSIVO-5 CAMA 1" <?php if($habitacion=="INTENSIVO-5 CAMA 1"){ echo "selected"; } ?>>INTENSIVO-5 &nbsp;&nbsp;(cama 1)</option>
									<option value="INTENSIVO-6 CAMA 1" <?php if($habitacion=="INTENSIVO-6 CAMA 1"){ echo "selected"; } ?>>INTENSIVO-6 &nbsp;&nbsp;(cama 1)</option>
									<option value="INTENSIVO-7 CAMA 1" <?php if($habitacion=="INTENSIVO-7 CAMA 1"){ echo "selected"; } ?>>INTENSIVO-7 &nbsp;&nbsp;(cama 1)</option>
									<option value="INTENSIVO-8 CAMA 1" <?php if($habitacion=="INTENSIVO-8 CAMA 1"){ echo "selected"; } ?>>INTENSIVO-8 &nbsp;&nbsp;(cama 1)</option>
									<option value="INTENSIVO-9 CAMA 1" <?php if($habitacion=="INTENSIVO-9 CAMA 1"){ echo "selected"; } ?>>INTENSIVO-9 &nbsp;&nbsp;(cama 1)</option>
									<option value="INTENSIVO-10 CAMA 1" <?php if($habitacion=="INTENSIVO-10 CAMA 1"){ echo "selected"; } ?>>INTENSIVO-10 &nbsp;&nbsp;(cama 1)</option>
									<option value="INTENSIVO-11 CAMA 1" <?php if($habitacion=="INTENSIVO-11 CAMA 1"){ echo "selected"; } ?>>INTENSIVO-11 &nbsp;&nbsp;(cama 1)</option>

									<option value="HEMODIALISIS-1 CAMA 1" <?php if($habitacion=="HEMODIALISIS-1 CAMA 1"){ echo "selected"; } ?>>HEMODIALISIS-1 &nbsp;&nbsp;(cama 1)</option>
									<option value="HEMODIALISIS-1 CAMA 2" <?php if($habitacion=="HEMODIALISIS-1 CAMA 2"){ echo "selected"; } ?>>HEMODIALISIS-1 &nbsp;&nbsp;(cama 2)</option>

									<option value="GASTROSCOPIA-1 CAMA 1" <?php if($habitacion=="GASTROSCOPIA-1 CAMA 1"){ echo "selected"; } ?>>GASTROSCOPIA-1 &nbsp;&nbsp;(cama 1)</option>
									<option value="GASTROSCOPIA-2 CAMA 2" <?php if($habitacion=="GASTROSCOPIA-2 CAMA 2"){ echo "selected"; } ?>>GASTROSCOPIA-2 &nbsp;&nbsp;(cama 2)</option>

									<option value="CIRUGIA-11 CAMA 1" <?php if($habitacion=="CIRUGIA-11 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-11 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-12 CAMA 1" <?php if($habitacion=="CIRUGIA-12 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-12 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-14 CAMA 1" <?php if($habitacion=="CIRUGIA-14 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-14 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-15 CAMA 1" <?php if($habitacion=="CIRUGIA-15 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-15 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-16 CAMA 1" <?php if($habitacion=="CIRUGIA-16 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-16 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-18 CAMA 1" <?php if($habitacion=="CIRUGIA-18 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-18 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-18 CAMA 2" <?php if($habitacion=="CIRUGIA-18 CAMA 2"){ echo "selected"; } ?>>CIRUGIA-18 &nbsp;&nbsp;(cama 2)</option>
									<option value="CIRUGIA-19 CAMA 1" <?php if($habitacion=="CIRUGIA-19 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-19 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-19 CAMA 2" <?php if($habitacion=="CIRUGIA-19 CAMA 2"){ echo "selected"; } ?>>CIRUGIA-19 &nbsp;&nbsp;(cama 2)</option>
									<option value="CIRUGIA-20 CAMA 1" <?php if($habitacion=="CIRUGIA-20 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-20 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-20 CAMA 2" <?php if($habitacion=="CIRUGIA-20 CAMA 2"){ echo "selected"; } ?>>CIRUGIA-20 &nbsp;&nbsp;(cama 2)</option>
									<option value="CIRUGIA-22 CAMA 1" <?php if($habitacion=="CIRUGIA-22 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-22 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-22 CAMA 2" <?php if($habitacion=="CIRUGIA-22 CAMA 2"){ echo "selected"; } ?>>CIRUGIA-22 &nbsp;&nbsp;(cama 2)</option>
									<option value="CIRUGIA-131 CAMA 1" <?php if($habitacion=="CIRUGIA-131 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-131 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-132 CAMA 1" <?php if($habitacion=="CIRUGIA-132 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-132 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-133 CAMA 1" <?php if($habitacion=="CIRUGIA-133 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-133 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-134 CAMA 1" <?php if($habitacion=="CIRUGIA-134 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-134 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-135 CAMA 1" <?php if($habitacion=="CIRUGIA-135 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-135 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-136 CAMA 1" <?php if($habitacion=="CIRUGIA-136 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-136 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-137 CAMA 1" <?php if($habitacion=="CIRUGIA-137 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-137 &nbsp;&nbsp;(cama 1)</option>

									<option value="AISLAMIENTO-1 CAMA 1" <?php if($habitacion=="AISLAMIENTO-1 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-1 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-2 CAMA 1" <?php if($habitacion=="AISLAMIENTO-2 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-2 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-3 CAMA 1" <?php if($habitacion=="AISLAMIENTO-3 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-3 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-4 CAMA 1" <?php if($habitacion=="AISLAMIENTO-4 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-4 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-5 CAMA 1" <?php if($habitacion=="AISLAMIENTO-5 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-5 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-6 CAMA 1" <?php if($habitacion=="AISLAMIENTO-6 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-6 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-7 CAMA 1" <?php if($habitacion=="AISLAMIENTO-7 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-7 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-8 CAMA 1" <?php if($habitacion=="AISLAMIENTO-8 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-8 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-8 CAMA 2" <?php if($habitacion=="AISLAMIENTO-8 CAMA 2"){ echo "selected"; } ?>>AISLAMIENTO-8 &nbsp;&nbsp;(cama 2)</option>
									<option value="AISLAMIENTO-9 CAMA 1" <?php if($habitacion=="AISLAMIENTO-9 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-9 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-9 CAMA 2" <?php if($habitacion=="AISLAMIENTO-9 CAMA 2"){ echo "selected"; } ?>>AISLAMIENTO-9 &nbsp;&nbsp;(cama 2)</option>
									<option value="AISLAMIENTO-10 CAMA 1" <?php if($habitacion=="AISLAMIENTO-10 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-10 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-10 CAMA 2" <?php if($habitacion=="AISLAMIENTO-10 CAMA 2"){ echo "selected"; } ?>>AISLAMIENTO-10 &nbsp;&nbsp;(cama 2)</option>
									<option value="AISLAMIENTO-11 CAMA 1" <?php if($habitacion=="AISLAMIENTO-11 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-11 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-11 CAMA 2" <?php if($habitacion=="AISLAMIENTO-11 CAMA 2"){ echo "selected"; } ?>>AISLAMIENTO-11 &nbsp;&nbsp;(cama 2)</option>
									<option value="AISLAMIENTO-12 CAMA 1" <?php if($habitacion=="AISLAMIENTO-12 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-12 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-12 CAMA 2" <?php if($habitacion=="AISLAMIENTO-12 CAMA 2"){ echo "selected"; } ?>>AISLAMIENTO-12 &nbsp;&nbsp;(cama 2)</option>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-12">
								<label>Médico tratante *</label>
								<select name="medico" id="medico" class="form-control" onChange="cambia_medico()" required="required" disabled>
									<option value="0">Elija uno</option>
									<?php
									$qryM2 = "SELECT * FROM web_medicos WHERE status_med37='A' and  colegiado_med35  > '0' ORDER by primer_apellido_med29,primer_nombre_med18";
									$rsM2 = $conexion2->query($qryM2);
									while ($rowM2 = $rsM2->fetch_assoc()){
									?>
									<option value="<?php echo $rowM2["cod_med12"]; ?>" <?php if($medico==$rowM2["cod_med12"]){ echo "selected"; } ?>><?php echo $rowM2["primer_apellido_med29"]; ?> <?php if(!empty($rowM2["segundo_apellido_med37"])){ echo $rowM2["segundo_apellido_med37"]; } ?>, <?php echo $rowM2["primer_nombre_med18"]; ?> <?php if(!empty($rowM2["segundo_nombre_med22"])){ echo $rowM2["segundo_nombre_med22"]; } ?></option>
									<?php } ?>
									<option value="999999" <?php if($medico=="999999"){ echo "selected"; } ?>>OTRO</option>
								</select>

								<div id="otrobox" <?php if($medico!="999999" && !empty($mediconombre)){?>style="display: none;"<?php } ?>>
								<div class="row">
									<div class="col-md-12">
										<input type="text" class="form-control mt-3" name="otromed" placeholder="nombre médico" value="<?php echo $medicootro; ?>">
									</div>
								</div>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-12">
								<label>Motivo de ingreso</label>
								<textarea name="motivo" id="motivo" rows="4" class="form-control" disabled><?php echo $motivo; ?></textarea>
							</div>

						</div>
					</div>
				</div>
				<?php if($status<"2"){ ?>
				<div class="col-md-4">
					<div class="box-admin-opt">
						<h5 class="pt-0 mt-0">Menús activos</h5>
						<?php if(1==2){ ?>
						<div class="row mb-4">
							<div class="col-12 pr-3 position-relative">
								<input type="search" id="search" name="search" class="form-control" placeholder="buscador ej. huevos, jugo">
								<p class="position-absolute" id="opt-times" style="right: 30px; top: 7px;">
									<a href="#" id="texto-borrar" style="color: #A0A0A0;"><i class="fa fa-times"></i></a>
								</p>
							</div>
						</div>
						<!-- Search container -->
						<div id="prueba-result" style="margin-top: -15px; margin-bottom: 20px;">
							<div id="container"></div>
						</div>
						<?php } ?>

						<?php 
						$qryL = "SELECT * FROM _programaciones WHERE status!='E' and inicio <='$datenow' and final >='$datenow' ORDER by nombre";
						$rsL  = $conexion->query($qryL);
						while ($rowL = $rsL->fetch_assoc()){
						?>
						<button class="form-control mt-2" type="button" data-toggle="collapse" data-target="#collapseExample<?php echo $rowL["id"]; ?>" aria-expanded="false" aria-controls="collapseExample" style="background: #eee; text-align: left;">
							<b class="tit-pruebas"><?php echo $rowL["nombre"]; ?></b>
						</button>
						<div class="collapse p-2" id="collapseExample<?php echo $rowL["id"]; ?>">
							<?php 
							$idO  = $rowL["id"];
							$qryO = "SELECT * FROM _menus a WHERE a.id in (select idmenu from _menus_progra_enlace b where b.idmenu=a.id and b.idprogra='$idO') and a.status!='E' ORDER by a.nombre";
							$rsO  = $conexion->query($qryO);
							while ($rowO = $rsO->fetch_assoc()){
							?>
								<h6 class="mt-2"><?php echo $rowO["nombre"]; ?></h6>
								<?php 
								$idM  = $rowO["id"];
								$qryM = "SELECT *, (select idopcionmenu from _pacientes_menu_enlace b where b.idopcionmenu=a.id and b.keyunico='$keyForm') as idmo, (select idprogra from _pacientes_menu_enlace b where b.idopcionmenu=a.id and b.keyunico='$keyForm') as idprogram FROM _menus_opciones a WHERE idmenu='$idM' and status!='E' ORDER by nombre";
								$rsM  = $conexion->query($qryM);
								while ($rowM = $rsM->fetch_assoc()){
								?>
								<div class="row px-2">
									<div class="col-md-12" style="font-size: 11pt;">
										<input type="checkbox" id="item<?php echo $idO; ?>-<?php echo $rowM["id"]; ?>" name="pr<?php echo $rowM["id"]; ?>" value="<?php echo $rowM["id"]; ?>" <?php if($rowM["idmo"]==$rowM["id"] && $rowM["idprogram"]==$idO){ echo "checked"; } ?>>&nbsp; <?php echo $rowM["nombre"]; ?><br>
									</div>
								</div>
								<input type="hidden" id="idprogra<?php echo $rowL["id"]; ?>" value="<?php echo $rowL["id"]; ?>">
								<script>
									$(document).on('click', '#item<?php echo $idO; ?>-<?php echo $rowM["id"]; ?>', (e) => {
										const postData = {
											id: $('#item<?php echo $idO; ?>-<?php echo $rowM["id"]; ?>').val(),
											key: $('#key').val(),
											pacienteid: $('#idpaciente').val(),
											idprogra: $('#idprogra<?php echo $rowL["id"]; ?>').val()
										};
										$.post('platos_add.php?sol=<?php echo $_GET["sol"]; ?>', postData, (response) => {
							      			console.log(response);
							      			$("#item<?php echo $idO; ?>-<?php echo $rowM["id"]; ?>").prop("checked", true);
							      			fetchTasks();
							      		});
							      		e.preventDefault();
									});
								</script>
								<?php } ?>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php } ?>
				<div class="col-md-4">
					<div class="box-admin-opt">
						<h5 class="pt-0 mt-0">Menú elegido</h5>
						<?php if($status<"2"){ ?>
						<div class="table-elegidas" id="tasks" style="min-height: 150px;"></div>
						<?php }else{ ?>
						<div class="table-elegidas" style="min-height: 150px;">
							<?php
							$keyun = "solicitud".$idSol;
							$query = "SELECT *, (select nombre from _menus_opciones o where o.id=p.idopcionmenu) as nmopt, (select nombre from _menus m where m.id in (select idmenu from _menus_opciones o where o.idmenu=m.id and p.idopcionmenu=o.id)) as nmmenu, (select nombre from _programaciones c where c.id=p.idprogra) as nprogra FROM _pacientes_menu_enlace p WHERE p.keyunico='$keyun' ORDER by idprogra";
  							$result = $conexion->query($query);
  							while($row = $result->fetch_array()) {
							?>
							<div class="row">
								<div class='col-11'><b><?php echo $row["nprogra"];?></b><br><?php echo $row["nmmenu"];?> (<?php echo $row["nmopt"];?>)</div>
							</div>
							<?php } ?>
						</div>
						<?php } ?>
						<div class="row mt-3 pb-4">
							<div class="col-md-12">
								<label>Observaciones</label>
								<textarea name="observaciones" id="observaciones" rows="4" class="form-control" <?php if($status=="2"){ echo "disabled"; } ?>><?php echo $observaciones; ?></textarea>
							</div>
						</div>
						<?php if($status=="0"){ ?>
						<input type="submit" name="submitform" class="form-control btn text-light" value="grabar cambios" style="font-weight: bold; font-size: 18pt; background: #17a2b8; text-shadow: 0px 1px 1px #1d527d; margin-top: 0px;">

						<input type="submit" name="submitcocina" class="form-control btn bg-warning" value="enviar a cocina" style="font-weight: bold; font-size: 18pt; margin-top: 15px;">
						<?php } ?>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>

<script>
	// Testing Jquery
	console.log('jquery is working!');

	$('#prueba-result').css('display','none');

	// coloco la opcion de borrar el texto despues de escribir en el campo
	$('#opt-times').hide();
	$("#search").keypress(function(){ 
	  	$('#opt-times').show();
	});
	 // opcion de borrar el texto del campo
	$(document).on('click', '#texto-borrar', (e) => {
		$("#search").val('');
		$("#prueba-result").css('display','none');
	});

  // search key type event
  $('#search').keyup(function() {
    if($('#search').val()) {
      let search = $('#search').val();

      $.ajax({
        url: 'platos_search.php',
        data: {search},
        type: 'POST',
        success: function (response) {
          if(!response.error) {
            let tasks = JSON.parse(response);
            let template = '';
            tasks.forEach(task => {
              template += `
              	<input type="checkbox" id="item${task.id}" name="pr${task.id}" value="${task.id}"> ${task.name}<br>
                    ` 
            });
            $('#prueba-result').css('display','block');
            $('#container').html(template);
          }
        } 
      });
    }else{
    	$('#prueba-result').css('display','none');
    }
  });

  // habilita campo para agregar nombre medico si no esta en el listado
  function cambia_medico() {
	if (document.getElementById("medico").value=="999999") {
		$("#otrobox").css("display", "block");
		console.log('block');
	}else{
		$("#otrobox").css("display", "none");
	};
  };

</script>

<?php include("footer.php"); ?>

