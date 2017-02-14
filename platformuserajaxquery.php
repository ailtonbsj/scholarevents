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
    $buscaBk = mysql_query($sqlBk);
    if(!$buscaBk){
        echo "ERROR";
        exit;
    }
    $regs = mysql_num_rows($buscaBk);
    if($regs == 1){
        $_SESSION['bloqueioInsc'] = TRUE;
    }
    else {
        $_SESSION['bloqueioInsc'] = FALSE;
    }
}

if($type == 'horaprof'){
    $sql1 = "SELECT sch_espacotempo.momento_ini,sch_espacotempo.momento_fin,sch_locais.local FROM sch_espacotempo,sch_locais WHERE sch_espacotempo.id_local = sch_locais.id AND id_acontec = '$id' ORDER BY sch_espacotempo.momento_ini ASC";
    $query1 = mysql_query($sql1, $link1);
    if(!$query1){
        echo "ERROR";
        exit;
    }
    $cont = 0;
    $result = NULL;
    while($lines = mysql_fetch_assoc($query1)){
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
    $query1 = mysql_query($sql1, $link1);
    if(!$query1){
        echo "ERROR";
        exit;
    }
    $cont = 0;
    $result2 = NULL;
    while($lines = mysql_fetch_assoc($query1)){
        $result2[$cont] = $lines;
        $cont++;
    }
    
    $horaProfSet[0] = $result;
    $horaProfSet[1] = $result2;
    
    
    echo json_encode($horaProfSet);
}
elseif($type == 'basic'){
    $sql1 = "SELECT sch_acontecimentos.id_acon,sch_acontecimentos.titulo,vagas_total,total_inscritos,sch_acontecimentos.descricao,id_subevent,sch_subeventos.titulo AS titulo_sub FROM sch_acontecimentos,sch_subeventos WHERE sch_acontecimentos.id_subevent = sch_subeventos.id";
    $query1 = mysql_query($sql1, $link1);
    if(!$query1){
        echo "ERROR";
        exit;
    }
    $cont = 0;
    $result = NULL;
    while($lines = mysql_fetch_assoc($query1)){
        $result[$cont] = $lines;
        $cont++;
    }

    echo json_encode($result);
}
elseif ($type == "useracon"){
    $sql3 = "SELECT sch_acontecimentos.id_acon,sch_acontecimentos.titulo AS titulo ,sch_subeventos.titulo AS subevento FROM sch_aluno_acont,sch_acontecimentos,sch_subeventos WHERE (sch_aluno_acont.id_acon = sch_acontecimentos.id_acon) AND (sch_subeventos.id = sch_acontecimentos.id_subevent)"
            . " AND (id_al = '$id')";
    $query3 = mysql_query($sql3, $link1);
    if(!$query3){
        echo "ERROR";
        exit;
    }
    $cont = 0;
    $result3 = NULL;
    while($lines = mysql_fetch_assoc($query3)){
        $result3[$cont] = $lines;
        $cont++;
    }
    
    $sql4 = "SELECT sch_aluno_acont.id_acon,momento_ini,momento_fin,local,sch_acontecimentos.titulo FROM sch_aluno_acont,sch_espacotempo,sch_locais,sch_acontecimentos WHERE (id_local = sch_locais.id) AND (sch_aluno_acont.id_acon = sch_espacotempo.id_acontec) AND (sch_aluno_acont.id_acon = sch_acontecimentos.id_acon) AND "
            . "(id_al = '$id') ORDER BY sch_espacotempo.momento_ini,sch_locais.local ASC";
    $query4 = mysql_query($sql4, $link1);
    if(!$query4){
        echo "ERROR";
        exit;
    }
    $cont = 0;
    $result4 = NULL;
    while($lines = mysql_fetch_assoc($query4)){
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
        $queryHA = mysql_query($sqlHorarioAcon, $link1);
        if(!$queryHA){
            echo "ERROR";
            exit;
        }
        while($lin = mysql_fetch_assoc($queryHA)){
            $inicio = $lin['momento_ini'];
            $fim = $lin['momento_fin'];
            $sqlCrash = "SELECT * FROM sch_aluno_acont,sch_espacotempo WHERE (sch_espacotempo.id_acontec = sch_aluno_acont.id_acon) AND (sch_aluno_acont.id_al = '$idUser') AND (NOT(((momento_ini > '$inicio') AND (momento_ini > '$fim')) OR ((momento_fin < '$inicio') AND (momento_fin < '$fim'))))";
            $queryCrash = mysql_query($sqlCrash, $link1);
            if(!$queryCrash){
                echo "ERROR";
                exit;
            }
            if(mysql_num_rows($queryCrash) != 0){
                $cont = 0;
                $result4 = NULL;
                while($reslines = mysql_fetch_assoc($queryCrash)){
                    $result4[$cont] = $reslines;
                    $cont++;
                }
                echo json_encode($result4);
                exit;
            }
        }
        
        $sql5 = "INSERT INTO sch_aluno_acont (id_al, id_acon) VALUES ('$idUser', '$id')";
        $query5 = mysql_query($sql5, $link1);
        if(!$query5){
            echo "ERROR";
            exit;
        }
        $sql6 = "SELECT * FROM sch_aluno_acont WHERE id_acon = '$id'";
        $query6 = mysql_query($sql6, $link1);
        if(!$query6){
            echo "ERROR";
            exit;
        }
        $totalinsc = mysql_num_rows($query6);
        $sql7 = "UPDATE sch_acontecimentos SET total_inscritos = '$totalinsc' WHERE id_acon = '$id';";
        $query7 = mysql_query($sql7, $link1);
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
    $queryEx = mysql_query($sqlEx, $link1);
    if(!$queryEx){
        echo "ERROR";
        exit;
    }
    if(mysql_num_rows($queryEx) == 1){
        $sql8 = "DELETE FROM sch_aluno_acont WHERE id_al = '$idUser' AND id_acon = '$id'";
        $query8 = mysql_query($sql8, $link1);
        if(!$query8){
            echo "ERROR";
            exit;
        }
        $sql6 = "SELECT * FROM sch_aluno_acont WHERE id_acon = '$id'";
        $query6 = mysql_query($sql6, $link1);
        if(!$query6){
            echo "ERROR";
            exit;
        }
        $totalinsc = mysql_num_rows($query6);
        $sql7 = "UPDATE sch_acontecimentos SET total_inscritos = '$totalinsc' WHERE id_acon = '$id';";
        $query7 = mysql_query($sql7, $link1);
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
    $buscaFull = mysql_query($sqlFull,$link1);
    if(!$buscaFull){
        echo "ERROR";
        exit;
    }
    $_SESSION['UserNome'] = $id;
    echo "SUCESS";
}
?>
