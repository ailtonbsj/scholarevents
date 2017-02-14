<?php

require '../link1.php';
if(isset($_POST['tipoupload'])){
    if($_POST['tipoupload'] == 'logo'){
        $prefix_id = "log";
        $w_img = 147;
        $h_img = 131;
    }
    else if($_POST['tipoupload'] == 'ban'){
        $prefix_id = "ban";
        $w_img = 551;
        $h_img = 171;
    }
    else if($_POST['tipoupload'] == 'cert'){
        $prefix_id = "cer";
        $w_img = 1504;
        $h_img = 1129;
    }
    else {
        header("Location: index.php?error=12");
        exit;
    }
}
else{
    header("Location: index.php?error=12");
    exit;
}

if($_FILES['img_logoban']['error'] > 0){
    header("Location: index.php?error=12");
    exit;
}
$tMime = $_FILES['img_logoban']['type'];
if(($tMime == 'image/png') or ($tMime == 'image/jpg') or ($tMime == 'image/jpeg')){
    
   
    if($tMime == 'image/png'){
        $extensao = ".png";
    }
    else{
        $extensao = ".jpg";
    }
    $id_img = $prefix_id . "" . date("ymdHis") . $extensao;
	
	$pserve = $_SERVER['SCRIPT_FILENAME'];
	$pparts = pathinfo($pserve);
	$pparts = $pparts['dirname'];
	$pparts = substr($pparts,0,strlen($pparts)-6);	
    $upfile = $pparts .'/images/' . $id_img;
    
    if($_FILES['img_logoban']['size'] < (5242880)){
        $dimensaoImage = getimagesize($_FILES['img_logoban']['tmp_name']);
        if($dimensaoImage[0]>$w_img or $dimensaoImage[1]>$h_img){
            header("Location: index.php?error=13");
            exit;
        }
        if(is_uploaded_file($_FILES['img_logoban']['tmp_name'])){
            if(!move_uploaded_file($_FILES['img_logoban']['tmp_name'],$upfile)){
                header("Location: index.php?error=11");
                exit;
            }
        }
        else{
            header("Location: index.php?error=666");
            exit;
        }
        if($_POST['tipoupload'] == "logo"){
            $sqlLogDelete = "DELETE FROM sch_images WHERE nome_img LIKE '%log%'";
            $buscaDelete = mysql_query($sqlLogDelete,$link1);
            if(!$buscaDelete){
                header("Location: index.php?error=14");
                exit;
            } 
        }
        if($_POST['tipoupload'] == "cert"){
            $sqlLogDelete = "DELETE FROM sch_images WHERE nome_img LIKE '%cer%'";
            $buscaDelete = mysql_query($sqlLogDelete,$link1);
            if(!$buscaDelete){
                header("Location: index.php?error=14");
                exit;
            } 
        }
        $sqlLogInsert = "INSERT INTO sch_images (nome_img) VALUES ('$id_img')";
        $buscaInsert = mysql_query($sqlLogInsert);
        if(!$buscaInsert){
            header("Location: index.php?error=14");
            exit;
        }
        header("Location: index.php?infor&sucess");
    }
    else {
        header("Location: index.php?error=MAX_SIZE");
        exit;
    }
}
else {
    header("Location: index.php?error=12");
}

?>