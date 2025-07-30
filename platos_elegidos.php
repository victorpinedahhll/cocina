<?php
session_start();

$page = "platoselegir";

$pacval  = $_REQUEST["paciente"];
$idpac   = $_GET["id"];

$keyun = $_SESSION["keyun$idpac"];
if($pacval=="NO"){
  $keyun = $_SESSION["keyunvisit$idpac"];
}

if($_GET["sol"] > "0"){
  $keyun = "solicitud".$_GET["sol"];
}

if(!empty($keyun)){

  require("security.php");
  require("_private/_access.php");
  include("parametros_generales.php");
  
  //$query = "SELECT *, (select nombre from _menus_opciones o where o.idmenu=p.idmenu) as nmopt from _pacientes_menu_enlace p WHERE p.keyunico='$keyun'";
  $query = "SELECT *";
  
  // ----- TIPO 2 ------
  $query.= ", (select nombre from _menus_opciones o where o.id=p.idopcion and p.tipo='2') as nmopt";
  $query.= ", (select nombre from _menus m where m.id in (select idmenu from _menus_opciones o where o.idmenu=m.id and p.idopcion=o.id)) as nmmenu";
  
  // ----- TIPO 3 ------
  $query.= ", (select nombre from _menus_opciones o where o.id in (select idopcion from _menus_subopciones s where s.idopcion=o.id and p.idmenu=s.idmenu and p.idopcion=s.id)) as nmsubmenu";
  $query.= ", (select nombre from _menus m where m.id in (select idmenu from _menus_subopciones s where s.idmenu=m.id and p.idopcion=s.id and s.idmenu=p.idmenu)) as menut3";
  $query.= ", (select nombre from _menus_subopciones d where d.id in (select idopcion2 from _menus_subopciones2 t where t.idopcion2=d.id and t.idmenu=p.idmenu and p.idopcion=t.idopcion)) as submenu2";
  $query.= ", (select nombre from _menus_subopciones s where s.id=p.idopcion and s.idmenu=p.idmenu) as nmsub";

  // ----- TIPO 4 ------
  $query.= ", (select nombre from _menus m where m.id in (select idmenu from _menus_subopciones2 t where t.idmenu=m.id and t.id=p.idopcion and t.idmenu=p.idmenu)) as menut4";
  $query.= ", (select nombre from _menus_opciones o where o.id in (select idopcion from _menus_subopciones2 t where t.idopcion=o.id and t.id=p.idopcion and t.idmenu=p.idmenu)) as submenu4";
  $query.= ", (select nombre from _menus_subopciones d where d.id in (select idopcion2 from _menus_subopciones2 t where t.idopcion2=d.id and t.id=p.idopcion and t.idmenu=p.idmenu)) as ssubmenu4";
  $query.= ", (select nombre from _menus_subopciones2 t where t.id=p.idopcion and t.idmenu=p.idmenu) as tmsub";

  // ----- TIPO 5 ------
  $query.= ", (select nombre from _menus_subopciones2 t where t.id in (select idopcion3 from _menus_subopciones3 x where x.idopcion3=t.id and x.idmenu=p.idmenu and x.id=p.idopcion)) as tmsub5";
  $query.= ", (select nombre from _menus_subopciones3 x where x.id=p.idopcion and x.idmenu=p.idmenu) as sssmenu5";

  // ----- TIPO 6 ------
  $query.= ", (select nombre from _menus m where m.id in (select idmenu from _menus_subopciones4 z where z.idmenu=m.id and z.id=p.idopcion and z.idmenu=p.idmenu)) as menut6";
  $query.= ", (select nombre from _menus_opciones o where o.id in (select idopcion from _menus_subopciones4 z where z.idopcion=o.id and z.id=p.idopcion and z.idmenu=p.idmenu)) as submenu6";
  $query.= ", (select nombre from _menus_subopciones d where d.id in (select idopcion2 from _menus_subopciones4 z where z.idopcion2=d.id and z.id=p.idopcion and z.idmenu=p.idmenu)) as ssubmenu6";
  $query.= ", (select nombre from _menus_subopciones2 t where t.id in (select idopcion3 from _menus_subopciones4 z where z.idopcion3=t.id and z.id=p.idopcion and z.idmenu=p.idmenu)) as tmsub6";
  $query.= ", (select nombre from _menus_subopciones3 x where x.id in (select idopcion4 from _menus_subopciones4 z where z.idopcion4=x.id and z.id=p.idopcion and z.idmenu=p.idmenu)) as ttmsub6";
  $query.= ", (select nombre from _menus_subopciones4 z where z.id=p.idopcion and z.idmenu=p.idmenu) as sssmenu6";
  $query.= ", (select nombre from _programaciones c where c.id=p.idopcion) as nprogra ";
  $query.= "FROM _pacientes_menu_enlace p WHERE p.keyunico='$keyun' and idpaciente='$idpac' and p.paciente='$pacval' ORDER by id";
  // echo  $query."<br><br>";
  $result = $conexion->query($query);

  $json = array();
  while($row = $result->fetch_array()) {

    if($row["tipo"]=="2"){
        $json[] = array(
          'idmenu'  => $row['idmenu'],
          'key'     => $row['keyunico'],
          'id'      => $row['id'],
          'idprogra' => $row['idopcion'],
          'name'    => $row['nmmenu']." ".$row['nmopt'],
          'nprogra' => $row['nprogra'],
          'paciente' => $pacval
        );
    }

    if($row["tipo"]=="3"){
        $json[] = array(
          'idmenu'  => $row['idmenu'],
          'key'     => $row['keyunico'],
          'id'      => $row['id'],
          'idprogra' => $row['idopcion'],
          'name'    => $row['menut3']." ".$row['nmsubmenu']." ".$row["nmsub"],
          'nprogra' => $row['nprogra'],
          'paciente' => $pacval
        );
    }

    if($row["tipo"]=="4"){
        $json[] = array(
          'idmenu'  => $row['idmenu'],
          'key'     => $row['keyunico'],
          'id'      => $row['id'],
          'idprogra' => $row['idopcion'],
          'name'    => $row['menut4']." ".$row["submenu4"]." ".$row['ssubmenu4']." ".$row['tmsub'],
          'nprogra' => $row['nprogra'],
          'paciente' => $pacval
        );
    }

    if($row["tipo"]=="5"){
        $json[] = array(
          'idmenu'  => $row['idmenu'],
          'key'     => $row['keyunico'],
          'id'      => $row['id'],
          'idprogra' => $row['idopcion'],
          'name'    => $row['menut4']." ".$row["submenu4"]." ".$row['ssubmenu4']." ".$row['tmsub5']." ".$row["sssmenu5"],
          'nprogra' => $row['nprogra'],
          'paciente' => $pacval
        );
    }

    if($row["tipo"]=="6"){
        $json[] = array(
          'idmenu'  => $row['idmenu'],
          'key'     => $row['keyunico'],
          'id'      => $row['id'],
          'idprogra' => $row['idopcion'],
          'name'    => $row['menut6']." ".$row["submenu6"]." ".$row['ssubmenu6']." ".$row['tmsub6']." ".$row["ttmsub6"]." ".$row["sssmenu6"],
          'nprogra' => $row['nprogra'],
          'paciente' => $pacval
        );
    }

  }

  $jsonstring = json_encode($json);
  echo $jsonstring;

}
?>