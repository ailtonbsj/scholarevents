<?php

$sid = $_GET['sid'];

require '../link1.php';
include './removesLib.php';

//anexos
$sqlQueryAnexos = "SELECT * FROM sch_anexos WHERE id_subev = '$sid'";
$buscaQueryAnexos = $link1->query($sqlQueryAnexos);
if(!$buscaQueryAnexos){
    header("Location: index.php?error=REM_SUBEV");
    exit;
}

foreach($buscaQueryAnexos->fetchAll(PDO::FETCH_ASSOC) as $regQanexos){
    $rtRanexo = removeAnexos($regQanexos['id_anexo']);
    if($rtRanexo != "SUCCESS"){
        header("Location: index.php?error=REM_SUBEV");
        exit;
    }
}

//acontecimentos
$sqlQueryAcon = "SELECT * FROM sch_acontecimentos WHERE id_subevent = '$sid'";
$buscaQueryAcon = $link1->query($sqlQueryAcon);
foreach($buscaQueryAcon->fetchAll(PDO::FETCH_ASSOC) as $regAcon){
    if(removeAcontecimento($regAcon['id_acon']) != "SUCCESS"){
        header("Location: index.php?error=REM_SUBEV");
        exit;
    }
}

$sqlRemSub = "DELETE FROM sch_subeventos WHERE id = '$sid'";
$buscaRemSub = $link1->query($sqlRemSub);
if(!$buscaRemSub){
    header("Location: index.php?error=REM_SUBEV");
    exit;
}

header("Location: index.php?sucessremev");