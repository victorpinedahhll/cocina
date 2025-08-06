<?php
$titulo = "Auxiliares Asignaciones";
$nologg = "SI";
$page   = "asignaciones";
$areaLg = "ASIGNACIONES"; // valida roles del usuario

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
				<div class="col-md-8 pr-5">
					<div class="row box-menu text-light py-2 mb-2" style="background: #1366e0;">
						<div class="col-4"><b>Auxiliar</b></div>
						<div class="col-3"><b>Area</b></div>
						<div class="col-2 text-center"><b>Fecha Inicio</b></div>
                        <div class="col-2 text-center"><b>Fecha Final</b></div>
						<div class="col-1 text-center"></div>
					</div>
					<?php
					$qryST = "AND status != 'E'";
					if($idsession==1){
						$qryST = "";
					}
					$van = 0;
					$qryR = "
                    SELECT *
                        , (
                            SELECT nombre_us07 
                            FROM _usuarios_admin b 
                            WHERE b.id_us00 = a.id_aux
                        ) AS naux 
                        , (
                            SELECT _nombre 
                            FROM _areas c 
                            WHERE c._id = a.id_area
                        ) AS narea
                    FROM _auxiliar_asignaciones a 
					WHERE id > 0 $qryST 
                    ORDER BY id desc, fecha_inicio
                    ";
					$rsR  = $conexion->query($qryR);
					while ($rowR = $rsR->fetch_assoc()){
						$van = $van + 1;

						$bgf = "";
						if($rowR["status"]=="E"){
							$bgf = "background: #fbe4e4;";
						}
						?>
						<div class="row box-items py-2 <?php if ($van%2==0){ echo "bg-muted"; } ?>" style="<?php echo $bgf; ?>; border: 1px solid #eee; border-top: 0px;">
							<div class="col-4">
								<a href="#" data-toggle="modal" data-target="#boxEdit<?php echo $rowR["id"];?>">
									<?php echo $rowR["naux"];?>
								</a>
							</div>
                            <div class="col-3">
								<?php echo $rowR["narea"];?>
							</div>
							<div class="col-2 text-center">
								<?php echo formatearFecha($rowR["fecha_inicio"]);?>
							</div>
							<div class="col-2 text-center">
								<?php echo formatearFecha($rowR["fecha_final"]); ?>
							</div>
							<div class="col-1 text-center">
								<a href="#" data-toggle="modal" data-target="#boxDel<?php echo $rowR["id"];?>" class="text-dark">
									<i class="fa fa-trash"></i>
								</a>
							</div>
						</div>

						<!-- Modal editar -->
						<div class="modal fade" id="boxEdit<?php echo $rowR["id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  	<div class="modal-dialog modal-dialog-centered position-relative" role="document">
						    	<div class="modal-content">
							        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="top:20px; right: 20px; z-index: 777;">
							          <span aria-hidden="true">&times;</span>
							        </button>
									<div class="modal-body p-4">
										<form action="asignaciones_auxiliares_grabar.php" method="POST" accept-charset="utf-8">
										<input type="hidden" name="acc" value="edit">
										<input type="hidden" name="id"  value="<?php echo $rowR["id"]; ?>">
										<div class="rowu mx-0" style="background: #1366e0;">
											<div class="col-md-12">
												<h5 class="text-light py-3 m-0 text-center"><b>Editar Asignación</b></h5>
											</div>
										</div>
										<div class="mt-2">
											<div class="form-row mt-2">
												<div class="form-group col-md-12">
													<label>Auxiliar de Nutrición *</label>
													<select name="auxiliar" class="form-control">
														<option value="">elegir uno</option>
														<?php 
														$qryX = "
														SELECT * 
														FROM _usuarios_admin a 
														WHERE 
															status_wua32 = 1 
															AND nivel_wua67 = 'AUXILIAR' 
															AND id_us00 IN (
																SELECT _usuario_id 
																FROM _usuarios_roles u 
																WHERE 
																	_usuario_id = a.id_us00 
																	AND _rol = 'TOMA_PEDIDOS'
															)
														";
														$resX = $conexion->query($qryX);
														while ($rowX = $resX->fetch_assoc()){
														?>
														<option value="<?php echo $rowX["id_us00"]; ?>" <?php if($rowX["id_us00"]==$rowR["id_aux"]){ echo "selected"; } ?>><?php echo $rowX["nombre_us07"]; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-12">
													<label>Área de Atención</label>
													<select name="area" class="form-control">
														<option value="">elija una</option>
														<?php 
														$qAR = "SELECT * FROM _areas WHERE _status='A'";
														$rAR = $conexion->query($qAR);
														while ($fAR = $rAR->fetch_assoc()){
														?>
														<option value="<?php echo $fAR["_id"]; ?>" <?php if($fAR["_id"]==$rowR["id_area"]){ echo "selected"; } ?>><?php echo $fAR["_nombre"];?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-6">
													<label>Fecha Inicio</label>
													<input type="date" name="inicio" class="form-control" value="<?php echo $rowR["fecha_inicio"]; ?>">
												</div>
												<div class="form-group col-md-6">
													<label>Fecha Final</label>
													<input type="date" name="final" class="form-control" value="<?php echo $rowR["fecha_final"]; ?>">
												</div>
											</div>
											<div class="form-row mt-3">
												<div class="form-group col-md-6">
													<input type="submit" name="submitformEdit" class="btn btn-cocina text-light w-100" value="salvar cambios">
												</div>
											</div>
										</div>
										</form>
									</div>
								</div>
							</div>
						</div>

						<!-- Modal borrar -->
						<div class="modal fade" id="boxDel<?php echo $rowR["id"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  	<div class="modal-dialog modal-dialog-centered position-relative" role="document">
						    	<div class="modal-content">
							        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="top:20px; right: 20px; z-index: 777;">
							          <span aria-hidden="true">&times;</span>
							        </button>
									<div class="modal-body p-4">
										<form action="asignaciones_auxiliares_grabar.php" method="POST">
										<input type="hidden" name="acc" value="borrar">
										<input type="hidden" name="id"  value="<?php echo $rowR["id"]; ?>">
										<div class="row">
											<div class="col-md-8">
												<h5 class="mt-0 mb-3 pl-2 text-secondary"><b>Eliminar Asignación</b></h5>
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-12">
												Esta seguro de querer eliminar la asignación de: <b><?php echo $rowR["naux"];?></b>?
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-6">
												<input type="submit" name="submitformDel" class="form-control btn btn-cocina text-light" value="Si, eliminar">
											</div>
										</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>


				</div>
				<div class="col-md-4">
					<form action="asignaciones_auxiliares_grabar.php" method="POST" accept-charset="utf-8">
					<input type="hidden" name="acc" value="add">
					<div class="rowu mx-0" style="background: #1366e0;">
						<div class="col-md-12">
							<h5 class="text-light py-3 m-0 text-center"><b>Agregar Asignación</b></h5>
						</div>
					</div>
					<div class="box-items mt-2">
						<div class="form-row mt-2">
							<div class="form-group col-md-12">
								<label>Auxiliar de Nutrición *</label>
								<select name="auxiliar" class="form-control">
                                    <option value="">elegir uno</option>
                                    <?php 
                                    $qryX = "
                                    SELECT * 
                                    FROM _usuarios_admin a 
                                    WHERE 
                                        status_wua32 = 1 
                                        AND nivel_wua67 = 'AUXILIAR' 
                                        AND id_us00 IN (
                                            SELECT _usuario_id 
                                            FROM _usuarios_roles u 
                                            WHERE 
                                                _usuario_id = a.id_us00 
                                                AND _rol = 'TOMA_PEDIDOS'
                                        )
                                    ";
                                    $resX = $conexion->query($qryX);
                                    while ($rowX = $resX->fetch_assoc()){
                                    ?>
                                    <option value="<?php echo $rowX["id_us00"]; ?>"><?php echo $rowX["nombre_us07"]; ?></option>
                                    <?php } ?>
                                </select>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-12">
								<label>Área de Atención</label>
                                <select name="area" class="form-control">
                                    <option value="">elija una</option>
                                    <?php 
                                    $qAR = "SELECT * FROM _areas WHERE _status='A'";
                                    $rAR = $conexion->query($qAR);
                                    while ($fAR = $rAR->fetch_assoc()){
                                    ?>
                                    <option value="<?php echo $fAR["_id"];?>"><?php echo $fAR["_nombre"];?></option>
                                    <?php } ?>
                                </select>
							</div>
						</div>
                        <div class="form-row">
							<div class="form-group col-md-6">
                                <label>Fecha Inicio</label>
                                <input type="date" name="inicio" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Fecha Final</label>
                                <input type="date" name="final" class="form-control">
                            </div>
                        </div>
						<div class="form-row mt-3">
							<div class="form-group col-md-6">
								<input type="submit" name="submitformAdd" class="form-control btn btn-cocina text-light" value="agregar asignación">
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>

		</div>
	</div>
</div>

<?php include("footer.php"); ?>

