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
					<style>
					.colores {
						margin: 0px 0 7px 0;
						font-size: 10pt;
					}
					</style>
					<div class="colores">
						<b>Identificador:</b>&nbsp; 
						<i class="fa fa-square" style="color: #ffffff; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=1" style="color: #000; text-decoration: underline;">Sin Asignar</a>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-square" style="color: #e1f0ed; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=2" style="color: #000; text-decoration: underline;">En Proceso</a>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-square" style="color: #efe4d6; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=3" style="color: #000; text-decoration: underline;">Enviado a Cocina</a>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-square" style="color: #d9ead3; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=4" style="color: #000; text-decoration: underline;">Entregado</a>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-square" style="color: #f4cccc; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=C" style="color: #000; text-decoration: underline;">Cancelado</a>&nbsp;&nbsp;&nbsp;
					</div>
					<div class="pt-2">
						<div class="row box-menu mb-2">
							<div class="col-md-2">
								Fecha Ingreso
							</div>
							<div class="col-md-3">
								Nombre Paciente
							</div>
							<div class="col-md-2">
								Tipo Dieta
							</div>
							<div class="col-md-2">
								Habitación
							</div>
							<div class="col-md-3">
								Médico Tratante
							</div>
						</div>
						<?php 
						//$qryPac = "SELECT * FROM _ordenes_medicas a WHERE a.id in (select id_paciente from _pacientes_solicitudes b WHERE a.id=b.id_paciente and b.status<'2') and a.status='A' ORDER by a.fecha_ingreso";
						$qryPac = "
							SELECT *, (
								SELECT nombre FROM _tipo_dieta d WHERE d.id = o.dieta
							) AS tdieta  
							FROM _ordenes_medicas o 
							ORDER by status,fecha_ingreso";
						$rsPac  = $conexion->query($qryPac);
						while ($rowPac = $rsPac->fetch_assoc()){

							$idOM  = $rowPac["id"];

							// reviso si existe solicitud para la orden medica para colocar estado de enviado a cocina
							$qryEC = "SELECT * FROM _pacientes_solicitudes WHERE orden_medica = '$idOM'";
							$resOM = $conexion->query($qryEC);

							// reviso si existe un pedido en proceso para la orden medica para colocar estado de En Proceso
							$veriOkPP = "NO";
							$qryPP = "SELECT * FROM _pacientes_menu_enlace WHERE idpaciente = '$idOM'";
							$resPP = $conexion->query($qryPP);
							if($resPP->num_rows > 0){
								while ($rowPP = $resPP->fetch_assoc()){
									if( substr($rowPP["keyunico"],0,9) !== "solicitud" ){
										$veriOkPP = "SI";
										break;
									}
								}
							}

							$bgitem = "#ffffff";

							// entregada
							if($entregado){
								$bgitem = "#d9ead3";

							// en cocina
							}elseif($resOM->num_rows > 0){
								$bgitem = "#efe4d6";
							
							// en proceso
							}elseif($veriOkPP == "SI"){
								$bgitem = "#e1f0ed";

							// cancelada
							}elseif($cancelado){
								$bgitem = "#f4cccc";

							// asigna auxiliar de cocina
							}elseif($rowPac["auxiliar_nutricion"] > 0){
								$bgitem = "#e1f0ed";
							}
						?>
						<div class="row box-items" style="background: <?php echo $bgitem; ?>;">
							<div class="col-md-2 pt-1 pl-1">
								<a href="ordenes_medicas_editar.php?id=<?php echo $rowPac["id"]; ?>" style="text-decoration: underline;">
									Orden # <?php echo $rowPac["id"]; ?>
								</a><br>
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
							<div class="col-md-3 pt-2 pl-1" style="line-height: 14pt;">
								<?php echo $rowPac["pnombre"]; ?> <?php if(!empty($rowPac["snombre"])) { echo $rowPac["snombre"]; } ?> <?php echo $rowPac["papellido"]; ?> <?php if(!empty($rowPac["sapellido"])) { echo $rowPac["sapellido"]; } ?><br>
								<span style="font-size: 9pt;">código <?php echo $rowPac["codigo"]; ?></span>
							</div>
							<div class="col-md-2 pt-2">
								<?php echo $rowPac["tdieta"]; ?>
							</div>
							<div class="col-md-2 pt-2">
								<?php echo $rowPac["habitacion"]; ?>
							</div>
							<div class="col-md-3 pt-2">
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

