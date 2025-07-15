<?php
$titulo = "Pacientes";
$nologg = "SI";
$page   = "pacientes";

include("header.php");

if($nvsessiontemp!="A"){
	echo "<body>";
	echo "<script>alert('Acceso Denegado o a expirado su sesion');document.location='logout.php';</script>";
	echo "</body>";
	exit;
}
?>
<style>
	body {
	  background: #f4f6f9 url('images/bg-cocina.jpg') no-repeat top center fixed; background-size: cover;
	  }
	.logout {
        position: fixed;
    }
	.content-text {
		margin: 160px 21px 0 21px;
	}
	header {
		height: 160px;
	}
</style>

<div class="row pt-0 mb-4">
	<div class="col-md-12 content-box position-relative">
		<header>
		<div class="row">
			<div class="col-md-3 pt-2">
				<img src="images/logo-trans.png" height="60">
			</div>
			<div class="col-md-2 pt-4 esconder-tablet text-center">
				<h1 class="pb-0 mb-0" style="font-size: 16pt !important;"></h1>
			</div>
			<div class="col-md-7 pt-5 text-right" style="padding-top: 33px;">
				<a href="#" class="btn btn-info" data-toggle="modal" data-target="#boxAdd" style="font-weight: bold;">
					agregar paciente
				</a>
			</div>
		</div>
		
		<div class="row mb-5">
			<div class="col-md-12">
				<div class="esconder-movil">
					<div class="mb-3 h4-sidebar-nobg text-center bg-info" style="height: 43px; font-size: 16pt; padding-top: 2px;">
						<?php echo $titulo;?>
					</div>
				</div>
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
		</style>
		
		</header>

		<div class="container" style="margin-top: 200px;">
			<div class="row">
				<div class="col-md-12">
					<div class="box-admin-opt pt-3">
						<div class="row bg-info text-light py-2" style="font-weight: bold;">
							<div class="col-md-2">
								Fecha Ingreso
							</div>
							<div class="col-md-3">
								Nombre Paciente
							</div>
							<div class="col-md-3 hidden-max-991">
								Habitación
							</div>
							<div class="col-md-4">
								Médico Tratante
							</div>
						</div>
						<?php 
						//$qryPac = "SELECT * FROM _pacientes_activos a WHERE a.id in (select id_paciente from _pacientes_solicitudes b WHERE a.id=b.id_paciente and b.status<'2') and a.status='A' ORDER by a.fecha_ingreso";
						$qryPac = "SELECT * FROM _pacientes_activos ORDER by status,fecha_ingreso";
						$rsPac  = $conexion->query($qryPac);
						while ($rowPac = $rsPac->fetch_assoc()){
						?>
						<div class="row py-2" <?php if($rowPac["status"]=="I"){ ?>style="background: #fbe0e2;"<?php } ?>>
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
								<?php if($rowPac["status"]=="I"){ ?><br><span class="text-danger" style="font-size: 9pt;">Inactivo</span><?php } ?>
							</div>
							<div class="col-md-3">
								<a href="pacientes_activos_editar.php?id=<?php echo $rowPac["id"]; ?>" style="text-decoration: underline;">
									<?php echo $rowPac["pnombre"]; ?> <?php if(!empty($rowPac["snombre"])) { echo $rowPac["snombre"]; } ?> <?php echo $rowPac["papellido"]; ?> <?php if(!empty($rowPac["sapellido"])) { echo $rowPac["sapellido"]; } ?>
								</a>
							</div>
							<div class="col-md-3 hidden-max-991">
								<?php echo $rowPac["habitacion"]; ?>
							</div>
							<div class="col-md-4">
								<?php echo $rowPac["medico_tratante"]; ?>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>

			<!-- Modal agregar -->
			<div class="modal fade" id="boxAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  	<div class="modal-dialog modal-lg position-relative" role="document">
				    <div class="modal-content" style="background: linear-gradient(#f4f6f9, #dae4f4);">
				        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="top:20px; right: 20px; z-index: 777;">
				          <span aria-hidden="true">&times;</span>
				        </button>
						<div class="modal-body p-4">
							<h5 class="mt-0 mb-3 pl-0 text-dark"><b>Agregar Paciente</b></h5>
							<form id="form-prueba" action="pacientes_activos_grabar.php" method="POST" autocomplete="off">
							<div class="row">
								<div class="col-md-12">
									<div class="box-admin-opt">
										<h5 class="pt-0 mt-0">Datos del paciente</h5>
										<div class="form-row">
											<div class="form-group col-md-6">
												<label>Fecha Ingreso *</label>
												<input type="date" name="fingreso" id="fingreso" class="form-control" required="required">
											</div>
											<div class="form-group col-md-6">
												<label>Código</label>
												<input type="text" name="pcodigo" id="pcodigo" class="form-control">
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-6">
												<label>Primer Nombre *</label>
												<input type="text" name="pnombre" id="pnombre" class="form-control" required="required">
											</div>
											<div class="form-group col-md-6">
												<label>Segundo Nombre</label>
												<input type="text" name="snombre" id="snombre" class="form-control">
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-6">
												<label>Primer Apellido *</label>
												<input type="text" name="papellido" id="papellido" class="form-control" required="required">
											</div>
											<div class="form-group col-md-6">
												<label>Segundo Apellido</label>
												<input type="text" name="sapellido" id="sapellido" class="form-control">
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-6">
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
											<div class="form-group col-md-6">
												<label>Médico tratante *</label>
												<select name="medico" id="medico" class="form-control" onChange="cambia_medico()" required="required">
													<option value="0">Elija uno</option>
													<?php
													$qryM2 = "SELECT * FROM web_medicos WHERE status_med37='A' and  colegiado_med35  > '0' ORDER by primer_apellido_med29,primer_nombre_med18";
													$rsM2 = $conexion2->query($qryM2);
													while ($rowM2 = $rsM2->fetch_assoc()){
													?>
													<option value="<?php echo $rowM2["cod_med12"]; ?>"><?php echo $rowM2["primer_apellido_med29"]; ?> <?php if(!empty($rowM2["segundo_apellido_med37"])){ echo $rowM2["segundo_apellido_med37"]; } ?>, <?php echo $rowM2["primer_nombre_med18"]; ?> <?php if(!empty($rowM2["segundo_nombre_med22"])){ echo $rowM2["segundo_nombre_med22"]; } ?></option>
													<?php } ?>
													<option value="999999">OTRO</option>
												</select>

												<div id="otrobox" style="display: none;">
												<div class="row">
													<div class="col-md-12">
														<input type="text" class="form-control mt-3" name="otromed" placeholder="nombre médico">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-12">
											<label>Motivo de ingreso</label>
											<textarea name="motivo" id="motivo" class="form-control" rows="2"></textarea>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-12">
											<label>Observaciones</label>
											<textarea name="observaciones" id="observaciones" class="form-control" rows="2"></textarea>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-12">
											<label>Alergias</label>&nbsp;  
											<input type="radio" name="alergias" value="Mariscos"> Mariscos&nbsp; 
											<input type="radio" name="alergias" value="Gluten"> Gluten&nbsp; 
											<input type="radio" name="alergias" value="Lactosa"> Lactosa&nbsp; 
											<input type="radio" name="alergias" value="NO" checked> Ninguna&nbsp; 
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-12">
											<label>Status</label>&nbsp;  
											<input type="radio" name="status" value="A" checked> Activo&nbsp; 
											<input type="radio" name="status" value="I"> Inactivo&nbsp; 
										</div>
									</div>
									<div class="form-row mt-3">
										<div class="form-group col-md-3"></div>
										<div class="form-group col-md-6">
											<input type="submit" name="submitadd" class="form-control btn text-light" value="agregar paciente" style="font-weight: bold; font-size: 18pt; background: #002d59; margin-top: 0px;">
										</div>
									</div>
								</div>
							</div>
							</form>
						</div>
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

