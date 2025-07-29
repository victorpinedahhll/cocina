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
					<style>
					.colores {
						margin: 0px 0 7px 0;
						font-size: 10pt;
					}
					</style>
					<div class="colores">
						<b>Identificador:</b>&nbsp; 
						<i class="fa fa-square" style="color: #ffffff; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=0" style="color: #000; text-decoration: underline;">En Proceso</a>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-square" style="color: #d9ead3; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=1" style="color: #000; text-decoration: underline;">Entregado a Auxiliar</a>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-square" style="color: #f8f5e5; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=3" style="color: #000; text-decoration: underline;">Entregado a Paciente</a>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-square" style="color: #f4cccc; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=C" style="color: #000; text-decoration: underline;">Cancelado</a>&nbsp;&nbsp;&nbsp;
					</div>
					<div class="pt-2">
						<div class="row box-menu mb-2" style="background: #1366e0;">
							<div class="col-md-2" style="color: #fff !important;">
								Fecha Ingreso
							</div>
							<div class="col-md-2" style="color: #fff !important;">
								Nombre Paciente
							</div>
							<div class="col-md-2" style="color: #fff !important;">
								Solicitante
							</div>
							<div class="col-md-2" style="color: #fff !important;">
								Habitación
							</div>
							<div class="col-md-3" style="color: #fff !important;">
								Médico Tratante
							</div>
							<div class="col-md-1" style="color: #fff !important;">
								&nbsp;
							</div>
						</div>
						<?php 
						$qryPac = "
							SELECT *, (
									SELECT nombre FROM _tipo_dieta d WHERE d.id = a.dieta
								) AS tdieta 
							FROM _pacientes_solicitudes a 
							ORDER by fecha_ingreso
						";
						$rsPac  = $conexion->query($qryPac);
						while ($rowPac = $rsPac->fetch_assoc()){
							$bgitem = "#ffffff";
							if($rowPac["status"]=="1"){
								$bgitem = "#d9ead3";
							}elseif($rowPac["status"]=="2"){
								$bgitem = "#f8f5e5";
							}elseif($rowPac["status"]=="C"){
								$bgitem = "#f4cccc";
							}
						?>
						<div class="row box-items" style="background: <?php echo $bgitem; ?>;">
							<div class="col-md-2 pt-0 pl-1">
								Orden # <?php echo $rowPac["orden_medica"]; ?> / 
								<a href="cocina_editar.php?id=<?php echo $rowPac["id"]; ?>" style="text-decoration: underline; color: #000;">
									Pedido <?php echo $rowPac["id"]; ?>
								</a><br>
								<span style="font-size: 9pt;">
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
								</span>
								<?php if($rowPac["status"]=="I"){ ?><br><span class="text-danger" style="font-size: 9pt;">Inactivo</span><?php } ?>
							</div>
							<div class="col-md-2 pt-2 pl-1" style="line-height: 14pt;">
								<?php echo $rowPac["pnombre"]; ?> <?php if(!empty($rowPac["snombre"])) { echo $rowPac["snombre"]; } ?> <?php echo $rowPac["papellido"]; ?> <?php if(!empty($rowPac["sapellido"])) { echo $rowPac["sapellido"]; } ?><br>
								<span style="font-size: 9pt;">código <?php echo $rowPac["codigo"]; ?></span>
							</div>
							<div class="col-md-2 pt-2">
								<?php if($rowPac["paciente"]=="SI"){ echo "Paciente"; }elseif($rowPac["paciente"]=="NO"){ echo "Visitante"; } ?>
							</div>
							<div class="col-md-2 pt-2">
								<?php echo $rowPac["habitacion"]; ?>
							</div>
							<div class="col-md-3 pt-2">
								<?php echo $rowPac["medico_nombre"]; ?>
							</div>
							<div class="col-md-1 pt-2">
								<a href="#" onClick="window.open('solicitudes_imprimir.php?sol=<?php echo $rowPac["id"];?>','mywindow','width=700,height=800,scrollbars=no,status=yes')"><i class="fa fa-print btn" style="background: #e6e6e6; color: #3e3e3e;"></i></a>
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

