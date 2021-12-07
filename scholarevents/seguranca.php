<?php
    $sqlTexto = "SELECT * FROM sch_textos WHERE id='manutencao' AND texto='ativo'";
    $buscaTexto = $link1->query($sqlTexto);
    $manutencao = false;
    if($buscaTexto->rowCount() == 1){
        $manutencao = true;
    }
    if($manutencao == true){
        header("Location: manutencao.php");
        exit;
    }
?>