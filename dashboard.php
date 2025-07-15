<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("security.php");
require("_private/_access.php");
if($nologg != "NO"){
    include("logged.php");
    include("parametros_generales.php");
}

if($nvsession=="ALL" || $nvsession=="777"){
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="robots" content="noindex, nofollow, nosnippet">
	<title>HHLL | Cocina</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="style-hl.css">

	<style>
		html,body {
			background-image: url('images/bg-cocina2.jpg');
			background-size: cover;
			background-repeat: no-repeat;
			background-position: center center;
		}
		.logo-home {
		  padding-top: 50px;
		}
		.imu {
			width: 100%;
			max-width: 300px;
			font-size: 8pt;
			text-align: center;
			margin: 10px auto;
			color: #fff;
			letter-spacing: 0.3px;
			background: rgba(0, 0, 0, 0.3);
			border-radius: 30px;
			padding: 3px;
		}
		.imu a {
			color: #fff !important;
		}
		.card {
		  height: 450px;
		}
		.card-header, .login_btn {
			background: #1a3a6c;
			color:  #fff;
		}
		.card-header h3 {
			color: #fff;
		}
		.input-group-text {
			background: #069ef6 !important;
		}
		.btn {
			letter-spacing: 0.5px;
		}
	</style>
</head>
<body>

<div class="container">
	<div class="row logo-home">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<img src="images/logo-trans.png" alt="Area Administrativa" class="img-fluid">
		</div>
	</div>
	<div class="d-flex justify-content-center">
		<div class="card position-relative">
			<div class="card-header text-center">
				<h3>Cocina</h3>
			</div>
			<div class="card-body">
				<form action="login_nivel.php" method="POST">
					<p class="text-center mb-4">
						Seleccione como desea ingresar al sistema
					</p>
					<div class="input-group form-group">
						<input type="submit" name="submitadmin" class="btn btn-md btn-info text-light w-100 font-weight-bold py-3" value="Chef">
					</div>
					<div class="input-group form-group">
						<input type="submit" name="submitsolicitud" class="btn btn-md btn-success text-light font-weight-bold w-100 py-3" value="Solicitudes">
					</div>
					<div class="input-group form-group">
						<input type="submit" name="submitcocina" class="btn btn-md btn-warning text-dark w-100 font-weight-bold py-3" value="Cocina">
					</div>
					<?php //if($_SESSION['splitacc']=="SI"){ ?>
					<div class="input-group form-group">
						<input type="submit" name="submitclose" class="btn btn-md btn-danger text-light w-100 font-weight-bold py-3" value="Cerrar Sesión">
					</div>
					<?php //} ?>
				</form>

			</div>

			
		</div>

	</div>
	<p class="imu">
		Powered by: 
		<a href="http://www.imupgrade.com" target="_blank">
			ImageUpgrade
		</a> &nbsp;|&nbsp; IT Herrera Llerandi
	</p>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

<script type="text/javascript">
function mostrarPassword(){
		var cambio = document.getElementById("txtPassword");
		if(cambio.type == "password"){
			cambio.type = "text";
			$('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambio.type = "password";
			$('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	} 
	
	$(document).ready(function () {
	//CheckBox mostrar contraseña
	$('#ShowPassword').click(function () {
		$('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
	});
});
</script>

</body>
</html>

<?php 
}else{
	echo "<body>";
	echo "<script>alert('Acceso Denegado o a expirado su sesion');document.location='logout.php';</script>";
	echo "</body>";
	exit;
}
 ?>}
