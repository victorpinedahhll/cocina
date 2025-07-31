<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//error_reporting(E_ALL & ~E_NOTICE);

require("security.php");
require("security_adv.php");
require("_private/_access.php");
include("logged.php");
include("parametros_generales.php");
?>
<!DOCTYPE HTML>
<html lang="en">
  <head>
    <meta name="robots" content="noindex, nofollow, nosnippet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Imupgrade.com">

    <?php if(!empty($meta)){ ?>
    <title><?php echo $meta; ?></title>
    <?php }else{ ?>
    <title>Cocina</title>
    <?php } ?>

    <!--Bootsrap 4 CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
      
      <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Quicksand:wght@300;400;500;600;700&family=Sansita+Swashed:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!--Custom styles-->
    <?php include("include_css.php"); ?>

    <!-- Favicons -->
    <link rel="icon" href="favicon.png" type="image/png">


    <!-- Se agregaron las librerias arriba si no deja de funcionar -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <?php if($page=="pedidos" || $page=="pacientesart" || $page=="solicitud"){ ?>
    <?php
    $keyP  = $_SESSION["keyun$idPac"];
    if($_GET["paciente"]=="NO"){
      $keyP  = $_SESSION["keyunvisit$idPac"];
    }  
    ?>
    <script>
        fetchTasks();

        // Fetching Tasks
        function fetchTasks() {
          $.ajax({
            url: 'platos_elegidos.php?sol=<?php echo $_GET["sol"]; ?>&id=<?php echo $_GET["id"]; ?>&paciente=<?php echo $_REQUEST["paciente"]; ?>&keypac=<?php echo $keyP; ?>',
            type: 'GET',
            success: function(response) {
              const tasks = JSON.parse(response);
              let template = '';
              tasks.forEach(task => {
               
                  // template += `
                  //   <div class='row' taskId="${task.id}" taskIdpr="${task.idprogra}-${task.idmenu}" taskKey="${task.key}">
                  //     <div class='col-11'><b>${task.nprogra}</b><br>${task.nmenu} (${task.name})</div>
                  //     <div class='col-1 text-center'><i class='btn fa fa-times item-delete'></i></div>
                  //   </div>
                  // `
                  template += `
                    <div class='row pt-3 pb-0' taskId="${task.id}" taskIdpr="${task.idprogra} ${task.idmenu}" taskKey="${task.key}">
                      <div class='col-11'><b>${task.name}</b></div>
                      <div class='col-1 text-center'><i class='btn fa fa-trash item-delete'></i></div>
                    </div>
                  `

              });
              $('#tasks').html(template);
            }
          });
        }

        // Delete a Single Task
        $(document).on('click', '.item-delete', function() {
          let element = $(this)[0].parentElement.parentElement;
          let id  = $(element).attr('taskId');
          let idp = $(element).attr('taskIdpr');
          let key = $(element).attr('taskKey');

          $.post('platos_delete.php', {id,key}, function (response) {
            let idpr = '#item'+idp;
            $(idpr).prop("checked", false);
            console.log(response);
            fetchTasks();
          });
        });
    </script>
    <?php } ?>

  </head>

  <body id="page-top">
    <header  style="background: #002d59;">
    <nav class="navbar navbar-expand-lg logout m-0 px-4 py-0">
      <a class="navbar-brand" href="#"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item pr-2 pt-1">
            <a class="nav-user">Bienvenido <b style="color: #002d59;"><?php echo $ussession; ?></b></a>
          </li>
          <?php 
          $qryMe = "
            SELECT *
              , (
                SELECT _nombre FROM _roles r WHERE r._nombre_sys = a._rol
              ) as namerol 
              , (
                SELECT _url FROM _roles r WHERE r._nombre_sys = a._rol
              ) as url  
              , (
                SELECT _orden FROM _roles r WHERE r._nombre_sys = a._rol
              ) as orden 
            FROM _usuarios_roles a 
            WHERE _usuario_id = ? 
            ORDER by orden
          ";
          $resMe = $pdo->prepare($qryMe);
          $resMe->execute([$idsession]);
          while ($rowMe = $resMe->fetch(PDO::FETCH_ASSOC)){
          ?>
          <li class="nav-item">
            <a class="nav-link px-3 <?php if($rowMe["_rol"]==$areaLg){ ?>active<?php } ?>" href="<?php echo $rowMe["url"]; ?>"><?php echo $rowMe["namerol"]; ?></a>
          </li>
          <?php } ?>
          <li class="nav-item">
            <a class="nav-link px-3 <?php if($page=="perfil"){ ?>active<?php } ?>" href="perfil_editar.php">Perfil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3" href="logout.php" style="color: #e70914 !important;">
              <i class="fa fa-power-off" title="cerrar sesión"></i>
            </a>
          </li>
        </ul>
      </div>
    </nav>

		<div class="row mt-5" style="background-color: ##002d59;">
			<div class="col-4 py-2 px-5">
				<img src="images/logo_v1.svg" height="45">
			</div>
			<div class="col-8 pr-5 pt-3 text-right">
        <?php if($page=="ordenes"){ ?>
        <a href="ordenes_medicas_agregar.php" class="btn" style="font-weight: bold; background-color: white;">
					<i class="fa fa-plus"></i>
				</a>
        <?php } ?>

        <?php if($page=="pacientes"){ ?>
        <a href="pacientes_agregar.php" class="btn" style="font-weight: bold; background-color: white;">
					<i class="fa fa-plus"></i>
				</a>
        <?php } ?>

        <?php if($page=="usuarios"){ ?>
				<a href="usuarios_agregar.php" class="btn btn-outline-secondary" style="font-weight: bold; background-color: white;">
          <i class="fa fa-plus"></i>
        </a>
        <?php } ?>

        <?php if($page=="tmenu" || $page=="dieta"){ ?>
        <a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#boxSearch"  style="font-weight: bold; background-color: white; color: black;">
					<i class="fa fa-search"></i>
				</a>
        <?php } ?>

        <?php if( ($page=="platos" || $page=="progra") && $_GET["id"] <= "0" ){ ?>
        <a href="#" class="btn btn-outline-secondary" data-toggle="modal" data-target="#boxAdd" style="font-weight: bold; background-color: white;">
					<i class="fa fa-plus"></i>
				</a>
				<a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#boxSearch"  style="font-weight: bold; background-color: white; color: black;">
					<i class="fa fa-search"></i>
				</a>
        <?php } ?>
			</div>
		</div>
		
    <?php
    $bgcol   = "#002d59"; 
    $fontcol = "#ffffff";
    // if($page=="pacientes"){
    //   $bgcol = "#d9ead3";
    //   $fontcol = "#3e3e3e";
    // }elseif($page=="pedidos"){
    //   $bgcol = "#f4cccc";
    //   $fontcol = "#3e3e3e";
    // }elseif($page=="platos"){
    //   $bgcol = "#e1f0ed";
    //   $fontcol = "#3e3e3e";
    // }elseif($page=="solicitud"){
    //   $bgcol = "#efe4d6";
    //   $fontcol = "#3e3e3e";
    // }elseif($page=="usuarios"){
    //   $bgcol = "#ded3fa";
    //   $fontcol = "#3e3e3e";
    // }
    ?>
		<div class="row mt-3" style="background: <?php echo $bgcol; ?>;">
			<div class="col-md-12" style="background: <?php echo $bgcol; ?>;">
				<div class="esconder-movil"  style="background: <?php echo $bgcol; ?>;">
					<div class="mb-3 text-center" style="background: <?php echo $bgcol; ?>;color: <?php echo $fontcol; ?>; height: 42px; font-size: 16pt; padding-top: 4px; font-weight: bold;">
						<?php echo $titulo;?>
					</div>
				</div>
			</div>
		</div>
		
		</header>
		</br>
		</br>
