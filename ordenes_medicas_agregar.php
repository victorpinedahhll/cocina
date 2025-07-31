<?php
$titulo = "Agregar Orden Médica";
$nologg = "SI";
$page   = "ordenes";   // identifica pagina para scripts, etc
$areaLg = "ORDENES"; // valida roles del usuario

include("header.php");

$sessadd    = $_SESSION["sessordenadd"];

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
			<form id="formUsuario" action="ordenes_medicas_grabar.php" method="POST" autocomplete="off">
			<input type="hidden" name="acceso" value="agregar">
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
							
						</div>
					</div>

					<div class="box-items">
						<div id="errores" style="color: red; margin-top: 10px;"></div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label>Código Paciente *</label>
								<input type="text" name="pcodigo" id="pcodigo" class="form-control" value="<?php echo $pcodigo; ?>">
							</div>
							<div class="form-group col-md-6">
								<label>Tipo de Dieta *</label>
								<select name="dieta" id="dieta" class="form-control">
									<?php 
									$qryD = "SELECT * FROM _tipo_dieta WHERE status = 'A'";
									$resD = $pdo->prepare($qryD);
									$resD->execute();
									while ($rowD = $resD->fetch(PDO::FETCH_ASSOC)){
									?>
									<option value="<?php echo $rowD["id"]; ?>"><?php echo $rowD["nombre"]; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label>Primer Nombre *</label>
								<input type="text" name="pnombre" id="pnombre" class="form-control" value="<?php echo $pnombre; ?>">
							</div>
							<div class="form-group col-md-6">
								<label>Segundo Nombre</label>
								<input type="text" name="snombre" id="snombre" class="form-control" value="<?php echo $snombre; ?>">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label>Primer Apellido *</label>
								<input type="text" name="papellido" id="papellido" class="form-control" value="<?php echo $papellido; ?>">
							</div>
							<div class="form-group col-md-6">
								<label>Segundo Apellido</label>
								<input type="text" name="sapellido" id="sapellido" class="form-control" value="<?php echo $sapellido; ?>">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label>Médico tratante *</label>
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
											<input type="text" class="form-control mt-3" name="otromed" id="otromed"" placeholder="nombre médico" value="<?php echo $rowM2["medico_otro"]; ?>">
										</div>
									</div>
								</div>
							</div>
							<div class="form-group col-md-6">
								<label>Habitacion/Cama *</label>
								<select name="habitacion" id="habitacion" class="form-control">
									<option value="0">Elija una</option>
									<?php 
									$qryHB = "SELECT * FROM _habitaciones WHERE status = 'A' ORDER by nombre";
									$resHB = $conexion->query($qryHB);
									while ($rowHB = $resHB->fetch_assoc()){
									?>
									<option value="<?php echo $rowHB["id"]; ?>" <?php if($habitacion==$rowHB["id"]){ echo "selected"; } ?>><?php echo $rowHB["nombre"]; ?></option>
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
								<textarea name="observaciones" id="observaciones" class="form-control" rows="2"><?php echo $observaciones; ?></textarea>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6" id="boxalergias">
								<label>Alergias</label><br>
								<?php
								$qryA = "SELECT * FROM _alergias WHERE _status = 'A' ORDER by _nombre";
								$resA = $conexion->query($qryA);
								while ($rowA = $resA->fetch_assoc()){
								?>
								<input type="checkbox" name="alergias[]" value="<?php echo $rowA["_nombre"]; ?>">&nbsp; <?php echo $rowA["_nombre"]; ?>&nbsp; <br>
								<?php } ?>
							</div>
							<div class="form-group col-md-6">
								<label>Auxiliar de Nutrición</label>
								<select name="auxiliar" class="form-control">
									<option value="">elegir uno</option>
									<?php 
									$qryX = "
									SELECT * 
									FROM _usuarios_admin a 
									WHERE 
										(
											status_wua32 = 1 
											AND nivel_wua67 = 'AUXILIAR' 
											AND id_us00 IN (
												SELECT _usuario_id 
												FROM _usuarios_roles u 
												WHERE _usuario_id = a.id_us00 AND _rol = 'TOMA_PEDIDOS' 
											)
										)
										OR id_us00 IN (
											SELECT auxiliar_nutricion 
											FROM _ordenes_medicas  
											WHERE auxiliar_nutricion IS NOT NULL
										)
									";
									$resX = $conexion->query($qryX);
									while ($rowX = $resX->fetch_assoc()){
									?>
									<option value="<?php echo $rowX["id_us00"]; ?>" <?php if($rowX["id_us00"]==$auxiliar){ echo "selected"; } ?>><?php echo $rowX["nombre_us07"]; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-row mt-3">
							<div class="form-group col-md-4"></div>
							<div class="form-group col-md-4">
								<input type="submit" name="submitadd" class="form-control btn text-light" value="agregar orden" style="font-weight: bold; font-size: 14pt; margin-top: 0px; background: #002d59;">
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
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
	// completa datos automaticamente por medio del codigo si el paciente ya existe
	$(document).ready(function() {
		$("#pcodigo").on("blur", function() {
			var codigo = $(this).val();

			if (codigo.trim() !== "") {
			$.ajax({
				url: "validar_paciente.php",
				type: "POST",
				data: { codigo: codigo },
				dataType: "json",
				success: function(response) {
					if (response.existe) {
						$("#pnombre").val(response.pnombre);
						$("#snombre").val(response.snombre);
						$("#papellido").val(response.papellido);
						$("#sapellido").val(response.sapellido);
						$("#medico").val(response.medico);
						$("#otromed").val(response.otromed);
						$("#boxalergias").css("display", "none");
					} 
				},
				error: function() {
				alert("Error al consultar el usuario.");
				}
			});
			}
		});
	});

	// valida campos obligatorios
	$('#formUsuario').submit(function(e) {
		e.preventDefault(); // evita el envío si hay errores

		let errores = [];

		let codigop    = $('#pcodigo').val().trim();
		let dieta      = $('#dieta').val().trim();
		let prnombre   = $('#pnombre').val().trim();
		let prapellido = $('#papellido').val().trim();
		let habitacion = $('#habitacion').val().trim();
		let medico     = $('#medico').val().trim();

		// Limpia errores anteriores
		$('#errores').html('');
		$('input').css('border', '');

		if (dieta === '') {
			errores.push('El campo Tipo de Dieta es obligatorio');
			$('#dieta').css('border', '1px solid red');
			$('.label-dieta').css('color', 'red');
		}

		if (codigop === '') {
			errores.push('El campo Código Paciente es obligatorio');
			$('#pcodigo').css('border', '1px solid red');
			$('.label-codigo').css('color', 'red');
		}

		if (prnombre === '') {
			errores.push('El campo Primer Nombre es obligatorio');
			$('#pnombre').css('border', '1px solid red');
			$('.label-pnombre').css('color', 'red');
		}

		if (prapellido === '') {
			errores.push('El campo Primer Apellido es obligatorio');
			$('#papellido').css('border', '1px solid red');
			$('.label-papellido').css('color', 'red');
		}

		if (habitacion === '') {
			errores.push('El campo Habitación es obligatorio');
			$('#habitacion').css('border', '1px solid red');
			$('.label-habitacion').css('color', 'red');
		}

		if (medico === '') {
			errores.push('El campo Médico Tratante es obligatorio');
			$('#medico').css('border', '1px solid red');
			$('.label-medico').css('color', 'red');
		}

		if (errores.length > 0) {
			$('#errores').html('<ul><li>' + errores.join('</li><li>') + '</li></ul>');
		} else {
			// Si todo está bien, podrías enviar con AJAX o permitir el envío normal
			this.submit(); // o hacer el submit manual
		}
	});

</script>

<?php include("footer.php"); ?>

