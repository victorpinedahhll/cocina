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
						<i class="fa fa-square" style="color: #c0dbf0; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=2" style="color: #000; text-decoration: underline;">En Proceso</a>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-square" style="color: #efe4d6; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=3" style="color: #000; text-decoration: underline;">Enviado a Cocina</a>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-square" style="color: #d4f5d0; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=4" style="color: #000; text-decoration: underline;">Entregado a Auxiliar</a>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-square" style="color: #f8f5e5; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=5" style="color: #000; text-decoration: underline;">Entregado a Paciente</a>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-square" style="color: #f4cccc; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=C" style="color: #000; text-decoration: underline;">Cancelado</a>&nbsp;&nbsp;&nbsp;
					</div>
					<div class="pt-2">
						<div class="row box-menu mb-2" style="background-color: #1366E0 !important;">
							<div class="col-md-1 text-light">
								Fecha
							</div>
							<div class="col-md-2 text-light">
								Nombre Paciente
							</div>
							<div class="col-md-1 text-light">
								Dieta/Menú
							</div>
							<div class="col-md-2 text-light">
								Habitación
							</div>
							<div class="col-md-3 text-light">
								Médico Tratante
							</div>
							<div class="col-md-2 text-light">
								Estado Solicitudes
							</div>
							<div class="col-md-1 text-light text-center">
								
							</div>
						</div>
						<?php 
						// obtengo fecha actual menos 6 horas 
						// que servira para no presentar platos agregados 
						// a ordenes mayores a ese tiempo por cuestion de sessions
						$fecha_vence_orden = strtotime($datenowfull);
						$fecha_vence_orden = strtotime("-6 hours", $fecha_vence_orden);
						$fecha_vence_orden = date ("Y-m-d H:i:s" , $fecha_vence_orden);

						$qEST = "";
						if($_GET["est"]=="1"){
							$qEST = "AND auxiliar_nutricion IS NULL";
						}elseif($_GET["est"]=="2"){
							$qEST = "AND id IN (SELECT idpaciente FROM _pacientes_menu_enlace m WHERE m.idpaciente=o.id AND m.keyunico NOT LIKE 'solicitud%')";
						}elseif($_GET["est"]=="3"){
							$qEST = "AND id IN (SELECT orden_medica FROM _pacientes_solicitudes p WHERE p.orden_medica=o.id AND p.status='0')";
						}elseif($_GET["est"]=="4"){
							$qEST = "AND id IN (SELECT orden_medica FROM _pacientes_solicitudes p WHERE p.orden_medica=o.id AND p.status='1')";
						}elseif($_GET["est"]=="5"){
							$qEST = "AND id IN (SELECT orden_medica FROM _pacientes_solicitudes p WHERE p.orden_medica=o.id AND p.status='2')";
						}elseif($_GET["est"]=="C"){
							$qEST = "AND id IN (SELECT orden_medica FROM _pacientes_solicitudes p WHERE p.orden_medica=o.id AND p.status='C')";
						}

						$qryPac = "
							SELECT *
								, (
									SELECT nombre FROM _tipo_dieta d WHERE d.id = o.dieta
								) AS tdieta 
								, (
									SELECT nombre FROM _tipo_menu m WHERE m.id = o.menu
								) AS tmenu 
								, (
								SELECT nombre FROM _habitaciones h WHERE h.id = o.habitacion
								) AS nhabitacion  
							FROM _ordenes_medicas o 
							WHERE id > 0 $qEST
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

							// // entregada
							// if($entregado){
							// 	$bgitem = "#d9ead3";

							// // en cocina
							// }elseif($resOM->num_rows > 0){
							// 	$bgitem = "#efe4d6";
							
							// // en proceso
							// }elseif($veriOkPP == "SI"){
							// 	$bgitem = "#e1f0ed";

							// // cancelada
							// }elseif($cancelado){
							// 	$bgitem = "#f4cccc";

							// // asigna auxiliar de cocina
							// }elseif($rowPac["auxiliar_nutricion"] > 0){
							// 	$bgitem = "#e1f0ed";
							// }
						?>
						<div class="row box-items" style="background: <?php echo $bgitem; ?>;">
							<div class="col-md-1 pt-0 pl-1">
								Orden # <?php echo $rowPac["id"]; ?>
								<br>
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
							<div class="col-md-2 pt-1 pl-1" style="line-height: 14pt;">
								<?php echo $rowPac["pnombre"]; ?> <?php if(!empty($rowPac["snombre"])) { echo $rowPac["snombre"]; } ?> <?php echo $rowPac["papellido"]; ?> <?php if(!empty($rowPac["sapellido"])) { echo $rowPac["sapellido"]; } ?><br>
								<span style="font-size: 9pt;">código <?php echo $rowPac["codigo"]; ?></span>
							</div>
							<div class="col-md-1 pt-1">
								<?php echo $rowPac["tdieta"]; ?><br>
								<?php echo $rowPac["tmenu"]; ?>
							</div>
							<div class="col-md-2 pt-2">
								<?php echo $rowPac["nhabitacion"]; ?>
							</div>
							<div class="col-md-3 pt-2">
								<?php echo $rowPac["medico_tratante"]; ?>
							</div>
							<div class="col-md-2 pt-2">
								<?php
								// revisa ordenes en proceso		
								$qryPE = "SELECT * FROM _pacientes_menu_enlace WHERE idpaciente = '$idOM' AND keyunico NOT LIKE 'solicitud%' AND actualizacion > '$fecha_vence_orden'";
								$resPE = $conexion->query($qryPE);

								// revisa ordenes sin auxiliar de nutricion asignado
								$qryPE2 = "SELECT * FROM _ordenes_medicas WHERE id = '$idOM' AND auxiliar_nutricion IS NULL";
								$resPE2 = $conexion->query($qryPE2);
								if($resPE2->num_rows > 0){ ?>
										<i class="fa fa-square mr-3" style="font-size: 14pt; color: #ffffff; border: 1px solid #C0C0C0;" title="Sin Asignar"></i>
								<?php 
								}elseif($resPE->num_rows > 0){
									?>
										<i class="fa fa-square mr-3" style="font-size: 14pt; color: #c0dbf0; border: 1px solid #C0C0C0;" title="En Proceso"></i>
								<?php 
								}

								// revisa estado en solicitudes (entregado a cocina, entregado a auxiliar, entregado a paciente y canceladp)
								$qryES = "SELECT * FROM _pacientes_solicitudes WHERE orden_medica = '$idOM'";
								$resES = $conexion->query($qryES);
								if($resES->num_rows > 0){ 
									while ($rowES = $resES->fetch_assoc()){
										if($rowES["status"]=="0"){
											?>
											<i class="fa fa-square mr-3" style="font-size: 14pt; color: #efe4d6; border: 1px solid #C0C0C0;" title="Enviada a Cocina"></i>
											<?php
										}elseif($rowES["status"]=="1"){
											?>
											<i class="fa fa-square mr-3" style="font-size: 14pt; color: #d4f5d0; border: 1px solid #C0C0C0;" title="Entregada a Auxiliar"></i>
											<?php
										}elseif($rowES["status"]=="2"){
											?>
											<i class="fa fa-square mr-3" style="font-size: 14pt; color: #f8f5e5; border: 1px solid #C0C0C0;" title="Entregada a Paciente"></i>
											<?php
										}elseif($rowES["status"]=="C"){
											?>
											<i class="fa fa-square mr-3" style="font-size: 14pt; color: #f4cccc; border: 1px solid #C0C0C0;" title="Cancelada"></i>
											<?php
										}
									} 
								}
								?>
							</div>
							<div class="col-md-1 pt-3 text-center">
								<a href="ordenes_medicas_editar.php?id=<?php echo $rowPac["id"]; ?>" style="color: #000;">
                                    <i class="fa fa-edit"></i>
								</a>
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

