<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
header("Content-Type: text/html;charset=UTF-8");

 if( !empty($_POST["key"]) ){

 	require("security.php");
	require("_private/_access.php");
	include("parametros_generales.php");

	$fingreso      = $_POST['fingreso'];
	$idpac         = $_POST['idpac'];
 	$pnombre       = $_POST['pnombre'];
 	$snombre       = $_POST['snombre'];
 	$papellido     = $_POST['papellido'];
 	$sapellido     = $_POST['sapellido'];
	$dieta         = $_POST['dieta'];
	$menu          = $_POST['menu'];
 	$habitacion    = $_POST['habitacion'];
 	$medico        = $_POST['medico'];
 	$codigo        = $_POST["codigo"];
	$motivo        = $_POST["motivo_ingreso"];
 	$otromed       = $_POST['otromed'];
 	$observaciones = $_POST['observaciones'];
 	$motivo        = $_POST['motivo'];
	$paciente      = $_POST['paciente'];
	$auxiliar      = $_POST['auxiliar'];
 	$key           = $_POST['key'];

 	$nameM  = "";
 	$nameO  = "";
 	if($medico > "0" && $medico!="999999"){
		// Obtengo datos del medico tratante
		$qryM   = "SELECT * FROM web_medicos WHERE cod_med12='$medico'";
		$rsM    = $conexion2->query($qryM);
		$rowM   = $rsM->fetch_assoc();
		//$nameM  = $rowM["primer_nombre_med18"]." ".$rowM["segundo_nombre_med22"]." ".$rowM["primer_apellido_med29"]." ".$rowM["segundo_apellido_med37"];
		$nameM  = $rowM["primer_nombre_med18"]." ".$rowM["primer_apellido_med29"];
		//$emailM = $rowM["email_med20"];
	}elseif(!empty($otromed)){
		$nameO  = $otromed;
	}

 	$qry = "INSERT INTO `_pacientes_solicitudes`(`id`, `orden_medica`, `pnombre`, `snombre`, `papellido`, `sapellido`, `habitacion`, `codigo`, `medico_tratante`, `medico_nombre`, `medico_otro`, `dieta`, `menu`, `observaciones`, `motivo`, `paciente`, `auxiliar_nutricion`, `status`, `usuario`, `actualizacion`, `fecha_ingreso`) VALUES ('0','$idpac','$pnombre','$snombre','$papellido','$sapellido','$habitacion','$codigo','$medico','$nameM','$otromed','$dieta','$menu','$observaciones','$motivo','$paciente','$auxiliar','0','$ussession','$datenowfull','$datenowfull')";
 	$conexion->query($qry);

	$pruebasList = "";
	$qryList = "SELECT *";
	// ----- TIPO 2 ------
	$qryList.= ", (select nombre from _menus_opciones o where o.id=p.idopcion and p.tipo='2') as nmopt";
	$qryList.= ", (select nombre from _menus m where m.id in (select idmenu from _menus_opciones o where o.idmenu=m.id and p.idopcion=o.id)) as nmmenu";

	// ----- TIPO 3 ------
	$qryList.= ", (select nombre from _menus_opciones o where o.id in (select idopcion from _menus_subopciones s where s.idopcion=o.id and p.idmenu=s.idmenu and p.idopcion=s.id)) as nmsubmenu";
	$qryList.= ", (select nombre from _menus m where m.id in (select idmenu from _menus_subopciones s where s.idmenu=m.id and p.idopcion=s.id and s.idmenu=p.idmenu)) as menut3";
	$qryList.= ", (select nombre from _menus_subopciones d where d.id in (select idopcion2 from _menus_subopciones2 t where t.idopcion2=d.id and t.idmenu=p.idmenu and p.idopcion=t.idopcion)) as submenu2";
	$qryList.= ", (select nombre from _menus_subopciones s where s.id=p.idopcion and s.idmenu=p.idmenu) as nmsub";

	// ----- TIPO 4 ------
	$qryList.= ", (select nombre from _menus m where m.id in (select idmenu from _menus_subopciones2 t where t.idmenu=m.id and t.id=p.idopcion and t.idmenu=p.idmenu)) as menut4";
	$qryList.= ", (select nombre from _menus_opciones o where o.id in (select idopcion from _menus_subopciones2 t where t.idopcion=o.id and t.id=p.idopcion and t.idmenu=p.idmenu)) as submenu4";
	$qryList.= ", (select nombre from _menus_subopciones d where d.id in (select idopcion2 from _menus_subopciones2 t where t.idopcion2=d.id and t.id=p.idopcion and t.idmenu=p.idmenu)) as ssubmenu4";
	$qryList.= ", (select nombre from _menus_subopciones2 t where t.id=p.idopcion and t.idmenu=p.idmenu) as tmsub";

	// ----- TIPO 5 ------
	$qryList.= ", (select nombre from _menus_subopciones2 t where t.id in (select idopcion3 from _menus_subopciones3 x where x.idopcion3=t.id and x.idmenu=p.idmenu and x.id=p.idopcion)) as tmsub5";
	$qryList.= ", (select nombre from _menus_subopciones3 x where x.id=p.idopcion and x.idmenu=p.idmenu) as sssmenu5";

	// ----- TIPO 6 ------
	$qryList.= ", (select nombre from _menus m where m.id in (select idmenu from _menus_subopciones4 z where z.idmenu=m.id and z.id=p.idopcion and z.idmenu=p.idmenu)) as menut6";
	$qryList.= ", (select nombre from _menus_opciones o where o.id in (select idopcion from _menus_subopciones4 z where z.idopcion=o.id and z.id=p.idopcion and z.idmenu=p.idmenu)) as submenu6";
	$qryList.= ", (select nombre from _menus_subopciones d where d.id in (select idopcion2 from _menus_subopciones4 z where z.idopcion2=d.id and z.id=p.idopcion and z.idmenu=p.idmenu)) as ssubmenu6";
	$qryList.= ", (select nombre from _menus_subopciones2 t where t.id in (select idopcion3 from _menus_subopciones4 z where z.idopcion3=t.id and z.id=p.idopcion and z.idmenu=p.idmenu)) as tmsub6";
	$qryList.= ", (select nombre from _menus_subopciones3 x where x.id in (select idopcion4 from _menus_subopciones4 z where z.idopcion4=x.id and z.id=p.idopcion and z.idmenu=p.idmenu)) as ttmsub6";
	$qryList.= ", (select nombre from _menus_subopciones4 z where z.id=p.idopcion and z.idmenu=p.idmenu) as sssmenu6";
	$qryList.= ", (select nombre from _programaciones c where c.id=p.idopcion) as nprogra ";
	$qryList.= "FROM _pacientes_menu_enlace p WHERE p.keyunico='$key' ORDER by id";
	$rsList  = $conexion->query($qryList);
	while ($rowList = $rsList->fetch_assoc()){
		if($rowList["tipo"]=="2"){
			$pruebasList.= $rowList['nmmenu']." ".$rowList['nmopt']."<br>";
		}
		if($rowList["tipo"]=="3"){
			$pruebasList.= $rowList['menut3']." ".$rowList['nmsubmenu']." ".$rowList["nmsub"]."<br>";
		}
		if($rowList["tipo"]=="4"){
			$pruebasList.= $rowList['menut4']." ".$rowList["submenu4"]." ".$rowList['ssubmenu4']." ".$rowList['tmsub']."<br>";
		}
		if($rowList["tipo"]=="5"){
			$pruebasList.= $rowList['menut4']." ".$rowList["submenu4"]." ".$rowList['ssubmenu4']." ".$rowList['tmsub5']." ".$rowList["sssmenu5"]."<br>";
		}
		if($rowList["tipo"]=="6"){
			$pruebasList.= $rowList['menut6']." ".$rowList["submenu6"]." ".$rowList['ssubmenu6']." ".$rowList['tmsub6']." ".$rowList["ttmsub6"]." ".$rowList["sssmenu6"]."<br>";
		}
	}

	$qryMax = "SELECT max(id) as maxid FROM _pacientes_solicitudes";
 	$rsMax  = $conexion->query($qryMax);
 	$rowMax = $rsMax->fetch_assoc();
 	$maxid  = $rowMax["maxid"];
 	$maxid  = "solicitud".$maxid;

	// elimino el <br> para agregar el nombre del plato en descripcion
	$descripcion_filtrada = str_replace('<br>','',$pruebasList);

	// ingreso estatus del pedido modificando el keyunico original por el numero de solicitud asignada
 	$sql = "UPDATE _pacientes_menu_enlace SET descripcion = '$descripcion_filtrada', keyunico = '$maxid' WHERE idpaciente='$idpac' and paciente='$paciente' and keyunico='$key'";
 	$conexion->query($sql);

 	$fecHora = strtotime($datenowfull);
	$anoEnv  = date("Y",$fecHora);
	$mesEnv  = date("m",$fecHora);
	if($mesEnv=="1"){ $mesElej = "ene"; }
	if($mesEnv=="2"){ $mesElej = "feb"; }
	if($mesEnv=="3"){ $mesElej = "mar"; }
	if($mesEnv=="4"){ $mesElej = "abr"; }
	if($mesEnv=="5"){ $mesElej = "may"; }
	if($mesEnv=="6"){ $mesElej = "jun"; }
	if($mesEnv=="7"){ $mesElej = "jul"; }
	if($mesEnv=="8"){ $mesElej = "ago"; }
	if($mesEnv=="9"){ $mesElej = "sep"; }
	if($mesEnv=="10"){ $mesElej = "oct"; }
	if($mesEnv=="11"){ $mesElej = "nov"; }
	if($mesEnv=="12"){ $mesElej = "dic"; }
	$diaEnv  = date("d",$fecHora);
	$horEnv  = date("H",$fecHora);
	$minEnv  = date("i",$fecHora);

	$dateEmail = $diaEnv." de ".$mesElej." ".$anoEnv." ".$horEnv.":".$minEnv." hrs";

	// envio correo
 	//$para = "jeremias.baten@herrerallerandi.com";
 	$para = "imupgrade@gmail.com";

	if($_POST["paciente"]=="SI"){
		unset($_SESSION["keyun$idpac"]);
	}
	if($_POST["paciente"]=="NO"){
		unset($_SESSION["keyunvisit$idpac"]);
	}

 	$asunto     = "Solicitud de cocina ingresada";

 	// BODY CORREO A HOSPITAL
	$contenidoMail = "<div style='border: 1px solid #C0C0C0; padding: 25px; max-width: 600px; background: #1a3a6c; border-top: 7px solid #f2bf0c; border-bottom: 7px solid #f2bf0c;'>\n";
	$contenidoMail.= "<div style='padding: 0px; margin-bottom: 20px; text-align: center;'>\n";
	$contenidoMail.="<img src='https://web.herrerallerandi.com/solicitudeslab/images/logo-herrerallerandi.png' height='60'>\n";
	$contenidoMail.= "</div>\n";
	$contenidoMail.= "<div style='padding: 25px; background: #fff; border: 1px solid #eee; text-align: center; font-size: 12pt;'>\n";
	$contenidoMail.="<h2 style='margin: 0 0 12px 0; color: #002d59;'><b>Solicitud de cocina ingresada</b></h2><br>\n";
	$contenidoMail.="<table border='0' width='100%' cellpadding='5'>\n";
	$contenidoMail.="<tr><td style='text-align: right;'><b style='color: #002d59;'>Fecha</b>:</td><td style='color: #002d59; text-align: left;'>$dateEmail</td></tr>\n";
	$contenidoMail.="<tr><td style='text-align: right;'><b style='color: #002d59;'>Nombre paciente</b>:</td><td style='color: #002d59; text-align: left;'>$pnombre $snombre $papellido $sapellido</td></tr>\n";
	if(!empty($nameM)){
		$contenidoMail.="<tr><td style='text-align: right;' valign='top'><b style='color: #002d59;'><nobr>Médico tratante</nobr></b>:</td><td style='color: #002d59; text-align: left;' valign='top'>Dr. $nameM</td></tr>\n";
	}elseif(!empty($nameO)){
		$contenidoMail.="<tr><td style='text-align: right;' valign='top'><b style='color: #002d59;'><nobr>Médico tratante</nobr></b>:</td><td style='color: #002d59; text-align: left;' valign='top'>Dr. $nameO</td></tr>\n";
	}
	$contenidoMail.="<tr><td style='text-align: right;' valign='top'><b style='color: #002d59;'>Platos solicitadaos</b>:</td><td style='color: #002d59; text-align: left; text-transform: uppercase;' valign='top'>$pruebasList</td></tr>\n";
	$contenidoMail.="</table>\n";
	$contenidoMail.="</div>\n";
	$contenidoMail.="<div style='padding: 20px; text-align: center; color: #fff; font-size: 10pt;'>\n";
	$contenidoMail.="<a href='https://www.herrerallerandi.com' style='color: #fff; text-decoration: none; font-size: 16pt; font-weight: bold;'>www.herrerallerandi.com</a></div>\n";
	$contenidoMail.="</div>\n";

 	echo "Solicitud ingresada";

 	header ("Location: pedidos_pacientes.php");
 }
 ?>