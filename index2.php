<!DOCTYPE html>
<html>
<head>
	<meta name="robots" content="noindex, nofollow, nosnippet">
	<title>HHLL | Sistema de Cocina</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="imupgrade.com" />
   
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!--Custom styles-->
	<?php include ('include_css.php'); ?>

	<style>
		html,body {
			padding: 0px;
			margin: 0px;
		}
		body {
			background-image: url('images/bg-cocina2.jpg');
			background-size: cover;
			background-repeat: no-repeat;
			background-position: center center;
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
				<br>
				<form action="login.php" method="POST">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" name="usuario" class="form-control" placeholder="usuario" value="<?php if(isset($_COOKIE["usuario_cook"])){ echo $_COOKIE["usuario_cook"]; }?>">
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" id="txtPassword" name="clave" class="form-control" placeholder="contraseña">
						<div class="input-group-append">
	            <button id="show_password" class="btn btn-light" type="button" onclick="mostrarPassword()" style="border-top: 1px solid #d3d2d2; border-right: 1px solid #d3d2d2; border-bottom: 1px solid #d3d2d2;"> <span class="fa fa-eye-slash icon"></span> </button>
	          </div>
					</div>
					<div class="row align-items-center remember">
						<input type="checkbox" name="recuerdame" value="SI" <?php if(isset($_COOKIE["recuerdame_cook"])){ echo "checked"; } ?>>Recuerdame
					</div>
					<div class="form-group">
						<input type="submit" name="submitlogin" value="Login" class="btn float-right login_btn">
					</div>
					
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

<!-- Modal agregar -->
<div class="modal fade" id="boxModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered position-relative" role="document">
    <div class="modal-content">
        <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close" style="top:20px; right: 20px; z-index: 777;">
          <span aria-hidden="true">&times;</span>
        </button>
		<div class="modal-body p-4 modal-custom">
			<form action="olvido_clave.php" method="POST" accept-charset="utf-8">
			<h2 style="color: #002d59;">¿olvidó su contraseña?</h2>
			<div class="form-row">
				<div class="form-group col-8">
					<label>Ingrese E-mail registrado</label>
					<input type="email" name="email" class="form-control">
				</div>
				<div class="form-group col-4">
					<label>&nbsp;</label>
					<input type="submit" name="submit" class="form-control btn text-light" value="enviar" style="background: #002d59;">
				</div>
			</div>
			</form>
		</div>
    </div>
  </div>
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