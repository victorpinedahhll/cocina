<?php
$titulo = "Pacientes";
$nologg = "SI";
$page   = "pacientes";
$areaLg = "PACIENTES";  // valida roles del usuario

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
					
						<div class="row box-menu mb-2">
							<div class="col-md-2">
								Fecha Ingreso
							</div>
							<div class="col-md-1">
								Código
							</div>
							<div class="col-md-2">
								Nombre Paciente
							</div>
							<div class="col-md-3">
								Médico Tratante
							</div>
							<div class="col-md-3">
								Alergias
							</div>
							<div class="col-md-1 text-center">
								Estado
							</div>
						</div>
						<?php 
						//$qryPac = "SELECT * FROM _pacientes a WHERE status='A' and id not in (select id_paciente from _pacientes_solicitudes b where b.id_paciente=a.id) ORDER by fecha_ingreso";
						$qryPac = "SELECT * FROM _pacientes a ORDER by fecha_ingreso";
						$rsPac  = $conexion->query($qryPac);
						while ($rowPac = $rsPac->fetch_assoc()){
							$bgcolor = "#ffffff";
							if($rowPac["status"]=="I"){
								$bgcolor = "#fbe4e4";
							}
						?>
						<div class="row box-items py-2" style="background-color: <?php echo $bgcolor; ?>;">
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
							<div class="col-md-1 pl-0">
								<?php echo $rowPac["codigo"]; ?>
							</div>
							<div class="col-md-2 pl-0">
								<a href="pacientes_editar.php?id=<?php echo $rowPac["id"]; ?>" style="text-decoration: underline;">
									<?php echo $rowPac["pnombre"]; ?> <?php if(!empty($rowPac["snombre"])) { echo $rowPac["snombre"]; } ?> <?php echo $rowPac["papellido"]; ?> <?php if(!empty($rowPac["sapellido"])) { echo $rowPac["sapellido"]; } ?>
								</a>
							</div>
							<div class="col-md-3">
								<?php echo $rowPac["medico_tratante"]; ?>
							</div>
							<div class="col-md-3">
								<?php
								$cod_pac = $rowPac["codigo"]; 
								$qryAl = "SELECT _alergia FROM _pacientes_alergias WHERE _paciente_cod = '$cod_pac'";
								$resAl = $conexion->query($qryAl);
								if($resAl->num_rows > 0){
									while ($rowAl = $resAl->fetch_assoc()){
										echo $rowAl["_alergia"].", "; 
									}
								}else{
									echo "Ninguna";
								}
								?>
							</div>
							<div class="col-md-1 text-center">
								<?php 
								if($rowPac["status"]=="I"){ echo "Inactivo"; }else{ echo "Activo"; } ?>
							</div>
						</div>
						<?php } ?>
					
				</div>
			</div>
		</div>
	</div>
</div>

<?php include("footer.php"); ?>

