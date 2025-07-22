<?php
$titulo = "Pacientes";
$nologg = "SI";
$page   = "pacientes";   // identifica pagina para scripts, etc
$areaLg = "INGRESO_PAC"; // valida roles del usuario

include("header.php");

$idPac  = $_GET["id"];
$qryPac = "SELECT * FROM _pacientes_activos WHERE id='$idPac'";
$rsPac  = $conexion->query($qryPac);
$rowPac = $rsPac->fetch_assoc();

$fechain    = $rowPac["fecha_ingreso"];
$pnombre    = $rowPac["pnombre"];
$snombre    = $rowPac["snombre"];
$papellido  = $rowPac["papellido"];
$sapellido  = $rowPac["sapellido"];
$habitacion = $rowPac["habitacion"];
$pcodigo    = $rowPac["codigo"];
$cama       = $rowPac["cama"];
$codmedico  = $rowPac["cod_medico"];
$medico     = $rowPac["medico_tratante"];
$motivo     = $rowPac["motivo_ingreso"];
$observaciones = $rowPac["observaciones"];
$alergias   = $rowPac["alergias"];
$status     = $rowPac["status"];
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
				<h1 class="pb-0 mb-0" style="font-size: 16pt !important; height: 60px;"></h1>
			</div>
			<div class="col-md-7 pt-5 text-right" style="padding-top: 33px;">

			</div>
		</div>
		
		<div class="row mb-5">
			<div class="col-md-12">
				<div class="esconder-movil">
					<div class="mb-3 h4-sidebar-nobg text-center bg-info" style="height: 43px; font-size: 16pt; padding-top: 2px;">
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
			<form id="form-prueba" action="pacientes_activos_grabar.php" method="POST" autocomplete="off">
			<input type="hidden" name="id" id="idsol" value="<?php echo $idPac; ?>">
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<div class="box-admin-opt">
						<h5 class="pt-0 mt-0">Datos del paciente</h5>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label>Fecha Ingreso *</label>
								<input type="date" name="fingreso" id="fingreso" class="form-control" required="required" value="<?php echo $fechain; ?>">
							</div>
							<div class="form-group col-md-6">
								<label>Código</label>
								<input type="text" name="pcodigo" id="pcodigo" class="form-control" value="<?php echo $pcodigo; ?>">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label>Primer Nombre *</label>
								<input type="text" name="pnombre" id="pnombre" class="form-control" required="required" value="<?php echo $pnombre; ?>">
							</div>
							<div class="form-group col-md-6">
								<label>Segundo Nombre</label>
								<input type="text" name="snombre" id="snombre" class="form-control" value="<?php echo $snombre; ?>">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label>Primer Apellido *</label>
								<input type="text" name="papellido" id="papellido" class="form-control" required="required" value="<?php echo $papellido; ?>">
							</div>
							<div class="form-group col-md-6">
								<label>Segundo Apellido</label>
								<input type="text" name="sapellido" id="sapellido" class="form-control" value="<?php echo $sapellido; ?>">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label>Habitacion/Cama *</label>
								<select name="habitacion" class="form-control">
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
							<div class="form-group col-md-6">
								<label>Médico tratante *</label>
								<select name="medico" id="medico" class="form-control" onChange="cambia_medico()" required="required">
									<option value="0">Elija uno</option>
									<?php
									$qryM2 = "SELECT * FROM web_medicos WHERE status_med37='A' and  colegiado_med35  > '0' ORDER by primer_apellido_med29,primer_nombre_med18";
									$rsM2 = $conexion2->query($qryM2);
									while ($rowM2 = $rsM2->fetch_assoc()){
									?>
									<option value="<?php echo $rowM2["cod_med12"]; ?>" <?php if($rowM2["cod_med12"]==$codmedico){ echo "selected"; } ?>><?php echo $rowM2["primer_apellido_med29"]; ?> <?php if(!empty($rowM2["segundo_apellido_med37"])){ echo $rowM2["segundo_apellido_med37"]; } ?>, <?php echo $rowM2["primer_nombre_med18"]; ?> <?php if(!empty($rowM2["segundo_nombre_med22"])){ echo $rowM2["segundo_nombre_med22"]; } ?></option>
									<?php } ?>
									<option value="999999" <?php if($rowM2["medico_tratante"]=="999999"){ echo "selected"; } ?>>OTRO</option>
								</select>

								<div id="otrobox" style="display: none;">
								<div class="row">
									<div class="col-md-12">
										<input type="text" class="form-control mt-3" name="otromed" placeholder="nombre médico" value="<?php echo $rowM2["medico_otro"]; ?>">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label>Motivo de ingreso</label>
							<textarea name="motivo" id="motivo" class="form-control" rows="2"><?php echo $motivo; ?></textarea>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label>Observaciones</label>
							<textarea name="observaciones" id="observaciones" class="form-control" rows="2"><?php echo $observaciones; ?></textarea>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label>Alergias</label>&nbsp;  
							<input type="radio" name="alergias" value="Mariscos" <?php if($alergias=="Mariscos"){ echo "checked"; } ?>> Mariscos&nbsp; 
							<input type="radio" name="alergias" value="Gluten" <?php if($alergias=="Gluten"){ echo "checked"; } ?>> Gluten&nbsp; 
							<input type="radio" name="alergias" value="Lactosa" <?php if($alergias=="Lactosa"){ echo "checked"; } ?>> Lactosa&nbsp; 
							<input type="radio" name="alergias" value="NO" <?php if($alergias=="NO" || empty($alergias)){ echo "checked"; } ?>> Ninguna&nbsp; 
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label>Status</label>&nbsp;  
							<input type="radio" name="status" value="A" <?php if($status=="A"){ echo "checked"; } ?>> Activo&nbsp; 
							<input type="radio" name="status" value="I" <?php if($status=="I"){ echo "checked"; } ?>> Inactivo&nbsp; 
						</div>
					</div>
					<div class="form-row mt-3">
						<div class="form-group col-md-4"></div>
						<div class="form-group col-md-4">
							<input type="submit" name="submitedit" class="form-control btn text-light" value="grabar cambios" style="font-weight: bold; font-size: 18pt; background: #002d59; margin-top: 0px;">
						</div>
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

