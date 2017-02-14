<?php

require '../link1.php';

$aconteci = $_POST['aconteci'];
$sql = "SELECT * FROM sch_espacotempo,sch_locais WHERE (id_local=id) AND (id_acontec = $aconteci)";

$busca = mysql_query($sql);

if(!$busca){
   echo "ERROR_QUERY";
   exit;
}
while ($linha = mysql_fetch_assoc($busca)){
    echo $linha['momento_ini'] . "'" . $linha['momento_fin'] . "'" . $linha['local'] . "'" . $linha['id_local'];
    echo "\"";
}

?>
