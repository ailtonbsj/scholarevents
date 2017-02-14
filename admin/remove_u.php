<?php
    require '../link1.php';
    
    
    if(isset($_GET["uid"])){
        $id = $_GET["uid"];
        $prof = $_GET["prof"];
        $aluno = $_GET["alu"];
        
        //remove os vinculos com acontecimento
        $sqlRemAlunos = "DELETE FROM sch_aluno_acont WHERE id_al = '$id'";
        $buscaRemAlunos = mysql_query($sqlRemAlunos,$link1);
        if(!$buscaRemAlunos){
            header("Location: index.php?error=7");
        }
        
        //remove o aluno
        $sqlRemAlunos = "DELETE FROM sch_alunos WHERE id = '$id'";
        $buscaRemAlunos = mysql_query($sqlRemAlunos,$link1);
        if(!$buscaRemAlunos){
            header("Location: index.php?error=7");
        }
        //remove o prof
        $sql11 = "DELETE FROM sch_professores WHERE id = $id";
        $busca11 = mysql_query($sql11,$link1);
        if(!$busca11){
            header("Location: index.php?error=7");
            exit;
        }
        
        //remove user
        $sql11 = "DELETE FROM sch_usuarios WHERE id = $id";
        $busca11 = mysql_query($sql11,$link1);
        if(!$busca11){
            header("Location: index.php?error=7");
            exit;
        }
        header("Location: index.php?list_user&sucess=cadastro");
        
    }
    if(isset($_GET["lid"])){
        $lid = $_GET["lid"];
        $sql15 = "DELETE FROM sch_locais WHERE id = $lid";
        $busca15 = mysql_query($sql15,$link1);
        if(!$busca15){
            header("Location: index.php?error=8");
            exit;
        }
        header("Location: index.php?list_local&sucess=ok");
    }
    
    if(isset($_GET['linkid'])){
        $linkmaisget = $_GET['linkid'];
        if($linkmaisget == "") $linkmaisget="ghgh";
        $sqlLinkId = "DELETE FROM sch_menu_mais WHERE nome_link = '$linkmaisget'";
        $buscaDeleteLink = mysql_query($sqlLinkId);
        if(!$buscaDeleteLink){
            header("Location: index.php?error=10");
            exit;
        }
        header("Location: index.php?infor&sucess");
    }
    
    if(isset($_GET['bannerid'])){
        $idban = $_GET['bannerid'];
        $urlBan = $_SERVER['DOCUMENT_ROOT'] .'/scholarevents/images/' . $idban;
        $deleteBanner = unlink($urlBan);
        if(!$deleteBanner){
            header("Location: index.php?error=15");
            exit;
        }
        $sqlDeleteBanner = "DELETE FROM sch_images WHERE nome_img LIKE '%$idban%'";
        $buscaDeleteBanner = mysql_query($sqlDeleteBanner,$link1);
        if(!$buscaDeleteBanner){
            header("Location: index.php?error=16");
            exit;
        }
        
        header("Location: index.php?infor=init&sucess");
    }
?>