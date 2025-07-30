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
						<i class="fa fa-square" style="color: #e1f0ed; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=2" style="color: #000; text-decoration: underline;">En Proceso</a>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-square" style="color: #efe4d6; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=3" style="color: #000; text-decoration: underline;">Enviado a Cocina</a>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-square" style="color: #d9ead3; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=4" style="color: #000; text-decoration: underline;">Entregado a Auxiliar</a>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-square" style="color: #f8f5e5; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=2" style="color: #000; text-decoration: underline;">Entregado a Paciente</a>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-square" style="color: #f4cccc; border: 1px solid #C0C0C0;"></i>&nbsp; <a href="?est=C" style="color: #000; text-decoration: underline;">Cancelado</a>&nbsp;&nbsp;&nbsp;
					</div>
					<div class="pt-2">
						<div class="row box-menu mb-2">
							<div class="col-md-1">
								Fecha
							</div>
							<div class="col-md-2">
								Habitación / Tipo Dieta
							</div>
							<div class="col-md-2">
								Nombre Paciente
							</div>
							<div class="col-md-2">
								Médico Tratante
							</div>
							<div class="col-md-2">
								Auxiliar de Nutrición
							</div>
							<div class="col-md-3 text-center">
								Pedido a
							</div>
						</div>
						<?php
						$qryNV = "";
						if($nvsession=="AUXILIAR"){
							$qryNV = "AND auxiliar_nutricion = '$idsession'";
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
							FROM _ordenes_medicas a 
							WHERE status='A' $qryNV $qEst0 $qEst1 $qEst2 $qEst3 $qEstC 
							ORDER by fecha_ingreso";
						$rsPac  = $conexion->query($qryPac);
						while ($rowPac = $rsPac->fetch_assoc()){

							$idOM  = $rowPac["id"];

							// reviso si existe solicitud para la orden medica para colocar estado de entregado a paciente
							$qEstp = "SELECT * FROM _pacientes_solicitudes WHERE orden_medica = '$idOM' AND status = '2'";
							$rEstp = $conexion->query($qEstp);

							// reviso si existe solicitud para la orden medica para colocar estado de entregado por cocina
							$qEstc = "SELECT * FROM _pacientes_solicitudes WHERE orden_medica = '$idOM' AND status = '1'";
							$rEstc = $conexion->query($qEstc);

							// reviso si existe solicitud para la orden medica para colocar estado de enviado a cocina
							$qryEC = "SELECT * FROM _pacientes_solicitudes WHERE orden_medica = '$idOM' AND status = '0'";
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

							// entregada a paciente
							if($rEstp->num_rows > 0 && $veriOkPP == "NO"){
								$bgitem = "#f8f5e5";

							// entregada por cocina
							}elseif($rEstc->num_rows > 0 && $veriOkPP == "NO"){
								$bgitem = "#d9ead3";

							// en cocina
							}elseif($resOM->num_rows > 0 && $veriOkPP == "NO"){
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
							<div class="col-md-2 pt-2">
								<?php echo $rowPac["medico_tratante"]; ?>
							</div>
							<div class="col-md-2 pt-2">
								<?php if($rowPac["auxiliar_nutricion"] > 0){ echo $rowPac["auxiliarn"]; }else{ echo "Aún NO asignado"; } ?>
							</div>
							<div class="col-md-3 pt-0">
								<?php
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
									<div class="col-4 px-2">
										<a href="pedidos_formulario.php?id=<?php echo $rowPac["id"]; ?>&paciente=SI" class="btn btn-sm btn-secondary w-100 py-2" style="line-height: 12pt;"><i class="fa fa-bed"></i><br>paciente</a>
									</div>
									<div class="col-4 px-2">
										<a href="pedidos_formulario.php?id=<?php echo $rowPac["id"]; ?>&paciente=NO" class="btn btn-sm btn-outline-secondary w-100 py-2" style="line-height: 12pt;"><i class="fa fa-user-clock"></i><br>visitante <?php echo $cvisitantes; ?></a>
									</div>
									<div class="col-4 px-2">
										<a href="pedidos_historial.php?id=<?php echo $rowPac["id"]; ?>" class="btn btn-sm btn-outline-secondary w-100 py-2" style="line-height: 12pt;"><i class="fa fa-layer-group"></i><br>historial</a>
									</div>
								</div>
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

