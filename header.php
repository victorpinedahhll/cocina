<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//error_reporting(E_ALL & ~E_NOTICE);

require("security.php");
require("security_adv.php");
require("_private/_access.php");
// if($nologg != "NO"){
    include("logged.php");
    include("parametros_generales.php");
// }
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

    <?php if($page=="pacientes" || $page=="pacientesart" || $page=="solicitud"){ ?>
    <script>
        fetchTasks();

        // Fetching Tasks
        function fetchTasks() {
          $.ajax({
            url: 'platos_elegidos.php?sol=<?php echo $_GET["sol"]; ?>',
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
                      <div class='col-11'>${task.name}</div>
                      <div class='col-1 text-center'><i class='btn fa fa-times item-delete'></i></div>
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
    <header>
    <nav class="navbar navbar-expand-lg logout m-0 px-4 py-0">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link">Bienvenido <b style="color: #002d59;"><?php echo $ussession; ?></b></a>
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
            FROM _usuarios_roles a 
            WHERE _usuario_id = ?
          ";
          $resMe = $pdo->prepare($qryMe);
          $resMe->execute([$idsession]);
          while ($rowMe = $resMe->fetch(PDO::FETCH_ASSOC)){
          ?>
          <li class="nav-item">
            <a class="nav-link px-3" href="<?php echo $rowMe["url"]; ?>"><?php echo $rowMe["namerol"]; ?></a>
          </li>
          <?php } ?>
          <li class="nav-item">
            <a class="nav-link px-3" href="perfil_editar.php">Perfil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3" href="logout.php" style="color: red !important;">Salir</a>
          </li>
        </ul>
      </div>
    </nav>

		<div class="row mt-5">
			<div class="col-4 py-2 px-5">
				<img src="images/logo-trans.png" height="45">
			</div>
			<div class="col-8 pr-5 pt-3 text-right">
        <?php if($page=="pacientes"){ ?>
        <a href="#" class="btn btn-outline-secondary" data-toggle="modal" data-target="#boxAdd" style="font-weight: bold;">
					<i class="fa fa-plus"></i>&nbsp; agregar paciente
				</a>
        <?php } ?>
        <?php if($page=="usuarios"){ ?>
				<a href="usuarios_agregar.php" class="btn btn-outline-secondary">
          <i class="fa fa-plus"></i>&nbsp; agregar usuario
        </a>
        <?php } ?>
        <?php if($page=="tmenu" || $page=="dieta"){ ?>
        <a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#boxSearch" style="font-weight: bold;">
					<i class="fa fa-search"></i>
				</a>
        <?php } ?>
			</div>
		</div>
		
		<div class="row mt-3">
			<div class="col-md-12">
				<div class="esconder-movil">
					<div class="mb-3 text-center text-light" style="background: #002d59; height: 40px; font-size: 16pt; padding-top: 2px; font-weight: bold;">
						<?php echo $titulo;?>
					</div>
				</div>
			</div>
		</div>
		
		</header>