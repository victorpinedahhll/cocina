<?php
$titulo = "Formulario";
$nologg = "SI";
$page   = "form";

include("header.php");
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

			</div>
		</div>
		
		<div class="row mb-5">
			<div class="col-md-12">
				<div class="esconder-movil">
					<div class="mb-3 h4-sidebar-nobg text-center" style="height: 43px; font-size: 16pt; padding-top: 2px;">
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

		<div style="width: 90%; margin: 175px auto 50px auto;">
			<div class="row">
				<div class="col-md-4">
					<div class="box-admin-opt">
						<h5 class="pt-0 mt-0">Datos del paciente</h5>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label>Nombre *</label>
								<input type="text" name="pnombre" id="pnombre" class="form-control" required="required">
							</div>
							<div class="form-group col-md-6">
								<label>Apellido *</label>
								<input type="text" name="snombre" id="snombre" class="form-control">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label>Habitacion *</label>
								<select name="room" id="room" class="form-control" required="required">
									<option value="0">Elija uno</option>
								</select>
							</div>
							<div class="form-group col-md-6">
								<label>Cama # *</label>
								<input type="text" name="cama" id="cama" class="form-control" required="required">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-12">
								<label>Médico tratante *</label>
								<select name="medico" id="medico" class="form-control" required="required">
									<option value="0">Elija uno</option>
								</select>
							</div>
						</div>
						<div class="form-row pb-4">
							<div class="form-group col-md-12">
								<label>Observaciones</label>
								<textarea name="observaciones" id="observaciones" rows="7" class="form-control"></textarea>
							</div>
						</div>	
					</div>
				</div>
				<div class="col-md-4">
					<div class="box-admin-opt">
						<h5 class="pt-0 mt-0">Menus</h5>
						<div class="row mb-4">
							<div class="col-12 pr-3 position-relative">
								<input type="search" id="search" name="search" class="form-control" placeholder="buscador ej. huevos, jugo">
								<p class="position-absolute" id="opt-times" style="right: 30px; top: 7px;">
									<a href="#" id="texto-borrar" style="color: #A0A0A0;"><i class="fa fa-times"></i></a>
								</p>
							</div>
						</div>
						<?php 
						$qryL = "SELECT * FROM _programaciones WHERE status!='E' ORDER by nombre";
						$rsL  = $conexion->query($qryL);
						while ($rowL = $rsL->fetch_assoc()){
						?>
						<button class="form-control mt-2" type="button" data-toggle="collapse" data-target="#collapseExample<?php echo $rowL["id"]; ?>" aria-expanded="false" aria-controls="collapseExample" style="background: #eee; text-align: left;">
							<b class="tit-pruebas"><?php echo $rowL["nombre"]; ?></b>
						</button>
						<div class="collapse p-2" id="collapseExample<?php echo $rowL["id"]; ?>">
							<?php 
							$idO  = $rowL["id"];
							$qryO = "SELECT * FROM _menus a WHERE a.id in (select idmenu from _menus_progra_enlace b where b.idmenu=a.id and b.idprogra='$idO') and a.status!='E' ORDER by a.nombre";
							$rsO  = $conexion->query($qryO);
							while ($rowO = $rsO->fetch_assoc()){
							?>
								<h6 class="mt-2"><?php echo $rowO["nombre"]; ?></h6>
								<?php 
								$idM  = $rowO["id"];
								$qryM = "SELECT * FROM _menus_opciones WHERE idmenu='$idM' and status!='E' ORDER by nombre";
								$rsM  = $conexion->query($qryM);
								while ($rowM = $rsM->fetch_assoc()){
								?>
								<div class="row px-2">
									<div class="col-md-12" style="font-size: 11pt;">
										<input type="checkbox" id="item<?php echo $rowM["id"]; ?>" name="pr<?php echo $rowM["id"]; ?>" value="<?php echo $rowM["id"]; ?>" >&nbsp; <?php echo $rowM["nombre"]; ?><br>
									</div>
								</div>
								<?php } ?>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box-admin-opt">
						<h5 class="pt-0 mt-0">Menu elegido</h5>
						
						<table class="table-elegidas table-sm" style="min-height: 250px;">
							<tbody id="tasks"></tbody>
						</table>
						
						<input type="submit" name="submitform" class="form-control btn text-light" value="enviar solicitud" style="font-weight: bold; font-size: 18pt; background: #002d59; margin-top: 20px;">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include("footer.php"); ?>

