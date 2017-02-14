<?php

$sid = $_GET['sid'];

require '../link1.php';
include './removesLib.php';

//anexos
$sqlQueryAnexos = "SELECT * FROM sch_anexos WHERE id_subev = '$sid'";
$buscaQueryAnexos = mysql_query($sqlQueryAnexos,$link1);
if(!$buscaQueryAnexos){
    header("Location: index.php?error=REM_SUBEV");
    exit;
}

while($regQanexos = mysql_fetch_assoc($buscaQueryAnexos)){
    $rtRanexo = removeAnexos($regQanexos['id_anexo']);
    if($rtRanexo != "SUCCESS"){
        header("Location: index.php?error=REM_SUBEV");
        exit;
    }
}

//acontecimentos
$sqlQueryAcon = "SELECT * FROM sch_acontecimentos WHERE id_subevent = '$sid'";
$buscaQueryAcon = mysql_query($sqlQueryAcon,$link1);
while($regAcon = mysql_fetch_assoc($buscaQueryAcon)){
    if(removeAcontecimento($regAcon['id_acon']) != "SUCCESS"){
        header("Location: index.php?error=REM_SUBEV");
        exit;
    }
}

$sqlRemSub = "DELETE FROM sch_subeventos WHERE id = '$sid'";
$buscaRemSub = mysql_query($sqlRemSub,$link1);
if(!$buscaRemSub){
    header("Location: index.php?error=REM_SUBEV");
    exit;
}

header("Location: index.php?sucessremev");