<?php
require './link1.php';

$inicio = '05';
$fim = '35';
$inicio = "2014-04-07 00:$inicio:00";
$fim = "2014-04-07 00:$fim:00";
$local = "22";
$sqlCrash = "SELECT * FROM sch_aluno_acont,sch_espacotempo WHERE (sch_espacotempo.id_acontec = sch_aluno_acont.id_acon) AND (sch_aluno_acont.id_al = '$id_aluno') AND (id_local = '$local') AND (NOT(((momento_ini > '$inicio') AND (momento_ini > '$fim')) OR ((momento_fin < '$inicio') AND (momento_fin < '$fim'))))";

$busca = mysql_query($sql, $link1);

echo mysql_num_rows($busca);

echo '<br />' . $sql;

?>

