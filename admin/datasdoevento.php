<?php

include '../link1.php';

$label = $_POST['label'];
$data = $_POST['data'];

$token = explode(" ", $data);
$dtoken = explode("/", $token[0]);

$datasql = $dtoken[2] . "-" . $dtoken[1] . "-" . $dtoken[0] . " " . $token[1];

if(($label == "Evento:Inicio") || ($label == "Evento:Fim") || ($label == "InscricaoOnline:Inicio") || ($label == "InscricaoOnline:Fim") || ($label == "BloqueioCursos")){
    $sql = "UPDATE sch_datas SET data = '$datasql' WHERE sch_datas.label = '$label'";
    $busca = mysql_query($sql,$link1);
    if(!$busca){
        echo "ERRO!!!\nNão foi possivel salvar!";
        exit;
    }
    echo "Modificado com Sucesso!!!";
}
?>

