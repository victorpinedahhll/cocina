<?php
if (isset($_SESSION['logincook'])){

	$excepciones = ["dashboard","perfil","platosadd","platoselegir"];
	if (!in_array($page, $excepciones)) {

		$idLg   = $_SESSION['clienteidcook'];
		$qryLgg = "SELECT * FROM _usuarios_roles WHERE _usuario_id = ? AND _rol = ?";
		$resLgg = $pdo->prepare($qryLgg);
		$resLgg->execute([$idLg,$areaLg]);
		$rowLgg = $resLgg->fetch(PDO::FETCH_ASSOC);
		if(!$rowLgg){
			header("location: logout.php");
			exit;
		}
	}

}else{

	header("location: logout.php");
	exit;

}
?>