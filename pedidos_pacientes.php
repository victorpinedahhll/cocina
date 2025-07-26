<?php
$titulo = "Pedidos a Pacientes";
$nologg = "SI";
$page   = "pedidos";
$areaLg = "TOMA_PEDIDOS";  // valida roles del usuario

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
					<style>
					.colores {
						margin: 0px 0 7px 0;
						font-size: 10pt;
					}
					</style>
					<div class="colores">
						<b>Identificador:</b>&nbsp; 
						<i class="fa fa-square" style="color: #ffffff; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=1" style="color: #000; text-decoration: underline;">Sin Asignar</a>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-square" style="color: #e0e0e0; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=2" style="color: #000; text-decoration: underline;">En Proceso</a>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-square" style="color: #d9ead3; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=3" style="color: #000; text-decoration: underline;">Finalizado</a>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-square" style="color: #f4cccc; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=C" style="color: #000; text-decoration: underline;">Cancelado</a>&nbsp;&nbsp;&nbsp;
					</div>
					<div class="pt-2">
						<div class="row box-menu mb-2">
							<div class="col-md-1">
								Fecha
							</div>
							<div class="col-md-2">
								Habitación
							</div>
							<div class="col-md-2">
								Nombre Paciente
							</div>
							<div class="col-md-2">
								Tipo Dieta
							</div>
							<div class="col-md-3">
								Médico Tratante
							</div>
							<div class="col-md-2">
								Auxiliar de Nutrición
							</div>
						</div>
						<?php 
						//$qryPac = "SELECT * FROM _ordenes_medicas a WHERE status='A' and id not in (select id_paciente from _pacientes_solicitudes b where b.id_paciente=a.id) ORDER by fecha_ingreso";
						$qryPac = "
							SELECT *, (
								SELECT nombre FROM _tipo_dieta d WHERE d.id = a.dieta
							) AS tdieta 
							, (
								SELECT nombre_us07 FROM _usuarios_admin u WHERE u.id_us00 = a.auxiliar_nutricion
							) AS auxiliarn 
							FROM _ordenes_medicas a 
							WHERE status='A' ORDER by fecha_ingreso";
						$rsPac  = $conexion->query($qryPac);
						while ($rowPac = $rsPac->fetch_assoc()){
						?>
						<div class="row box-items">
							<div class="col-md-1 pl-0">
								Orden # <?php echo $rowPac["id"]; ?><br>
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

								$fechaO = $diaP."/".$mesN."/".$anoP;
								?>
								<span style="font-size: 9pt;"><?php echo $fechaO; ?></span>
							</div>
							<div class="col-md-2 pt-2">
								<?php echo $rowPac["habitacion"]; ?>
							</div>
							<div class="col-md-2" style="line-height: 14pt;">
								<a href="pedidos_formulario.php?id=<?php echo $rowPac["id"]; ?>" style="text-decoration: underline;">
									<?php echo $rowPac["pnombre"]; ?> <?php if(!empty($rowPac["snombre"])) { echo $rowPac["snombre"]; } ?> <?php echo $rowPac["papellido"]; ?> <?php if(!empty($rowPac["sapellido"])) { echo $rowPac["sapellido"]; } ?>
								</a><br>
								<span style="font-size: 9pt;">código <?php echo $rowPac["codigo"]; ?></span>
							</div>
							<div class="col-md-2 pt-2">
								<?php echo $rowPac["tdieta"]; ?>
							</div>
							<div class="col-md-3 pt-2">
								<?php echo $rowPac["medico_tratante"]; ?>
							</div>
							<div class="col-md-2 pt-2">
								<?php if($rowPac["auxiliar_nutricion"] > 0){ echo $rowPac["auxiliarn"]; }else{ echo "Aún NO asignado"; } ?>
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

