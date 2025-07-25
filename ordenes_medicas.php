<?php
$titulo = "Ordenes Médicas";   // titulo de la pagina
$nologg = "SI";
$page   = "ordenes";   // identifica pagina para scripts, etc
$areaLg = "ORDENES"; // valida roles del usuario

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
						<div class="row bg-secondary mb-3 py-1 text-light" style="font-weight: bold;">
							<div class="col-md-2">
								Fecha Ingreso
							</div>
							<div class="col-md-2">
								Código Paciente
							</div>
							<div class="col-md-3">
								Nombre Paciente
							</div>
							<div class="col-md-2 hidden-max-991">
								Habitación
							</div>
							<div class="col-md-3">
								Médico Tratante
							</div>
						</div>
						<?php 
						//$qryPac = "SELECT * FROM _ordenes_medicas a WHERE a.id in (select id_paciente from _pacientes_solicitudes b WHERE a.id=b.id_paciente and b.status<'2') and a.status='A' ORDER by a.fecha_ingreso";
						$qryPac = "SELECT * FROM _ordenes_medicas ORDER by status,fecha_ingreso";
						$rsPac  = $conexion->query($qryPac);
						while ($rowPac = $rsPac->fetch_assoc()){
						?>
						<div class="row py-2" <?php if($rowPac["status"]=="I"){ ?>style="background: #fbe0e2;"<?php } ?>>
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
								<?php if($rowPac["status"]=="I"){ ?><br><span class="text-danger" style="font-size: 9pt;">Inactivo</span><?php } ?>
							</div>
							<div class="col-md-2">
								<?php echo $rowPac["codigo"]; ?>
							</div>
							<div class="col-md-3">
								<a href="ordenes_medicas_editar.php?id=<?php echo $rowPac["id"]; ?>" style="text-decoration: underline;">
									<?php echo $rowPac["pnombre"]; ?> <?php if(!empty($rowPac["snombre"])) { echo $rowPac["snombre"]; } ?> <?php echo $rowPac["papellido"]; ?> <?php if(!empty($rowPac["sapellido"])) { echo $rowPac["sapellido"]; } ?>
								</a>
							</div>
							<div class="col-md-2 hidden-max-991">
								<?php echo $rowPac["habitacion"]; ?>
							</div>
							<div class="col-md-3">
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

<script>
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

