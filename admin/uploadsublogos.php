<?php
require '../link1.php';

$idsubev = $_POST['idsubev'];

$upload_error = $_FILES['img_logsubev']['error'];
$upload_mime = $_FILES['img_logsubev']['type'];
$upload_size = $_FILES['img_logsubev']['size'];
$upload_file = $_FILES['img_logsubev']['tmp_name'];
$upload_name =  $_FILES['img_logsubev']['name'];

$token = explode('.', $upload_name);
$tamanho = count($token);
$idupload = "sub" . date("ymdHis") . '.' . $token[$tamanho-1];

$w_img = 155;
$h_img = 155;

$pserve = $_SERVER['SCRIPT_FILENAME'];
$pparts = pathinfo($pserve);
$pparts = $pparts['dirname'];
$pparts = substr($pparts,0,strlen($pparts)-6);	

$urlimage = $pparts .'/images/' . $idupload;

if($upload_error > 0){
    header("Location: index.php?error=12");
    exit;
}

if(($upload_mime == 'image/png') or ($upload_mime == 'image/jpg') or ($upload_mime == 'image/jpeg')){
    $dimensaoImage = getimagesize($_FILES['img_logsubev']['tmp_name']);
    if($upload_size < 204185){
        if($dimensaoImage[0]>$w_img or $dimensaoImage[1]>$h_img){
            header("Location: index.php?error=13");
            exit;
        }
        if(is_uploaded_file($upload_file)){
            if(!move_uploaded_file($upload_file,$urlimage)){
                header("Location: index.php?error=11");
                exit;
            }
        }
        else{
            header("Location: index.php?error=666");
            exit;
        }
        $sqlUpLogSubEv = "SELECT * FROM sch_subeventos WHERE id='$idsubev'";
        $buscaLogEv = mysql_query($sqlUpLogSubEv, $link1);
        if(!$buscaLogEv){
            header("Location: index.php?error=14");
            exit;
        }
        $linhaLogEv = mysql_fetch_assoc($buscaLogEv);
        $sqlUpLogSubEv = "UPDATE sch_subeventos SET logo = '$idupload' WHERE id = '$idsubev'";
        $buscaLogEv = mysql_query($sqlUpLogSubEv, $link1);
        if(!$buscaLogEv){
            header("Location: index.php?error=14");
            exit;
        }
        $nomepadraoImg = $linhaLogEv['logo'];
        if($nomepadraoImg != 'minicursos.png' and $nomepadraoImg != 'palestras.png' and $nomepadraoImg != 'publicacoes.png' and $nomepadraoImg != 'competicoes.png' and $nomepadraoImg != 'visitas.png'){
            $delete = unlink($_SERVER['DOCUMENT_ROOT'] .'/scholarevents/images/' . $linhaLogEv['logo']);
            if(!$delete){
            header("Location: index.php?error=15");
            exit;
        }
        }
        //sucesso!
        header("Location: index.php?novosub=$idsubev&sucess=2");
    }
    else {
        header("Location: index.php?error=12");
        exit;
    }
}
else {
    header("Location: index.php?error=12");
}
?>