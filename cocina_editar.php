<?php
$titulo = "Pedidos Cocina Detalle";
$nologg = "SI";
$page   = "pedidos";
$areaLg = "PEDIDOS";  // valida roles del usuario

include("header.php");

$idPac  = $_GET["id"];
$qryPac = "
	SELECT *
		, (SELECT nombre FROM _tipo_dieta t WHERE t.id=a.dieta) AS ndieta 
		, (SELECT nombre FROM _habitaciones h WHERE h.nombre=a.habitacion) AS nhabitacion 
	FROM _pacientes_solicitudes a 
	WHERE id='$idPac'
	";
$rsPac  = $conexion->query($qryPac);
$rowPac = $rsPac->fetch_assoc();

$fechain        = $rowPac["fecha_ingreso"];
$pnombre        = $rowPac["pnombre"];
$snombre        = $rowPac["snombre"];
$papellido      = $rowPac["papellido"];
$sapellido      = $rowPac["sapellido"];
$dieta          = $rowPac["dieta"];
$auxiliar       = $rowPac['auxiliar_nutricion'];
$habitacion     = $rowPac["habitacion"];
$medico         = $rowPac["medico_tratante"];
$medicotratante = $rowPac["medico_nombre"];
$observaciones  = $rowPac["observaciones"];
$status         = $rowPac["status"];
$codigo         = $rowPac["codigo"];
$motivo         = $rowPac["motivo"];

$fecHora = strtotime($fechain);
$diaEnv  = date("d",$fecHora);
$anoEnv  = date("Y",$fecHora);
$mesEnv  = date("m",$fecHora);
if($mesEnv=="1"){ $mesElej = "ene"; }
if($mesEnv=="2"){ $mesElej = "feb"; }
if($mesEnv=="3"){ $mesElej = "mar"; }
if($mesEnv=="4"){ $mesElej = "abr"; }
if($mesEnv=="5"){ $mesElej = "may"; }
if($mesEnv=="6"){ $mesElej = "jun"; }
if($mesEnv=="7"){ $mesElej = "jul"; }
if($mesEnv=="8"){ $mesElej = "ago"; }
if($mesEnv=="9"){ $mesElej = "sep"; }
if($mesEnv=="10"){ $mesElej = "oct"; }
if($mesEnv=="11"){ $mesElej = "nov"; }
if($mesEnv=="12"){ $mesElej = "dic"; }

$dateEmail = $diaEnv."/".$mesElej."/".$anoEnv;

if($_GET['idtp'] > "0"){
	$idplato = $_GET["idtp"];
	$qryT2 = "SELECT * FROM _tipo_menu WHERE id='$idplato'";
	$rsT2  = $conexion->query($qryT2);
	$rowT2 = $rsT2->fetch_assoc();
}

if($_GET['id2'] > "0"){
	$idM  = $_GET["id2"];
	$qryT = "SELECT * FROM _menus WHERE id='$idM'";
	$rsT  = $conexion->query($qryT);
	$rowT = $rsT->fetch_assoc();
}

if($_GET['id3'] > "0"){
	$idopc = $_GET["id3"];
	$qryO  = "SELECT * FROM _menus_opciones WHERE id='$idopc'";
	$rsO   = $conexion->query($qryO);
	$rowO  = $rsO->fetch_assoc();
	$nombreopc = $rowO["nombre"];
}

if($_GET['id4'] > "0"){
	$idopc1  = $_GET["id4"];
	$qryT4 = "SELECT * FROM _menus_subopciones WHERE id='$idopc1'";
	$rsT4  = $conexion->query($qryT4);
	$rowT4 = $rsT4->fetch_assoc();
	$nombreopcT4 = $rowT4["nombre"];
}

if($_GET['id5'] > "0"){
	$idopc2  = $_GET["id5"];
	$qryT5 = "SELECT * FROM _menus_subopciones2 WHERE id='$idopc2'";
	$rsT5  = $conexion->query($qryT5);
	$rowT5 = $rsT5->fetch_assoc();
	$nombreopcT5 = $rowT5["nombre"];
}

if($_GET['id6'] > "0"){
	$idopc3  = $_GET["id6"];
	$qryT6 = "SELECT * FROM _menus_subopciones3 WHERE id='$idopc3'";
	$rsT6  = $conexion->query($qryT6);
	$rowT6 = $rsT6->fetch_assoc();
	$nombreopcT6 = $rowT6["nombre"];
}

$txtcol = "000";
$btncol = "17a2b8";
if($_GET["van"]=="1"){
	$btncol = "17a2b8";
	$txtcol = "fff";
}elseif($_GET["van"]=="2"){
	$btncol = "28a745";
	$txtcol = "fff";
}elseif($_GET["van"]=="3"){
	$btncol = "582ba3";
	$txtcol = "fff";
}elseif($_GET["van"]=="4"){
	$btncol = "ffc107";
}
?>
<style>
	html,body {
		background: #dedede !important;
	}
	.content-text {
		margin: 160px 21px 0 21px;
	}

</style>

<div class="row pt-0 mb-4">
	<div class="col-md-12 content-box position-relative">

		<div style="width: 96%; margin: 175px auto 50px auto;">
			<div class="row">
				<div class="col-md-12">
					<div class="box-admin-opt px-3 pt-2 pb-0 mb-3" style="background: #ffffff; color: #3e3e3e; padding-bottom: 0px !important; box-shadow: 5px 10px 10px -10px #333333;">
						<ul class="form-ul">
							<li class="pt-2" style="width: 10%; line-height: 13pt;">
								<label style="font-size: 14pt;">Orden # <?php echo $idPac; ?></label><br>
								<?php echo $dateEmail; ?>
							</li>
							<li class="pt-2 pl-0" style="width: 18%; line-height: 13pt;">
								<label>Nombre Paciente</label><br>
								<?php echo $pnombre; ?> <?php echo $snombre; ?> <?php echo $papellido; ?> <?php echo $sapellido; ?>
							</li>
							<li class="pt-2" style="width: 18%; line-height: 13pt;">
								<label>Habitacion/Cama *</label><br>
								<?php echo $habitacion; ?>
							</li>
							<li class="pt-1 pl-0" style="width: 24%; line-height: 13pt;">
								<div class="m-0 px-3 text-center" style="background: #2b6daf; width: 70%; color: #fff; border-radius: 7px; line-height: 14pt; padding: 12px 0;">
									<span>Tipo de Dieta</span><br>
									<b style="font-size: 15pt;"><?php echo $rowPac["ndieta"]; ?></b>
								</div>
							</li>
							<li style="width: 25%;">
								
								<div class="row">
									<div class="col-md-9 pt-3" style="line-height: 11pt;">
										<label>Auxiliar de Nutrición:</label><br>
										<?php
										if($auxiliar>0){ 
											$qryX = "
												SELECT * 
												FROM _usuarios_admin 
												WHERE id_us00 = '$auxiliar'
											";
											$resX = $conexion->query($qryX);
											$rowX = $resX->fetch_assoc();
											echo $rowX["nombre_us07"];
										}
										?>
									</div>
								</div>
							</li>
							<li class="text-right pt-3" style="width: 5%;">
								<button type="button" class="btn btn-sm" data-toggle="modal" data-target="#exampleModal" style="background: #002d59; color: #fff;">
									<i class="fa fa-plus"></i>
								</button>
								<!-- Modal -->
								<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header" style="background: #002d59; color: #ffffff;">
								        <h5 class="modal-title text-light" id="exampleModalLabel"><b>Código paciente:</b> <?php echo $codigo; ?></h5>
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								          <span aria-hidden="true">&times;</span>
								        </button>
								      </div>
								      <div class="modal-body text-dark pb-5 text-left">
								     	<b>Médico tratante *</b><br>
										<?php echo $medicotratante; ?><br><br>
									  	<b>Motivo ingreso</b><br>
								        <?php echo $motivo; ?>
								      </div>
								    </div>
								  </div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>

			<?php 
			$nalergias = []; 
			$qryA = "SELECT * FROM _pacientes_alergias WHERE _paciente_cod = '$codigo'";
			$resA = $conexion->query($qryA);
			while ($rowA = $resA->fetch_assoc()){
				$nalergias[] = $rowA["_alergia"];
			}
			if($resA->num_rows > 0){ ?>
			<div class="row mt-1 mb-3 mx-1 blink_me">
				<div class="col-md-12 py-2 bg-danger text-center" style="border-radius: 7px;">
					<h5 class="text-light m-0"><b>Alerta</b>, este paciente es alérgico a: <b><?php echo implode(", ", $nalergias); ?></b></h5>
				</div>
			</div>
			<?php } ?>
			<?php if($rowPac["status"]=="0"){ ?>
			<form action="cocina_grabar.php" method="POST">
			<input type="hidden" name="id" value="<?php echo $idPac; ?>">
			<?php } ?>
			<div class="row mt-3 mb-5 pb-5">
                <?php
                $visita = 0; 
				$van    = 0;
                $qryH = "SELECT * FROM _pacientes_solicitudes WHERE id = $idPac";
                $resH = $conexion->query($qryH);
                while ($rowH = $resH->fetch_assoc()){
					$van++;
                    ?>
                    <div class="col-md-3 position-relative" style="min-height: 300px;">
                        <?php if($rowH["paciente"]=="SI"){?>
                            <h4 class="text-center py-3 mb-2" style="background: #002d59; color: #fff; border-radius: 4px;">Pedido a paciente</h4>
                        <?php 
                        }else{
                            $visita++;
                             ?>
                            <h4 class="text-center py-3 mb-2" style="background: #002d59; color: #fff; border-radius: 4px;">Pedido a visitante <?php echo $visita; ?></h4>
                        <?php } ?>
                        <div class="box-items platos-historial w-100 h-100" style="background: #fff url('images/fondo-portlet-platos.jpg') no-repeat bottom right; background-size: cover; padding: 18px 24px !important; font-size: 14pt; font-weight: bold; position: relative;">
                            <?php
                            $key_sol = "solicitud".$rowH["id"];
                            $id_pac  = $rowH["orden_medica"];

                            $query = "SELECT *";
        
                            // ----- TIPO 2 ------
                            $query.= ", (select nombre from _menus_opciones o where o.id=p.idopcion and p.tipo='2') as nmopt";
                            $query.= ", (select nombre from _menus m where m.id in (select idmenu from _menus_opciones o where o.idmenu=m.id and p.idopcion=o.id)) as nmmenu";
                            
                            // ----- TIPO 3 ------
                            $query.= ", (select nombre from _menus_opciones o where o.id in (select idopcion from _menus_subopciones s where s.idopcion=o.id and p.idmenu=s.idmenu and p.idopcion=s.id)) as nmsubmenu";
                            $query.= ", (select nombre from _menus m where m.id in (select idmenu from _menus_subopciones s where s.idmenu=m.id and p.idopcion=s.id and s.idmenu=p.idmenu)) as menut3";
                            $query.= ", (select nombre from _menus_subopciones d where d.id in (select idopcion2 from _menus_subopciones2 t where t.idopcion2=d.id and t.idmenu=p.idmenu and p.idopcion=t.idopcion)) as submenu2";
                            $query.= ", (select nombre from _menus_subopciones s where s.id=p.idopcion and s.idmenu=p.idmenu) as nmsub";

                            // ----- TIPO 4 ------
                            $query.= ", (select nombre from _menus m where m.id in (select idmenu from _menus_subopciones2 t where t.idmenu=m.id and t.id=p.idopcion and t.idmenu=p.idmenu)) as menut4";
                            $query.= ", (select nombre from _menus_opciones o where o.id in (select idopcion from _menus_subopciones2 t where t.idopcion=o.id and t.id=p.idopcion and t.idmenu=p.idmenu)) as submenu4";
                            $query.= ", (select nombre from _menus_subopciones d where d.id in (select idopcion2 from _menus_subopciones2 t where t.idopcion2=d.id and t.id=p.idopcion and t.idmenu=p.idmenu)) as ssubmenu4";
                            $query.= ", (select nombre from _menus_subopciones2 t where t.id=p.idopcion and t.idmenu=p.idmenu) as tmsub";

                            // ----- TIPO 5 ------
                            $query.= ", (select nombre from _menus_subopciones2 t where t.id in (select idopcion3 from _menus_subopciones3 x where x.idopcion3=t.id and x.idmenu=p.idmenu and x.id=p.idopcion)) as tmsub5";
                            $query.= ", (select nombre from _menus_subopciones3 x where x.id=p.idopcion and x.idmenu=p.idmenu) as sssmenu5";

                            // ----- TIPO 6 ------
                            $query.= ", (select nombre from _menus m where m.id in (select idmenu from _menus_subopciones4 z where z.idmenu=m.id and z.id=p.idopcion and z.idmenu=p.idmenu)) as menut6";
                            $query.= ", (select nombre from _menus_opciones o where o.id in (select idopcion from _menus_subopciones4 z where z.idopcion=o.id and z.id=p.idopcion and z.idmenu=p.idmenu)) as submenu6";
                            $query.= ", (select nombre from _menus_subopciones d where d.id in (select idopcion2 from _menus_subopciones4 z where z.idopcion2=d.id and z.id=p.idopcion and z.idmenu=p.idmenu)) as ssubmenu6";
                            $query.= ", (select nombre from _menus_subopciones2 t where t.id in (select idopcion3 from _menus_subopciones4 z where z.idopcion3=t.id and z.id=p.idopcion and z.idmenu=p.idmenu)) as tmsub6";
                            $query.= ", (select nombre from _menus_subopciones3 x where x.id in (select idopcion4 from _menus_subopciones4 z where z.idopcion4=x.id and z.id=p.idopcion and z.idmenu=p.idmenu)) as ttmsub6";
                            $query.= ", (select nombre from _menus_subopciones4 z where z.id=p.idopcion and z.idmenu=p.idmenu) as sssmenu6";
                            $query.= ", (select nombre from _programaciones c where c.id=p.idopcion) as nprogra ";
                            $query.= "FROM _pacientes_menu_enlace p WHERE p.keyunico='$key_sol' and idpaciente='$id_pac' ORDER by id";
                            $query."<br><br>";
                            $result = $conexion->query($query);
                            while($row = $result->fetch_assoc()) { 
                                if($row["tipo"]=="2"){
                                    echo "<p>".$row['nmmenu']." ".$row['nmopt']."<br>";
                                }

                                if($row["tipo"]=="3"){
                                    echo "<p>".$row['menut3']." ".$row['nmsubmenu']." ".$row["nmsub"]."<br>";
                                }

                                if($row["tipo"]=="4"){
                                    echo "<p>".$row['menut4']." ".$row["submenu4"]." ".$row['ssubmenu4']." ".$row['tmsub']."</p>";
                                }

                                if($row["tipo"]=="5"){
                                    echo "<p>".$row['menut4']." ".$row["submenu4"]." ".$row['ssubmenu4']." ".$row['tmsub5']." ".$row["sssmenu5"]."</p>";
                                }

                                if($row["tipo"]=="6"){
                                    echo "<p>".$row['menut6']." ".$row["submenu6"]." ".$row['ssubmenu6']." ".$row['tmsub6']." ".$row["ttmsub6"]." ".$row["sssmenu6"]."</p>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?php } ?>
				<div class="col-md-3 position-relative" style="min-height: 200px;">
					<h4 class="text-center py-3 mb-2" style="background: #002d59; color: #fff; border-radius: 4px;">Observaciones</h4>
					<div class="box-items platos-historial w-100 h-100" style="background: #fff; padding: 18px 24px !important; font-size: 14pt; font-weight: bold; position: relative;">
						<?php if(!empty($rowPac["observaciones"])){ echo $rowPac["observaciones"]; ?><br><br><?php } ?>
						<?php if(!empty($rowPac["observaciones_cocina"])){ ?><p class="text-secondary"><?php echo $rowPac["observaciones_cocina"]; ?></p><?php } ?>
					</div>
				</div>
				<?php if($rowPac["status"]=="0"){ ?>
				<div class="col-md-3" style="min-height: 300px;">
					<h4 class="text-center py-3 mb-2" style="background: #002d59; color: #fff; border-radius: 4px;">Observaciones cocina</h4>
					<div class="box-items platos-historial w-100 h-100" style="background: #fff; padding: 18px 24px !important; font-size: 14pt; font-weight: bold; position: relative;">
						<textarea name="observaciones" class="form-control" rows="7"></textarea>
						<input type="submit" name="submitfinal"    class="btn btn-lg btn-warning w-100 mt-3" value="entregar pedido" style="font-weight: bold;">
						<input type="submit" name="submitcancelar" class="btn btn-lg btn-danger w-100 mt-3" value="cancelar pedido" style="font-weight: bold;">
					</div>
				</div>
				<?php } ?>
				<div class="col-md-3">
					<h4 class="text-center py-3 mb-2" style="background: #002d59; color: #fff; border-radius: 4px;">Estado de la Orden</h4>
					<div class="box-items platos-historial w-100 h-100" style="background: #fff; padding: 14px !important; font-size: 14pt; font-weight: bold; position: relative;">
						<?php if($rowPac["status"]=="0"){ ?>
							<h4 class="py-3 px-4 m-0" style="color: #2b6daf; font-weight: bold;">En Proceso</h4>
						<?php }elseif($rowPac["status"]=="1"){ ?>
							<h4 class="py-3 px-4 m-0" style="color: #46bb1c; font-weight: bold;">Entregada a Auxiliar</h4>
						<?php }elseif($rowPac["status"]=="2"){ ?>
							<h4 class="py-3 px-4 m-0" style="color: #edc30b; font-weight: bold;">Entregada a Paciente</h4>
						<?php }elseif($rowPac["status"]=="C"){ ?>
							<h4 class="py-3 px-4 m-0" style="color: #d51427; font-weight: bold;">Cancelada</h4>
						<?php } ?>
					</div>
				</div>
            </div>
			</form>
		</div>
	</div>
</div>

<?php 
// elimino los sessions solo a modo de prueba
// unset($_SESSION["keyun$idPac"]);
// unset($_SESSION["keyunvisit$idPac"]);
?>

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

  // habilita campo para agregar nombre medico si no esta en el listado
  function cambia_medico() {
	if (document.getElementById("medico").value=="999999") {
		$("#otrobox").css("display", "block");
		console.log('block');
	}else{
		$("#otrobox").css("display", "none");
	};
  };

  $(document).on('change', '#alergias', (e) => {
	const postData = {
		pacienteid: $('#idpaciente').val(),
		alergia: $('#alergias').val()
	};
	$.post('alergia_add.php', postData, (response) => {
		console.log(response);
		location.reload(true);
	});
	e.preventDefault();
});
</script>

<?php include("footer.php"); ?>

