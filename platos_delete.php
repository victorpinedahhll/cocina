<?php
session_start();

$areaLg = "MENUS";  // valida roles del usuario

if(isset($_POST['id'])) {

  require("security.php");
  require("security_adv.php");
  require("_private/_access.php");
  include("logged.php");
  include("parametros_generales.php");

  $id    = post_int('id');
  $query = "DELETE FROM _pacientes_menu_enlace WHERE id = ?"; 
  $stmt  = $pdo->prepare($query);
  $stmt->execute([$id]);

  $stmt = null;
  $pdo  = null;

  echo "Se ha borrado el registro";  

}

?>