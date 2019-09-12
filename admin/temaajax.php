<?php

require '../link1.php';

$dados = $_POST['id'];

foreach ($dados as $reg) {
    ${$reg['name']} = $reg['value'];
}

$sqlres = "UPDATE sch_temas SET ativo = 'F'";
$busca3 = $link1->query($sqlres);
if(!$busca3){
    echo 'ERROR';
    exit;
}

$sqlbusca = "SELECT * FROM sch_temas WHERE (id='$idtheme') AND (block = 'T')";
$busca = $link1->query($sqlbusca);
if(!$busca){
    echo 'ERROR';
    exit;
}

if($busca->rowCount() == 1){
    $sqlres = "UPDATE sch_temas SET ativo = 'T' WHERE id = '$idtheme'";
    $busca = $link1->query($sqlres);
    if(!$busca){
        echo 'ERROR';
        exit;
    }
    echo "SUCCESS";
}
else {
    $sqlmod = "UPDATE sch_temas SET cor1 = '$cor1', cor2 = '$cor2', cor3 = '$cor3', cor4 = '$cor4', cor5 = '$cor5', cor6 = '$cor6', block = 'F', ativo = 'T' WHERE id = '$idtheme'";
    $busca = $link1->query($sqlmod);
    if(!$busca){
        echo 'ERROR';
        exit;
    }
    echo "SUCCESS";
}

?>