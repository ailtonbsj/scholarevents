<?php

require '../link1.php';

if(isset($_POST["id"])){
    $id = $_POST["id"];
    $subevent = $_POST["subevent"];
    $titulo = $_POST["titulo"];
    $descricao = $_POST["descricao"];
    $totalvagas = $_POST["totalvagas"];
    $pago = ($_POST["pago"] == 'true') ? "T": "F";
    if(($subevent == "") or ($titulo == "") or ($descricao == "") or ($totalvagas == "") or (@ ereg('[^0-9]',$totalvagas)?true:false)){
        echo "INVALID_FIELDS";
        exit;
    }
    if($id == ""){
        $id = date("ymdHis");
        $sql = "INSERT INTO sch_acontecimentos (id_acon, titulo, vagas_total, total_inscritos, descricao, id_subevent, pago) VALUES "
        . "('$id', '$titulo', '$totalvagas', 0, '$descricao', '$subevent', '$pago')";
        $sucesso = "SUCESS_INSERT";
    }else {
        $sql = "UPDATE sch_acontecimentos SET "
                . "titulo = '$titulo', vagas_total = '$totalvagas', descricao = '$descricao', pago = '$pago' WHERE sch_acontecimentos.id_acon = '$id';";
        $sucesso = "SUCESS_UPDATE";
    }
    $buscaInsert = mysql_query($sql);
    if(!$buscaInsert){
        echo "ERROR_INSERT";
        exit;
    }
    else{
        echo "$sucesso,$id";
    }
}
else {
    echo "NOT_EXIST_VAR";
}

?>

