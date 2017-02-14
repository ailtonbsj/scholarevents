<?php
    $sqlTexto = "SELECT * FROM sch_textos WHERE id='manutencao' AND texto='ativo'";
    $buscaTexto = mysql_query($sqlTexto,$link1);
    $manutencao = false;
    if(mysql_num_rows($buscaTexto) == 1){
        $manutencao = true;
    }
    if($manutencao == true){
        header("Location: manutencao.php");
        exit;
    }
?>