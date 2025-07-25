<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

header("Content-Type: text/html;charset=UTF-8");

$areaLg = "ORDENES"; // valida roles del usuario

require("security.php");
require("security_adv.php");
require("_private/_access.php");
include("logged.php");
include("parametros_generales.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["codigo"])) {

    $codigo = get_post("codigo");

    $sql = "SELECT pnombre, snombre, papellido, sapellido, cod_medico, medico_tratante FROM _pacientes WHERE codigo = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$codigo]);

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo json_encode([
            "existe" => true,
            "pnombre" => $row["pnombre"],
            "snombre" => $row["snombre"],
            "papellido" => $row["papellido"],
            "sapellido" => $row["sapellido"],
            "medico" => $row["cod_medico"],
            "otromed" => $row["medico_tratante"]
        ]);
    } else {
        echo json_encode(["existe" => false]);
    }
}
?>
