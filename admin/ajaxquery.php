<?php
    require '../link1.php';   
    if(isset($_POST["valoremail"])){
        $valorEmail = $_POST["valoremail"];
        $sql12 = "SELECT * FROM sch_usuarios WHERE email = '$valorEmail'";
        $busca12 = mysql_query($sql12,$link1);
        $linha12 = mysql_fetch_assoc($busca12);
        echo $linha12['email'];
    }
    if(isset($_POST["valorcpf"])){
        $valorCpf = $_POST["valorcpf"];
        $sql12 = "SELECT * FROM sch_usuarios WHERE cpf = '$valorCpf'";
        $busca12 = mysql_query($sql12,$link1);
        $linha12 = mysql_fetch_assoc($busca12);
        echo $linha12['cpf'];
    }
?>