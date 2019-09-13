<?php

require '../link1.php';

$sqlSena = "SELECT * FROM sch_textos WHERE id='admin' and texto='". $_POST['keynow1'] ."'";
$buscaSena = $link1->query($sqlSena);
if(!$buscaSena){
    echo "ERROR";
    exit;
}
if($buscaSena->rowCount() != 1){
    echo "INCORRECT";
    exit;
}
$sqlSena = "UPDATE sch_textos SET texto = '". $_POST['keynew1'] ."' WHERE id = 'admin';";
$buscaSena = $link1->query($sqlSena);
if(!$buscaSena){
    echo "ERROR";
    exit;
}
else{
    echo 'SUCESS';
    exit;
}

?>
