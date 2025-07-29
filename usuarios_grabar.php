<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

$areaLg = "USUARIOS";  // valida roles del usuario

require("security.php");
require("security_adv.php");
require("_private/_access.php");
require("logged.php");
include("parametros_generales.php");

if ( $_POST["acceso"]=="agregar" ) {
    $_SESSION["formadduser"] = $_POST;
}

// sanitizo los valores
$usuario = trim(get_post('usuario'));
$nivel   = get_post('nivel');
$nombre  = trim(get_post('nombre'));
$email   = trim(post_email('email'));
$clave1  = trim(get_post('pass1'));
$clave2  = trim(get_post('pass2'));

if ( $_POST["acceso"]=="agregar" || $_POST["acceso"]=="editar" ) {

    if( empty($nombre) ){
        echo "<script>alert('El campo de NOMBRE es requerido.');history.back();</script>";
        exit;
    }
    if( empty($usuario) ){
        echo "<script>alert('El campo de USUARIO es requerido.');history.back();</script>";
        exit;
    }

}

// desactiva usuarios
if ( $_GET["st"] >= "0" ) {

    $id   = get_int('us');
    $st   = get_int('st');
    $qry  = "UPDATE _usuarios_admin SET status_wua32 = ? WHERE id_us00 = ?";
    $stmt = $pdo->prepare($qry);
    $stmt->execute([$st,$id]);

    $stmt = null;
    $pdo  = null;

    header("Location: usuarios.php");

}

//  nuevo usuario
if ( $_POST["acceso"]=="agregar" ) {
    
    // valido que el nombre de usuario no exista
    $qry = "SELECT * FROM _usuarios_admin WHERE usuario_us13 = ?";
    $stmt = $pdo->prepare($qry);
    $stmt->execute([$usuario]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result){
        echo "<script>alert('El nombre de USUARIO ya existe, ingresa uno diferente.');history.back();</script>";
		exit;
    }

    // valido que el email no exista
    if(!empty($email)){
        $qry = "SELECT * FROM _usuarios_admin WHERE email_wua25 = ?";
        $stmt = $pdo->prepare($qry);
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result){
            echo "<script>alert('El email del USUARIO ya existe, ingresa uno diferente.');history.back();</script>";
            exit;
        }
    }

    if(strlen($clave1) >= 6){
        if($clave1==$clave2){
            $contrasena = password_hash($clave1, PASSWORD_DEFAULT);
        }else{
            echo "<script>alert('Las contraseñas no coinciden, intentelo de nuevo');history.back();</script>";
            exit;
        }
    }else{
        echo "<script>alert('La contraseña tiene que tener un mínimo de 6 caracteres, intentelo de nuevo');history.back();</script>";
        exit;
    }

    $sql  = "INSERT INTO `_usuarios_admin`(`id_us00`, `nombre_us07`, `usuario_us13`, `clave_us20`, `email_wua25`, `status_wua32`, `nivel_wua67`) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['0',$nombre,$usuario,$contrasena,$email,'1',$nivel]);

    if ($stmt->rowCount() > 0) {

        $sql2 = "SELECT MAX(id_us00) AS maxid FROM _usuarios_admin";
        $stmt = $pdo->prepare($sql2);
        $stmt->execute();
        $row  = $stmt->fetch(PDO::FETCH_ASSOC);
        $user = $row["maxid"];

        // ingreso los roles del usuario
        $rolesSeleccionados = $_POST['roles'];

        foreach ($rolesSeleccionados as $rol) {

            $qryRol = "INSERT INTO `_usuarios_roles`(`_id`, `_usuario_id`, `_rol`, `_usuario`) VALUES (?, ?, ?, ?)";
            $stmt   = $pdo->prepare($qryRol);
            $stmt->execute(['0',$user,$rol,$ussession]);

        }

        // elimino el session temporal de datos
        unset($_SESSION["formadduser"]);

    }

    $stmt = null;
    $pdo  = null;

    header("Location: usuarios.php");

}

//  edito usuario
if ( $_POST["acceso"]=="editar" ) {

    $id     = post_int('id');
    $status = post_int('status');

    // valido que el nombre de usuario no exista
    $qry = "SELECT * FROM _usuarios_admin WHERE usuario_us13 = ? AND id_us00 != ?";
    $stmt = $pdo->prepare($qry);
    $stmt->execute([$usuario,$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result){
        echo "<script>alert('El nombre de USUARIO ya existe, ingresa uno diferente.');history.back();</script>";
		exit;
    }

     // valido que el email no exista
    if(!empty($email)){
        $qry = "SELECT * FROM _usuarios_admin WHERE email_wua25 = ? AND id_us00 != ?";
        $stmt = $pdo->prepare($qry);
        $stmt->execute([$email,$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result){
            echo "<script>alert('El email del USUARIO ya existe, ingresa uno diferente.');history.back();</script>";
            exit;
        }
    }

    $veriOk = "NO";
    if(!empty($clave1) && !empty($clave2)){
        if(strlen($clave1) >= 6){
            if($clave1==$clave2){
                $contrasena = password_hash($clave1, PASSWORD_DEFAULT);
                $veriOk = "SI";
            }else{
                echo "<script>alert('Las contraseñas no coinciden, intentelo de nuevo');history.back();</script>";
                exit;
            }
        }else{
            echo "<script>alert('La contraseña tiene que tener un mínimo de 6 caracteres, intentelo de nuevo');history.back();</script>";
            exit;
        }
    }

    if($veriOk == "SI"){
        $sql  = "UPDATE `_usuarios_admin` SET `nombre_us07` = ?, `usuario_us13` = ?, `clave_us20` = ?, `email_wua25` = ?, `status_wua32` = ?, `nivel_wua67`= ? WHERE id_us00 = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nombre,$usuario,$contrasena,$email,$status,$nivel,$id]);
    }else{
        $sql  = "UPDATE `_usuarios_admin` SET `nombre_us07` = ?, `usuario_us13` = ?, `email_wua25` = ?, `status_wua32` = ?, `nivel_wua67`= ? WHERE id_us00 = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nombre,$usuario,$email,$status,$nivel,$id]);
    }
    
    // elimino los roles para volverlos a agregar actualizados
    $qryE  = "DELETE FROM `_usuarios_roles` WHERE _usuario_id = ?";
    $stmtE = $pdo->prepare($qryE);
    $stmtE->execute([$id]);

    // ingreso los nuevos roles del usuario
    $rolesSeleccionados = $_POST['roles'];

    foreach ($rolesSeleccionados as $rol) {

        $qryRol = "INSERT INTO `_usuarios_roles`(`_id`, `_usuario_id`, `_rol`, `_usuario`) VALUES (?, ?, ?, ?)";
        $stmt   = $pdo->prepare($qryRol);
        $stmt->execute(['0',$id,$rol,$ussession]);

    }

    // elimino la session si el usuario logeado cambio de nivel
    if ($usuario == $ussession && $nivel !== $nvsession){
        $stmt = null;
        $pdo  = null;

        header("Location: logout.php");
        exit;
    }

    $stmt = null;
    $pdo  = null;

    header("Location: usuarios.php");

}
?>