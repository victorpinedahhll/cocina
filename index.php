<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Herrera Llerandi</title>
    <meta name="robots" content="noindex, nofollow, nosnippet">
    <meta name="author" content="imupgrade.com" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <link rel="https://cdn.rawgit.com/mfd/f3d96ec7f0e8f034cc22ea73b3797b59/raw/856f1dbb8d807aabceb80b6d4f94b464df461b3e/gotham.css">

    <style>
        @font-face {
          font-family: GothamPro;
          src: url(fonts/GothamPro.eot);
          src: url(fonts/GothamPro.woff2) format("woff2"),url(fonts/GothamPro.woff) format("woff"),url(fonts/GothamPro.ttf) format("truetype"),url(fonts/GothamPro.svg#GothamPro) format("svg"),url(fonts/GothamPro.eot?#iefix) format("embedded-opentype");
          font-weight: 200;
          font-style: normal
        }
        @font-face {
          font-family: 'GothamPro light';
          src: url(fonts/GothamPro-Light.eot);
          src: url(fonts/GothamPro-Light.woff2) format("woff2"),url(fonts/GothamPro-Light.woff) format("woff"),url(fonts/GothamPro-Light.ttf) format("truetype"),url(fonts/GothamPro-Light.svg#GothamPro-Light) format("svg"),url(fonts/GothamPro-Light.eot?#iefix) format("embedded-opentype");
          font-weight: 100;
          font-style: normal
        }
        body {
            font-family: 'GothamPro';
        }
        .full-height {
            height: 100vh; /* Hace que la fila ocupe toda la altura de la ventana del navegador */
        }
        .logowhite {
            display: none;
        }
        @media (max-width: 767px){
            .logowhite {
                display: block;
                width: 100%;
                position: absolute;
                top: 45px;
                left: 0px;
                text-align: center;
            }
            .logowhite img {
                width: 55% !important;
            }
        }
        .col-ins {
            background: linear-gradient(#004997,#003064);
/*            background: #004997;*/
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .col-ins-2 {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        @media (max-width: 767px){
            .col-ins {
                display: none !important;
            }
        }
        .form-container {
            width: 100%;
            max-width: 425px; /* Opcional: Para limitar el ancho del formulario */
            background: rgba(255, 255, 255, 0.7);
            padding: 25px 40px 35px 40px;
            border-radius: 7px;
        }
        h3  {
            color: #004997;
            letter-spacing: 15px;
            font-size: 32pt;
            line-height: 44pt;
            margin-left: 25px;
        }
        label {
            font-size: 10pt;
        }
        .btn-intranet {
            background: #004997;
            color: #fff;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .btn-intranet:hover {
            background: #6d97af;
            color: #002549;
        }
        .powered {
            position: absolute;
            right: 30px;
            bottom: 30px;
            font-size: 9pt;
            text-align: right;
            color: #C0C0C0;
        }
        .powered a {
            color: #C0C0C0;
            text-decoration: none;
        }
        #bgfondo {
            background-image: url('images/bg-cocina2.jpg');
            background-size: cover; /* Ajusta la imagen al tamaño del div */
            background-position: center right; /* Centra la imagen */
            transition: background-image 0.3s ease; /* Transición suave */
        }
        #h4title { 
            color: #004997;
            font-size: 20pt;
        }
        @media (max-width: 767px){
            #bgfondo {
                background: linear-gradient(#004997,#003064);
                color: #fff;
            }
            .form-container {
                background: transparent !important;
            }
            #h4title { 
                color: #006be0;
            }
        }
        #show_password {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: transparent;
            border: 0px;
            color: #002345;
        }
    </style>
</head>
<body class="h-100">
    <div class="container-fluid p-0 full-height position-relative">
        <div class="row h-100">
            <!-- Columna 1 -->
            <div class="col-md-5 d-flex justify-content-center align-items-center col-ins">
                <div class="text-center w-100">
                    <img src="images/logo-herrerallerandi.png" alt="Hospital Herrera Llerandi" class="w-50">
                    <h3>intranet</h3>
                </div>
            </div>
            <!-- Columna 2 -->
            <div class="col-md-7 position-relative col-ins-2" id="bgfondo">
                <div class="logowhite">
                    <img src="images/logo-herrerallerandi.png" alt="Hospital Herrera Llerandi">
                </div>
                <div class="form-container">
                    <h4 id="h4title" class="text-center mb-4">Sistema <b>Cocina</b></h4>
                    <form action="login.php" method="POST">
                    <div class="mb-2">
                        <label class="form-label">Usuario</label>
                        <input type="text" name="usuario" class="form-control">
                    </div>
                    <div class="mb-4 position-relative">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="clave" class="form-control" id="txtPassword">
                        <button id="show_password" type="button" onclick="mostrarPassword()">
                            <span class="fa fa-eye-slash icon"></span>
                        </button>
                    </div>
                    <div>
                        <input type="submit" name="submitlogin" class="btn btn-intranet w-100" value="ingresar">
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="powered">
            Powered by:&nbsp; <a href="https://imupgrade.com" target="_blank">Image Upgrade GT</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
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
            //CheckBox mostrar contraseÃ±a
            $('#ShowPassword').click(function () {
                $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
            });
        });

    </script>

</body>
</html>
