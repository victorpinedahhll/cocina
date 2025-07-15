<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("security.php");
require("_private/_access.php");

$search = $_POST['search'];
if(!empty($search)) {
  $query = "SELECT * FROM _menus_opciones m WHERE nombre LIKE '%$search%' LIMIT 20";
  //echo $query;
  $result = $conexion->query($query);
  
  $json = array();
  while($row = $result->fetch_array()) {
    $json[] = array(
      'name' => $row['nombre'],
      'id' => $row['id']
    );
  }
  $jsonstring = json_encode($json);
  echo $jsonstring;
}

?>
