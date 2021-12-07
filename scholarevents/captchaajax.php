<?php

if (!isset($_SESSION)) {
  session_start();
}
$texto = $_POST['texto'];
if($texto == $_SESSION["captcha"]){
    echo "SUCESSO";
}
else {
    echo "FALHA";
}

?>