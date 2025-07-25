<?php
$titulo = "Control de Usuarios";
$nologg = "SI";
$page   = "usuarios";
$areaLg = "USUARIOS";  // valida roles del usuario

include("header.php");
?>
<style>
	.content-text {
		margin: 160px 21px 0 21px;
	}
</style>

<div class="row pt-0 mb-4">
	<div class="col-md-12 content-box position-relative">

		<div class="px-5" style="margin-top: 170px;">
			<div class="row">
				<div class="col-md-12">
					<div class="box-admin-opt pt-3">
						<div class="row bg-secondary text-light mb-3" style="height: 27px; font-weight: bold;">
							<div class="col-md-2">
								Usuario
							</div>
                            <div class="col-md-3">
								Nombre
							</div>
							<div class="col-md-4">
								Email
							</div>
							<div class="col-md-2">
								
							</div>
						</div>
						<?php
						$van = 0;
						if($idsession==="1"){
							$qryus = "
                                SELECT * 
                                FROM _usuarios_admin 
                                WHERE 
                                    id_us00 > '0'  
                                ORDER BY 
                                    status_wua32 desc
                                    , nombre_us07
                            ";
						}else{
							// no lista webmaster ni ambiente de pruebas (sandbox)
							$qryus = "
                                SELECT * 
                                FROM _usuarios_admin 
                                WHERE 
                                    id_us00 > '1' 
                                ORDER BY 
                                    status_wua32 desc
                                    , nombre_us07";
						}
						$stmt = $pdo->prepare($qryus);
                        $stmt->execute();
						while ($rowus = $stmt->fetch(PDO::FETCH_ASSOC)){
							$van = $van + 1;
						?>
						<div class="row pb-2 pt-2 mb-0 <?php if ($van%2==0){ echo "bg-muted"; } ?>" <?php if($rowus["status_wua32"]=="0"){ ?>style="background: #fbe4e4;<?php } ?>">
						    <div class="col-md-2">
								<?php echo $rowus["usuario_us13"]; ?>
							</div>	
                            <div class="col-md-3">
								<?php echo $rowus["nombre_us07"]; ?>
							</div>
							<div class="col-md-5">
								<?php echo $rowus["email_wua25"]; ?>
							</div>
							<div class="col-md-1 col-3 text-center">
								<?php 
								$colinac = "style='border: 1px solid #808080 !important; color: #808080 !important;'";
								if($rowus["status_wua32"]=="0"){
									$colinac = "style='border: 1px solid #f42a54 !important; color: #f42a54 !important;'";
								}
								?>
								<?php if($rowus["status_wua32"]=="1"){ ?>
								<a href="usuarios_grabar.php?us=<?php echo $rowus["id_us00"];?>&st=0" class="btn btn-sm mt-2 mt-md-0" <?php echo $colinac; ?>>
                                    desactivar
								</a>
								<?php }else{ ?>
								<a href="usuarios_grabar.php?us=<?php echo $rowus["id_us00"];?>&st=1" class="btn btn-sm px-3 mt-2 mt-md-0" <?php echo $colinac; ?>>
                                    activar
								</a>
								<?php } ?>
							</div>
							<div class="col-md-1 col-3 text-center">
								<a href="usuarios_editar.php?us=<?php echo $rowus["id_us00"];?>" class="btn btn-sm px-4 mt-2 mt-md-0" <?php echo $colinac; ?>>
                                    editar
								</a>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include("footer.php"); ?>

