<?php

require '../link1.php';

$sql_profe = "SELECT * FROM sch_usuarios WHERE tipo >= 8";
$sql_local = "SELECT * FROM sch_locais";
if($_POST['tipo'] == 'professor'){
    $busca = $link1->query($sql_profe);
}
else if($_POST['tipo'] == 'local'){
    $busca = $link1->query($sql_local);
}

if(!$busca){
    echo "ERROR_QUERY";
    exit;
}
echo "SUCESS\"";
foreach($busca->fetchAll(PDO::FETCH_ASSOC) as $linha){
    if($_POST['tipo'] == 'professor'){
        echo $linha['id'] . "'" . $linha['nome'] . "'" . $linha['email'];
        echo"\""; 
    }
    else if($_POST['tipo'] == 'local'){
        echo $linha['id'] . "'" . $linha['local'];
        echo"\""; 
    }
    
}

