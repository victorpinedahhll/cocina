<?php
$titulo = "Pacientes Cocina";
$nologg = "SI";
$page   = "pacientesart";

include("header.php");

if($nvsessiontemp!="S"){
	echo "<body>";
	echo "<script>alert('Acceso Denegado o a expirado su sesion');document.location='logout.php';</script>";
	echo "</body>";
	exit;
}

$idPac  = $_GET["id"];
$qryPac = "SELECT * FROM _pacientes_activos WHERE status='A' and id='$idPac'";
$rsPac  = $conexion->query($qryPac);
$rowPac = $rsPac->fetch_assoc();

$fechain = $rowPac["fecha_ingreso"];
$nombre  = $rowPac["nombre"];
$habitacion = $rowPac["habitacion"];
$cama    = $rowPac["cama"];
$medico  = $rowPac["medico_tratante"];
$observaciones = $rowPac["observaciones"];
$status  = $rowPac["status"];
?>
<style>
	body {
	  background: #f4f6f9 url('images/bg-darkwood.jpg') no-repeat top center fixed; background-size: cover;
	  }
	.logout {
        
    }
	.content-text {
		margin: 160px 21px 0 21px;
	}
	header {
		height: 60px !important;
		background: transparent !important;
	}

</style>

<div class="row pt-0">
	<div class="col-md-12 content-box position-relative">
		<header style="position: absolute;">
		<div class="row">
			<div class="col-md-3 pt-2">
				<img src="images/logo-herrerallerandi.png" height="60">
			</div>
			<div class="col-md-2 pt-4 esconder-tablet text-center">
				<h1 class="pb-0 mb-0" style="font-size: 16pt !important;"></h1>
			</div>
			<div class="col-md-7 pt-5 text-right" style="padding-top: 33px;">

			</div>
		</div>
		


		<style>
			.colores {
				margin: -12px 0 12px 0;
				font-size: 10pt;
			}
			.colores i {
				border:  1px solid #808080;
			}
			.form-control {
				font-weight: bold;
			}
		</style>
		
		</header>

		<div style="width: 90%; margin: 50px auto 50px auto;">
			<form id="form-prueba" action="pacientes_formulario.php" method="POST" autocomplete="off">
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
			<input type="hidden" name="paciente" id="idpaciente" value="<?php echo $idPaciente; ?>">
			<div class="row">
				<div class="col-md-4 p-0" style="z-index: 5;">
					<div class="box-admin-opt-art mt-5" style="background-position: center center; min-height: 535px;">
						<h3 class="title-menu"><i class="fa fa-user" style="color: #b79869; font-size: 30pt;"></i>&nbsp;&nbsp; Datos del paciente</h3>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label>Primer Nombre *</label>
								<input type="text" name="pnombre" id="pnombre" class="form-control" required="required" value="<?php echo $pnombre; ?>">
							</div>
							<div class="form-group col-md-6">
								<label>Segundo Nombre</label>
								<input type="text" name="snombre" id="snombre" class="form-control" value="<?php echo $snombre; ?>">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label>Primer Apellido *</label>
								<input type="text" name="papellido" id="papellido" class="form-control" required="required" value="<?php echo $papellido; ?>">
							</div>
							<div class="form-group col-md-6">
								<label>Segundo Apellido</label>
								<input type="text" name="sapellido" id="sapellido" class="form-control" value="<?php echo $sapellido; ?>">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-12">
								<label>Habitacion/Cama *</label>
								<select name="habitacion" class="form-control">
									<option value="0">Elija una</option>
									<option value="PEDIATRIA-1 CAMA 1" <?php if($habitacion=="PEDIATRIA-1 CAMA 1"){ echo "selected"; } ?>>PEDIATRIA-1 &nbsp;&nbsp;(cama 1)</option>
									<option value="PEDIATRIA-2 CAMA 1" <?php if($habitacion=="PEDIATRIA-2 CAMA 1"){ echo "selected"; } ?>>PEDIATRIA-2 &nbsp;&nbsp;(cama 1)</option>
									<option value="PEDIATRIA-3 CAMA 1" <?php if($habitacion=="PEDIATRIA-3 CAMA 1"){ echo "selected"; } ?>>PEDIATRIA-3 &nbsp;&nbsp;(cama 1)</option>
									<option value="PEDIATRIA-4 CAMA 1" <?php if($habitacion=="PEDIATRIA-4 CAMA 1"){ echo "selected"; } ?>>PEDIATRIA-4 &nbsp;&nbsp;(cama 1)</option>
									<option value="PEDIATRIA-4 CAMA 2" <?php if($habitacion=="PEDIATRIA-4 CAMA "){ echo "selected"; } ?>>PEDIATRIA-4 &nbsp;&nbsp;(cama 2)</option>
									<option value="PEDIATRIA-5 CAMA 1" <?php if($habitacion=="PEDIATRIA-5 CAMA 1"){ echo "selected"; } ?>>PEDIATRIA-5 &nbsp;&nbsp;(cama 1)</option>
									<option value="PEDIATRIA-5 CAMA 2" <?php if($habitacion=="PEDIATRIA-5 CAMA 2"){ echo "selected"; } ?>>PEDIATRIA-5 &nbsp;&nbsp;(cama 2)</option>
									<option value="PEDIATRIA-6 CAMA 1" <?php if($habitacion=="PEDIATRIA-6 CAMA 1"){ echo "selected"; } ?>>PEDIATRIA-6 &nbsp;&nbsp;(cama 1)</option>
									<option value="PEDIATRIA-6 CAMA 2" <?php if($habitacion=="PEDIATRIA-6 CAMA 2"){ echo "selected"; } ?>>PEDIATRIA-6 &nbsp;&nbsp;(cama 2)</option>

									<option value="MEDICINA-5 CAMA 1" <?php if($habitacion=="MEDICINA-5 CAMA 1"){ echo "selected"; } ?>>MEDICINA-5 &nbsp;&nbsp;(cama 1)</option>
									<option value="MEDICINA-6 CAMA 1" <?php if($habitacion=="MEDICINA-6 CAMA 1"){ echo "selected"; } ?>>MEDICINA-6 &nbsp;&nbsp;(cama 1)</option>
									<option value="MEDICINA-7 CAMA 1" <?php if($habitacion=="MEDICINA-7 CAMA 1"){ echo "selected"; } ?>>MEDICINA-7 &nbsp;&nbsp;(cama 1)</option>
									<option value="MEDICINA-8 CAMA 1" <?php if($habitacion=="MEDICINA-8 CAMA 1"){ echo "selected"; } ?>>MEDICINA-8 &nbsp;&nbsp;(cama 1)</option>
									<option value="MEDICINA-9 CAMA 1" <?php if($habitacion=="MEDICINA-9 CAMA 1"){ echo "selected"; } ?>>MEDICINA-9 &nbsp;&nbsp;(cama 1)</option>
									<option value="MEDICINA-10 CAMA 1" <?php if($habitacion=="MEDICINA-10 CAMA 1"){ echo "selected"; } ?>>MEDICINA-10 &nbsp;&nbsp;(cama 1)</option>
									<option value="MEDICINA-23 CAMA 1" <?php if($habitacion=="MEDICINA-23 CAMA 1"){ echo "selected"; } ?>>MEDICINA-23 &nbsp;&nbsp;(cama 1)</option>
									<option value="MEDICINA-23 CAMA 2" <?php if($habitacion=="MEDICINA-23 CAMA 2"){ echo "selected"; } ?>>MEDICINA-23 &nbsp;&nbsp;(cama 2)</option>
									<option value="MEDICINA-24 CAMA 1" <?php if($habitacion=="MEDICINA-24 CAMA 1"){ echo "selected"; } ?>>MEDICINA-24 &nbsp;&nbsp;(cama 1)</option>
									<option value="MEDICINA-24 CAMA 2" <?php if($habitacion=="MEDICINA-24 CAMA 2"){ echo "selected"; } ?>>MEDICINA-24 &nbsp;&nbsp;(cama 2)</option>
									<option value="MEDICINA-25 CAMA 1" <?php if($habitacion=="MEDICINA-25 CAMA 1"){ echo "selected"; } ?>>MEDICINA-25 &nbsp;&nbsp;(cama 1)</option>
									<option value="MEDICINA-25 CAMA 2" <?php if($habitacion=="MEDICINA-25 CAMA 2"){ echo "selected"; } ?>>MEDICINA-25 &nbsp;&nbsp;(cama 2)</option>
									<option value="MEDICINA-26 CAMA 1" <?php if($habitacion=="MEDICINA-26 CAMA 1"){ echo "selected"; } ?>>MEDICINA-26 &nbsp;&nbsp;(cama 1)</option>
									<option value="MEDICINA-26 CAMA 2" <?php if($habitacion=="MEDICINA-26 CAMA 2"){ echo "selected"; } ?>>MEDICINA-26 &nbsp;&nbsp;(cama 2)</option>

									<option value="NEONATOS-1 CAMA 1" <?php if($habitacion=="NEONATOS-1 CAMA 1"){ echo "selected"; } ?>>NEONATOS-1 &nbsp;&nbsp;(cama 1)</option>
									<option value="NEONATOS-2 CAMA 1" <?php if($habitacion=="NEONATOS-2 CAMA 1"){ echo "selected"; } ?>>NEONATOS-2 &nbsp;&nbsp;(cama 1)</option>

									<option value="MATERNIDAD-1 CAMA 1" <?php if($habitacion=="MATERNIDAD-1 CAMA 1"){ echo "selected"; } ?>>MATERNIDAD-1 &nbsp;&nbsp;(cama 1)</option>
									<option value="MATERNIDAD-2 CAMA 1" <?php if($habitacion=="MATERNIDAD-2 CAMA 1"){ echo "selected"; } ?>>MATERNIDAD-2 &nbsp;&nbsp;(cama 1)</option>
									<option value="MATERNIDAD-3 CAMA 1" <?php if($habitacion=="MATERNIDAD-3 CAMA 1"){ echo "selected"; } ?>>MATERNIDAD-3 &nbsp;&nbsp;(cama 1)</option>
									<option value="MATERNIDAD-4 CAMA 1" <?php if($habitacion=="MATERNIDAD-4 CAMA 1"){ echo "selected"; } ?>>MATERNIDAD-4 &nbsp;&nbsp;(cama 1)</option>
									<option value="MATERNIDAD-5 CAMA 1" <?php if($habitacion=="MATERNIDAD-5 CAMA 1"){ echo "selected"; } ?>>MATERNIDAD-5 &nbsp;&nbsp;(cama 1)</option>
									<option value="MATERNIDAD-6 CAMA 1" <?php if($habitacion=="MATERNIDAD-6 CAMA 1"){ echo "selected"; } ?>>MATERNIDAD-6 &nbsp;&nbsp;(cama 1)</option>
									<option value="MATERNIDAD-7 CAMA 1" <?php if($habitacion=="MATERNIDAD-7 CAMA 1"){ echo "selected"; } ?>>MATERNIDAD-7 &nbsp;&nbsp;(cama 1)</option>
									<option value="MATERNIDAD-8 CAMA 1" <?php if($habitacion=="MATERNIDAD-8 CAMA 1"){ echo "selected"; } ?>>MATERNIDAD-8 &nbsp;&nbsp;(cama 1)</option>
									<option value="MATERNIDAD-9 CAMA 1" <?php if($habitacion=="MATERNIDAD-9 CAMA 1"){ echo "selected"; } ?>>MATERNIDAD-9 &nbsp;&nbsp;(cama 1)</option>
									<option value="MATERNIDAD-10 CAMA 1" <?php if($habitacion=="MATERNIDAD-10 CAMA 1"){ echo "selected"; } ?>>MATERNIDAD-10 &nbsp;&nbsp;(cama 1)</option>

									<option value="INTENSIVO NEONATOS-1 CAMA 1" <?php if($habitacion=="INTENSIVO NEONATOS-1 CAMA 1"){ echo "selected"; } ?>>INTENSIVO NEONATOS-1 &nbsp;&nbsp;(cama 1)</option>

									<option value="INTENSIVO-1 CAMA 1" <?php if($habitacion=="INTENSIVO-1 CAMA 1"){ echo "selected"; } ?>>INTENSIVO-1 &nbsp;&nbsp;(cama 1)</option>
									<option value="INTENSIVO-2 CAMA 1" <?php if($habitacion=="INTENSIVO-2 CAMA 1"){ echo "selected"; } ?>>INTENSIVO-2 &nbsp;&nbsp;(cama 1)</option>
									<option value="INTENSIVO-3 CAMA 1" <?php if($habitacion=="INTENSIVO-3 CAMA 1"){ echo "selected"; } ?>>INTENSIVO-3 &nbsp;&nbsp;(cama 1)</option>
									<option value="INTENSIVO-4 CAMA 1" <?php if($habitacion=="INTENSIVO-4 CAMA 1"){ echo "selected"; } ?>>INTENSIVO-4 &nbsp;&nbsp;(cama 1)</option>
									<option value="INTENSIVO-5 CAMA 1" <?php if($habitacion=="INTENSIVO-5 CAMA 1"){ echo "selected"; } ?>>INTENSIVO-5 &nbsp;&nbsp;(cama 1)</option>
									<option value="INTENSIVO-6 CAMA 1" <?php if($habitacion=="INTENSIVO-6 CAMA 1"){ echo "selected"; } ?>>INTENSIVO-6 &nbsp;&nbsp;(cama 1)</option>
									<option value="INTENSIVO-7 CAMA 1" <?php if($habitacion=="INTENSIVO-7 CAMA 1"){ echo "selected"; } ?>>INTENSIVO-7 &nbsp;&nbsp;(cama 1)</option>
									<option value="INTENSIVO-8 CAMA 1" <?php if($habitacion=="INTENSIVO-8 CAMA 1"){ echo "selected"; } ?>>INTENSIVO-8 &nbsp;&nbsp;(cama 1)</option>
									<option value="INTENSIVO-9 CAMA 1" <?php if($habitacion=="INTENSIVO-9 CAMA 1"){ echo "selected"; } ?>>INTENSIVO-9 &nbsp;&nbsp;(cama 1)</option>
									<option value="INTENSIVO-10 CAMA 1" <?php if($habitacion=="INTENSIVO-10 CAMA 1"){ echo "selected"; } ?>>INTENSIVO-10 &nbsp;&nbsp;(cama 1)</option>
									<option value="INTENSIVO-11 CAMA 1" <?php if($habitacion=="INTENSIVO-11 CAMA 1"){ echo "selected"; } ?>>INTENSIVO-11 &nbsp;&nbsp;(cama 1)</option>

									<option value="HEMODIALISIS-1 CAMA 1" <?php if($habitacion=="HEMODIALISIS-1 CAMA 1"){ echo "selected"; } ?>>HEMODIALISIS-1 &nbsp;&nbsp;(cama 1)</option>
									<option value="HEMODIALISIS-1 CAMA 2" <?php if($habitacion=="HEMODIALISIS-1 CAMA 2"){ echo "selected"; } ?>>HEMODIALISIS-1 &nbsp;&nbsp;(cama 2)</option>

									<option value="GASTROSCOPIA-1 CAMA 1" <?php if($habitacion=="GASTROSCOPIA-1 CAMA 1"){ echo "selected"; } ?>>GASTROSCOPIA-1 &nbsp;&nbsp;(cama 1)</option>
									<option value="GASTROSCOPIA-2 CAMA 2" <?php if($habitacion=="GASTROSCOPIA-2 CAMA 2"){ echo "selected"; } ?>>GASTROSCOPIA-2 &nbsp;&nbsp;(cama 2)</option>

									<option value="CIRUGIA-11 CAMA 1" <?php if($habitacion=="CIRUGIA-11 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-11 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-12 CAMA 1" <?php if($habitacion=="CIRUGIA-12 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-12 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-14 CAMA 1" <?php if($habitacion=="CIRUGIA-14 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-14 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-15 CAMA 1" <?php if($habitacion=="CIRUGIA-15 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-15 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-16 CAMA 1" <?php if($habitacion=="CIRUGIA-16 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-16 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-18 CAMA 1" <?php if($habitacion=="CIRUGIA-18 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-18 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-18 CAMA 2" <?php if($habitacion=="CIRUGIA-18 CAMA 2"){ echo "selected"; } ?>>CIRUGIA-18 &nbsp;&nbsp;(cama 2)</option>
									<option value="CIRUGIA-19 CAMA 1" <?php if($habitacion=="CIRUGIA-19 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-19 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-19 CAMA 2" <?php if($habitacion=="CIRUGIA-19 CAMA 2"){ echo "selected"; } ?>>CIRUGIA-19 &nbsp;&nbsp;(cama 2)</option>
									<option value="CIRUGIA-20 CAMA 1" <?php if($habitacion=="CIRUGIA-20 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-20 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-20 CAMA 2" <?php if($habitacion=="CIRUGIA-20 CAMA 2"){ echo "selected"; } ?>>CIRUGIA-20 &nbsp;&nbsp;(cama 2)</option>
									<option value="CIRUGIA-22 CAMA 1" <?php if($habitacion=="CIRUGIA-22 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-22 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-22 CAMA 2" <?php if($habitacion=="CIRUGIA-22 CAMA 2"){ echo "selected"; } ?>>CIRUGIA-22 &nbsp;&nbsp;(cama 2)</option>
									<option value="CIRUGIA-131 CAMA 1" <?php if($habitacion=="CIRUGIA-131 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-131 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-132 CAMA 1" <?php if($habitacion=="CIRUGIA-132 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-132 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-133 CAMA 1" <?php if($habitacion=="CIRUGIA-133 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-133 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-134 CAMA 1" <?php if($habitacion=="CIRUGIA-134 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-134 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-135 CAMA 1" <?php if($habitacion=="CIRUGIA-135 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-135 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-136 CAMA 1" <?php if($habitacion=="CIRUGIA-136 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-136 &nbsp;&nbsp;(cama 1)</option>
									<option value="CIRUGIA-137 CAMA 1" <?php if($habitacion=="CIRUGIA-137 CAMA 1"){ echo "selected"; } ?>>CIRUGIA-137 &nbsp;&nbsp;(cama 1)</option>

									<option value="AISLAMIENTO-1 CAMA 1" <?php if($habitacion=="AISLAMIENTO-1 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-1 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-2 CAMA 1" <?php if($habitacion=="AISLAMIENTO-2 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-2 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-3 CAMA 1" <?php if($habitacion=="AISLAMIENTO-3 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-3 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-4 CAMA 1" <?php if($habitacion=="AISLAMIENTO-4 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-4 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-5 CAMA 1" <?php if($habitacion=="AISLAMIENTO-5 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-5 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-6 CAMA 1" <?php if($habitacion=="AISLAMIENTO-6 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-6 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-7 CAMA 1" <?php if($habitacion=="AISLAMIENTO-7 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-7 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-8 CAMA 1" <?php if($habitacion=="AISLAMIENTO-8 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-8 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-8 CAMA 2" <?php if($habitacion=="AISLAMIENTO-8 CAMA 2"){ echo "selected"; } ?>>AISLAMIENTO-8 &nbsp;&nbsp;(cama 2)</option>
									<option value="AISLAMIENTO-9 CAMA 1" <?php if($habitacion=="AISLAMIENTO-9 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-9 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-9 CAMA 2" <?php if($habitacion=="AISLAMIENTO-9 CAMA 2"){ echo "selected"; } ?>>AISLAMIENTO-9 &nbsp;&nbsp;(cama 2)</option>
									<option value="AISLAMIENTO-10 CAMA 1" <?php if($habitacion=="AISLAMIENTO-10 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-10 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-10 CAMA 2" <?php if($habitacion=="AISLAMIENTO-10 CAMA 2"){ echo "selected"; } ?>>AISLAMIENTO-10 &nbsp;&nbsp;(cama 2)</option>
									<option value="AISLAMIENTO-11 CAMA 1" <?php if($habitacion=="AISLAMIENTO-11 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-11 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-11 CAMA 2" <?php if($habitacion=="AISLAMIENTO-11 CAMA 2"){ echo "selected"; } ?>>AISLAMIENTO-11 &nbsp;&nbsp;(cama 2)</option>
									<option value="AISLAMIENTO-12 CAMA 1" <?php if($habitacion=="AISLAMIENTO-12 CAMA 1"){ echo "selected"; } ?>>AISLAMIENTO-12 &nbsp;&nbsp;(cama 1)</option>
									<option value="AISLAMIENTO-12 CAMA 2" <?php if($habitacion=="AISLAMIENTO-12 CAMA 2"){ echo "selected"; } ?>>AISLAMIENTO-12 &nbsp;&nbsp;(cama 2)</option>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-12">
								<label>Médico tratante *</label>
								<select name="medico" id="medico" class="form-control" required="required">
									<option value="0">Elija uno</option>
									<?php
									$qryM2 = "SELECT * FROM web_medicos WHERE status_med37='A' and  colegiado_med35  > '0' ORDER by primer_apellido_med29,primer_nombre_med18";
									$rsM2 = $conexion2->query($qryM2);
									while ($rowM2 = $rsM2->fetch_assoc()){
									?>
									<option value="<?php echo $rowM2["cod_med12"]; ?>"><?php echo $rowM2["primer_apellido_med29"]; ?> <?php if(!empty($rowM2["segundo_apellido_med37"])){ echo $rowM2["segundo_apellido_med37"]; } ?>, <?php echo $rowM2["primer_nombre_med18"]; ?> <?php if(!empty($rowM2["segundo_nombre_med22"])){ echo $rowM2["segundo_nombre_med22"]; } ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 p-0" style="z-index: 15;">
					<div class="box-admin-opt-art" style="background-position: center center; min-height: 650px;">
						<h3 class="title-menu"><i class="fa fa-utensils" style="color: #b79869; font-size: 30pt;"></i>&nbsp;&nbsp; Menus activos</h3>
						<?php if(1==2){ ?>
						<div class="row mb-4">
							<div class="col-12 pr-3 position-relative">
								<input type="search" id="search" name="search" class="form-control" placeholder="buscador ej. huevos, jugo">
								<p class="position-absolute" id="opt-times" style="right: 30px; top: 7px;">
									<a href="#" id="texto-borrar" style="color: #A0A0A0;"><i class="fa fa-times"></i></a>
								</p>
							</div>
						</div>
						<!-- Search container -->
						<div id="prueba-result" style="margin-top: -15px; margin-bottom: 20px;">
							<div id="container"></div>
						</div>
						<?php } ?>

						<?php 
						$qryL = "SELECT * FROM _programaciones WHERE status!='E' and inicio <='$datenow' and final >='$datenow' ORDER by nombre";
						$rsL  = $conexion->query($qryL);
						while ($rowL = $rsL->fetch_assoc()){
						?>
						<button class="form-control mt-2" type="button" data-toggle="collapse" data-target="#collapseExample<?php echo $rowL["id"]; ?>" aria-expanded="false" aria-controls="collapseExample" style="background: #eee; text-align: left;">
							<b class="tit-pruebas"><?php echo $rowL["nombre"]; ?></b>
						</button>
						<div class="collapse p-2 mt-2" id="collapseExample<?php echo $rowL["id"]; ?>" style="min-height: 110px; background: rgba(255, 255, 255, 0.7); padding: 12px 25px 10px 20px; border-radius: 5px;">
							<?php 
							$idO  = $rowL["id"];
							$qryO = "SELECT * FROM _menus a WHERE a.id in (select idmenu from _menus_progra_enlace b where b.idmenu=a.id and b.idprogra='$idO') and a.status!='E' ORDER by a.nombre";
							$rsO  = $conexion->query($qryO);
							while ($rowO = $rsO->fetch_assoc()){
							?>
								<h6 class="mt-2"><?php echo $rowO["nombre"]; ?></h6>
								<?php 
								$idM  = $rowO["id"];
								$qryM = "SELECT *, (select idopcionmenu from _pacientes_menu_enlace b where b.idopcionmenu=a.id and b.idprogra='$idO' and keyunico='$keyForm') as idmo, (select keyunico from _pacientes_menu_enlace b where b.idopcionmenu=a.id and b.idprogra='$idO' and keyunico='$keyForm') as nkeyu FROM _menus_opciones a WHERE idmenu='$idM' and status!='E' ORDER by nombre";
								$rsM  = $conexion->query($qryM);
								while ($rowM = $rsM->fetch_assoc()){
								?>
								<div class="row px-2">
									<div class="col-md-12" style="font-size: 11pt;">
										<input type="checkbox" id="item<?php echo $idO; ?>-<?php echo $rowM["id"]; ?>" name="pr<?php echo $rowM["id"]; ?>" value="<?php echo $rowM["id"]; ?>" <?php if($rowM["idmo"]==$rowM["id"] && $rowM["nkeyu"]==$keyForm){ echo "checked"; } ?>>&nbsp; <?php echo $rowM["nombre"]; ?><br>
									</div>
								</div>
								<input type="hidden" id="idprogra<?php echo $rowL["id"]; ?>" value="<?php echo $rowL["id"]; ?>">
								<script>
									$(document).on('click', '#item<?php echo $idO; ?>-<?php echo $rowM["id"]; ?>', (e) => {
										const postData = {
											id: $('#item<?php echo $idO; ?>-<?php echo $rowM["id"]; ?>').val(),
											key: $('#key').val(),
											pacienteid: $('#idpaciente').val(),
											idprogra: $('#idprogra<?php echo $rowL["id"]; ?>').val()
										};
										$.post('platos_add.php', postData, (response) => {
							      			console.log(response);
							      			$("#item<?php echo $idO; ?>-<?php echo $rowM["id"]; ?>").prop("checked", true);
							      			fetchTasks();
							      		});
							      		e.preventDefault();
									});
								</script>
								<?php } ?>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
				</div>
				<div class="col-md-4 p-0">
					<div class="box-admin-opt-art mt-5" style="z-index: 5;">
						<h3 class="title-menu" style="background-position: center right;"><i class="fa fa-utensils" style="color: #b79869; font-size: 30pt;"></i>&nbsp;&nbsp; Menu elegido</h3>
						
						<div class="table-elegidas" id="tasks" style="min-height: 110px; background: rgba(255, 255, 255, 0.7); padding: 12px 25px 10px 20px; border-radius: 5px;"></div>

						<div class="row mt-3 pb-4">
							<div class="col-md-12">
								<label>Observaciones</label>
								<textarea name="observaciones" id="observaciones" rows="4" class="form-control"><?php echo $observaciones; ?></textarea>
							</div>
						</div>
						
						<input type="submit" name="submitform" class="form-control btn text-light" value="enviar solicitud" style="font-weight: bold; font-size: 18pt; background: linear-gradient(#271512,#070400); margin-top: 20px;">
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

</script>

<?php include("footer.php"); ?>

