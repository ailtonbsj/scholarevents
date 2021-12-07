<?php

function removeAcontecimento($idAcon){
    
    require '../link1.php';
    
    //remove os alunos
    $sqlRemAlunos = "DELETE FROM sch_aluno_acont WHERE id_acon = '$idAcon'";
    $buscaRemAlunos = $link1->query($sqlRemAlunos);
    if(!$buscaRemAlunos){
        return "ERROR";
    }
    //remove professores
    $sqlRemProf = "DELETE FROM sch_professor_acontecimento WHERE id_acon = '$idAcon'";
    $buscaRemProf = $link1->query($sqlRemProf);
    if(!$buscaRemProf){
        return "ERROR";
    }
    //remove Horarios
    $sqlRemHora = "DELETE FROM sch_espacotempo WHERE id_acontec = '$idAcon'";
    $buscaRemHora = $link1->query($sqlRemHora);
    if(!$buscaRemHora){
        return "ERROR";
    }
    //remove Acontecimento
    $sqlRemAcon = "DELETE FROM sch_acontecimentos WHERE id_acon = '$idAcon'";
    $buscaRemAcon = $link1->query($sqlRemAcon);
    if(!$buscaRemAcon){
        return "ERROR";
    }
    return "SUCCESS";
}

function removeAnexos($id){
    require '../link1.php';
    
    $urlfile = dirname($_SERVER['SCRIPT_FILENAME']) .'/../anexos/' . $id;
    $detelou = unlink($urlfile);
    if(!$detelou){
        return "ERROR_UNLINK";
    }
    
    $sqlDel = "DELETE FROM sch_anexos WHERE id_anexo = '$id'";
    $buscaDel = $link1->query($sqlDel);
    if(!$buscaDel){
        return "ERROR_DB";
    }
    
    return "SUCCESS";
    
}



?>