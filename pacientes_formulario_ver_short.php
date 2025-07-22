<?php
$titulo = "Solicitudes Cocina";
$nologg = "SI";
$page   = "solicitud";

include("header.php");

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
$medico     = $rowPac["medico_tratante"];
$mediconombre  = $rowPac["medico_nombre"];
$medicootro  = $rowPac["medico_otro"];
$observaciones = $rowPac["observaciones"];
$status  = $rowPac["status"];
$codigo  = $rowPac["codigo"];
$motivo  = $rowPac["motivo"];
$keyForm = "solicitud".$rowPac["id"];

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
					<div class="mb-3 h4-sidebar-nobg text-center bg-warning text-dark" style="height: 43px; font-size: 16pt; padding-top: 2px;">
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
			<?php if($status<"2"){ ?>
			<form id="form-prueba" action="pacientes_formulario_cocina.php" method="POST" autocomplete="off">
			<input type="hidden" name="idsol" id="idsol" value="<?php echo $idSol; ?>">
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
			<div class="row mb-3">
				<div class="col-md-12">
					<div class="box-admin-opt p-3 pb-0" style="background: #002d59; color: #fff; padding-bottom: 0px !important; box-shadow: 5px 10px 10px -10px #333333;">
						<div class="form-row">
							<div class="form-group col">
								<label>Nombre Paciente</label><br>
								<?php echo $pnombre; ?> <?php echo $snombre; ?> <?php echo $papellido; ?> <?php echo $sapellido; ?>
							</div>
							<div class="form-group col">
								<label>Habitacion/Cama *</label><br>
								<?php echo $habitacion; ?>
							</div>
							<div class="form-group col">
								<label>Médico tratante *</label><br>
								<?php
								$qryM2 = "SELECT * FROM web_medicos WHERE status_med37='A' and colegiado_med35  > '0' and cod_med12='$medico'";
								$rsM2 = $conexion2->query($qryM2);
								$rowM2 = $rsM2->fetch_assoc();
								?>
								<?php echo $rowM2["primer_apellido_med29"]; ?> <?php if(!empty($rowM2["segundo_apellido_med37"])){ echo $rowM2["segundo_apellido_med37"]; } ?>, <?php echo $rowM2["primer_nombre_med18"]; ?> <?php if(!empty($rowM2["segundo_nombre_med22"])){ echo $rowM2["segundo_nombre_med22"]; } ?>
							</div>
							<div class="form-group col">
								<label>Fecha Ingreso</label><br>
								<?php echo $dateEmail; ?>
							</div>
							<div class="form-group col-1 text-right">
								<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal">
									<i class="fa fa-plus"></i>
								</button>
								<!-- Modal -->
								<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header bg-info">
								        <h5 class="modal-title text-light" id="exampleModalLabel"><b>Código paciente:</b> <?php echo $codigo; ?></h5>
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								          <span aria-hidden="true">&times;</span>
								        </button>
								      </div>
								      <div class="modal-body text-dark pb-5 text-left">
								      	<b>Motivo ingreso</b><br>
								        <?php echo $motivo; ?>
								      </div>
								    </div>
								  </div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-4">
					<div class="box-admin-opt">
						<h5 class="mt-0 mb-2 bg-info text-light text-center p-3" style="border-radius: 4px;">Menú elegido</h5>
						
						<?php 
						$query = "SELECT *, (select nombre from _menus_opciones o where o.id=p.idopcionmenu) as nmopt, (select nombre from _menus m where m.id in (select idmenu from _menus_opciones o where o.idmenu=m.id and p.idopcionmenu=o.id)) as nmmenu, (select nombre from _programaciones c where c.id=p.idprogra) as nprogra FROM _pacientes_menu_enlace p WHERE p.keyunico='$keyForm' ORDER by idprogra";
  						$result = $conexion->query($query);
  						while ($rowquer = $result->fetch_assoc()){
						?>
						<div class='row pt-1 pb-1' style="border-bottom: 1px dotted #C0C0C0;">
	                      <div class='col'><b><?php echo $rowquer["nprogra"]; ?></b><br><?php echo $rowquer["nmmenu"]; ?> (<?php echo $rowquer["nmopt"]; ?>)</div>
	                    </div>
	                	<?php } ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box-admin-opt">
						<h5 class="mt-0 mb-2 bg-info text-light text-center p-3" style="border-radius: 4px;">Observaciones</h5>

						<div class="row mt-3 pb-4">
							<div class="col-md-12">
								<textarea name="observaciones" id="observaciones" rows="4" class="form-control"<?php if($status=="2"){ ?>disabled<?php } ?>><?php echo $observaciones; ?></textarea>
							</div>
						</div>
						<?php if($status<"2"){ ?>
						<input type="submit" name="submitfinal" class="form-control btn bg-success text-light" value="solicitud finalizada" style="font-weight: bold; text-shadow: 0px 1px 1px #1d527d; font-size: 18pt; margin-top: 15px;">
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

