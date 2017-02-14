<?php

require '../link1.php';

$sqlSena = "SELECT * FROM sch_textos WHERE id='admin' and texto='". $_POST['keynow1'] ."'";
$buscaSena = mysql_query($sqlSena);
if(!$buscaSena){
    echo "ERROR";
    exit;
}
if(mysql_num_rows($buscaSena) != 1){
    echo "INCORRECT";
    exit;
}
$sqlSena = "UPDATE sch_textos SET texto = '". $_POST['keynew1'] ."' WHERE id = 'admin';";
$buscaSena = mysql_query($sqlSena);
if(!$buscaSena){
    echo "ERROR";
    exit;
}
else{
    echo 'SUCESS';
    exit;
}

?>
