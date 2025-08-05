<?php
$titulo = "Pedidos Cocina Detalle";
$nologg = "SI";
$page   = "pedidos";
$areaLg = "PEDIDOS";  // valida roles del usuario

include("header.php");
?>
<style>
	.content-text {
		margin: 160px 21px 0 21px;
	}

</style>

<div class="row pt-0 mb-4">
	<div class="col-md-12 content-box position-relative">

		<div style="width: 96%; margin: 150px auto 150px auto;">
            <div class="row p-0" style="background: #1366e0; border-radius: 30px;">
                <div class="col-md-12 py-2">
                    <?php
                    $qTD = "SELECT * FROM _tipo_dieta WHERE status = 'A'";
                    $rTD = $conexion->query($qTD);
                    while ($fTD = $rTD->fetch_assoc()){
                        echo "<a href='?td=".$fTD["id"]."' style='color: #fff; margin-right: 15px; margin-left: 15px; border-right: 1px solid #c0dbf0; padding-right: 23px;'>".$fTD["nombre"]."</a>";
                    }
                    ?>
                </div>
            </div>
			<div class="row mt-3 mb-5 pb-5">
                <?php
                $qTipd  = "";
                if($_GET["td"] > 0){
                    $idTP   = $_GET["td"];
                    $qTipd  = "AND dieta = '$idTP'";
                }
                $visita = 0; 
				$van    = 0;
                $qryH = "
                SELECT *
                    , (select nombre from _tipo_dieta t where t.id=a.dieta) as ndieta 
                    , (select nombre from _tipo_menu m where m.id=a.menu) as nmenu 
                FROM _pacientes_solicitudes a 
                WHERE 
                    status = '0' 
                    AND orden_medica IN (
                        SELECT id 
                        FROM _ordenes_medicas o 
                        WHERE 
                            o.id=a.orden_medica 
                            AND o.status = 'A' 
                    ) 
                    $qTipd
                ";
                $resH = $conexion->query($qryH);
                while ($rowH = $resH->fetch_assoc()){
					$van++;
                    ?>
                    <div class="col-md-3" style="min-height: 300px;">
                        <div class="p-3" style="background: #002d59; color: #fff;">
                            <h4 class="m-0" style="font-size: 14pt;"><b>Orden # <?php echo $rowH["orden_medica"]; ?> &nbsp;|&nbsp; Pedido # <?php echo $rowH["id"]; ?></b></h4>    
                            <h5 class="m-0" style="color: #fff !important; font-size: 12pt;"><?php echo $rowH["pnombre"]; ?> <?php echo $rowH["papellido"]; ?></h5>
                            <p class="m-0" style="font-size: 10pt;">Tipo Dieta: <b><?php echo $rowH["ndieta"]; ?></b></p>
                            <p class="m-0" style="font-size: 10pt;">Tipo Menú: <b><?php echo $rowH["nmenu"]; ?></b></p>
                            <p class="m-0" style="font-size: 10pt;"><?php echo $rowH["habitacion"]; ?></p>
                            <p class="m-0" style="font-size: 10pt;">DR. <?php echo $rowH["medico_nombre"]; ?></p>
                        </div>
                        <?php
                        $cod_pac =  $rowH["codigo"];
                        $qAL = "SELECT * FROM _pacientes_alergias WHERE _paciente_cod = '$cod_pac'";
                        $rAl = $conexion->query($qAL);
                        if($rAl->num_rows > 0){ ?>
                        <div class="bg-danger text-light py-1 px-3">
                            Alergia a: 
                            <b>
                            <?php 
                            while ( $fAl = $rAl->fetch_assoc() ){ 
                                echo $fAl["_alergia"].", ";
                            } ?>
                            </b>
                        </div>
                        <?php } ?>
                        <div class="box-items platos-historial w-100 h-100 position-relative" style="background: #fff url('images/fondo-portlet-platos.jpg') no-repeat bottom right; background-size: cover; padding: 18px 24px 60px 24px !important; font-size: 14pt; font-weight: bold;">
                            <form action="cocina_grabar.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $rowH["id"]; ?>">
                            <?php
                            $id_pac  = "solicitud".$rowH["id"];

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
                            $query.= "FROM _pacientes_menu_enlace p WHERE p.keyunico = '$id_pac' ORDER by id";
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
                            <div style="position: absolute; bottom: 18px; left: 18px;">
                                <input type="submit" name="submitfinal"    class="btn btn-warning w-100" value="entregar pedido" style="font-weight: bold;">
                                <input type="submit" name="submitcancelar" class="btn btn-danger w-100 mt-2" value="cancelar pedido" style="font-weight: bold;">
                            </div>
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </div>
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

