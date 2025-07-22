<?php
$titulo = "Pedido a Pacientes";
$nologg = "SI";
$page   = "pacientes";
$areaLg = "TOMA_PEDIDOS";  // valida roles del usuario

include("header.php");

$idPac  = $_GET["id"];
$qryPac = "SELECT * FROM _pacientes_activos WHERE status='A' and id='$idPac'";
$rsPac  = $conexion->query($qryPac);
$rowPac = $rsPac->fetch_assoc();

$fechain = $rowPac["fecha_ingreso"];
$pnombre = $rowPac["pnombre"];
$snombre = $rowPac["snombre"];
$papellido = $rowPac["papellido"];
$sapellido = $rowPac["sapellido"];
$habitacion = $rowPac["habitacion"];
$medico  = $rowPac["cod_medico"];
$medicotratante = $rowPac["medico_tratante"];
$observaciones = $rowPac["observaciones"];
$alergias = $rowPac["alergias"];
$status  = $rowPac["status"];
$codigo  = $rowPac["codigo"];
$motivo  = $rowPac["motivo_ingreso"];

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

$dateEmail = $diaEnv." / ".$mesElej." / ".$anoEnv;

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

	.content-text {
		margin: 160px 21px 0 21px;
	}

</style>

<div class="row pt-0 mb-4">
	<div class="col-md-12 content-box position-relative">

		<div style="width: 90%; margin: 175px auto 50px auto;">
			<form id="form-prueba" action="pacientes_form.php" method="POST" autocomplete="off">
			<?php
			if(empty($_SESSION['keyun'])){
				$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$charshort = '';
				for ($i = 0; $i < 8; $i++) {
					$charshort .= $chars[rand(0, strlen($chars)-1)];
				}
				$keyForm = $charshort;
				$_SESSION['keyun'] = $charshort;
			}else{
				$keyForm = $_SESSION['keyun'];
			}
			$idPaciente = $rowPac["id"];
			?>
			<input type="hidden" name="key" id="key" value="<?php echo $keyForm; ?>">
			<input type="hidden" name="paciente"   id="idpaciente" value="<?php echo $idPaciente; ?>">
			<input type="hidden" name="fingreso"   value="<?php echo $dateEmail; ?>">
			<input type="hidden" name="codigo"     value="<?php echo $codigo; ?>">
			<input type="hidden" name="pnombre"    value="<?php echo $pnombre; ?>">
			<input type="hidden" name="snombre"    value="<?php echo $snombre; ?>">
			<input type="hidden" name="snombre"    value="<?php echo $snombre; ?>">
			<input type="hidden" name="papellido"  value="<?php echo $papellido; ?>">
			<input type="hidden" name="sapellido"  value="<?php echo $sapellido; ?>">
			<input type="hidden" name="habitacion" value="<?php echo $habitacion; ?>">
			<input type="hidden" name="medico"     value="<?php echo $medico; ?>">
			<input type="hidden" name="motivo"     value="<?php echo $motivo; ?>">
			<div class="row">
				<div class="col-md-12">
					<div class="box-admin-opt p-3 pb-0" style="background: #002d59; color: #fff; padding-bottom: 0px !important; box-shadow: 5px 10px 10px -10px #333333;">
						<div class="form-row">
							<div class="form-group col">
								<label>Nombre Paciente</label><br>
								<?php echo $pnombre; ?> <?php echo $snombre; ?> <?php echo $papellido; ?> <?php echo $sapellido; ?>
							</div>
							<div class="form-group col">
								<label>Habitacion/Cama *</label><br>
								<?php echo $habitacion; ?>
							</div>
							<div class="form-group col">
								<label>Médico tratante *</label><br>
								<?php
								$qryM2 = "SELECT * FROM web_medicos WHERE status_med37='A' and  colegiado_med35  > '0' ORDER by primer_apellido_med29,primer_nombre_med18";
								$rsM2 = $conexion2->query($qryM2);
								$rowM2 = $rsM2->fetch_assoc();
								?>
								<?php echo $rowM2["primer_apellido_med29"]; ?> <?php if(!empty($rowM2["segundo_apellido_med37"])){ echo $rowM2["segundo_apellido_med37"]; } ?>, <?php echo $rowM2["primer_nombre_med18"]; ?> <?php if(!empty($rowM2["segundo_nombre_med22"])){ echo $rowM2["segundo_nombre_med22"]; } ?>
							</div>
							<div class="form-group col">
								<label>Fecha Ingreso</label><br>
								<?php echo $dateEmail; ?>
							</div>
							<div class="form-group col">
								<label>Alergias:</label><br>
								<select name="alergias" id="alergias" class="w-100" style="background: #002d59; color: #fff; border: 1px solid #C0C0C0; padding: 4px 8px;">
									<option value="">Ninguna</option>
									<option value="Mariscos" <?php if($alergias=="Mariscos"){ echo "selected"; } ?>>Mariscos</option>
									<option value="Gluten" <?php if($alergias=="Gluten"){ echo "selected"; } ?>>Gluten</option>
									<option value="Lactosa" <?php if($alergias=="Lactosa"){ echo "selected"; } ?>>Lactosa</option>
								</select>
							</div>
							<div class="form-group col-1 text-right">
								<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal">
									<i class="fa fa-plus"></i>
								</button>
								<!-- Modal -->
								<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header bg-info">
								        <h5 class="modal-title text-light" id="exampleModalLabel"><b>Código paciente:</b> <?php echo $codigo; ?></h5>
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								          <span aria-hidden="true">&times;</span>
								        </button>
								      </div>
								      <div class="modal-body text-dark pb-5 text-left">
								      	<b>Motivo ingreso</b><br>
								        <?php echo $motivo; ?>
								      </div>
								    </div>
								  </div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
			<?php if($alergias!="NO"){ ?>
			<div class="row mt-2 mb-3 mx-2">
				<div class="col-md-12 py-2 bg-danger text-center" style="border-radius: 7px;">
					<h5 class="text-light m-0"><b>Alerta</b>, este paciente es alérgico a: <b><?php echo $alergias; ?></b></h5>
				</div>
			</div>
			<?php } ?>
			<div class="row">
				<div class="col-md-8">
					<div class="box-admin-opt h-100">

						<!----------- SELECCION UNO ------------>
						<div class="row">
						<?php
						$qryidtp = "";
						if($idplato > "0"){
							$qryidtp = "and id='$idplato'";
						}
						$van = 0;
						$qryL = "SELECT * FROM _tipo_menu t WHERE status!='E' $qryidtp ORDER by id";
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
									<a nmae="#" class="btn btn-lg w-100" style="box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 40px; background: #<?php echo $btncol;?>; color: #<?php echo $txtcol;?>;">
										<?php echo $rowL["nombre"]; ?>
									</a>
								<?php }else{ ?>
									<a href="?id=<?php echo $idPac; ?>&idtp=<?php echo $rowL["id"]; ?>&opt1=SI&van=<?php echo $van; ?>" class="btn btn-lg w-100" style="box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 40px; background: #<?php echo $btncol;?>; color: #<?php echo $txtcol;?>;">
										<?php echo $rowL["nombre"]; ?>
									</a>
								<?php } ?>
							</div>
							<?php if($idplato > "0"){ ?>
							<div class="col-3">
								<a href="?id=<?php echo $idPac; ?>" class="btn btn-lg w-100" style="box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 40px; background: #fff; color: #000; border: 1px solid #C0C0C0;">Menu Principal</a>
							</div>
							<?php } ?>		
						<?php } ?>
						</div>

						<!----------- SELECCION DOS ------------>
						<?php if($_GET['opt1']=="SI"){ ?>
						<div class="row px-2">
							<div class="col-md-12 mt-3 mb-0 py-2 text-center" style="background: #eee; color: #808080; border-radius: 4px; font-size: 12pt; font-weight: bold; box-shadow: 5px 10px 10px -10px #808080;"><?php echo $rowT2["nombre"]; ?></div>
						</div>
						<div class="row">
							<?php
							$sql = "SELECT * FROM _menus a WHERE a.id in (select idmenu from _menu_tipo_enlace b where b.idmenu=a.id and b.idtipo='$idplato' and b.idmenu in (select idmenu from _menus_progra_enlace c where c.idmenu=b.idmenu and c.idprogra in (select id from _programaciones d where d.id=c.idprogra and d.status='A' and d.inicio <='$datenow' and d.final >='$datenow'))) and a.status!='E'";
							$rs  = $conexion->query($sql);
							while ($row = $rs->fetch_assoc()){
							?>
								<div class="col-4 px-2 mt-3 text-center">
									<a href="?id=<?php echo $idPac; ?>&idtp=<?php echo $idplato; ?>&id2=<?php echo $row["id"]; ?>&opt2=SI&van=<?php echo $_GET["van"]; ?>" class="btn btn-lg w-100" style="font-size: 14pt; background: #<?php echo $btncol;?>; color: #<?php echo $txtcol; ?>; box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 16pt; <?php if(strlen($row["nombre"]) < 25){ echo "padding-top: 18px;"; } ?>">
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
										<a href="?id=<?php echo $idPac; ?>&idtp=<?php echo $_GET["idtp"]; ?>&id2=<?php echo $_GET["id2"]; ?>&id3=<?php echo $row["id"]; ?>&opt3=SI&van=<?php echo $_GET["van"];?>" class="btn btn-lg w-100" style="font-size: 14pt; background: #<?php echo $btncol;?>; color: #<?php echo $txtcol;?>; box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 16pt; <?php if(strlen($row["nombre"]) < 25){ echo "padding-top: 18px;"; } ?>">
											<?php echo $row["nombre"]; ?>
										</a>
									</div>
								<?php }else{ ?>	
									<div class="col-4 px-2 mt-3 text-center">
										<a href="platos_add.php?idpac=<?php echo $idPac; ?>&key=<?php echo $keyForm; ?>&idmenu=<?php echo $idM; ?>&idprogra=<?php echo $row["id"]; ?>&tipo=2&idtp=<?php echo $idplato;?>&van=<?php echo $_GET["van"]; ?>" class="btn btn-lg w-100" style="font-size: 14pt; background: #<?php echo $btncol;?>; color: #<?php echo $txtcol;?>; box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 16pt; <?php if(strlen($row["nombre"]) < 25){ echo "padding-top: 18px;"; } ?>">
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
										<a href="?id=<?php echo $idPac; ?>&idtp=<?php echo $_GET["idtp"]; ?>&id2=<?php echo $_GET["id2"]; ?>&id3=<?php echo $idopc; ?>&id4=<?php echo $row2["id"]; ?>&opt4=SI&van=<?php echo $_GET["van"];?>" class="btn btn-lg w-100" style="font-size: 14pt; background: #<?php echo $btncol;?>; color: #<?php echo $txtcol;?>; box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 16pt; <?php if(strlen($row["nombre"]) < 25){ echo "padding-top: 18px;"; } ?>">
											<?php echo $row2["nombre"]; ?>
										</a>
									</div>
								<?php }else{ ?>	
									<div class="col-4 px-2 mt-3 text-center">
										<a href="platos_add.php?idpac=<?php echo $idPac; ?>&key=<?php echo $keyForm; ?>&idmenu=<?php echo $idM; ?>&idprogra=<?php echo $row2["id"]; ?>&tipo=3&idtp=<?php echo $idplato;?>&van=<?php echo $_GET["van"]; ?>" class="btn btn-lg w-100" style="font-size: 14pt; background: #<?php echo $btncol;?>; color: #<?php echo $txtcol;?>; box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 16pt; <?php if(strlen($row["nombre"]) < 25){ echo "padding-top: 18px;"; } ?>">
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
										<a href="?id=<?php echo $idPac; ?>&idtp=<?php echo $idplato; ?>&id2=<?php echo $idM; ?>&id3=<?php echo $idopc; ?>&id4=<?php echo $idopc1; ?>&id5=<?php echo $row3["id"]; ?>&opt5=SI&van=<?php echo $_GET["van"];?>" class="btn btn-lg w-100" style="font-size: 14pt; background: #<?php echo $btncol;?>; color: #<?php echo $txtcol;?>; box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 16pt; <?php if(strlen($row3["nombre"]) < 25){ echo "padding-top: 18px;"; } ?>">
											<?php echo $row3["nombre"]; ?>
										</a>
									</div>
								<?php }else{ ?>	
									<div class="col-4 px-2 mt-3 text-center">
										<a href="platos_add.php?idpac=<?php echo $idPac; ?>&key=<?php echo $keyForm; ?>&idmenu=<?php echo $idM; ?>&idprogra=<?php echo $row3["id"]; ?>&tipo=4&idtp=<?php echo $idplato;?>&van=<?php echo $_GET["van"]; ?>" class="btn btn-lg w-100" style="font-size: 14pt; background: #<?php echo $btncol;?>; color: #<?php echo $txtcol;?>; box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 16pt; <?php if(strlen($row["nombre"]) < 25){ echo "padding-top: 18px;"; } ?>">
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
										<a href="?id=<?php echo $idPac; ?>&idtp=<?php echo $idplato; ?>&id2=<?php echo $idM; ?>&id3=<?php echo $idopc; ?>&id4=<?php echo $idopc1; ?>&id5=<?php echo $idopc2;?>&id6=<?php echo $id4;?>&opt6=SI&van=<?php echo $_GET["van"];?>" class="btn btn-lg w-100" style="font-size: 14pt; background: #<?php echo $btncol;?>; color: #<?php echo $txtcol;?>; box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 16pt; <?php if(strlen($row["nombre"]) < 25){ echo "padding-top: 18px;"; } ?>">
											<?php echo $row4["nombre"]; ?>
										</a>
									</div>
								<?php }else{ ?>	
									<div class="col-4 px-2 mt-3 text-center">
										<a href="platos_add.php?idpac=<?php echo $idPac; ?>&key=<?php echo $keyForm; ?>&idmenu=<?php echo $idM; ?>&idprogra=<?php echo $row4["id"]; ?>&tipo=5&idtp=<?php echo $idplato;?>&van=<?php echo $_GET["van"]; ?>" class="btn btn-lg w-100" style="font-size: 14pt; background: #<?php echo $btncol;?>; color: #<?php echo $txtcol;?>; box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 16pt; <?php if(strlen($row["nombre"]) < 25){ echo "padding-top: 18px;"; } ?>">
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
									<a href="platos_add.php?idpac=<?php echo $idPac; ?>&key=<?php echo $keyForm; ?>&idmenu=<?php echo $idM; ?>&idprogra=<?php echo $row5["id"]; ?>&tipo=6&idtp=<?php echo $idplato;?>&van=<?php echo $_GET["van"]; ?>" class="btn btn-lg w-100" style="font-size: 14pt; background: #<?php echo $btncol;?>; color: #<?php echo $txtcol;?>; box-shadow: 5px 10px 10px -10px #808080; height: 60px; line-height: 16pt; <?php if(strlen($row["nombre"]) < 25){ echo "padding-top: 18px;"; } ?>">
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
						<h5 class="mt-0 mb-2 bg-info text-light text-center p-3" style="border-radius: 4px;">Menú elegido</h5>
						
						<div class="table-elegidas" id="tasks" style="min-height: 150px;"></div>

						<div class="row mt-3 pb-4">
							<div class="col-md-12">
								<label>Observaciones</label>
								<textarea name="observaciones" id="observaciones" rows="4" class="form-control"><?php echo $observaciones; ?></textarea>
							</div>
						</div>
						
						<input type="submit" name="submitform" class="form-control btn text-light" value="grabar solicitud" style="font-weight: bold; font-size: 18pt; background: #002d59; margin-top: 0px;">
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>

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

