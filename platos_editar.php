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
					<form action="platos_grabar2.php" method="POST" accept-charset="utf-8">
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
							<div class="row py-1 text-light mt-2" style="background: #808080;">
								<div class="col-8">
									<b><?php echo $rowOp["nombre"];?></b>
								</div>
								<div class="col-1 text-center">
									<?php if($rowOp["status"]=="I"){?>
										<i class="fa fa-times text-danger2"></i>
									<?php }elseif($rowOp["status"]=="E"){?>
										<i class="fa fa-ban text-warning"></i>
									<?php }else{ ?>
										<i class="fa fa-check text-success2"></i>
									<?php } ?>
								</div>
								<div class="col-1">
									<a href="#" class="text-light" style="font-size: 9pt;" data-toggle="modal" data-target="#boxaddOp1<?php echo $rowOp["id"];?>">
										<i class="fa fa-plus"></i>
									</a>
								</div>
								<div class="col-1">
									<a href="#" class="text-light" style="font-size: 9pt;" data-toggle="modal" data-target="#boxeditOp1<?php echo $rowOp["id"];?>">
										<i class="fa fa-edit"></i>
									</a>
								</div>
								<div class="col-1">
									<a href="#" data-toggle="modal" data-target="#boxDelOp1<?php echo $rowOp["id"];?>" class="text-light" style="font-size: 9pt;">
										<i class="fa fa-trash"></i>
									</a>
								</div>
							</div>

							<!-- Modal agregar subopcion -->
							<div class="modal fade" id="boxaddOp1<?php echo $rowOp["id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  	<div class="modal-dialog modal-dialog-centered position-relative" role="document">
							    	<div class="modal-content" style="background: linear-gradient(#f4f6f9, #dae4f4);">
								        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="top:20px; right: 20px; z-index: 777;">
								          <span aria-hidden="true">&times;</span>
								        </button>
										<div class="modal-body p-4">
											<form action="platos_subopciones_grabar2.php" method="POST" accept-charset="utf-8">
											<input type="hidden" name="acc" value="add">
											<input type="hidden" name="idopcion" value="<?php echo $rowOp["id"];?>">
											<input type="hidden" name="idmenu" value="<?php echo $_GET["id"];?>">
											<div class="row">
												<div class="col-md-8">
													<h5 class="mt-0 mb-3 pl-2 text-info"><b>Agregar opciónes para:<br><span class="text-dark"><?php echo $rowOp["nombre"];?></span></b></h5>
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

							<!-- Modal editar subopcion -->
							<div class="modal fade" id="boxeditOp1<?php echo $rowOp["id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  	<div class="modal-dialog modal-dialog-centered position-relative" role="document">
							    	<div class="modal-content" style="background: linear-gradient(#f4f6f9, #dae4f4);">
								        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="top:20px; right: 20px; z-index: 777;">
								          <span aria-hidden="true">&times;</span>
								        </button>
										<div class="modal-body p-4">
											<form action="platos_subopciones_grabar2.php" method="POST" accept-charset="utf-8">
											<input type="hidden" name="id" value="<?php echo $rowOp["id"];?>">
											<input type="hidden" name="idmenu" value="<?php echo $_GET["id"];?>">
											<div class="row">
												<div class="col-md-8">
													<h5 class="mt-0 mb-3 pl-2 text-info"><b>Editar opciónes para:<br><span class="text-dark"><?php echo $rowOp["nombre"];?></span></b></h5>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-12">
													<label>Nombre *</label>
													<input type="text" name="nombre" class="form-control" value="<?php echo $rowOp["nombre"];?>">
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
													<input type="submit" name="submitformEdit" class="form-control btn btn-info text-light" value="editar">
												</div>
											</div>
											</form>
										</div>
									</div>
								</div>
							</div>

							<!-- Modal borrar -->
							<div class="modal fade" id="boxDelOp1<?php echo $rowOp["id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  	<div class="modal-dialog modal-dialog-centered position-relative" role="document">
							    	<div class="modal-content" style="background: linear-gradient(#f4f6f9, #dae4f4);">
								        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="top:20px; right: 20px; z-index: 777;">
								          <span aria-hidden="true">&times;</span>
								        </button>
										<div class="modal-body p-4">
											<form action="platos_opciones_grabar2.php" method="POST" accept-charset="utf-8">
											<input type="hidden" name="acc" value="delete">
											<input type="hidden" name="id"  value="<?php echo $rowOp["id"];?>">
											<input type="hidden" name="idmenu" value="<?php echo $_GET["id"];?>">
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
							<?php 
							$id  = $rowOp["id"];
							$idm = $_GET["id"];
							$qry2 = "SELECT * FROM _menus_subopciones WHERE status!='E' and idmenu='$idm' and idopcion='$id' ORDER by status, nombre";
							$rs2  = $conexion->query($qry2);
							while ($row2 = $rs2->fetch_assoc()){
							?>
								<div class="row py-1" style="border-bottom: 1px solid #eee; background: #C0C0C0;">
									<div class="col-8">
										<?php echo $row2["nombre"];?>
									</div>
									<div class="col-1 text-center">
										<?php if($row2["status"]=="I"){?>
											<i class="fa fa-times text-danger2"></i>
										<?php }elseif($row2["status"]=="E"){?>
											<i class="fa fa-ban text-warning"></i>
										<?php }else{ ?>
											<i class="fa fa-check text-success2"></i>
										<?php } ?>
									</div>
									<div class="col-1">
										<a href="#" class="text-dark" style="font-size: 9pt;" data-toggle="modal" data-target="#boxaddOp2<?php echo $row2["id"];?>">
											<i class="fa fa-plus"></i>
										</a>
									</div>
									<div class="col-1">
										<a href="#" class="text-dark" style="font-size: 9pt;" data-toggle="modal" data-target="#boxeditOp2<?php echo $row2["id"];?>">
											<i class="fa fa-edit"></i>
										</a>
									</div>
									<div class="col-1">
										<a href="#" data-toggle="modal" data-target="#boxDelOp2<?php echo $row2["id"];?>" class="text-dark" style="font-size: 9pt;">
											<i class="fa fa-trash"></i>
										</a>
									</div>
								</div>

								<!-- Modal agregar subopcion -->
								<div class="modal fade" id="boxaddOp2<?php echo $row2["id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  	<div class="modal-dialog modal-dialog-centered position-relative" role="document">
								    	<div class="modal-content" style="background: linear-gradient(#f4f6f9, #dae4f4);">
									        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="top:20px; right: 20px; z-index: 777;">
									          <span aria-hidden="true">&times;</span>
									        </button>
											<div class="modal-body p-4">
												<form action="platos_subopciones_grabar3.php" method="POST" accept-charset="utf-8">
												<input type="hidden" name="acc" value="add">
												<input type="hidden" name="idopcion" value="<?php echo $rowOp["id"];?>">
												<input type="hidden" name="idopcion2" value="<?php echo $row2["id"];?>">
												<input type="hidden" name="idmenu" value="<?php echo $_GET["id"];?>">
												<div class="row">
													<div class="col-md-8">
														<h5 class="mt-0 mb-3 pl-2 text-info"><b>Agregar opciónes para:<br><span class="text-dark"><?php echo $row2["nombre"];?></span></b></h5>
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

								<!-- Modal editar subopcion -->
								<div class="modal fade" id="boxeditOp2<?php echo $row2["id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  	<div class="modal-dialog modal-dialog-centered position-relative" role="document">
								    	<div class="modal-content" style="background: linear-gradient(#f4f6f9, #dae4f4);">
									        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="top:20px; right: 20px; z-index: 777;">
									          <span aria-hidden="true">&times;</span>
									        </button>
											<div class="modal-body p-4">
												<form action="platos_subopciones_grabar3.php" method="POST" accept-charset="utf-8">
												<input type="hidden" name="idopcion" value="<?php echo $rowOp["id"];?>">
												<input type="hidden" name="idopcion2" value="<?php echo $row2["id"];?>">
												<input type="hidden" name="idmenu" value="<?php echo $_GET["id"];?>">
												<div class="row">
													<div class="col-md-8">
														<h5 class="mt-0 mb-3 pl-2 text-info"><b>Editar opciónes para:<br><span class="text-dark"><?php echo $row2["nombre"];?></span></b></h5>
													</div>
												</div>
												<div class="form-row">
													<div class="form-group col-md-12">
														<label>Nombre *</label>
														<input type="text" name="nombre" class="form-control" value="<?php echo $row2["nombre"];?>">
													</div>
												</div>
												<div class="form-row">
													<div class="form-group col-md-12">
														<label>Descripción</label>
														<textarea name="descripcion" class="form-control" rows="2"><?php echo $row2["descripcion"];?></textarea>
													</div>
												</div>
												<div class="form-row">
													<div class="form-group col-md-12">
														<label>Status</label>&nbsp;&nbsp; 
														<input type="radio" name="status" value="A" <?php if($row2["status"]=="A"){ echo "checked"; } ?>> Activo&nbsp; 
														<input type="radio" name="status" value="I" <?php if($row2["status"]=="I"){ echo "checked"; } ?>> Inactivo
													</div>
												</div>
												<div class="form-row">
													<div class="form-group col-md-6">
														<input type="submit" name="submitformEdit" class="form-control btn btn-info text-light" value="editar">
													</div>
												</div>
												</form>
											</div>
										</div>
									</div>
								</div>

								<!-- Modal borrar -->
								<div class="modal fade" id="boxDelOp2<?php echo $row2["id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  	<div class="modal-dialog modal-dialog-centered position-relative" role="document">
								    	<div class="modal-content" style="background: linear-gradient(#f4f6f9, #dae4f4);">
									        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="top:20px; right: 20px; z-index: 777;">
									          <span aria-hidden="true">&times;</span>
									        </button>
											<div class="modal-body p-4">
												<form action="platos_subopciones_grabar3.php" method="POST" accept-charset="utf-8">
												<input type="hidden" name="acc" value="delete">
												<input type="hidden" name="idopcion" value="<?php echo $rowOp["id"];?>">
												<input type="hidden" name="idopcion2" value="<?php echo $row2["id"];?>">
												<input type="hidden" name="idmenu" value="<?php echo $_GET["id"];?>">
												<div class="row">
													<div class="col-md-8">
														<h5 class="mt-0 mb-3 pl-2 text-info"><b>Eliminar Opción</b></h5>
													</div>
												</div>
												<div class="form-row">
													<div class="form-group col-md-12">
														Esta seguro de querer eliminar la opción: <b><?php echo $row2["nombre"];?></b>?
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
								<?php
								$id2 = $row2["id"];
								$qry3 = "SELECT * FROM _menus_subopciones2 WHERE status!='E' and idmenu='$idm' and idopcion='$id' and idopcion2='$id2' ORDER by status, nombre";
								$rs3  = $conexion->query($qry3);
								while ($row3 = $rs3->fetch_assoc()){
									?>
									<div class="row py-1" style="border-bottom: 1px solid #eee; background: #eee;">
										<div class="col-8">
											<?php echo $row3["nombre"];?>
										</div>
										<div class="col-1 text-center">
											<?php if($row3["status"]=="I"){?>
												<i class="fa fa-times text-danger2"></i>
											<?php }elseif($row3["status"]=="E"){?>
												<i class="fa fa-ban text-warning"></i>
											<?php }else{ ?>
												<i class="fa fa-check text-success2"></i>
											<?php } ?>
										</div>
										<div class="col-1">
											<a href="#" class="text-dark" style="font-size: 9pt;" data-toggle="modal" data-target="#boxaddOp3<?php echo $row3["id"];?>">
												<i class="fa fa-plus"></i>
											</a>
										</div>
										<div class="col-1">
											<a href="#" class="text-dark" style="font-size: 9pt;" data-toggle="modal" data-target="#boxeditOp3<?php echo $row3["id"];?>">
												<i class="fa fa-edit"></i>
											</a>
										</div>
										<div class="col-1">
											<a href="#" data-toggle="modal" data-target="#boxDelOp3<?php echo $row3["id"];?>" class="text-dark" style="font-size: 9pt;">
												<i class="fa fa-trash"></i>
											</a>
										</div>
									</div>
									<!-- Modal agregar subopcion -->
									<div class="modal fade" id="boxaddOp3<?php echo $row3["id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									  	<div class="modal-dialog modal-dialog-centered position-relative" role="document">
									    	<div class="modal-content" style="background: linear-gradient(#f4f6f9, #dae4f4);">
										        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="top:20px; right: 20px; z-index: 777;">
										          <span aria-hidden="true">&times;</span>
										        </button>
												<div class="modal-body p-4">
													<form action="platos_subopciones_grabar4.php" method="POST" accept-charset="utf-8">
													<input type="hidden" name="acc" value="add">
													<input type="hidden" name="idopcion" value="<?php echo $rowOp["id"];?>">
													<input type="hidden" name="idopcion2" value="<?php echo $row2["id"];?>">
													<input type="hidden" name="idopcion3" value="<?php echo $row3["id"];?>">
													<input type="hidden" name="idmenu" value="<?php echo $_GET["id"];?>">
													<div class="row">
														<div class="col-md-8">
															<h5 class="mt-0 mb-3 pl-2 text-info"><b>Agregar opciónes para:<br><span class="text-dark"><?php echo $row3["nombre"];?></span></b></h5>
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

									<!-- Modal editar subopcion -->
									<div class="modal fade" id="boxeditOp3<?php echo $row3["id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									  	<div class="modal-dialog modal-dialog-centered position-relative" role="document">
									    	<div class="modal-content" style="background: linear-gradient(#f4f6f9, #dae4f4);">
										        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="top:20px; right: 20px; z-index: 777;">
										          <span aria-hidden="true">&times;</span>
										        </button>
												<div class="modal-body p-4">
													<form action="platos_subopciones_grabar4.php" method="POST" accept-charset="utf-8">
													<input type="hidden" name="idopcion" value="<?php echo $rowOp["id"];?>">
													<input type="hidden" name="idopcion2" value="<?php echo $row2["id"];?>">
													<input type="hidden" name="idopcion3" value="<?php echo $row3["id"];?>">
													<input type="hidden" name="idmenu" value="<?php echo $_GET["id"];?>">
													<div class="row">
														<div class="col-md-8">
															<h5 class="mt-0 mb-3 pl-2 text-info"><b>Editar opciónes para:<br><span class="text-dark"><?php echo $row3["nombre"];?></span></b></h5>
														</div>
													</div>
													<div class="form-row">
														<div class="form-group col-md-12">
															<label>Nombre *</label>
															<input type="text" name="nombre" class="form-control" value="<?php echo $row3["nombre"];?>">
														</div>
													</div>
													<div class="form-row">
														<div class="form-group col-md-12">
															<label>Descripción</label>
															<textarea name="descripcion" class="form-control" rows="2"><?php echo $row3["descripcion"];?></textarea>
														</div>
													</div>
													<div class="form-row">
														<div class="form-group col-md-12">
															<label>Status</label>&nbsp;&nbsp; 
															<input type="radio" name="status" value="A" <?php if($row3["status"]=="A"){ echo "checked"; } ?>> Activo&nbsp; 
															<input type="radio" name="status" value="I" <?php if($row3["status"]=="I"){ echo "checked"; } ?>> Inactivo
														</div>
													</div>
													<div class="form-row">
														<div class="form-group col-md-6">
															<input type="submit" name="submitformEdit" class="form-control btn btn-info text-light" value="editar">
														</div>
													</div>
													</form>
												</div>
											</div>
										</div>
									</div>

									<!-- Modal borrar -->
									<div class="modal fade" id="boxDelOp3<?php echo $row3["id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									  	<div class="modal-dialog modal-dialog-centered position-relative" role="document">
									    	<div class="modal-content" style="background: linear-gradient(#f4f6f9, #dae4f4);">
										        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="top:20px; right: 20px; z-index: 777;">
										          <span aria-hidden="true">&times;</span>
										        </button>
												<div class="modal-body p-4">
													<form action="platos_subopciones_grabar4.php" method="POST" accept-charset="utf-8">
													<input type="hidden" name="acc" value="delete">
													<input type="hidden" name="idopcion" value="<?php echo $rowOp["id"];?>">
													<input type="hidden" name="idopcion2" value="<?php echo $row2["id"];?>">
													<input type="hidden" name="idopcion3" value="<?php echo $row3["id"];?>">
													<input type="hidden" name="idmenu" value="<?php echo $_GET["id"];?>">
													<div class="row">
														<div class="col-md-8">
															<h5 class="mt-0 mb-3 pl-2 text-info"><b>Eliminar Opción</b></h5>
														</div>
													</div>
													<div class="form-row">
														<div class="form-group col-md-12">
															Esta seguro de querer eliminar la opción: <b><?php echo $row3["nombre"];?></b>?
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
									<?php
									$id3 = $row3["id"];
									$qry4 = "SELECT * FROM _menus_subopciones3 WHERE status!='E' and idmenu='$idm' and idopcion='$id' and idopcion2='$id2' and idopcion3='$id3' ORDER by status, nombre";
									$rs4  = $conexion->query($qry4);
									while ($row4 = $rs4->fetch_assoc()){
										?>
										<div class="row py-1" style="border-bottom: 1px solid #eee; background: #f7f7f7;">
											<div class="col-8">
												<?php echo $row4["nombre"];?>
											</div>
											<div class="col-1 text-center">
												<?php if($row4["status"]=="I"){?>
													<i class="fa fa-times text-danger2"></i>
												<?php }elseif($row4["status"]=="E"){?>
													<i class="fa fa-ban text-warning"></i>
												<?php }else{ ?>
													<i class="fa fa-check text-success2"></i>
												<?php } ?>
											</div>
											<div class="col-1">
												<a href="#" class="text-dark" style="font-size: 9pt;" data-toggle="modal" data-target="#boxaddOp4<?php echo $row4["id"];?>">
													<i class="fa fa-plus"></i>
												</a>
											</div>
											<div class="col-1">
												<a href="#" class="text-dark" style="font-size: 9pt;" data-toggle="modal" data-target="#boxeditOp4<?php echo $row4["id"];?>">
													<i class="fa fa-edit"></i>
												</a>
											</div>
											<div class="col-1">
												<a href="#" data-toggle="modal" data-target="#boxDelOp4<?php echo $row4["id"];?>" class="text-dark" style="font-size: 9pt;">
													<i class="fa fa-trash"></i>
												</a>
											</div>
										</div>
										<!-- Modal agregar subopcion -->
										<div class="modal fade" id="boxaddOp4<?php echo $row4["id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										  	<div class="modal-dialog modal-dialog-centered position-relative" role="document">
										    	<div class="modal-content" style="background: linear-gradient(#f4f6f9, #dae4f4);">
											        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="top:20px; right: 20px; z-index: 777;">
											          <span aria-hidden="true">&times;</span>
											        </button>
													<div class="modal-body p-4">
														<form action="platos_subopciones_grabar5.php" method="POST" accept-charset="utf-8">
														<input type="hidden" name="acc" value="add">
														<input type="hidden" name="idopcion" value="<?php echo $rowOp["id"];?>">
														<input type="hidden" name="idopcion2" value="<?php echo $row2["id"];?>">
														<input type="hidden" name="idopcion3" value="<?php echo $row3["id"];?>">
														<input type="hidden" name="idopcion4" value="<?php echo $row4["id"];?>">
														<input type="hidden" name="idmenu" value="<?php echo $_GET["id"];?>">
														<div class="row">
															<div class="col-md-8">
																<h5 class="mt-0 mb-3 pl-2 text-info"><b>Agregar opciónes para:<br><span class="text-dark"><?php echo $row4["nombre"];?></span></b></h5>
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

										<!-- Modal editar subopcion -->
										<div class="modal fade" id="boxeditOp4<?php echo $row4["id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										  	<div class="modal-dialog modal-dialog-centered position-relative" role="document">
										    	<div class="modal-content" style="background: linear-gradient(#f4f6f9, #dae4f4);">
											        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="top:20px; right: 20px; z-index: 777;">
											          <span aria-hidden="true">&times;</span>
											        </button>
													<div class="modal-body p-4">
														<form action="platos_subopciones_grabar5.php" method="POST" accept-charset="utf-8">
														<input type="hidden" name="idopcion" value="<?php echo $rowOp["id"];?>">
														<input type="hidden" name="idopcion2" value="<?php echo $row2["id"];?>">
														<input type="hidden" name="idopcion3" value="<?php echo $row3["id"];?>">
														<input type="hidden" name="idopcion4" value="<?php echo $row4["id"];?>">
														<input type="hidden" name="idmenu" value="<?php echo $_GET["id"];?>">
														<div class="row">
															<div class="col-md-8">
																<h5 class="mt-0 mb-3 pl-2 text-info"><b>Editar opciónes para:<br><span class="text-dark"><?php echo $row4["nombre"];?></span></b></h5>
															</div>
														</div>
														<div class="form-row">
															<div class="form-group col-md-12">
																<label>Nombre *</label>
																<input type="text" name="nombre" class="form-control" value="<?php echo $row4["nombre"];?>">
															</div>
														</div>
														<div class="form-row">
															<div class="form-group col-md-12">
																<label>Descripción</label>
																<textarea name="descripcion" class="form-control" rows="2"><?php echo $row4["descripcion"];?></textarea>
															</div>
														</div>
														<div class="form-row">
															<div class="form-group col-md-12">
																<label>Status</label>&nbsp;&nbsp; 
																<input type="radio" name="status" value="A" <?php if($row4["status"]=="A"){ echo "checked"; } ?>> Activo&nbsp; 
																<input type="radio" name="status" value="I" <?php if($row4["status"]=="I"){ echo "checked"; } ?>> Inactivo
															</div>
														</div>
														<div class="form-row">
															<div class="form-group col-md-6">
																<input type="submit" name="submitformEdit" class="form-control btn btn-info text-light" value="editar">
															</div>
														</div>
														</form>
													</div>
												</div>
											</div>
										</div>

										<!-- Modal borrar -->
										<div class="modal fade" id="boxDelOp4<?php echo $row4["id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										  	<div class="modal-dialog modal-dialog-centered position-relative" role="document">
										    	<div class="modal-content" style="background: linear-gradient(#f4f6f9, #dae4f4);">
											        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="top:20px; right: 20px; z-index: 777;">
											          <span aria-hidden="true">&times;</span>
											        </button>
													<div class="modal-body p-4">
														<form action="platos_subopciones_grabar5.php" method="POST" accept-charset="utf-8">
														<input type="hidden" name="acc" value="delete">
														<input type="hidden" name="idopcion" value="<?php echo $rowOp["id"];?>">
														<input type="hidden" name="idopcion2" value="<?php echo $row2["id"];?>">
														<input type="hidden" name="idopcion3" value="<?php echo $row3["id"];?>">
														<input type="hidden" name="idopcion4" value="<?php echo $row4["id"];?>">
														<input type="hidden" name="idmenu" value="<?php echo $_GET["id"];?>">
														<div class="row">
															<div class="col-md-8">
																<h5 class="mt-0 mb-3 pl-2 text-info"><b>Eliminar Opción</b></h5>
															</div>
														</div>
														<div class="form-row">
															<div class="form-group col-md-12">
																Esta seguro de querer eliminar la opción: <b><?php echo $row4["nombre"];?></b>?
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
										<?php
										$id4 = $row4["id"];
										$qry5 = "SELECT * FROM _menus_subopciones4 WHERE status!='E' and idmenu='$idm' and idopcion='$id' and idopcion2='$id2' and idopcion3='$id3' and idopcion4='$id4' ORDER by status, nombre";
										$rs5  = $conexion->query($qry5);
										while ($row5 = $rs5->fetch_assoc()){
											?>
											<div class="row py-1" style="border-bottom: 1px solid #eee; background: #fff;">
												<div class="col-8">
													<?php echo $row5["nombre"];?>
												</div>
												<div class="col-1 text-center">
													<?php if($row5["status"]=="I"){?>
														<i class="fa fa-times text-danger2"></i>
													<?php }elseif($row5["status"]=="E"){?>
														<i class="fa fa-ban text-warning"></i>
													<?php }else{ ?>
														<i class="fa fa-check text-success2"></i>
													<?php } ?>
												</div>
												<div class="col-1">
													
												</div>
												<div class="col-1">
													<a href="#" class="text-dark" style="font-size: 9pt;" data-toggle="modal" data-target="#boxeditOp5<?php echo $row5["id"];?>">
														<i class="fa fa-edit"></i>
													</a>
												</div>
												<div class="col-1">
													<a href="#" data-toggle="modal" data-target="#boxDelOp5<?php echo $row5["id"];?>" class="text-dark" style="font-size: 9pt;">
														<i class="fa fa-trash"></i>
													</a>
												</div>
											</div>

											<!-- Modal editar subopcion -->
											<div class="modal fade" id="boxeditOp5<?php echo $row5["id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
											  	<div class="modal-dialog modal-dialog-centered position-relative" role="document">
											    	<div class="modal-content" style="background: linear-gradient(#f4f6f9, #dae4f4);">
												        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="top:20px; right: 20px; z-index: 777;">
												          <span aria-hidden="true">&times;</span>
												        </button>
														<div class="modal-body p-4">
															<form action="platos_subopciones_grabar6.php" method="POST" accept-charset="utf-8">
															<input type="hidden" name="idopcion" value="<?php echo $rowOp["id"];?>">
															<input type="hidden" name="idopcion2" value="<?php echo $row2["id"];?>">
															<input type="hidden" name="idopcion3" value="<?php echo $row3["id"];?>">
															<input type="hidden" name="idopcion4" value="<?php echo $row4["id"];?>">
															<input type="hidden" name="idopcion5" value="<?php echo $row5["id"];?>">
															<input type="hidden" name="idmenu" value="<?php echo $_GET["id"];?>">
															<div class="row">
																<div class="col-md-8">
																	<h5 class="mt-0 mb-3 pl-2 text-info"><b>Editar opciónes para:<br><span class="text-dark"><?php echo $row5["nombre"];?></span></b></h5>
																</div>
															</div>
															<div class="form-row">
																<div class="form-group col-md-12">
																	<label>Nombre *</label>
																	<input type="text" name="nombre" class="form-control" value="<?php echo $row5["nombre"];?>">
																</div>
															</div>
															<div class="form-row">
																<div class="form-group col-md-12">
																	<label>Descripción</label>
																	<textarea name="descripcion" class="form-control" rows="2"><?php echo $row5["descripcion"];?></textarea>
																</div>
															</div>
															<div class="form-row">
																<div class="form-group col-md-12">
																	<label>Status</label>&nbsp;&nbsp; 
																	<input type="radio" name="status" value="A" <?php if($row5["status"]=="A"){ echo "checked"; } ?>> Activo&nbsp; 
																	<input type="radio" name="status" value="I" <?php if($row5["status"]=="I"){ echo "checked"; } ?>> Inactivo
																</div>
															</div>
															<div class="form-row">
																<div class="form-group col-md-6">
																	<input type="submit" name="submitformEdit" class="form-control btn btn-info text-light" value="editar">
																</div>
															</div>
															</form>
														</div>
													</div>
												</div>
											</div>

											<!-- Modal borrar -->
											<div class="modal fade" id="boxDelOp5<?php echo $row5["id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
											  	<div class="modal-dialog modal-dialog-centered position-relative" role="document">
											    	<div class="modal-content" style="background: linear-gradient(#f4f6f9, #dae4f4);">
												        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="top:20px; right: 20px; z-index: 777;">
												          <span aria-hidden="true">&times;</span>
												        </button>
														<div class="modal-body p-4">
															<form action="platos_subopciones_grabar6.php" method="POST" accept-charset="utf-8">
															<input type="hidden" name="acc" value="delete">
															<input type="hidden" name="idopcion" value="<?php echo $rowOp["id"];?>">
															<input type="hidden" name="idopcion2" value="<?php echo $row2["id"];?>">
															<input type="hidden" name="idopcion3" value="<?php echo $row3["id"];?>">
															<input type="hidden" name="idopcion4" value="<?php echo $row4["id"];?>">
															<input type="hidden" name="idopcion5" value="<?php echo $row5["id"];?>">
															<input type="hidden" name="idmenu" value="<?php echo $_GET["id"];?>">
															<div class="row">
																<div class="col-md-8">
																	<h5 class="mt-0 mb-3 pl-2 text-info"><b>Eliminar Opción para:<br><span class="text-dark"><?php echo $row5["nombre"];?></span></b></h5>
																</div>
															</div>
															<div class="form-row">
																<div class="form-group col-md-12">
																	Esta seguro de querer eliminar la opción: <b><?php echo $row5["nombre"];?></b>?
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
									<?php } ?>
								<?php } ?>
							<?php } ?>
							<hr>
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
							<form action="platos_opciones_grabar2.php" method="POST" accept-charset="utf-8">
							<input type="hidden" name="acc" value="add">
							<input type="hidden" name="idmenu" value="<?php echo $_GET["id"];?>">
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