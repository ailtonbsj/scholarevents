<?php

require '../link1.php';

if(isset($_POST["subevent"])){
    $idsub = $_POST["subevent"];
    $filtro = $_POST["filtro"];
    if($filtro == ""){
        $sql = "SELECT * FROM sch_acontecimentos WHERE id_subevent = '$idsub'";
    }
    else{
        $sql = "SELECT * FROM sch_acontecimentos WHERE id_subevent = '$idsub' AND ((titulo LIKE '%$filtro%') OR (vagas_total LIKE '%$filtro%') OR (total_inscritos LIKE '%$filtro%') OR (descricao LIKE '%$filtro%'))";
    }
    $busca = mysql_query($sql);
    if(!$busca){
        echo "ERROR_QUERY";
        exit;
    }
    echo "SUCESS\"";
    while($linha = mysql_fetch_assoc($busca)){
        echo $linha['id_acon'] . "'" . $linha['titulo'] . "'" .
                $linha['vagas_total'] . "'" . $linha['total_inscritos'] . "'" . $linha['descricao']; //. "'" .$linha['pago'];
        echo "\"";
    }
}
?>

