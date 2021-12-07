<?php

    require '../link1.php';

    if(isset($_POST['info_titulo'])){
        $titulo = str_replace("'","\'",strip_tags($_POST['info_titulo']));
        $sqlTexto = "UPDATE sch_textos SET texto = '$titulo' WHERE id = 'titulo'";
    }
    else if(isset($_POST['sobre'])){
        $sobre = str_replace("'","\'",$_POST['sobre']);
        $sqlTexto = "UPDATE sch_textos SET texto = '$sobre' WHERE id = 'sobre'";
    }
    else if(isset($_POST['html1'])){
        $html1 = str_replace("'","\'",$_POST['html1']);
        $sqlTexto = "UPDATE sch_textos SET texto = '$html1' WHERE id = 'html1'";
    }
    else if(isset($_POST['html2'])){
        $html2 = str_replace("'","\'",$_POST['html2']);
        $sqlTexto = "UPDATE sch_textos SET texto = '$html2' WHERE id = 'html2'";
    }
    else if(isset ($_POST['nome_link'])){
        $nomeLink = $_POST['nome_link'];
        $urlLink = $_POST['url_link'];
        $sqlTexto = "INSERT INTO sch_menu_mais (nome_link,url) VALUES ('$nomeLink', '$urlLink');";
    }
    
    $buscaTexto = $link1->query($sqlTexto);
    if(!$buscaTexto){
        header("Location: index.php?error=10");
    }
    else{
        header("Location: index.php?infor&sucess");
    }
?>

