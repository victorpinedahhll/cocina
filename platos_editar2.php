<?php
$titulo = "Platos Cocina";
$nologg = "SI";
$page   = "platos";

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
	  background: #f4f6f9 url('images/bg-cocina.jpg') no-repeat top center; background-size: cover;
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

<?php
$id    = $_GET['id'];
$qryAg = "SELECT * FROM _menus WHERE id='$id'";
$rsAg  = $conexion->query($qryAg);
$rowR = $rsAg->fetch_assoc();
?>

<div class="row pt-0 mb-4">
	<div class="col-md-12 content-box position-relative">
		<header>
		<div class="row">
			<div class="col-md-3 pt-2">
				<img src="images/logo-trans.png" height="60">
			</div>
			<div class="col-md-2 pt-4 esconder-tablet text-center">
				<h1 class="pb-0 mb-0" style="font-size: 16pt !important; height: 60px;">&nbsp;</h1>
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

		<div class="container" style="margin-top: 175px;">
			<div class="row">
				<div class="col-md-7 box-admin-opt">
					<form action="platos_grabar.php" method="POST" accept-charset="utf-8">
					<input type="hidden" name="acc" value="edit">
					<input type="hidden" name="id"  value="<?php echo $rowR["id"];?>">
					<div class="row">
						<div class="col-md-8">
							<h5 class="mt-0 mb-3 pl-2 text-info"><b><a href="platos.php" class="text-info">< Editar Plato</a></b></h5>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label>Nombre *</label>
							<input type="text" name="nombre" class="form-control" value="<?php echo $rowR["nombre"];?>" required="required" style="font-weight: bold; font-size: 18pt;">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12 pb-2">
							<label>Tipo Menu</label>
							<div class="row">
							<?php
							$qryTM = "SELECT *, (select idtipo from _menu_tipo_enlace b where b.idtipo=a.id and idmenu='$id') as idtipo FROM _tipo_menu a WHERE status='A' ORDER by id";
							$rsTM  = $conexion->query($qryTM);
							while ($rowTM = $rsTM->fetch_assoc()){
							?>
								<div class="col-md-5">
									<input type="checkbox" name="tmen_<?php echo $rowTM["id"]; ?>" value="<?php echo $rowTM["id"]; ?>" <?php if($rowTM["id"]==$rowTM["idtipo"]){ echo "checked"; } ?>>&nbsp; <?php echo $rowTM["nombre"]; ?>
								</div>
							<?php } ?>
							</div>
						</div>
						<div class="form-group col-md-12">
							<label>Tipo Dieta</label>
							<div class="row">
							<?php
							$qryTM = "SELECT *, (select iddieta from _menu_dieta_enlace b where b.iddieta=a.id and idmenu='$id') as iddieta FROM _tipo_dieta a WHERE status='A' ORDER by id";
							$rsTM  = $conexion->query($qryTM);
							while ($rowTM = $rsTM->fetch_assoc()){
							?>
								<div class="col-md-5">
									<input type="checkbox" name="tdie_<?php echo $rowTM["id"]; ?>" value="<?php echo $rowTM["id"]; ?>" <?php if($rowTM["id"]==$rowTM["iddieta"]){ echo "checked"; } ?>>&nbsp; <?php echo $rowTM["nombre"]; ?>
								</div>
							<?php } ?>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label>Descripción</label>
							<textarea name="descripcion" class="form-control" rows="2"><?php echo $rowR["descripcion"];?></textarea>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label>Status</label>&nbsp;&nbsp; 
							<input type="radio" name="status" value="A" <?php if($rowR["status"]=="A"){ echo "checked"; } ?>> Activo&nbsp; 
							<input type="radio" name="status" value="I" <?php if($rowR["status"]=="I"){ echo "checked"; } ?>> Inactivo
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<input type="submit" name="submitformEdit" class="form-control btn btn-info text-light" value="grabar cambios">
						</div>
					</div>
					</form>
				</div>
				<div class="col-md-5">
					<div class="box-admin-opt">
						<a href="#" data-toggle="modal" data-target="#boxAdd" class="btn btn-info w-100">
							agregar opción
						</a>

						<h6 class="text-dark mt-3 mb-3 text-center"><b>Opciones disponibles</b></h6>

						<div class="row bg-muted text-dark" style="border-radius: 4px; height: 27px;">
							<div class="col-7"><b>Nombre</b></div>
							<div class="col-3 text-center"><b>Status</b></div>
							<div class="col-1 text-center">&nbsp;</div>
						</div>
						
						<?php 
						$qryOp = "SELECT * FROM _menus_opciones WHERE status!='E' and idmenu='$id' ORDER by status, nombre";
						$rsOp  = $conexion->query($qryOp);
						while ($rowOp = $rsOp->fetch_assoc()){
							$van = $van + 1;

							$bgf = "";
							if($rowOp["status"]=="I"){
								$bgf = "background: #fbe4e4;";
							}
							?>
							<div class="row py-2 <?php if ($van%2==0){ echo "bg-muted"; } ?>" style="<?php echo $bgf; ?>; border: 1px solid #eee; border-top: 0px;">
								<div class="col-7">
									<a href="platos_opciones_editar.php?id=<?php echo $rowOp["id"];?>&idm=<?php echo $id;?>">
										<?php echo $rowOp["nombre"];?>
									</a>
								</div>
								<div class="col-3 text-center">
									<?php if($rowOp["status"]=="A"){?>
										Activo
									<?php }elseif($rowOp["status"]=="E"){?>
										Eliminado
									<?php }else{ ?>
										Inactivo
									<?php } ?>
								</div>
								<div class="col-1">
									<a href="#" data-toggle="modal" data-target="#boxDel<?php echo $rowOp["id"];?>" class="text-muted" style="font-size: 9pt;">
										<i class="fa fa-trash"></i>
									</a>
								</div>
							</div>

							<!-- Modal editar -->
							<div class="modal fade" id="boxEdit<?php echo $rowOp["id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  	<div class="modal-dialog modal-dialog-centered position-relative" role="document">
							    	<div class="modal-content" style="background: linear-gradient(#f4f6f9, #dae4f4);">
								        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="top:20px; right: 20px; z-index: 777;">
								          <span aria-hidden="true">&times;</span>
								        </button>
										<div class="modal-body p-4">
											<form action="platos_opciones_grabar.php" method="POST" accept-charset="utf-8">
											<input type="hidden" name="acc" value="edit">
											<input type="hidden" name="id"  value="<?php echo $rowOp["id"];?>">
											<input type="hidden" name="idmenu" value="<?php echo $id;?>">
											<div class="row">
												<div class="col-md-8">
													<h5 class="mt-0 mb-3 pl-2 text-info"><b>Editar Opción</b></h5>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-12">
													<label>Nombre *</label>
													<input type="text" name="nombre" class="form-control" value="<?php echo $rowOp["nombre"];?>" required="required">
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-12">
													<label>Descripción</label>
													<textarea name="descripcion" class="form-control" rows="2"><?php echo $rowOp["descripcion"];?></textarea>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-12">
													<label>Status</label>&nbsp;&nbsp; 
													<input type="radio" name="status" value="A" <?php if($rowOp["status"]=="A"){ echo "checked"; } ?>> Activo&nbsp; 
													<input type="radio" name="status" value="I" <?php if($rowOp["status"]=="I"){ echo "checked"; } ?>> Inactivo
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-6">
													<input type="submit" name="submitformEdit" class="form-control btn btn-info text-light" value="grabar cambios">
												</div>
											</div>
											</form>
										</div>
									</div>
								</div>
							</div>

							<!-- Modal borrar -->
							<div class="modal fade" id="boxDel<?php echo $rowOp["id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  	<div class="modal-dialog modal-dialog-centered position-relative" role="document">
							    	<div class="modal-content" style="background: linear-gradient(#f4f6f9, #dae4f4);">
								        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="top:20px; right: 20px; z-index: 777;">
								          <span aria-hidden="true">&times;</span>
								        </button>
										<div class="modal-body p-4">
											<form action="platos_opciones_grabar.php" method="POST" accept-charset="utf-8">
											<input type="hidden" name="acc" value="delete">
											<input type="hidden" name="id"  value="<?php echo $rowOp["id"];?>">
											<input type="hidden" name="idmenu" value="<?php echo $id;?>">
											<div class="row">
												<div class="col-md-8">
													<h5 class="mt-0 mb-3 pl-2 text-info"><b>Eliminar Opción</b></h5>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-12">
													Esta seguro de querer eliminar la opción: <b><?php echo $rowOp["nombre"];?></b>?
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-6">
													<input type="submit" name="submitformDel" class="form-control btn btn-info text-light" value="Si, eliminar">
												</div>
											</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>

			<!-- Modal agregar -->
			<div class="modal fade" id="boxAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  	<div class="modal-dialog modal-dialog-centered position-relative" role="document">
			    	<div class="modal-content" style="background: linear-gradient(#f4f6f9, #dae4f4);">
				        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="top:20px; right: 20px; z-index: 777;">
				          <span aria-hidden="true">&times;</span>
				        </button>
						<div class="modal-body p-4">
							<form action="platos_opciones_grabar.php" method="POST" accept-charset="utf-8">
							<input type="hidden" name="acc" value="add">
							<input type="hidden" name="idmenu" value="<?php echo $rowR["id"]; ?>">
							<div class="row">
								<div class="col-md-8">
									<h5 class="mt-0 mb-3 pl-2 text-info"><b>Agregar opciónes</b></h5>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-12">
									<label>Nombre *</label>
									<input type="text" name="nombre" class="form-control">
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-12">
									<label>Descripción</label>
									<textarea name="descripcion" class="form-control" rows="2"></textarea>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-12">
									<label>Status</label>&nbsp;&nbsp; 
									<input type="radio" name="status" value="A" checked> Activo&nbsp; 
									<input type="radio" name="status" value="I"> Inactivo
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-6">
									<input type="submit" name="submitform" class="form-control btn btn-info text-light" value="agregar">
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

<?php include("footer.php"); ?>

