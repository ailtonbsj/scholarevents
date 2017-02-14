<?php

function removeAcontecimento($idAcon){
    
    require '../link1.php';
    
    //remove os alunos
    $sqlRemAlunos = "DELETE FROM sch_aluno_acont WHERE id_acon = '$idAcon'";
    $buscaRemAlunos = mysql_query($sqlRemAlunos,$link1);
    if(!$buscaRemAlunos){
        return "ERROR";
    }
    //remove professores
    $sqlRemProf = "DELETE FROM sch_professor_acontecimento WHERE id_acon = '$idAcon'";
    $buscaRemProf = mysql_query($sqlRemProf,$link1);
    if(!$buscaRemProf){
        return "ERROR";
    }
    //remove Horarios
    $sqlRemHora = "DELETE FROM sch_espacotempo WHERE id_acontec = '$idAcon'";
    $buscaRemHora = mysql_query($sqlRemHora,$link1);
    if(!$buscaRemHora){
        return "ERROR";
    }
    //remove Acontecimento
    $sqlRemAcon = "DELETE FROM sch_acontecimentos WHERE id_acon = '$idAcon'";
    $buscaRemAcon = mysql_query($sqlRemAcon,$link1);
    if(!$buscaRemAcon){
        return "ERROR";
    }
    return "SUCCESS";
}

function removeAnexos($id){
    require '../link1.php';
    
    $urlfile = $_SERVER['DOCUMENT_ROOT'] .'/scholarevents/anexos/' . $id;
    $detelou = unlink($urlfile);
    if(!$detelou){
        return "ERROR_UNLINK";
    }
    
    $sqlDel = "DELETE FROM sch_anexos WHERE id_anexo = '$id'";
    $buscaDel = mysql_query($sqlDel, $link1);
    if(!$buscaDel){
        return "ERROR_DB";
    }
    
    return "SUCCESS";
    
}



?>