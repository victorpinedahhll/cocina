<?php
session_start();

if(isset($_POST['id'])) {

  require("security.php");
  require("_private/_access.php");

  $id = $_POST['id'];
  $query = "DELETE FROM _pacientes_menu_enlace WHERE id='$id'"; 
  $result = $conexion->query($query);

  echo "Se ha borrado el registro";  

}

?>