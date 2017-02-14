<?php

require '../link1.php';

$descricao = $_POST['descricao_anexo'];
$idsubev = $_POST['idsubev'];

$upload_error = $_FILES['file_anexo']['error'];
$upload_mime =  $_FILES['file_anexo']['type'];
$upload_size =  $_FILES['file_anexo']['size'];
$upload_file =  $_FILES['file_anexo']['tmp_name'];
$upload_name =  $_FILES['file_anexo']['name'];

$token = explode('.', $upload_name);
$tamanho = count($token);
$idupload = "inc" . date("ymdHis") . '.' . $token[$tamanho-1];

$pserve = $_SERVER['SCRIPT_FILENAME'];
$pparts = pathinfo($pserve);
$pparts = $pparts['dirname'];
$pparts = substr($pparts,0,strlen($pparts)-6);

$urlimage = $pparts .'/anexos/' . $idupload;

if($upload_error > 0){
    header("Location: index.php?error=12");
    exit;
}

if($upload_size < 5242880){
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
    //consulta
    $sqlUpdate1 = "INSERT INTO sch_anexos (id_subev, id_anexo, descricao) VALUES ('$idsubev', '$idupload', '$descricao')";
    $buscaUpdate1 = mysql_query($sqlUpdate1);
    if(!$buscaUpdate1){
        header("Location: index.php?error=14");
        exit;
    }
    //sucesso!
    header("Location: index.php?novosub=$idsubev&sucess=2");
}
else {
    header("Location: index.php?error=12");
    exit;
}
?>
