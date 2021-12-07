<?php

require '../link1.php';

$acontecimento = $_POST['acontecimento'];
$professor = $_POST['professor'];
$operacao = $_POST['operacao'];

if($operacao == "INSERT"){
$sql = "INSERT INTO sch_professor_acontecimento (id_acon, id_prof) VALUES ('$acontecimento', '$professor')";
}
else if($operacao == "DELETE"){
    $sql = "DELETE FROM sch_professor_acontecimento WHERE sch_professor_acontecimento.id_acon = $acontecimento AND sch_professor_acontecimento.id_prof = $professor";
}
else if($operacao == "QUERY"){
    $sql = "SELECT id_prof,nome,email FROM sch_professor_acontecimento, sch_usuarios WHERE (sch_professor_acontecimento.id_prof = sch_usuarios.id) AND (id_acon = $acontecimento)";
}
$busca = $link1->query($sql);
if(!$busca){
    echo "ERROR_QUERY";
    exit;
}
else if($operacao == "QUERY") {
    echo "SUCESS\"";
    foreach($busca->fetchAll(PDO::FETCH_ASSOC) as $row){
        echo $row['id_prof'] . "'" . $row['nome'] . "'" . $row['email'];
        echo "\"";
    }
}
else {
    echo "SUCESS";
    exit;
}
?>

