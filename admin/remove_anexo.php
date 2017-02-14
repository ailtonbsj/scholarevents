<?php

$id = $_GET['idanexo'];
$subev = $_GET['subev'];

include './removesLib.php';

$retornRemAnexo = removeAnexos($id);

if($retornRemAnexo == "ERROR_UNLINK"){
    header("Location: index.php?error=15");
    exit;
}

if($retornRemAnexo == "ERROR_DB"){
    header("Location: index.php?error=7");
    exit;
}
//sucesso!
    header("Location: index.php?novosub=$subev&sucess=2");
?>

