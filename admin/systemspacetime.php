<?php

require '../link1.php';

$data = $_POST['data'];
$inicio_d = $_POST['inicio'];
$fim_d = $_POST['fim'];
$local = $_POST['local'];
$aconteci = $_POST['aconteci'];

$cps_data = explode("/", $data);
$data = $cps_data[2] . "-" . $cps_data[1] . "-" . $cps_data[0];

$inicio = "$data $inicio_d";
$fim = "$data $fim_d";

//$sqlspacetime = "SELECT * FROM sch_espacotempo WHERE (id_local = '$local') AND (NOT(((momento_ini > '$inicio') AND (momento_ini > '$fim')) OR ((momento_fin < '$inicio') AND (momento_fin < '$fim'))))";
$sqlspacetime = "SELECT sch_espacotempo.*,sch_locais.*,sch_acontecimentos.titulo FROM sch_espacotempo,sch_locais,sch_acontecimentos WHERE ((id_local = '$local') AND (id=id_local) AND (id_acontec=id_acon)) AND (NOT(((momento_ini > '$inicio') AND (momento_ini > '$fim')) OR ((momento_fin < '$inicio') AND (momento_fin < '$fim'))))";
$buscaspacetime = mysql_query($sqlspacetime, $link1);
if(!$buscaspacetime){
    echo "ERROR_QUERY";
    exit;
}

if(mysql_num_rows($buscaspacetime) == 0){
    $sql_insert = "INSERT INTO sch_espacotempo (id_local, momento_ini, momento_fin, id_acontec) VALUES ("
            . "'$local', '$inicio', '$fim', '$aconteci')";
    $busca_insert = mysql_query($sql_insert, $link1);
    if(!$busca_insert){
        echo "ERROR_QUERY";
        exit;
    }
    echo "SUCESS";
}
else {
    echo "Choque de Horário com os eventos:<br /><br />";
    while ($linha = mysql_fetch_assoc($buscaspacetime)){
        echo $linha['titulo'] . "<br />(Inicio:" . $linha['momento_ini'] . " / Fim:" . $linha['momento_fin'] . ")";
        echo "<br />";
    }
}

?>
