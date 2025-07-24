<?php
$titulo = "Agregar Paciente";
$nologg = "SI";
$page   = "pacientes";   // identifica pagina para scripts, etc
$areaLg = "PACIENTES"; // valida roles del usuario

include("header.php");

$sessadd    = $_SESSION["sessadd"];

$fechain    = $sessadd["fingreso"];
$pnombre    = $sessadd["pnombre"];
$snombre    = $sessadd["snombre"];
$papellido  = $sessadd["papellido"];
$sapellido  = $sessadd["sapellido"];
$habitacion = $sessadd["habitacion"];
$pcodigo    = $sessadd["pcodigo"];
$cama       = $sessadd["cama"];
$codmedico  = $sessadd["cod_medico"];
$medico     = $sessadd["medico_tratante"];
$motivo     = $sessadd["motivo"];
$observaciones = $sessadd["observaciones"];
$alergias   = $sessadd["alergias"];
$status     = $sessadd["status"];
?>
<style>
	.content-text {
		margin: 160px 21px 0 21px;
	}
</style>

<div class="row pt-0 mb-4">
	<div class="col-md-12 content-box position-relative">

		<div style="width: 90%; margin: 175px auto 50px auto;">
			<form id="form-prueba" action="pacientes_grabar.php" method="POST" autocomplete="off">
			<input type="hidden" name="id" id="idsol" value="<?php echo $idPac; ?>">
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<div class="box-admin-opt">
						<h5 class="pt-0 mt-0 text-secondary">Datos del paciente</h5>
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
						<div class="form-group col-md-4">
							<label>Alergias</label><br>  
							<input type="radio" name="alergias" value="Mariscos" <?php if($alergias=="Mariscos"){ echo "checked"; } ?>> Mariscos&nbsp; <br>
							<input type="radio" name="alergias" value="Gluten" <?php if($alergias=="Gluten"){ echo "checked"; } ?>> Gluten&nbsp;<br> 
							<input type="radio" name="alergias" value="Lactosa" <?php if($alergias=="Lactosa"){ echo "checked"; } ?>> Lactosa&nbsp;<br> 
							<input type="radio" name="alergias" value="NO" <?php if($alergias=="NO" || empty($alergias)){ echo "checked"; } ?>> Ninguna&nbsp; 
						</div>
						<div class="form-group col-md-4">
							<label>Status</label><br>  
							<input type="radio" name="status" value="A" <?php if($status=="A"){ echo "checked"; }else{ echo "checked"; } ?>> Activo&nbsp; <br>
							<input type="radio" name="status" value="I" <?php if($status=="I"){ echo "checked"; } ?>> Inactivo&nbsp; 
						</div>
					</div>
					<div class="form-row mt-3">
						<div class="form-group col-md-4"></div>
						<div class="form-group col-md-4">
							<input type="submit" name="submitadd" class="form-control btn btn-secondary text-light" value="agregar paciente" style="font-weight: bold; font-size: 18pt; margin-top: 0px;">
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

