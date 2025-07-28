<?php
$titulo    = "Mi Perfil";
$nologg    = "SI";
$page      = "perfil";

include("header.php");

$qryEdit = "SELECT * FROM _usuarios_admin WHERE id_us00='$idsession'";
$rsEdit  = $conexion->query($qryEdit);
?>
<style>
	body {
	  background: #f4f6f9;
	  }
	.logout {
        position: absolute;
    }
	.content-text {
		margin: 30px 21px 0 21px;
	}
	h5 {
		margin: 25px 0px 30px 0px;
		color: #538cbe;
		text-transform: uppercase;
		font-size: 20pt;
	}
	.marco-con {
		margin-top: 50px;
		margin-bottom: 30px;
		padding: 20px;
		background: #f2f2f2;
	}
</style>
<div class="row pt-0 pl-5 pr-5 mb-4">
	<div class="col-md-2"></div>
	<div class="col-md-8 content-box position-relative" style="margin-top: 150px;">
		
		<div class="row content-text mb-5">
			<div class="col-md-12">
				<?php
				if ($rsEdit->num_rows > 0 && isset($_SESSION['logincook'])) {
					$rowEdit = $rsEdit->fetch_assoc();
					
					
					// DATOS DE LA NOTIFICACIÓN
					$nombre     = $rowEdit['nombre_us07'];
					$usuario    = $rowEdit['usuario_us13'];
					$email      = $rowEdit["email_wua25"];
					?>
			
					<form action="perfil_grabar.php" method="POST" autocomplete="off">
					<input type="hidden" name="acc" value="editar">
					<input type="hidden" name="idr" value="<?php echo $idRes; ?>">
					
					<div class="form-row">
						<div class="form-group col-md-6">
							<label>Usuario</label><br>
							<h3><b><?php echo $usuario; ?></b></h3>
						</div>
						<?php if($_GET["ch"]=="SI"){ ?>
						<div class="form-group col-md-6" data-appear-animation="fadeOut" data-appear-animation-delay="1100" data-appear-animation-duration="2s">
							<button class="btn btn-success" style="font-size: 12pt;">
								<b>Tus datos han sido actualizados</b>
							</button>
						</div>
						<?php } ?>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label>Nombre</label>
							<input type="text" name="nombre" class="form-control" value="<?php echo $nombre; ?>" required="required">
						</div>
						<div class="form-group col-md-6">
							<label>Email</label>
							<input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label>Contraseña</label>
							<input type="text" name="clave1" class="form-control">
						</div>
						<div class="form-group col-md-6">
							<label>Contraseña confirmar</label>
							<input type="text" name="clave2" class="form-control">
						</div>
					</div>
					<div class="form-row mt-4 mb-5">
						<div class="col-md-4">
							<input type="submit" name="submitform" value="Grabar Cambios" class="btn btn-cocina" style="font-weight: bold;">
						</div>
					</div>
					</form>

				<?php }else{ ?>
				<h3>Acceso Denegado</h3>
				<p>Sus permisos no permiten el ingreso a esta área</p>
				<?php } ?>
			</div>
			<div class="col-md-3">
				
			</div>
		</div>
	</div>
</div>

<?php include("footer.php"); ?>
