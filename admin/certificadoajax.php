<?php

require '../link1.php';

$cert = $_POST['certn'];
$cont = 0;

$cont = 0;
foreach ($cert as $lnc) {
	$lnc = str_replace("&nbsp;"," ",strip_tags($lnc));
    $sqlcert = "UPDATE sch_textos SET texto = '$lnc' WHERE id = 'cert$cont'";
    $buscaCert = mysql_query($sqlcert,$link1);
    if(!$buscaCert){
        echo "ERROR";
        exit;
    }
    $cont++;
}
echo 'SUCESS';
?>