<?php
$titulo = "Programaciones Cocina";
$nologg = "SI";
$page   = "progra";
$areaLg = "PROGRAMACION"; // valida roles del usuario

include("header.php");

$bus = $_POST["busqueda"];
$qryB = "";
if(!empty($bus)){
	$qryB = "and (nombre LIKE '%$bus%') ";
}

$nivelm = "and status != 'E'";
if($nvsession=="777"){
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
$total_pages_sql = "SELECT count(*) as cuantos FROM _programaciones WHERE id > '0' $nivelm $qryB";
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
$qryAg = "SELECT count(*) as cuantosag FROM _programaciones WHERE id > '0' $nivelm $qryB";
$rsAg  = $conexion->query($qryAg);
$rowAg = $rsAg->fetch_assoc();
$couAg = $rowAg["cuantosag"];
?>

<div class="row pt-0 mb-4">
	<div class="col-md-12 content-box position-relative">

		<div class="px-5" style="margin-top: 175px;">
			<div class="row">
				<div class="col-md-12">
					<div class="row box-menu mb-2">
						<div class="col-6"><b>Nombre</b></div>
						<div class="col-2"><b>Fecha Inicio</b></div>
						<div class="col-2"><b>Fecha Final</b></div>
						<div class="col-1 text-center"><b>Status</b></div>
						<div class="col-1 text-center">&nbsp;</div>
					</div>
					<?php 
					$van = 0;
					$qryR = "SELECT * FROM _programaciones WHERE id > '0' $nivelm $qryB ORDER BY status LIMIT $offset, $no_of_records_per_page";
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
							<?php
							$idTip   = $rowR["id"];
							$qryMO  = "SELECT count(*) as counmo FROM _menus_progra_enlace WHERE idprogra='$idTip'";
							$rsMO   = $conexion->query($qryMO);
							$rowMO  = $rsMO->fetch_assoc();
							$counMO = $rowMO["counmo"];
							?>
							<div class="col-6">
								<a href="programaciones_editar.php?id=<?php echo $rowR["id"];?>">
									<?php echo $rowR["nombre"];?> (<?php echo $counMO; ?>)
								</a>
							</div>
							<div class="col-2">
								<?php 
								$fechaI = strtotime($rowR["inicio"]);
								$mesI   = date("m",$fechaI);
								if($mesI=="1"){ $mesIni = "Ene"; }
								if($mesI=="2"){ $mesIni = "Feb"; }
								if($mesI=="3"){ $mesIni = "Mar"; }
								if($mesI=="4"){ $mesIni = "Abr"; }
								if($mesI=="5"){ $mesIni = "May"; }
								if($mesI=="6"){ $mesIni = "Jun"; }
								if($mesI=="7"){ $mesIni = "Jul"; }
								if($mesI=="8"){ $mesIni = "Ago"; }
								if($mesI=="9"){ $mesIni = "Sep"; }
								if($mesI=="10"){ $mesIni = "Oct"; }
								if($mesI=="11"){ $mesIni = "Nov"; }
								if($mesI=="12"){ $mesIni = "Dic"; }
								echo date("d",$fechaI)."/".$mesIni."/".date("Y",$fechaI);
								?>
							</div>
							<div class="col-2">
								<?php 
								$fechaF = strtotime($rowR["final"]);
								$mesF   = date("m",$fechaF);
								if($mesF=="1"){ $mesFni = "Ene"; }
								if($mesF=="2"){ $mesFni = "Feb"; }
								if($mesF=="3"){ $mesFni = "Mar"; }
								if($mesF=="4"){ $mesFni = "Abr"; }
								if($mesF=="5"){ $mesFni = "May"; }
								if($mesF=="6"){ $mesFni = "Jun"; }
								if($mesF=="7"){ $mesFni = "Jul"; }
								if($mesF=="8"){ $mesFni = "Ago"; }
								if($mesF=="9"){ $mesFni = "Sep"; }
								if($mesF=="10"){ $mesFni = "Oct"; }
								if($mesF=="11"){ $mesFni = "Nov"; }
								if($mesF=="12"){ $mesFni = "Dic"; }
								echo date("d",$fechaF)."/".$mesFni."/".date("Y",$fechaF);
								?>
							</div>
							<div class="col-1 text-center">
								<?php if($rowR["final"] > $datenow && $rowR["status"]=="A"){ ?>
									<b class="text-success"><nobr>En Fecha</nobr></b>
								<?php }elseif($rowR["status"]=="A"){?>
									Activo
								<?php }elseif($rowR["status"]=="E"){?>
									<span class="text-danger">Eliminado</span>
								<?php }else{ ?>
									Inactivo
								<?php } ?>
							</div>
							<div class="col-1 text-center">
								<?php if($rowR["status"]!="E"){ ?>
								<a href="#" data-toggle="modal" data-target="#boxDel<?php echo $rowR["id"];?>" class="text-muted" style="font-size: 9pt;">
									<i class="fa fa-trash"></i>
								</a>
								<?php } ?>
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
										<form action="programaciones_grabar.php" method="POST" accept-charset="utf-8">
										<input type="hidden" name="acc" value="delete">
										<input type="hidden" name="id"  value="<?php echo $rowR["id"];?>">
										<div class="row">
											<div class="col-md-8">
												<h5 class="mt-0 mb-3 pl-2 text-secondary"><b>Eliminar Programación</b></h5>
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-12">
												Esta seguro de querer eliminar la programación: <b><?php echo $rowR["nombre"];?></b>?
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
				</div>
			</div>

			<!-- Modal agregar -->
			<div class="modal fade" id="boxAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  	<div class="modal-dialog position-relative" role="document">
				    <div class="modal-content">
				        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="top:20px; right: 20px; z-index: 777;">
				          <span aria-hidden="true">&times;</span>
				        </button>
						<div class="modal-body p-4">
							<h5 class="mt-0 mb-3 pl-0 text-dark"><b>Agregar Programación</b></h5>
							<form action="programaciones_grabar.php" method="POST" accept-charset="utf-8">
							<input type="hidden" name="acc" value="add">
							<div class="form-row">
								<div class="form-group col-md-12">
									<label>Nombre *</label>
									<input type="text" name="nombre" class="form-control" required="required">
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
							<div class="form-row">
								<div class="form-group col-md-12">
									<textarea name="descripcion" class="form-control" rows="2" placeholder="Descripción"></textarea>
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
									<input type="submit" name="submitformAdd" class="form-control btn btn-secondary text-light" value="agregar">
								</div>
							</div>
							</form>
						</div>
					</div>
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
							<form action="programaciones.php" method="POST">
							<div class="row">
								<div class="col-md-9 col-9 p-0 pr-2">
									<input type="text" name="busqueda" class="form-control">
								</div>
								<div class="col-3 p-0">
									<input type="submit" class="btn btn-secondary form-control" name="filtro" value="buscar" style="font-weight: bold;">
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

