<?php
$titulo = "Pacientes Pacientes";
$nologg = "SI";
$page   = "pedidos";
$areaLg = "PEDIDOS";  // valida roles del usuario

include("header.php");
?>
<style>
	.content-text {
		margin: 160px 21px 0 21px;
	}
</style>

<div class="row pt-0 mb-4">
	<div class="col-md-12 content-box position-relative">

		<div class="container" style="margin-top: 175px;">
			<div class="row">
				<div class="col-md-12">
					<div class="box-admin-opt pt-3">
						<div class="row bg-secondary mb-3 py-1 text-light" style="font-weight: bold;">
							<div class="col-md-2">
								Fecha Ingreso
							</div>
							<div class="col-md-3">
								Nombre Paciente
							</div>
							<div class="col-md-3 hidden-max-991">
								Habitación
							</div>
							<div class="col-md-4">
								Médico Tratante
							</div>
						</div>
						<?php 
						//$qryPac = "SELECT * FROM _pacientes_activos a WHERE status='A' and id not in (select id_paciente from _pacientes_solicitudes b where b.id_paciente=a.id) ORDER by fecha_ingreso";
						$qryPac = "SELECT * FROM _pacientes_activos a WHERE status='A' ORDER by fecha_ingreso";
						$rsPac  = $conexion->query($qryPac);
						while ($rowPac = $rsPac->fetch_assoc()){
						?>
						<div class="row py-2">
							<div class="col-md-2">
								<?php
								$fecha = strtotime($rowPac["fecha_ingreso"]);
								$diaP  = date("d",$fecha);
								$mesP  = date("m",$fecha);
								$anoP  = date("Y",$fecha);

								if($mesP=="1"){ $mesN = "Ene"; }
								if($mesP=="2"){ $mesN = "Feb"; }
								if($mesP=="3"){ $mesN = "Mar"; }
								if($mesP=="4"){ $mesN = "Abr"; }
								if($mesP=="5"){ $mesN = "May"; }
								if($mesP=="6"){ $mesN = "Jun"; }
								if($mesP=="7"){ $mesN = "Jul"; }
								if($mesP=="8"){ $mesN = "Ago"; }
								if($mesP=="9"){ $mesN = "Sep"; }
								if($mesP=="10"){ $mesN = "Oct"; }
								if($mesP=="10"){ $mesN = "Nov"; }
								if($mesP=="12"){ $mesN = "Dic"; }

								echo $diaP."/".$mesN."/".$anoP; ?>
							</div>
							<div class="col-md-3">
								<a href="pacientes_formulario.php?id=<?php echo $rowPac["id"]; ?>" style="text-decoration: underline;">
									<?php echo $rowPac["pnombre"]; ?> <?php if(!empty($rowPac["snombre"])) { echo $rowPac["snombre"]; } ?> <?php echo $rowPac["papellido"]; ?> <?php if(!empty($rowPac["sapellido"])) { echo $rowPac["sapellido"]; } ?>
								</a>
							</div>
							<div class="col-md-3 hidden-max-991">
								<?php echo $rowPac["habitacion"]; ?>
							</div>
							<div class="col-md-4">
								<?php echo $rowPac["medico_tratante"]; ?>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include("footer.php"); ?>

