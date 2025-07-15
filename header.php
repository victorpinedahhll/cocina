<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//error_reporting(E_ALL & ~E_NOTICE);

require("security.php");
require("_private/_access.php");
if($nologg != "NO"){
    include("logged.php");
    include("parametros_generales.php");
}
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

    <style>
      .logout {
            top: 15px;
            right: 35px;
            z-index: 999999;
            font-size: 10pt;
        }
        @media (max-width: 991px){
            .content-box, .logout {
                display: none;
            }
        }

    </style>

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
    <?php if($nologg != "NO" && $page!="pacientesart"){ ?>
    <div class="logout">
      Bienvenido: <b style="font-size: 12pt;"><?php echo $nmsession; ?> &nbsp;
      <?php 
      if($nvsessiontemp=="S"){ 
        echo "<span class='bg-success text-light px-2 py-1' style='font-size: 8pt; border-radius: 30px;'> &nbsp;Solicitudes </span>"; 
      }elseif($nvsessiontemp=="C"){ 
        echo "<span class='bg-warning px-2 py-1' style='font-size: 8pt; border-radius: 30px;'> &nbsp;Cocina </span>"; 
      }elseif($nvsession=="ALL"){ 
        echo "<span class='bg-info text-light px-2 py-1' style='font-size: 8pt; border-radius: 30px;'> &nbsp;Chef </span>"; 
      }elseif($nvsession=="777"){ 
        echo "<span class='bg-secondary px-2 py-1 text-light' style='font-size: 8pt; border-radius: 30px;'> &nbsp;Webmaster </span>"; 
      } ?>
      </b> &nbsp;&nbsp;&nbsp;|&nbsp; 
      <?php if($nvsessiontemp=="C"){  ?>
        <a href="cocina.php" <?php if($page=="forms"){ ?>class="active"<?php } ?>>Solicitudes Cocina</a> &nbsp;|&nbsp;
      <?php }elseif($nvsessiontemp=="S"){  ?>
        <a href="pacientes.php" <?php if($page=="pacientes"){ ?>class="active"<?php } ?>>Pacientes Activos</a> &nbsp;|&nbsp;
        <a href="solicitudes.php" <?php if($page=="solicitud"){ ?>class="active"<?php } ?>>Solicitudes</a> &nbsp;|&nbsp;
      <?php }elseif($nvsession=="ALL" || $nvsession=="777"){  ?>
        <a href="pacientes_activos.php" <?php if($page=="pacientes"){ ?>class="active"<?php } ?>>Pacientes</a> &nbsp;|&nbsp; 
        <a href="programaciones.php" <?php if($page=="progra"){ ?>class="active"<?php } ?>>Programación Menus</a> &nbsp;|&nbsp; 
        <a href="platos.php" <?php if($page=="platos"){ ?>class="active"<?php } ?>>Platos</a> &nbsp;|&nbsp; 
        <a href="tipo_dietas.php" <?php if($page=="dieta"){ ?>class="active"<?php } ?>>Tipo Dietas</a> &nbsp;|&nbsp; 
        <a href="tipo_menus.php" <?php if($page=="tmenu"){ ?>class="active"<?php } ?>>Tipo Menus</a> &nbsp;|&nbsp;
      <?php } ?>
        <a href="perfil_editar.php" <?php if($page=="perfil"){ ?>class="active"<?php } ?>>Perfil</a> &nbsp;|&nbsp; 
        <a href="logout.php" style="color: #bd2026;">salir</a></div>
      <?php } ?>