<?php
$titulo = "Tipo Dietas";
$nologg = "SI";
$page   = "dieta";
$areaLg = "TIPO_DIETA"; // valida roles del usuario

include("header.php");

$bus = $_POST["busqueda"];
$qryB = "";
if(!empty($bus)){
	$qryB = "and (nombre LIKE '%$bus%') ";
}

$nivelm = "and status != 'E'";
if($nvsession=="ADMIN"){
	$nivelm = "";
}

// FUNSION DE SALTO DE PAGINA
if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
}else {
    $pageno = 1;
}
$no_of_records_per_page = 50;
$offset = ($pageno-1) * $no_of_records_per_page;
$total_pages_sql = "SELECT count(*) as cuantos FROM _tipo_dieta WHERE id > '0' $nivelm $qryB";
$result = $conexion->query($total_pages_sql);
$total_rows = $result->fetch_assoc();
$van_reg = $total_rows["cuantos"];

if ($van_reg > $no_of_records_per_page){
   $total_pages = ceil($van_reg / $no_of_records_per_page);
}
?>
<style>

	.content-text {
		margin: 160px 21px 0 21px;
	}

</style>

<?php
$qryAg = "SELECT count(*) as cuantosag FROM _tipo_dieta WHERE id > '0' $nivelm $qryB";
$rsAg  = $conexion->query($qryAg);
$rowAg = $rsAg->fetch_assoc();
$couAg = $rowAg["cuantosag"];
?>

<div class="row pt-0 mb-4">
	<div class="col-md-12 content-box position-relative">

		<div class="container" style="margin-top: 175px;">
			<div class="row mt-3">
				<div class="col-md-7 pr-5">
					<div class="row box-menu mb-2">
						<div class="col-8"><b>Nombre</b></div>
						<div class="col-3 text-center"><b>Status</b></div>
						<div class="col-1 text-center">&nbsp;</div>
					</div>
					<?php 
					$van = 0;
					$qryR = "SELECT * FROM _tipo_dieta WHERE id > '0' $nivelm $qryB ORDER BY status LIMIT $offset, $no_of_records_per_page";
					$rsR  = $conexion->query($qryR);
					while ($rowR = $rsR->fetch_assoc()){
						$van = $van + 1;

						$bgf = "";
						if($rowR["status"]=="I"){
							$bgf = "background: #fbf5e4;";
						}elseif($rowR["status"]=="E"){
							$bgf = "background: #fbe4e4;";
						}
						?>
						<div class="row box-items py-2 <?php if ($van%2==0){ echo "bg-muted"; } ?>" style="<?php echo $bgf; ?>; border: 1px solid #eee; border-top: 0px;">
							<div class="col-8">
								<a href="#" data-toggle="modal" data-target="#boxEdit<?php echo $rowR["id"];?>">
									<?php echo $rowR["nombre"];?>
								</a>
							</div>
							<div class="col-3 text-center">
								<?php if($rowR["status"]=="A"){?>
									Activo
								<?php }elseif($rowR["status"]=="E"){?>
									<span class="text-danger">Eliminado</span>
								<?php }else{ ?>
									Inactivo
								<?php } ?>
							</div>
							<div class="col-1">
								<?php if($rowR["status"]!="E"){ ?>
								<a href="#" data-toggle="modal" data-target="#boxDel<?php echo $rowR["id"];?>" class="text-muted" style="font-size: 9pt;">
									<i class="fa fa-trash"></i>
								</a>
								<?php } ?>
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
										<form action="tipo_dietas_grabar.php" method="POST" accept-charset="utf-8">
										<input type="hidden" name="acc" value="edit">
										<input type="hidden" name="id"  value="<?php echo $rowR["id"];?>">
										<div class="row">
											<div class="col-md-8">
												<h5 class="mt-0 mb-3 pl-2 text-secondary"><b>Editar Tipo Dieta</b></h5>
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-12">
												<label>Nombre *</label>
												<input type="text" name="nombre" class="form-control" value="<?php echo $rowR["nombre"];?>" required="required" value="<?php echo $rowR["nombre"];?>">
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
												<input type="submit" name="submitformEdit" class="form-control btn btn-cocina text-light" value="grabar cambios">
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
										<form action="tipo_dietas_grabar.php" method="POST" accept-charset="utf-8">
										<input type="hidden" name="acc" value="delete">
										<input type="hidden" name="id"  value="<?php echo $rowR["id"];?>">
										<div class="row">
											<div class="col-md-8">
												<h5 class="mt-0 mb-3 pl-2 text-secondary"><b>Eliminar Tipo Dieta</b></h5>
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-12">
												Esta seguro de querer eliminar el tipo de dieta: <b><?php echo $rowR["nombre"];?></b>?
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

					<?php 
				    if ($van_reg > $no_of_records_per_page){?>
				    	<div class="row">
							<div class="col-md-12 pagination-2">
					            <a href="?pageno=1" class="btn-pagination mr-1"><<</a>
					            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>" class="btn-pagination mr-1"><</a>
								<?php
								$pagenum = "1";
								$totnum = $total_pages-5;
								if ($pageno >= $totnum){
									$pagenum = $totnum;
								}elseif($pageno > 1 && $pageno < $totnum){
									$pagenum = $pageno;
								}
								$j = 0;
								for($i=$pagenum; $i <= $total_pages; $i++, $j++){
									if ($j <= 4 && $i > 0){ ?>
										<a href="?pageno=<?php echo $i;?>" class="btn-pagination mr-1 <?php if($pageno == $i){ echo "pag-active"; } ?>"><?php echo $i;?></a> 
									<?php 
									} 
								} ?>
								<a href="<?php if($pageno >= $total_pages){ ?>#<?php }else{ ?>?pageno=<?php echo ($pageno + 1);?><?php } ?>" class="btn-pagination mr-1">></a>
								<a href="?pageno=<?php echo $total_pages; ?>" class="btn-pagination">>></a>
								<?php 
								if ($pageno < $totnum){ ?>
									<a name="#" class="hidden-movil" style="border: 0px !important; margin-left: 7px; color: #808080;">... <?php echo $total_pages;?></a>
								<?php 
								} ?>
							</div>
				        </div>
				    <?php } ?>

				</div>
				<div class="col-md-4">
					<form action="tipo_dietas_grabar.php" method="POST" accept-charset="utf-8">
					<input type="hidden" name="acc" value="add">
					<div class="row box-menu mx-0 mb-2">
						<div class="col-md-12 text-center">
							<h5 class="m-0 py-1 text-secondary"><b>Agregar Tipo Dieta</b></h5>
						</div>
					</div>
					<div class="box-items p-0 m-0">
						<div class="form-row mt-2">
							<div class="form-group col-md-12">
								<label>Nombre *</label>
								<input type="text" name="nombre" class="form-control" value="<?php echo $rowR["nombre"];?>" required="required">
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
							<div class="form-group col-md-12">
								<input type="submit" name="submitformAdd" class="form-control btn btn-cocina text-light" value="agregar">
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>

			<!-- Modal buscador texto -->
			<div class="modal fade" id="boxSearch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  	<div class="modal-dialog position-relative" role="document">
				    <div class="modal-content">
				        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="top:20px; right: 20px; z-index: 777;">
				          <span aria-hidden="true">&times;</span>
				        </button>
						<div class="modal-body p-5">
							<h5 class="mt-0 mb-3 pl-0 text-dark"><b>Búsqueda por nombre</b></h5>
							<form action="tipo_dietas.php" method="POST">
							<div class="row">
								<div class="col-md-9 col-9 p-0 pr-2">
									<input type="text" name="busqueda" class="form-control">
								</div>
								<div class="col-3 p-0">
									<input type="submit" class="btn btn-info form-control" name="filtro" value="buscar" style="font-weight: bold;">
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

