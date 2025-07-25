<?php
$titulo = "Pedidos Cocina";
$nologg = "SI";
$page   = "solicitud";
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

		<div class="px-5" style="margin-top: 175px;">
			<div class="row">
				<div class="col-md-12">
					<div class="box-admin-opt pt-3">
						<div class="row bg-secondary text-light" style="height: 27px; font-weight: bold;">
							<div class="col-md-2">
								Fecha Ingreso
							</div>
							<div class="col-md-2">
								Código Paciente
							</div>
							<div class="col-md-3">
								Nombre Paciente
							</div>
							<div class="col-md-2">
								Habitación
							</div>
							<div class="col-md-2">
								Médico Tratante
							</div>
							<div class="col-md-1">
								&nbsp;
							</div>
						</div>
						<?php 
						$qryPac = "SELECT * FROM _pacientes_solicitudes WHERE status > '0' ORDER by fecha_ingreso";
						$rsPac  = $conexion->query($qryPac);
						while ($rowPac = $rsPac->fetch_assoc()){
							$bgcolor = "transparent";
							if($rowPac["status"]=="1"){
								$bgcolor = "#faf6cb";
							}elseif($rowPac["status"]=="2"){
								$bgcolor = "#d9fbd8";
							}
						?>
						<div class="row py-2" style="background: <?php echo $bgcolor; ?>">
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
							<div class="col-md-2">
								<?php echo $rowPac["codigo"]; ?>
							</div>
							<div class="col-md-3">
								<a href="pacientes_formulario_ver.php?sol=<?php echo $rowPac["id"]; ?>" style="text-decoration: underline;">
									<?php echo $rowPac["pnombre"]; ?> <?php echo $rowPac["papellido"]; ?>
								</a>
							</div>
							<div class="col-md-2 hidden-max-991">
								<?php echo $rowPac["habitacion"]; ?>
							</div>
							<div class="col-md-2">
								Dr. <?php
								if($rowPac["medico_tratante"]!="999999"){
									echo $rowPac["medico_nombre"];
								}elseif($rowPac["medico_tratante"]=="999999"){
									echo $rowPac["medico_otro"];
								}
								?>
							</div>
							<div class="col-md-1">
								<a href="#" onClick="window.open('solicitudes_imprimir.php?sol=<?php echo $rowPac["id"];?>','mywindow','width=700,height=800,scrollbars=no,status=yes')"><i class="fa fa-print btn btn-warning"></i></a>
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

