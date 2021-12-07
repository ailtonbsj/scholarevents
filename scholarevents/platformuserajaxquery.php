<?php

require './link1.php';
date_default_timezone_set("Brazil/East");

if (!isset($_SESSION)) {
  session_start();
}

if(isset($_POST['type'])){
    $type = $_POST['type'];    
}

if(isset($_POST['id'])){
    $id = $_POST['id'];
}

$idUser = $_SESSION['UserId'];

if(!isset($_SESSION['bloqueioInsc'])){
    $dnow = date("Y-m-d H:i:s");
    $sqlBk = "SELECT * FROM sch_datas WHERE (label = 'BloqueioCursos') AND (data > '$dnow')";
    $buscaBk = $link1->query($sqlBk);
    if(!$buscaBk){
        echo "ERROR";
        exit;
    }
    $regs = $buscaBk->rowCount();
    if($regs == 1){
        $_SESSION['bloqueioInsc'] = TRUE;
    }
    else {
        $_SESSION['bloqueioInsc'] = FALSE;
    }
}

if($type == 'horaprof'){
    $sql1 = "SELECT sch_espacotempo.momento_ini,sch_espacotempo.momento_fin,sch_locais.local FROM sch_espacotempo,sch_locais WHERE sch_espacotempo.id_local = sch_locais.id AND id_acontec = '$id' ORDER BY sch_espacotempo.momento_ini ASC";
    $query1 = $link1->query($sql1);
    if(!$query1){
        echo "ERROR";
        exit;
    }
    $cont = 0;
    $result = NULL;
    foreach($query1->fetchAll(PDO::FETCH_ASSOC) as $lines){
        $token = explode(" ", $lines['momento_ini']);
        $data = explode("-", $token[0]);
        $lines['momento_ini'] = NULL;
        $lines['momento_ini']['data'] = $data;
        $lines['momento_ini']['hora'] = $token[1];
        
        $token = explode(" ", $lines['momento_fin']);
        $data = explode("-", $token[0]);
        $lines['momento_fin'] = NULL;
        $lines['momento_fin']['data'] = $data;
        $lines['momento_fin']['hora'] = $token[1];
        
        $result[$cont] = $lines;
        $cont++;
    }
    
    $sql1 = "SELECT nome,email FROM sch_professor_acontecimento,sch_usuarios WHERE (sch_professor_acontecimento.id_prof = sch_usuarios.id) AND (id_acon = '$id')";
    $query1 = $link1->query($sql1);
    if(!$query1){
        echo "ERROR";
        exit;
    }
    $cont = 0;
    $result2 = NULL;
    foreach($query1->fetchAll(PDO::FETCH_ASSOC) as $lines){
        $result2[$cont] = $lines;
        $cont++;
    }
    
    $horaProfSet[0] = $result;
    $horaProfSet[1] = $result2;
    
    
    echo json_encode($horaProfSet);
}
elseif($type == 'basic'){
    $sql1 = "SELECT sch_acontecimentos.id_acon,sch_acontecimentos.titulo,vagas_total,total_inscritos,sch_acontecimentos.descricao,id_subevent,sch_subeventos.titulo AS titulo_sub FROM sch_acontecimentos,sch_subeventos WHERE sch_acontecimentos.id_subevent = sch_subeventos.id";
    $query1 = $link1->query($sql1);
    if(!$query1){
        echo "ERROR";
        exit;
    }
    $cont = 0;
    $result = NULL;
    foreach($query1->fetchAll(PDO::FETCH_ASSOC) as $lines){
        $result[$cont] = $lines;
        $cont++;
    }

    echo json_encode($result);
}
elseif ($type == "useracon"){
    $sql3 = "SELECT sch_acontecimentos.id_acon,sch_acontecimentos.titulo AS titulo ,sch_subeventos.titulo AS subevento FROM sch_aluno_acont,sch_acontecimentos,sch_subeventos WHERE (sch_aluno_acont.id_acon = sch_acontecimentos.id_acon) AND (sch_subeventos.id = sch_acontecimentos.id_subevent)"
            . " AND (id_al = '$id')";
    $query3 = $link1->query($sql3);
    if(!$query3){
        echo "ERROR";
        exit;
    }
    $cont = 0;
    $result3 = NULL;
    foreach($query3->fetchAll(PDO::FETCH_ASSOC) as $lines){
        $result3[$cont] = $lines;
        $cont++;
    }
    
    $sql4 = "SELECT sch_aluno_acont.id_acon,momento_ini,momento_fin,local,sch_acontecimentos.titulo FROM sch_aluno_acont,sch_espacotempo,sch_locais,sch_acontecimentos WHERE (id_local = sch_locais.id) AND (sch_aluno_acont.id_acon = sch_espacotempo.id_acontec) AND (sch_aluno_acont.id_acon = sch_acontecimentos.id_acon) AND "
            . "(id_al = '$id') ORDER BY sch_espacotempo.momento_ini,sch_locais.local ASC";
    $query4 = $link1->query($sql4);
    if(!$query4){
        echo "ERROR";
        exit;
    }
    $cont = 0;
    $result4 = NULL;
    foreach($query4->fetchAll(PDO::FETCH_ASSOC) as $lines){
        $token = explode(" ", $lines['momento_ini']);
        $data = explode("-", $token[0]);
        $lines['momento_ini'] = NULL;
        $lines['momento_ini']['data'] = $data;
        $lines['momento_ini']['hora'] = $token[1];
        
        $token = explode(" ", $lines['momento_fin']);
        $data = explode("-", $token[0]);
        $lines['momento_fin'] = NULL;
        $lines['momento_fin']['data'] = $data;
        $lines['momento_fin']['hora'] = $token[1];
        
        $result4[$cont] = $lines;
        $cont++;
    }
    
    $saidaJson[0] = $result3;
    $saidaJson[1] = $result4;
    
    echo json_encode($saidaJson);
    
}
elseif($type == "participate"){
    
    if($_SESSION['bloqueioInsc']){
        
        $sqlHorarioAcon = "SELECT * FROM sch_espacotempo WHERE id_acontec = '$id'";
        $queryHA = $link1->query($sqlHorarioAcon);
        if(!$queryHA){
            echo "ERROR";
            exit;
        }
        foreach($queryHA->fetchAll(PDO::FETCH_ASSOC) as $lin){
            $inicio = $lin['momento_ini'];
            $fim = $lin['momento_fin'];
            $sqlCrash = "SELECT * FROM sch_aluno_acont,sch_espacotempo WHERE (sch_espacotempo.id_acontec = sch_aluno_acont.id_acon) AND (sch_aluno_acont.id_al = '$idUser') AND (NOT(((momento_ini > '$inicio') AND (momento_ini > '$fim')) OR ((momento_fin < '$inicio') AND (momento_fin < '$fim'))))";
            $queryCrash = $link1->query($sqlCrash);
            if(!$queryCrash){
                echo "ERROR";
                exit;
            }
            if($queryCrash->rowCount() != 0){
                $cont = 0;
                $result4 = NULL;
                foreach($queryCrash->fetchAll(PDO::FETCH_ASSOC) as $reslines){
                    $result4[$cont] = $reslines;
                    $cont++;
                }
                echo json_encode($result4);
                exit;
            }
        }
        
        $sql5 = "INSERT INTO sch_aluno_acont (id_al, id_acon) VALUES ('$idUser', '$id')";
        $query5 = $link1->query($sql5);
        if(!$query5){
            echo "ERROR";
            exit;
        }
        $sql6 = "SELECT * FROM sch_aluno_acont WHERE id_acon = '$id'";
        $query6 = $link1->query($sql6);
        if(!$query6){
            echo "ERROR";
            exit;
        }
        $totalinsc = $query6->rowCount();
        $sql7 = "UPDATE sch_acontecimentos SET total_inscritos = '$totalinsc' WHERE id_acon = '$id';";
        $query7 = $link1->query($sql7);
        if(!$query7){
            echo "ERROR";
            exit;
        }
        
        echo 'SUCCESS';    
    }
    else {
        echo 'BLOQUEIO';
    }
}
elseif($type == "removeuser"){
    
    if($_SESSION['bloqueioInsc']){
    
    $sqlEx = "SELECT * FROM sch_aluno_acont WHERE id_al = '$idUser' AND id_acon = '$id'";
    $queryEx = $link1->query($sqlEx);
    if(!$queryEx){
        echo "ERROR";
        exit;
    }
    if($queryEx->rowCount() == 1){
        $sql8 = "DELETE FROM sch_aluno_acont WHERE id_al = '$idUser' AND id_acon = '$id'";
        $query8 = $link1->query($sql8);
        if(!$query8){
            echo "ERROR";
            exit;
        }
        $sql6 = "SELECT * FROM sch_aluno_acont WHERE id_acon = '$id'";
        $query6 = $link1->query($sql6);
        if(!$query6){
            echo "ERROR";
            exit;
        }
        $totalinsc = $query6->rowCount();
        $sql7 = "UPDATE sch_acontecimentos SET total_inscritos = '$totalinsc' WHERE id_acon = '$id';";
        $query7 = $link1->query($sql7);
        if(!$query7){
            echo "ERROR";
            exit;
        }
        echo 'SUCCESS';   
    } else {
        echo 'ERROR';
    }
    
    }
    else {
        echo 'BLOQUEIO';
    }
}
elseif($type == "changeName"){
    $id;
    $sqlFull = "UPDATE sch_usuarios SET nome = '$id' WHERE id = '$idUser';";
    $buscaFull = $link1->query($sqlFull);
    if(!$buscaFull){
        echo "ERROR";
        exit;
    }
    $_SESSION['UserNome'] = $id;
    echo "SUCESS";
}
?>
