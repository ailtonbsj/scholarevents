<?php

require '../link1.php';

$idEvent = $_POST['idsubev'];
$tituloSub = $_POST['titulo_subev'];
$platformSub = $_POST['radio_platform'];
$descricaoSub = $_POST['desc_subev'];
$pagoSubEv = isset($_POST['sub_pago']) ? "T":"F";
$certSubEv = isset($_POST['sub_cert']) ? "T":"F";
$inforSub = $pagoSubEv . $certSubEv;
switch ($platformSub){
    case "minicurso":
        $logSub = "minicursos.png";
        break;
    case "palestra":
        $logSub = "palestras.png";
        break;
    case "simposio":
        $logSub = "publicacoes.png";
        break;
    case "competicao":
        $logSub = "competicoes.png";
        break;
    case "visita":
        $logSub = "visitas.png";
        break;
}
if($tituloSub == "" or $descricaoSub == ""){
    echo "erro1";
    exit;
}
if($idEvent == "new"){
    $idEvent = 'sub' . date("ymdHis");
    $sqlNovoSub = "INSERT INTO sch_subeventos (id, titulo, descricao, plataforma, inform, logo) "
            . "VALUES ('$idEvent', '$tituloSub', '$descricaoSub', '$platformSub', '$inforSub', '$logSub')";
    $buscaNovoSub = $link1->query($sqlNovoSub);
    if(!$buscaNovoSub){
        echo "erro2";
        exit;
    }
    header("Location: index.php?novosub=$idEvent&sucess=1#anchor1");
}
else{
    $sqlUpdateSub = "UPDATE sch_subeventos SET titulo = '$tituloSub', descricao = '$descricaoSub', "
            . "plataforma = '$platformSub', inform = '$inforSub' WHERE id = '$idEvent'";
    $buscaUpdateSub = $link1->query($sqlUpdateSub);
    if(!$buscaUpdateSub){
        echo "erro5";
        exit;
    }
    header("Location: index.php?novosub=$idEvent&sucess=2");
}
?>
