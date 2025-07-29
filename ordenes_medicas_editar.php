<?php
$titulo = "Editar Orden Médica";
$nologg = "SI";
$page   = "ordenes";   // identifica pagina para scripts, etc
$areaLg = "ORDENES"; // valida roles del usuario

include("header.php");

$idPac  = $_GET["id"];
$qryPac = "SELECT * FROM _ordenes_medicas o WHERE id='$idPac'";
$rsPac  = $conexion->query($qryPac);
$rowPac = $rsPac->fetch_assoc();

$fechain    = $rowPac["fecha_ingreso"];
$pnombre    = $rowPac["pnombre"];
$snombre    = $rowPac["snombre"];
$papellido  = $rowPac["papellido"];
$sapellido  = $rowPac["sapellido"];
$dieta      = $rowPac["dieta"];
$habitacion = $rowPac["habitacion"];
$pcodigo    = $rowPac["codigo"];
$cama       = $rowPac["cama"];
$codmedico  = $rowPac["cod_medico"];
$medico     = $rowPac["medico_tratante"];
$motivo     = $rowPac["motivo_ingreso"];
$observaciones = $rowPac["observaciones"];
$status     = $rowPac["status"];
?>
<style>
	.content-text {
		margin: 160px 21px 0 21px;
	}
</style>

<div class="row pt-0 mb-4">
	<div class="col-md-12 content-box position-relative">

		<div style="width: 90%; margin: 175px auto 50px auto;">
			<form id="formUsuario" action="ordenes_medicas_grabar.php" method="POST" autocomplete="off">
			<input type="hidden" name="acceso" value="editar">
			<input type="hidden" name="id" id="idsol" value="<?php echo $idPac; ?>">
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<div class="row box-menu mx-1 mb-3">
						<div class="col-md-6 py-2">
							<h5 class="text-secondary m-0 p-0">
								<a href="ordenes_medicas.php" style="color: #002d59;">
									<i class="fa fa-angle-left"></i>
								</a>&nbsp;
								Información del paciente
							</h5>
						</div>
						<div class="col-md-6 py-2 text-right">
							Fecha ingreso: <b><?php echo formatearFechaEs($fechain); ?></b>
						</div>
					</div>

					<div class="box-items">
						<div id="errores" style="color: red; margin-top: 10px;"></div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="label-codigo">Código Paciente *</label>
								<input type="text" name="pcodigo" id="pcodigo" class="form-control" value="<?php echo $pcodigo; ?>">
							</div>
							<div class="form-group col-md-6">
								<label class="label-dieta">Tipo de Dieta *</label>
								<select name="dieta" id="dieta" class="form-control">
									<option value="">elija una</option>
									<?php 
									$qryD = "SELECT * FROM _tipo_dieta WHERE status = 'A'";
									$resD = $pdo->prepare($qryD);
									$resD->execute();
									while ($rowD = $resD->fetch(PDO::FETCH_ASSOC)){
									?>
									<option value="<?php echo $rowD["id"]; ?>" <?php if($rowD["id"]==$dieta){ echo "selected"; } ?>><?php echo $rowD["nombre"]; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="label-pnombre">Primer Nombre *</label>
								<input type="text" name="pnombre" id="pnombre" class="form-control" value="<?php echo $pnombre; ?>">
							</div>
							<div class="form-group col-md-6">
								<label>Segundo Nombre</label>
								<input type="text" name="snombre" id="snombre" class="form-control" value="<?php echo $snombre; ?>">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="label-papellido">Primer Apellido *</label>
								<input type="text" name="papellido" id="papellido" class="form-control" value="<?php echo $papellido; ?>">
							</div>
							<div class="form-group col-md-6">
								<label>Segundo Apellido</label>
								<input type="text" name="sapellido" id="sapellido" class="form-control" value="<?php echo $sapellido; ?>">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="label-medico">Médico tratante *</label>
								<select name="medico" id="medico" class="form-control" onChange="cambia_medico()">
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
							<div class="form-group col-md-6">
								<label class="label-habitacion">Habitacion/Cama *</label>
								<select name="habitacion" id="habitacion" class="form-control">
									<option value="">Elija una</option>
									<?php 
									$qryH = "SELECT * FROM _habitaciones WHERE status='A' ORDER by nombre";
									$resH = $conexion->query($qryH);
									while ($rowH = $resH->fetch_assoc()){
									?>
									<option value="<?php echo $rowH["id"]; ?>" <?php if($rowH["id"]==$habitacion){ echo "selected"; } ?>><?php echo $rowH["nombre"]; ?></option>
									<?php } ?>
								</select>
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
								<textarea name="observaciones" id="observaciones" class="form-control" rows="4"><?php echo $observaciones; ?></textarea>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-12">
								<label>Alergias</label><br>
								<?php 
								$qryA = "SELECT * FROM _pacientes_alergias WHERE _paciente_cod = '$pcodigo'";
								$resA = $conexion->query($qryA);
								while ($rowA = $resA->fetch_assoc()){
									echo $rowA["_alergia"].", ";
								}
								?>
								
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
								<input type="submit" name="submitedit" class="form-control btn text-light" value="grabar cambios" style="font-weight: bold; font-size: 14pt; margin-top: 0px; background: #002d59;">
							</div>
						</div>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

	// valida campos obligatorios
	$(document).ready(function() {
		$('#formUsuario').submit(function(e) {
			
			e.preventDefault(); // evita el envío si hay errores

			let errores = [];

			let omcodigo     = $('#pcodigo').val().trim();
			// console.log('pcodigo:', omcodigo);

			let omdieta      = $('#dieta').val().trim();
			// console.log('dieta:', omdieta);

			let ompnombre    = $('#pnombre').val().trim();
			// console.log('pnombre:', ompnombre);

			let ompapellido  = $('#papellido').val().trim();
			// console.log('papellido:', ompapellido);

			let omhabitacion = $('#habitacion').val().trim();
			// console.log('habitacion:', omhabitacion);

			let ommedico     = $('#medico').val().trim();
			// console.log('medico:', ommedico);

			// Limpia errores anteriores
			$('#errores').html('');
			$('input').css('border', '');

			if (omcodigo === '') {
				errores.push('El campo Código Paciente es obligatorio');
				$('#pcodigo').css('border', '1px solid red');
				$('.label-codigo').css('color', 'red');
			}

			if (omdieta === '') {
				errores.push('El campo Tipo de Dieta es obligatorio');
				$('#dieta').css('border', '1px solid red');
				$('.label-dieta').css('color', 'red');
			}

			if (ompnombre === '') {
				errores.push('El campo Primer Nombre es obligatorio');
				$('#pnombre').css('border', '1px solid red');
				$('.label-pnombre').css('color', 'red');
			}

			if (ompapellido === '') {
				errores.push('El campo Primer Apellido es obligatorio');
				$('#papellido').css('border', '1px solid red');
				$('.label-papellido').css('color', 'red');
			}

			if (omhabitacion === '') {
				errores.push('El campo Habitación es obligatorio');
				$('#habitacion').css('border', '1px solid red');
				$('.label-habitacion').css('color', 'red');
			}

			if (ommedico === '') {
				errores.push('El campo Médico Tratante es obligatorio');
				$('#medico').css('border', '1px solid red');
				$('.label-medico').css('color', 'red');
			}

			if (errores.length > 0) {
				$('#errores').html('<ul><li>' + errores.join('</li><li>') + '</li></ul>');
			} else {
				// Si todo está bien, podrías enviar con AJAX o permitir el envío normal
				// console.log("Enviando formulario...");
				this.submit(); // o hacer el submit manual
			}

		});
	});

</script>

<?php include("footer.php"); ?>

