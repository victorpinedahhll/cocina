<?php
$titulo = "Pedido a Pacientes";
$nologg = "SI";
$page   = "pedidos";
$areaLg = "TOMA_PEDIDOS";  // valida roles del usuario

include("header.php");

$idPac  = $_GET["id"];
$qryPac = "
	SELECT *
		, (SELECT nombre FROM _tipo_dieta t WHERE t.id=a.dieta) AS ndieta 
		, (SELECT nombre FROM _habitaciones h WHERE h.id=a.habitacion) AS nhabitacion 
		, (SELECT nombre_us07 FROM _usuarios_admin u WHERE u.id_us00=a.auxiliar_nutricion) AS nauxiliar 
	FROM _ordenes_medicas a 
	WHERE status='A' AND id='$idPac'
";
$rsPac  = $conexion->query($qryPac);
$rowPac = $rsPac->fetch_assoc();

$fechain        = $rowPac["fecha_ingreso"];
$pnombre        = $rowPac["pnombre"];
$snombre        = $rowPac["snombre"];
$papellido      = $rowPac["papellido"];
$sapellido      = $rowPac["sapellido"];
$dieta          = $rowPac["dieta"];
$auxiliar       = $rowPac['auxiliar_nutricion'];
$habitacion     = $rowPac["nhabitacion"];
$medico         = $rowPac["cod_medico"];
$medicotratante = $rowPac["medico_tratante"];
$observaciones  = $rowPac["observaciones"];
$status         = $rowPac["status"];
$codigo         = $rowPac["codigo"];
$motivo         = $rowPac["motivo_ingreso"];

$fecHora = strtotime($fechain);
$diaEnv  = date("d",$fecHora);
$anoEnv  = date("Y",$fecHora);
$mesEnv  = date("m",$fecHora);
if($mesEnv=="1"){ $mesElej = "ene"; }
if($mesEnv=="2"){ $mesElej = "feb"; }
if($mesEnv=="3"){ $mesElej = "mar"; }
if($mesEnv=="4"){ $mesElej = "abr"; }
if($mesEnv=="5"){ $mesElej = "may"; }
if($mesEnv=="6"){ $mesElej = "jun"; }
if($mesEnv=="7"){ $mesElej = "jul"; }
if($mesEnv=="8"){ $mesElej = "ago"; }
if($mesEnv=="9"){ $mesElej = "sep"; }
if($mesEnv=="10"){ $mesElej = "oct"; }
if($mesEnv=="11"){ $mesElej = "nov"; }
if($mesEnv=="12"){ $mesElej = "dic"; }

$dateEmail = $diaEnv."/".$mesElej."/".$anoEnv;

if($_GET['idtp'] > "0"){
	$idplato = $_GET["idtp"];
	$qryT2 = "SELECT * FROM _tipo_menu WHERE id='$idplato'";
	$rsT2  = $conexion->query($qryT2);
	$rowT2 = $rsT2->fetch_assoc();
}

if($_GET['id2'] > "0"){
	$idM  = $_GET["id2"];
	$qryT = "SELECT * FROM _menus WHERE id='$idM'";
	$rsT  = $conexion->query($qryT);
	$rowT = $rsT->fetch_assoc();
}

if($_GET['id3'] > "0"){
	$idopc = $_GET["id3"];
	$qryO  = "SELECT * FROM _menus_opciones WHERE id='$idopc'";
	$rsO   = $conexion->query($qryO);
	$rowO  = $rsO->fetch_assoc();
	$nombreopc = $rowO["nombre"];
}

if($_GET['id4'] > "0"){
	$idopc1  = $_GET["id4"];
	$qryT4 = "SELECT * FROM _menus_subopciones WHERE id='$idopc1'";
	$rsT4  = $conexion->query($qryT4);
	$rowT4 = $rsT4->fetch_assoc();
	$nombreopcT4 = $rowT4["nombre"];
}

if($_GET['id5'] > "0"){
	$idopc2  = $_GET["id5"];
	$qryT5 = "SELECT * FROM _menus_subopciones2 WHERE id='$idopc2'";
	$rsT5  = $conexion->query($qryT5);
	$rowT5 = $rsT5->fetch_assoc();
	$nombreopcT5 = $rowT5["nombre"];
}

if($_GET['id6'] > "0"){
	$idopc3  = $_GET["id6"];
	$qryT6 = "SELECT * FROM _menus_subopciones3 WHERE id='$idopc3'";
	$rsT6  = $conexion->query($qryT6);
	$rowT6 = $rsT6->fetch_assoc();
	$nombreopcT6 = $rowT6["nombre"];
}

$txtcol = "000";
$btncol = "17a2b8";
if($_GET["van"]=="1"){
	$btncol = "17a2b8";
	$txtcol = "fff";
}elseif($_GET["van"]=="2"){
	$btncol = "28a745";
	$txtcol = "fff";
}elseif($_GET["van"]=="3"){
	$btncol = "582ba3";
	$txtcol = "fff";
}elseif($_GET["van"]=="4"){
	$btncol = "ffc107";
}
?>
<style>
	html,body {
		background: #dedede !important;
	}
	.content-text {
		margin: 160px 21px 0 21px;
	}

</style>

<div class="row pt-0 mb-4">
	<div class="col-md-12 content-box position-relative">

		<div style="width: 96%; margin: 175px auto 50px auto;">
			<div class="row">
				<div class="col-md-12">
					<div class="box-admin-opt px-3 pt-2 pb-0 mb-3" style="background: #ffffff; color: #3e3e3e; padding-bottom: 0px !important; box-shadow: 5px 10px 10px -10px #333333;">
						<ul class="form-ul">
							<li class="pt-2" style="width: 10%; line-height: 13pt;">
								<label style="font-size: 14pt;">Orden # <?php echo $idPac; ?></label><br>
								<?php echo $dateEmail; ?>
							</li>
							<li class="pt-2 pl-0" style="width: 18%; line-height: 13pt;">
								<label>Nombre Paciente</label><br>
								<?php echo $pnombre; ?> <?php echo $snombre; ?> <?php echo $papellido; ?> <?php echo $sapellido; ?>
							</li>
							<li class="pt-2" style="width: 18%; line-height: 13pt;">
								<label>Habitacion/Cama *</label><br>
								<?php echo $habitacion; ?>
							</li>
							<li class="pt-1 pl-0" style="width: 24%; line-height: 13pt;">
								<?php if($_REQUEST["paciente"]=="SI"){ ?>
								<div class="m-0 px-3 text-center" style="background: #2b6daf; width: 70%; color: #fff; border-radius: 7px; line-height: 14pt; padding: 12px 0;">
									<span>Tipo de Dieta</span><br>
									<b style="font-size: 15pt;"><?php echo $rowPac["ndieta"]; ?></b>
								</div>
								<?php }else{ 
									$cvisitantes = 1; 
									// cuento cuantas solicitudes de visitantes existen
									$qryVE = "SELECT * FROM _pacientes_solicitudes WHERE orden_medica = $idPac AND paciente = 'NO'";
									$resVE = $conexion->query($qryVE);
									while ($rowVE = $resVE->fetch_assoc()){
										$cvisitantes++;
									}
									?>
									<label>Menú para</label><br>
									<b style="font-size: 20pt; color: #1d88f4;">VISITANTE <?php echo $cvisitantes; ?></b>
								<?php } ?>
							</li>
							<li style="width: 25%;">
								<label>Auxiliar de Nutrición:</label>
								<?php if ($nvsession == "ADMIN" || $nvsession == "COCINA"){ ?>
								<form action="pedidos_asignar.php" method="POST">
								<input type="hidden" name="asignar"  value="SI">
								<input type="hidden" name="id"       value="<?php echo $idPac; ?>">
								<input type="hidden" name="paciente" value="<?php echo $_GET["paciente"]; ?>">
								<div class="row">
									<div class="col-md-9">
										<select name="auxiliar" class="form-control form-control-sm" style="padding: 4px 8px; background: #ffffff;">
											<option value="">elegir uno</option>
											<?php 
											$qryX = "
											SELECT * 
											FROM _usuarios_admin a 
											WHERE 
												(
													status_wua32 = 1 
													AND nivel_wua67 = 'AUXILIAR' 
													AND id_us00 IN (
														SELECT _usuario_id 
														FROM _usuarios_roles u 
														WHERE _usuario_id = a.id_us00 AND _rol = 'TOMA_PEDIDOS' 
													)
												)
												OR id_us00 IN (
													SELECT auxiliar_nutricion 
													FROM _ordenes_medicas  
													WHERE auxiliar_nutricion IS NOT NULL
												)
											";
											$resX = $conexion->query($qryX);
											while ($rowX = $resX->fetch_assoc()){
											?>
											<option value="<?php echo $rowX["id_us00"]; ?>" <?php if($rowX["id_us00"]==$auxiliar){ echo "selected"; } ?>><?php echo $rowX["nombre_us07"]; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-md-3 pl-0">
										<input type="submit" value="asignar" class="btn btn-sm" style="background: #002d59; color: #fff;">
									</div>
								</div>
								</form>
								<?php }else{ ?>
									<br><?php echo $rowPac["nauxiliar"]; ?>
								<?php } ?>
							</li>
							<li class="text-right pt-3" style="width: 5%;">
								<button type="button" class="btn btn-sm" data-toggle="modal" data-target="#exampleModal" style="background: #002d59; color: #fff;">
									<i class="fa fa-plus"></i>
								</button>
								<!-- Modal -->
								<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header" style="background: #002d59; color: #ffffff;">
								        <h5 class="modal-title text-light" id="exampleModalLabel"><b>Código paciente:</b> <?php echo $codigo; ?></h5>
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								          <span aria-hidden="true">&times;</span>
								        </button>
								      </div>
								      <div class="modal-body text-dark pb-5 text-left">
								     	<b>Médico tratante *</b><br>
										<?php echo $medicotratante; ?><br><br>
									  	<b>Motivo ingreso</b><br>
								        <?php echo $motivo; ?>
								      </div>
								    </div>
								  </div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<?php
			$nalergias = []; 
			$qryA = "SELECT * FROM _pacientes_alergias WHERE _paciente_cod = '$codigo'";
			$resA = $conexion->query($qryA);
			while ($rowA = $resA->fetch_assoc()){
				$nalergias[] = $rowA["_alergia"];
			}
			if($resA->num_rows > 0){ ?>
			<div class="row mt-1 mb-3 mx-1 blink_me">
				<div class="col-md-12 py-2 bg-danger text-center" style="border-radius: 7px;">
					<h5 class="text-light m-0"><b>Alerta</b>, este paciente es alérgico a: <b><?php echo implode(", ", $nalergias); ?></b></h5>
				</div>
			</div>
			<?php } ?>

			<?php
			// creo sessiones por paciente y visitante 
			if($_REQUEST["paciente"]=="SI"){
				if( empty($_SESSION["keyun$idPac"]) ){
					$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					$charshort = '';
					for ($i = 0; $i < 8; $i++) {
						$charshort .= $chars[rand(0, strlen($chars)-1)];
					}
					$keyForm = $charshort.$idPac;
					$_SESSION["keyun$idPac"] = $keyForm;
				}else{
					$keyForm = $_SESSION["keyun$idPac"];
				}
			}

			if($_REQUEST["paciente"]=="NO"){
				if( empty($_SESSION["keyunvisit$idPac"]) ){
					$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					$charshort = '';
					for ($i = 0; $i < 8; $i++) {
						$charshort .= $chars[rand(0, strlen($chars)-1)];
					}
					$keyForm = $charshort.$idPac;
					$_SESSION["keyunvisit$idPac"] = $keyForm;
				}else{
					$keyForm = $_SESSION["keyunvisit$idPac"];
				}
			}
			?>
			<?php if(!empty($auxiliar) && $auxiliar > 0){ ?>
			<form id="form-prueba" action="pedidos_form.php" method="POST" autocomplete="off">
			<?php
			$idPaciente = $rowPac["id"];
			// echo $keyForm;
			?>
			<input type="hidden" name="key" id="key" value="<?php echo $keyForm; ?>">
			<input type="hidden" name="idpac" id="idpaciente" value="<?php echo $idPaciente; ?>">
			<input type="hidden" name="fingreso"   value="<?php echo $dateEmail; ?>">
			<input type="hidden" name="codigo"     value="<?php echo $codigo; ?>">
			<input type="hidden" name="pnombre"    value="<?php echo $pnombre; ?>">
			<input type="hidden" name="snombre"    value="<?php echo $snombre; ?>">
			<input type="hidden" name="snombre"    value="<?php echo $snombre; ?>">
			<input type="hidden" name="papellido"  value="<?php echo $papellido; ?>">
			<input type="hidden" name="sapellido"  value="<?php echo $sapellido; ?>">
			<input type="hidden" name="dieta"      value="<?php echo $dieta; ?>">
			<input type="hidden" name="habitacion" value="<?php echo $habitacion; ?>">
			<input type="hidden" name="medico"     value="<?php echo $medico; ?>">
			<input type="hidden" name="motivo"     value="<?php echo $motivo; ?>">
			<input type="hidden" name="paciente"   value="<?php echo $_REQUEST["paciente"]; ?>">
			<input type="hidden" name="auxiliar"   value="<?php echo $auxiliar; ?>">
			<?php } ?>
			<div class="row">
				<div class="col-md-8">
					<div class="box-admin-opt h-100">

						<!----------- TIPOS DE MENUS ------------>
						<div class="row">
						<?php
						// coloco opciones segun tipo de dieta del paciente
						$qryidtp = "";
						if($idplato > "0"){
							$qryidtp = "and id='$idplato'";
						}
						$van = 0;
						$qryL = "
							SELECT * 
							FROM _tipo_menu t 
							WHERE 
								status = 'A' 
								AND id IN (
									SELECT idtipo 
									FROM _menu_tipo_enlace m 
									WHERE 
										m.idtipo = t.id 
										AND m.idmenu IN (
											SELECT idmenu 
											FROM _menu_dieta_enlace d 
											WHERE 
												d.idmenu = m.idmenu 
												AND iddieta = $dieta
										) 
								) 
								$qryidtp 
							ORDER by id
						";
						$rsL  = $conexion->query($qryL);
						while ($rowL = $rsL->fetch_assoc()){
							$van = $van + 1;
							$txtcol1 = "000";
							$btncol1 = "17a2b8";
							if(empty($_GET['van'])){
								if($van=="1"){
									$btncol = "17a2b8";
									$txtcol = "fff";
								}elseif($van=="2"){
									$btncol = "28a745";
									$txtcol = "fff";
								}elseif($van=="3"){
									$btncol = "582ba3";
									$txtcol = "fff";
								}elseif($van=="4"){
									$btncol = "ffc107";
								}
							}
							?>
							<div class="col px-2 text-center">
								<?php if($idplato > "0"){ ?>
									<a name="#" class="btn btn-lg w-100" style="box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 40px; background: #fff; color: #000; border: 1px solid #C0C0C0;">
										<img src="images/svg/<?php echo $rowL["icon"]; ?>" height="30">&nbsp; <?php echo $rowL["nombre"]; ?> <span style="color: #808080;">(dieta <?php echo $rowPac["ndieta"]; ?>)</span>
									</a>
								<?php }else{ ?>
									<a href="?id=<?php echo $idPac; ?>&idtp=<?php echo $rowL["id"]; ?>&opt1=SI&paciente=<?php echo $_REQUEST["paciente"]; ?>&van=<?php echo $van; ?>" class="btn btn-lg w-100" style="box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 40px; background: #fff; color: #000; border: 1px solid #C0C0C0;">
										<img src="images/svg/<?php echo $rowL["icon"]; ?>" height="30">&nbsp; <?php echo $rowL["nombre"]; ?>
									</a>
								<?php } ?>
							</div>
							<?php if($idplato > "0"){ ?>
							<div class="col-3">
								<a href="?id=<?php echo $idPac; ?>&paciente=<?php echo $_REQUEST["paciente"]; ?>" class="btn btn-lg w-100" style="box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 40px; background: #fff; color: #000; border: 1px solid #C0C0C0;"><img src="images/svg/back-svgrepo-com.svg" height="40"></a>
							</div>
							<?php } ?>		
						<?php } ?>
						</div>

						<!----------- SELECCION PLATOS ------------>
						<?php 
						if($_GET['opt1']=="SI"){ 
							$qryOP1 = "";
							if($_REQUEST["paciente"]=="SI"){
							 	$qryOP1 = "AND a.id IN (SELECT idmenu FROM _menu_dieta_enlace d WHERE d.idmenu = a.id AND d.iddieta = $dieta) ";
							}
						?>
						<div class="row px-2">
							<div class="col-md-12 mt-3 mb-0 py-2 text-center" style="background: #eee; color: #808080; border-radius: 4px; font-size: 12pt; font-weight: bold; box-shadow: 5px 10px 10px -10px #808080;">platos de este menú</div>
						</div>
						<div class="row">
							<?php
							$sql = "
							SELECT * 
							FROM _menus a 
							WHERE 
								a.status = 'A' 
								AND a.id IN (
									SELECT idmenu 
									FROM _menu_tipo_enlace b 
									WHERE 
										b.idmenu = a.id 
										AND b.idtipo = $idplato 
								) 
								AND a.id IN (
									SELECT idmenu 
									FROM _menus_progra_enlace c 
									WHERE 
										c.idmenu = a.id 
										AND c.idprogra IN (
											SELECT id 
											FROM _programaciones d 
											WHERE 
												d.id = c.idprogra 
												AND d.status = 'A' 
												AND d.inicio <= '$datenow' 
												AND d.final >= '$datenow'
										)
								) 
								$qryOP1
							";
							$rs  = $conexion->query($sql);
							while ($row = $rs->fetch_assoc()){
							?>
								<div class="col-4 px-2 mt-3 text-center">
									<a href="?id=<?php echo $idPac; ?>&idtp=<?php echo $idplato; ?>&id2=<?php echo $row["id"]; ?>&opt2=SI&paciente=<?php echo $_REQUEST["paciente"]; ?>&van=<?php echo $_GET["van"]; ?>" class="btn btn-lg w-100" style="font-size: 14pt; background: #fff; color: #000; border: 1px solid #C0C0C0; box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 16pt; <?php if(strlen($row["nombre"]) < 30){ echo "padding-top: 18px;"; } ?>">
										<?php echo $row["nombre"]; ?>
									</a>
								</div>
							<?php } ?>
						</div>
						<?php } ?>

						<!----------- SELECCION TRES ------------>
						<?php if($_GET['opt2']=="SI"){ ?>
						<div class="row px-2">
							<div class="col-md-12 mt-3 mb-0 py-2 text-center" style="background: #eee; color: #808080; border-radius: 4px; font-size: 12pt; font-weight: bold; box-shadow: 5px 10px 10px -10px #808080;"><?php if($idplato > "0"){ echo $rowT2["nombre"]." <span style='color: #808080;'>:</span>&nbsp; "; } ?><?php echo $rowT["nombre"]; ?></div>
						</div>
						<div class="row mt-2">
							<?php
							$idO = 1;
							$qryM = "SELECT * FROM _menus_opciones WHERE idmenu='$idM' and status!='E' ORDER by nombre";
							$rs  = $conexion->query($qryM);
							while ($row = $rs->fetch_assoc()){
								$id1 = $row["id"];
								$qry1 = "SELECT * FROM _menus_subopciones WHERE idmenu='$idM' and idopcion='$id1' and status!='E' ORDER by nombre";
								$rs1  = $conexion->query($qry1);
								if($rs1->num_rows > 0){
									$row1 = $rs1->fetch_assoc();
									?>
									<div class="col-4 px-2 mt-3 text-center">
										<a href="?id=<?php echo $idPac; ?>&idtp=<?php echo $_GET["idtp"]; ?>&id2=<?php echo $_GET["id2"]; ?>&id3=<?php echo $row["id"]; ?>&opt3=SI&paciente=<?php echo $_REQUEST["paciente"]; ?>&van=<?php echo $_GET["van"];?>" class="btn btn-lg w-100" style="font-size: 14pt; background: #fff; color: #000; border: 1px solid #C0C0C0; box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 16pt; <?php if(strlen($row["nombre"]) < 30){ echo "padding-top: 18px;"; } ?>">
											<?php echo $row["nombre"]; ?>
										</a>
									</div>
								<?php }else{ ?>	
									<div class="col-4 px-2 mt-3 text-center">
										<a href="platos_add.php?idpac=<?php echo $idPac; ?>&key=<?php echo $keyForm; ?>&idmenu=<?php echo $idM; ?>&idprogra=<?php echo $row["id"]; ?>&tipo=2&idtp=<?php echo $idplato;?>&codpac=<?php echo $codigo;?>&paciente=<?php echo $_REQUEST["paciente"]; ?>&van=<?php echo $_GET["van"]; ?>" class="btn btn-lg w-100" style="font-size: 14pt; background: #fff; color: #000; border: 1px solid #C0C0C0; box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 16pt; <?php if(strlen($row["nombre"]) < 30){ echo "padding-top: 18px;"; } ?>">
											<?php echo $row["nombre"]; ?>
										</a>
									</div>
								<?php } ?>
							<?php } ?>
						</div>
						<?php } ?>

						<!----------- SELECCION CUATRO ------------>
						<?php if($_GET['opt3']=="SI"){ ?>
						<div class="row px-2">
							<div class="col-md-12 mt-3 mb-0 py-2 text-center" style="background: #eee; border-radius: 4px; font-size: 12pt; color: #808080; font-weight: bold; box-shadow: 5px 10px 10px -10px #808080;"><?php if($idplato > "0"){ echo $rowT2["nombre"]." <span style='color: #808080;'>:</span>&nbsp; "; } ?><?php if($_GET["id2"] > "0"){ echo $rowT["nombre"]." <span style='color: #808080;'>:</span>&nbsp; "; } ?><?php echo $nombreopc; ?></div>
						</div>
						<div class="row mt-2">
							<?php
							$qry2 = "SELECT * FROM _menus_subopciones WHERE idmenu='$idM' and idopcion='$idopc' and status!='E' ORDER by nombre";
							$rs2  = $conexion->query($qry2);
							while($row2 = $rs2->fetch_assoc()){
								$id2 = $row2["id"];
								$qry22 = "SELECT * FROM _menus_subopciones2 WHERE idmenu='$idM' and idopcion='$idopc' and idopcion2='$id2' and status!='E' ORDER by nombre";
								$rs22  = $conexion->query($qry22);
								if($rs22->num_rows > 0){
									$row22 = $rs22->fetch_assoc();
									?>
									<div class="col-4 px-2 mt-3 text-center">
										<a href="?id=<?php echo $idPac; ?>&idtp=<?php echo $_GET["idtp"]; ?>&id2=<?php echo $_GET["id2"]; ?>&id3=<?php echo $idopc; ?>&id4=<?php echo $row2["id"]; ?>&opt4=SI&paciente=<?php echo $_REQUEST["paciente"]; ?>&van=<?php echo $_GET["van"];?>" class="btn btn-lg w-100" style="font-size: 14pt; background: #fff; color: #000; border: 1px solid #C0C0C0; box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 16pt; <?php if(strlen($row["nombre"]) < 30){ echo "padding-top: 18px;"; } ?>">
											<?php echo $row2["nombre"]; ?>
										</a>
									</div>
								<?php }else{ ?>	
									<div class="col-4 px-2 mt-3 text-center">
										<a href="platos_add.php?idpac=<?php echo $idPac; ?>&key=<?php echo $keyForm; ?>&idmenu=<?php echo $idM; ?>&idprogra=<?php echo $row2["id"]; ?>&tipo=3&idtp=<?php echo $idplato;?>&codpac=<?php echo $codigo;?>&paciente=<?php echo $_REQUEST["paciente"]; ?>&van=<?php echo $_GET["van"]; ?>" class="btn btn-lg w-100" style="font-size: 14pt; background: #fff; color: #000; border: 1px solid #C0C0C0; box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 16pt; <?php if(strlen($row["nombre"]) < 30){ echo "padding-top: 18px;"; } ?>">
											<?php echo $row2["nombre"]; ?>
										</a>
									</div>
								<?php } ?>
							<?php } ?>
						</div>
						<?php } ?>


						<!----------- SELECCION CINCO ------------>
						<?php if($_GET['opt4']=="SI"){ ?>
						<div class="row px-2">
							<div class="col-md-12 mt-3 mb-0 py-2 text-center" style="background: #eee; border-radius: 4px; font-size: 12pt; color: #808080; font-weight: bold; box-shadow: 5px 10px 10px -10px #808080;"><?php if($idplato > "0"){ echo $rowT2["nombre"]." <span style='color: #808080;'>:</span>&nbsp; "; } ?><?php if($_GET["id2"] > "0"){ echo $rowT["nombre"]." <span style='color: #808080;'>:</span>&nbsp; "; } ?><?php if($_GET["id3"] > "0"){ echo $rowO["nombre"]." <span style='color: #808080;'>:</span>&nbsp; "; } ?><?php echo $nombreopcT4; ?></div>
						</div>
						<div class="row mt-2">
							<?php
							$qry3   = "SELECT * FROM _menus_subopciones2 WHERE idmenu='$idM' and idopcion='$idopc' and idopcion2='$idopc1' and status!='E' ORDER by nombre";
							$rs3    = $conexion->query($qry3);
							while($row3 = $rs3->fetch_assoc()){
								$id3 = $row3["id"];
								$qry33 = "SELECT * FROM _menus_subopciones3 WHERE idmenu='$idM' and idopcion='$idopc' and idopcion2='$idopc1' and idopcion3='$id3' and status!='E' ORDER by nombre";
								$rs33  = $conexion->query($qry33);
								if($rs33->num_rows > 0){
									$row33 = $rs33->fetch_assoc();
									?>
									<div class="col-4 px-2 mt-3 text-center">
										<a href="?id=<?php echo $idPac; ?>&idtp=<?php echo $idplato; ?>&id2=<?php echo $idM; ?>&id3=<?php echo $idopc; ?>&id4=<?php echo $idopc1; ?>&id5=<?php echo $row3["id"]; ?>&opt5=SI&van=<?php echo $_GET["van"];?>" class="btn btn-lg w-100" style="font-size: 14pt; background: #fff; color: #000; border: 1px solid #C0C0C0; box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 16pt; <?php if(strlen($row3["nombre"]) < 25){ echo "padding-top: 18px;"; } ?>">
											<?php echo $row3["nombre"]; ?>
										</a>
									</div>
								<?php }else{ ?>	
									<div class="col-4 px-2 mt-3 text-center">
										<a href="platos_add.php?idpac=<?php echo $idPac; ?>&key=<?php echo $keyForm; ?>&idmenu=<?php echo $idM; ?>&idprogra=<?php echo $row3["id"]; ?>&tipo=4&idtp=<?php echo $idplato;?>&codpac=<?php echo $codigo;?>&paciente=<?php echo $_REQUEST["paciente"]; ?>&van=<?php echo $_GET["van"]; ?>" class="btn btn-lg w-100" style="font-size: 14pt; background: #fff; color: #000; border: 1px solid #C0C0C0; box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 16pt; <?php if(strlen($row["nombre"]) < 30){ echo "padding-top: 18px;"; } ?>">
											<?php echo $row3["nombre"]; ?>
										</a>
									</div>
								<?php } ?>
							<?php } ?>
						</div>
						<?php } ?>

						<!----------- SELECCION SEIS ------------>
						<?php if($_GET['opt5']=="SI"){ ?>
						<div class="row px-2">
							<div class="col-md-12 mt-3 mb-0 py-2 text-center" style="background: #eee; border-radius: 4px; font-size: 12pt; color: #808080; font-weight: bold; box-shadow: 5px 10px 10px -10px #808080;"><?php echo $rowT2["nombre"]; ?><span style='color: #808080;'>:</span>&nbsp; <?php echo $rowT["nombre"]; ?><span style='color: #808080;'>:</span>&nbsp; <?php echo $rowO["nombre"]; ?> <span style='color: #808080;'>:</span>&nbsp; <?php echo $nombreopcT4; ?> <span style='color: #808080;'>:</span>&nbsp; <?php echo $nombreopcT5; ?></div>
						</div>
						<div class="row mt-2">
							<?php
							$qry4 = "SELECT * FROM _menus_subopciones3 WHERE idmenu='$idM' and idopcion='$idopc' and idopcion2='$idopc1' and idopcion3='$idopc2' and status!='E' ORDER by nombre";
							$rs4  = $conexion->query($qry4);
							while($row4 = $rs4->fetch_assoc()){

								$id4 = $row4["id"];
								$qry44 = "SELECT * FROM _menus_subopciones4 WHERE idmenu='$idM' and idopcion='$idopc' and idopcion2='$idopc1' and idopcion3='$idopc2' and idopcion4='$id4' and status!='E' ORDER by nombre";
								$rs44  = $conexion->query($qry44);
								if($rs44->num_rows > 0){
									$row44 = $rs44->fetch_assoc();
									?>
									<div class="col-4 px-2 mt-3 text-center">
										<a href="?id=<?php echo $idPac; ?>&idtp=<?php echo $idplato; ?>&id2=<?php echo $idM; ?>&id3=<?php echo $idopc; ?>&id4=<?php echo $idopc1; ?>&id5=<?php echo $idopc2;?>&id6=<?php echo $id4;?>&opt6=SI&paciente=<?php echo $_REQUEST["paciente"]; ?>&van=<?php echo $_GET["van"];?>" class="btn btn-lg w-100" style="font-size: 14pt; background: #fff; color: #000; border: 1px solid #C0C0C0; box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 16pt; <?php if(strlen($row["nombre"]) < 30){ echo "padding-top: 18px;"; } ?>">
											<?php echo $row4["nombre"]; ?>
										</a>
									</div>
								<?php }else{ ?>	
									<div class="col-4 px-2 mt-3 text-center">
										<a href="platos_add.php?idpac=<?php echo $idPac; ?>&key=<?php echo $keyForm; ?>&idmenu=<?php echo $idM; ?>&idprogra=<?php echo $row4["id"]; ?>&tipo=5&idtp=<?php echo $idplato;?>&codpac=<?php echo $codigo;?>&paciente=<?php echo $_REQUEST["paciente"]; ?>&van=<?php echo $_GET["van"]; ?>" class="btn btn-lg w-100" style="font-size: 14pt; background: #fff; color: #000; border: 1px solid #C0C0C0; box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 16pt; <?php if(strlen($row["nombre"]) < 30){ echo "padding-top: 18px;"; } ?>">
											<?php echo $row4["nombre"]; ?>
										</a>
									</div>
								<?php } ?>
							<?php } ?>
						</div>
						<?php } ?>

						<!----------- SELECCION SIETE ------------>
						<?php if($_GET['opt6']=="SI"){ ?>
						<div class="row px-2">
							<div class="col-md-12 mt-3 mb-0 py-2 text-center" style="background: #eee; border-radius: 4px; font-size: 12pt; color: #808080; font-weight: bold; box-shadow: 5px 10px 10px -10px #808080;"><?php echo $rowT2["nombre"]; ?><span style='color: #808080;'>:</span>&nbsp; <?php echo $rowT["nombre"]; ?><span style='color: #808080;'>:</span>&nbsp; <?php echo $rowO["nombre"]; ?> <span style='color: #808080;'>:</span>&nbsp; <?php echo $nombreopcT4; ?> <span style='color: #808080;'>:</span>&nbsp; <?php echo $nombreopcT5; ?> <span style='color: #808080;'>:</span>&nbsp; <?php echo $nombreopcT6; ?></div>
						</div>
						<div class="row mt-2">
							<?php
							$qry5 = "SELECT * FROM _menus_subopciones4 WHERE idmenu='$idM' and idopcion='$idopc' and idopcion2='$idopc1' and idopcion3='$idopc2' and idopcion4='$idopc3' and status!='E' ORDER by nombre";
							$rs5  = $conexion->query($qry5);
							while($row5 = $rs5->fetch_assoc()){
								?>
								<div class="col-4 px-2 mt-3 text-center">
									<a href="platos_add.php?idpac=<?php echo $idPac; ?>&key=<?php echo $keyForm; ?>&idmenu=<?php echo $idM; ?>&idprogra=<?php echo $row5["id"]; ?>&tipo=6&idtp=<?php echo $idplato;?>&codpac=<?php echo $codigo;?>&paciente=<?php echo $_REQUEST["paciente"]; ?>&van=<?php echo $_GET["van"]; ?>" class="btn btn-lg w-100" style="font-size: 14pt; background: #fff; color: #000; border: 1px solid #C0C0C0; box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 16pt; <?php if(strlen($row["nombre"]) < 30){ echo "padding-top: 18px;"; } ?>">
										<?php echo $row5["nombre"]; ?>
									</a>
								</div>
							<?php } ?>
						</div>
						<?php } ?>
						
					</div>
				</div>
				<div class="col-md-4">
					<div class="box-admin-opt">
						<h5 class="mt-0 mb-2 text-center p-3" style="background: #eee; color: #3e3e3e; border-radius: 4px;"><img src="images/svg/dinner-svgrepo-com-2.svg" height="30">&nbsp; Menú elegido</h5>
						
						<div class="table-elegidas px-2" id="tasks" style="min-height: 150px;"></div>
						<?php if(!empty($auxiliar) && $auxiliar > 0){ ?>
						<div class="row mt-5 pb-4">
							<div class="col-md-12">
								<label>Observaciones</label>
								<textarea name="observaciones" id="observaciones" rows="4" class="form-control"><?php echo $observaciones; ?></textarea>
							</div>
						</div>
						
						<input type="submit" name="submitform" class="form-control btn text-light" value="enviar solicitud a cocina" style="font-weight: bold; font-size: 14pt; background: #002d59; margin-top: 0px;">
						<?php } ?>
					</div>
				</div>
			</div>
			<?php if(!empty($auxiliar) && $auxiliar > 0){ ?>
			</form>
			<?php } ?>
		</div>
	</div>
</div>

<?php 
// elimino los sessions solo a modo de prueba
// unset($_SESSION["keyun$idPac"]);
// unset($_SESSION["keyunvisit$idPac"]);
?>

<script>
	// Testing Jquery
	console.log('jquery is working!');

	$('#prueba-result').css('display','none');

	// coloco la opcion de borrar el texto despues de escribir en el campo
	$('#opt-times').hide();
	$("#search").keypress(function(){ 
	  	$('#opt-times').show();
	});
	 // opcion de borrar el texto del campo
	$(document).on('click', '#texto-borrar', (e) => {
		$("#search").val('');
		$("#prueba-result").css('display','none');
	});

  // search key type event
  $('#search').keyup(function() {
    if($('#search').val()) {
      let search = $('#search').val();

      $.ajax({
        url: 'platos_search.php',
        data: {search},
        type: 'POST',
        success: function (response) {
          if(!response.error) {
            let tasks = JSON.parse(response);
            let template = '';
            tasks.forEach(task => {
              template += `
              	<input type="checkbox" id="item${task.id}" name="pr${task.id}" value="${task.id}"> ${task.name}<br>
                    ` 
            });
            $('#prueba-result').css('display','block');
            $('#container').html(template);
          }
        } 
      });
    }else{
    	$('#prueba-result').css('display','none');
    }
  });

  // habilita campo para agregar nombre medico si no esta en el listado
  function cambia_medico() {
	if (document.getElementById("medico").value=="999999") {
		$("#otrobox").css("display", "block");
		console.log('block');
	}else{
		$("#otrobox").css("display", "none");
	};
  };

  $(document).on('change', '#alergias', (e) => {
	const postData = {
		pacienteid: $('#idpaciente').val(),
		alergia: $('#alergias').val()
	};
	$.post('alergia_add.php', postData, (response) => {
		console.log(response);
		location.reload(true);
	});
	e.preventDefault();
});
</script>

<?php include("footer.php"); ?>

