<?php

require '../link1.php';

$idlocal = $_POST['idlocal'];
$momento_ini = $_POST['momento_ini'];
$momento_fin = $_POST['momento_fin'];
$acontc = $_POST['acontc'];

$sqldelete = "DELETE FROM sch_espacotempo WHERE (id_acontec='$acontc') AND (id_local='$idlocal') AND (momento_ini='$momento_ini') AND (momento_fin='$momento_fin')";

$buscadelete = mysql_query($sqldelete,$link1);

if(!$buscadelete){
    echo "ERROR_QUERY";
    exit;
}

echo "SUCESS";

?>