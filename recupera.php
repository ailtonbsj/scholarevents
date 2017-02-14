<?php

require './link1.php';

$form = $_POST['form'];

foreach ($form as $value) {
    switch ($value["name"]) {
        case "nome":
            $nome = $value["value"];
            break;
        case "email":
            $email = $value["value"];
            break;
        case "celular":
            $celular = $value["value"];
            break;
        case "data_nasc":
            $data_nasc = $value["value"];
            $tk = explode("/", $data_nasc);
            @$data_nasc = $tk[2] . "-" . $tk[1] . "-" . $tk[0];
            break;
        case "uf":
            $uf = $value["value"];
            break;
        case "cidade":
            $cidade = $value["value"];
            break;
        case "endereco":
            $endereco = $value["value"];
            break;
    }
}
$sql1 = "SELECT * FROM sch_usuarios,sch_alunos WHERE (sch_usuarios.id = sch_alunos.id) AND (nome = '$nome') AND (email = '$email') AND (celular = '$celular') AND (d_nascimento = '$data_nasc') AND (uf = '$uf') AND (cidade = '$cidade') AND (endereco = '$endereco')";
$query1 = mysql_query($sql1);
if(mysql_num_rows($query1) == 1){
    $lin = mysql_fetch_assoc($query1);
    echo $lin['senha'];
    exit;
}
else {
    echo "ERROR";
    exit;
}

?>

