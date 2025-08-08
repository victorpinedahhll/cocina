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
						<b>Estados:</b>&nbsp; 
						<?php if($nvsession!="AUXILIAR"){ ?>
						<i class="fa fa-square d-none" style="color: #ffffff; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=1" style="color: #000; text-decoration: underline;">Sin Asignar</a>&nbsp;&nbsp;&nbsp;
						<?php } ?>
						<i class="fa fa-square d-none" style="color: #c0dbf0; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=2" style="color: #000; text-decoration: underline;">En Proceso</a>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-square d-none" style="color: #efe4d6; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=3" style="color: #000; text-decoration: underline;">Enviado a Cocina</a>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-square d-none" style="color: #d4f5d0; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=4" style="color: #000; text-decoration: underline;">Entregado a Auxiliar</a>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-square d-none" style="color: #f8f5e5; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=5" style="color: #000; text-decoration: underline;">Entregado a Paciente</a>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-square d-none" style="color: #f4cccc; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=C" style="color: #000; text-decoration: underline;">Cancelado</a>&nbsp;&nbsp;&nbsp;
					</div>
					<div class="pt-2">
						<div class="row box-menu mb-2" style="background-color: #1366E0 !important">
							<div class="col-md-1 text-light">
								Fecha
							</div>
							<div class="col-md-2 text-light">
								Habitación / Tipo Dieta
							</div>
							<div class="col-md-2 text-light">
								Nombre Paciente
							</div>
							<div class="col-md-2 text-light">
								Médico Tratante
							</div>
							<div class="col-md-2 text-light">
								Auxiliar de Nutrición
							</div>
							<div class="col-md-3 text-center text-light">
								Pedido a
							</div>
						</div>
						<?php
						$qryNV = "";
						if($nvsession=="AUXILIAR"){
							$qryNV = "AND auxiliar_nutricion = '$idsession'";
						}

						$qEST = "";
						if($_GET["est"]=="1"){
							$qEST = "AND auxiliar_nutricion IS NULL";
						}elseif($_GET["est"]=="2"){
							$qEST = "AND id IN (SELECT idpaciente FROM _pacientes_menu_enlace m WHERE m.idpaciente=a.id AND m.keyunico NOT LIKE 'solicitud%')";
						}elseif($_GET["est"]=="3"){
							$qEST = "AND id IN (SELECT orden_medica FROM _pacientes_solicitudes p WHERE p.orden_medica=a.id AND p.status='0')";
						}elseif($_GET["est"]=="4"){
							$qEST = "AND id IN (SELECT orden_medica FROM _pacientes_solicitudes p WHERE p.orden_medica=a.id AND p.status='1')";
						}elseif($_GET["est"]=="5"){
							$qEST = "AND id IN (SELECT orden_medica FROM _pacientes_solicitudes p WHERE p.orden_medica=a.id AND p.status='2')";
						}elseif($_GET["est"]=="C"){
							$qEST = "AND id IN (SELECT orden_medica FROM _pacientes_solicitudes p WHERE p.orden_medica=a.id AND p.status='C')";
						}

						//$qryPac = "SELECT * FROM _ordenes_medicas a WHERE status='A' and id not in (select id_paciente from _pacientes_solicitudes b where b.id_paciente=a.id) ORDER by fecha_ingreso";
						$qryPac = "
							SELECT *
								, (
									SELECT nombre FROM _tipo_dieta d WHERE d.id = a.dieta
								) AS tdieta 
								, (
									SELECT nombre_us07 FROM _usuarios_admin u WHERE u.id_us00 = a.auxiliar_nutricion
								) AS auxiliarn 
								, (
									SELECT nombre FROM _habitaciones h WHERE h.id = a.habitacion
								) AS nhabitacion 
								, (
									SELECT area FROM _habitaciones h WHERE h.id = a.habitacion
								) AS narea 
							FROM _ordenes_medicas a 
							WHERE status='A' $qryNV $qEST  
							ORDER by fecha_ingreso";
						$rsPac  = $conexion->query($qryPac);
						while ($rowPac = $rsPac->fetch_assoc()){

							$idOM  = $rowPac["id"];

							// reviso si el pedido ya fue entregado a paciente
							$qEstp = "SELECT * FROM _pacientes_solicitudes WHERE orden_medica = '$idOM' AND status = '2'";
							$rEstp = $conexion->query($qEstp);

							// reviso si el pedido ya fue entregado por cocina a auxiliar
							$qEstc = "SELECT * FROM _pacientes_solicitudes WHERE orden_medica = '$idOM' AND status = '1'";
							$rEstc = $conexion->query($qEstc);

							// reviso si el pedido ya fue enviado a cocina
							$qryEC = "SELECT * FROM _pacientes_solicitudes WHERE orden_medica = '$idOM' AND status = '0'";
							$resOM = $conexion->query($qryEC);

							// reviso si ya se agregaron platos a una orden medica sin enviar a cocina
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

							// reviso si la orden medica ya se le asigno un auxiliar de nutricion
							$qEstOm = "SELECT * FROM _ordenes_medicas WHERE id = '$idOM' AND auxiliar_nutricion IS NULL";
							$rEstOm = $conexion->query($qEstOm);

							$bgitem = "#ffffff";

							// // orden sin asignar auxiliar de nutricion
							// if($rEstOm->num_rows > 0){
							// 	$bgitem = "#ffffff";

							// // entregada a paciente
							// }elseif($rEstp->num_rows > 0){
							// 	$bgitem = "#f8f5e5";

							// // entregada por cocina a auxiliar de nutricion
							// }elseif($rEstc->num_rows > 0){
							// 	$bgitem = "#d9ead3";

							// // en cocina
							// }elseif($resOM->num_rows > 0 && $veriOkPP == "NO"){
							// 	$bgitem = "#efe4d6";
							
							// // en proceso
							// }elseif($veriOkPP == "SI"){
							// 	$bgitem = "#c0dbf0";

							// // cancelada
							// }elseif($cancelado){
							// 	$bgitem = "#f4cccc";

							// // asigna auxiliar de cocina
							// }elseif($rowPac["auxiliar_nutricion"] > 0){
							// 	$bgitem = "#e1f0ed";
							// }
						?>
						<div class="row box-items" style="background: <?php echo $bgitem; ?>;">
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
							<div class="col-md-2 pt-1">
								<?php echo $rowPac["nhabitacion"]; ?><br>
								Dieta: <b><?php echo $rowPac["tdieta"]; ?></b>
							</div>
							<div class="col-md-2 pt-1" style="line-height: 14pt;">
								<?php echo $rowPac["pnombre"]; ?> <?php if(!empty($rowPac["snombre"])) { echo $rowPac["snombre"]; } ?> <?php echo $rowPac["papellido"]; ?> <?php if(!empty($rowPac["sapellido"])) { echo $rowPac["sapellido"]; } ?><br>
								Código: <?php echo $rowPac["codigo"]; ?>
							</div>
							<div class="col-md-2 pt-1">
								<?php echo $rowPac["medico_tratante"]; ?>
							</div>
							<div class="col-md-2 pt-2">
								<?php if ($nvsession == "ADMIN" || $nvsession == "COCINA"){ ?>
								<a href="#" data-toggle="modal" data-target="#modalAsignar<?php echo $idOM; ?>">
									<?php 
									if($rowPac["auxiliar_nutricion"] > 0){ 
										echo $rowPac["auxiliarn"]; 
									}else{ 
										echo "<b style='color: red;'>Aún NO asignado</b>"; 
									} ?>
								</a>
								<?php }else{ ?>
									<?php 
									if($rowPac["auxiliar_nutricion"] > 0){ 
										echo $rowPac["auxiliarn"]; 
									}else{ 
										echo "Aún NO asignado"; 
									} ?>
								<?php } ?>
								<!-- Modal -->
								<div class="modal fade" id="modalAsignar<?php echo $idOM; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<form action="pedidos_asignar.php" method="POST" class="mt-3">
										<input type="hidden" name="asignar"  value="SI">
										<input type="hidden" name="id"       value="<?php echo $idOM; ?>">
										<div class="modal-content">
											<div class="modal-header" style="background: #002d59;">
												<h5 class="modal-title text-light" id="exampleModalLabel">Orden # <?php echo $rowPac["id"]; ?></h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<h4><?php echo $rowPac["pnombre"]; ?> <?php if(!empty($rowPac["snombre"])) { echo $rowPac["snombre"]; } ?> <?php echo $rowPac["papellido"]; ?> <?php if(!empty($rowPac["sapellido"])) { echo $rowPac["sapellido"]; } ?></h4>
												<b>Dieta: <?php echo $rowPac["tdieta"]; ?></b>
												<div class="row mb-4 mt-3">
													<div class="col-md-12">
														<select name="auxiliar" class="form-control" style="padding: 4px 8px; background: #ffffff;">
															<option value="">elegir uno</option>
															<?php
															$area_aux = $rowPac["narea"]; 
															$qryX = "
															SELECT * 
															FROM _usuarios_admin a 
															WHERE 
																status_wua32 = 1 
																AND nivel_wua67 = 'AUXILIAR' 
																AND id_us00 IN (
																	SELECT _usuario_id 
																	FROM _usuarios_roles u 
																	WHERE _usuario_id = a.id_us00 AND _rol = 'TOMA_PEDIDOS' 
																)
																AND id_us00 IN (
																	SELECT id_aux 
																	FROM _auxiliar_asignaciones c 
																	WHERE c.id_aux = a.id_us00 
																	AND c.status = 'A' 
																	AND c.id_area = '$area_aux' 
																	AND '$datenow' BETWEEN fecha_inicio AND fecha_final 
																)
															";
															
															$resX = $conexion->query($qryX);
															if($resX->num_rows > 0){
																while ($rowX = $resX->fetch_assoc()){
																?>
																<option value="<?php echo $rowX["id_us00"]; ?>" <?php if($rowX["id_us00"]==$rowPac["auxiliar_nutricion"]){ echo "selected"; } ?>><?php echo $rowX["nombre_us07"]; ?></option>
																<?php } ?>
															<?php }else{ ?>
																<option value="">No hay auxiliares de nutricion para esta area</option>
															<?php } ?>
														</select>
													</div>
												</div>
												
												<input type="submit" value="asignar" class="btn" style="background: #002d59; color: #fff;">
											</div>
										</div>
										</form>
									</div>
								</div>
							</div>
							<div class="col-md-3 pt-0">
								<?php
								if($rowPac["auxiliar_nutricion"] > 0){
									$cvisitantes = 1; 
									// cuento cuantas solicitudes de visitantes existen
									$id_pac = $rowPac["id"];
									$qryVE = "SELECT * FROM _pacientes_solicitudes WHERE orden_medica = $id_pac AND paciente = 'NO'";
									$resVE = $conexion->query($qryVE);
									while ($rowVE = $resVE->fetch_assoc()){
										$cvisitantes++;
									}
								?>
								<div class="row">
									<div class="col-4 px-2 position-relative">
										<?php 
										$qPP = "SELECT * FROM _pacientes_menu_enlace WHERE idpaciente = '$idOM' AND keyunico NOT LIKE 'solicitud%' AND paciente = 'SI'";
										$rPP = $conexion->query($qPP);
										if($rPP->num_rows > 0){
										?>
										<div style="position: absolute; top: -4px; right: 20px; background: red; width: 10px; height: 10px; border-radius: 25px;"></div>
										<?php } ?>
										<a href="pedidos_formulario.php?id=<?php echo $rowPac["id"]; ?>&paciente=SI" class="btn btn-sm btn-secondary w-100 py-2" style="line-height: 12pt;"><i class="fa fa-bed"></i><br>paciente</a>
									</div>
									<div class="col-4 px-2 position-relative">
										<?php 
										$qPP2 = "SELECT * FROM _pacientes_menu_enlace WHERE idpaciente = '$idOM' AND keyunico NOT LIKE 'solicitud%' AND paciente = 'NO'";
										$rPP2 = $conexion->query($qPP2);
										if($rPP2->num_rows > 0){
										?>
										<div style="position: absolute; top: -4px; right: 20px; background: red; width: 10px; height: 10px; border-radius: 25px;"></div>
										<?php } ?>
										<a href="pedidos_formulario.php?id=<?php echo $rowPac["id"]; ?>&paciente=NO" class="btn btn-sm btn-outline-secondary w-100 py-2" style="line-height: 12pt;"><i class="fa fa-user-clock"></i><br>visitante <?php echo $cvisitantes; ?></a>
									</div>
									<div class="col-4 px-2 position-relative">
										<?php 
										$qPP3 = "SELECT * FROM _pacientes_solicitudes WHERE orden_medica = '$idOM' AND status = '1'";
										$rPP3 = $conexion->query($qPP3);
										if($rPP3->num_rows > 0){
										?>
										<div style="position: absolute; top: -4px; right: 20px; background: red; width: 10px; height: 10px; border-radius: 25px;"></div>
										<?php } ?>
										<a href="pedidos_historial.php?id=<?php echo $rowPac["id"]; ?>" class="btn btn-sm btn-outline-secondary w-100 py-2" style="line-height: 12pt;"><i class="fa fa-layer-group"></i><br>historial</a>
									</div>
								</div>
								<?php } ?>
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

