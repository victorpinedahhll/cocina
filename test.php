<?php
$clave1 = "jnbaten22";
//echo password_hash($clave1, PASSWORD_DEFAULT);
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
     <!--Bootsrap 4 CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
 </head>
 <body>
     
 <style>
     .ul-menu {
        list-style-type: none;
        padding-left: 0px;
     }
     .ul-menu li {
        float: left;
        width:  31%;
        text-align: center;
        padding: 20px;
        height: 140px;
        line-height: 140px !important;
        margin-bottom: 20px;
     }
     .ul-menu li a {
        padding: 30px;
        background: #3cb4e5;
        border-radius: 40px;
        height: 140px;
        color:  #fff;
        display: block;
        font-size: 28pt;
        line-height: 28pt;
        text-decoration: none;
    }
    @media (max-width: 991px){
        .ul-menu li {
            width: 48%;
        }
    }
    @media (max-width: 767px){
        .ul-menu li a {
            font-size: 20pt;
        }
    }
 </style>
 <div class="container">
 <ul class="ul-menu">
     <li>
         <a href="#">
             Desayunos
         </a>
     </li>
     <li>
         <a href="#">
             Desayunos Internacionales
         </a>
     </li>
     <li>
         <a href="#">
             Baguettes y Wraps
         </a>
     </li>
     <li>
         <a href="#">
             Ensaladas
         </a>
     </li>
     <li>
         <a href="#">
             Sopas
         </a>
     </li>
     <li>
         <a href="#">
             Combos
         </a>
     </li>
     <li>
         <a href="#">
             Crepes
         </a>
     </li>
     <li>
         <a href="#">
             Snacks
         </a>
     </li>
     <li>
         <a href="#">
             Licuados
         </a>
     </li>
     <li>
         <a href="#">
             Bebidas Frías
         </a>
     </li>
     <li>
         <a href="#">
             Bebidas Calientes
         </a>
     </li>
     <li>
         <a href="#">
             Postres
         </a>
     </li>
 </ul>
</div>
  </body>
 </html>