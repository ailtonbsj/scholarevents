<?php
    require '../link1.php';   
    if(isset($_POST["valoremail"])){
        $valorEmail = $_POST["valoremail"];
        $sql12 = "SELECT * FROM sch_usuarios WHERE email = '$valorEmail'";
        $busca12 = $link1->query($sql12);
        $linha12 = $busca12->fetchAll(PDO::FETCH_ASSOC);
        echo $linha12['email'];
    }
    if(isset($_POST["valorcpf"])){
        $valorCpf = $_POST["valorcpf"];
        $sql12 = "SELECT * FROM sch_usuarios WHERE cpf = '$valorCpf'";
        $busca12 = $link1->query($sql12);
        $linha12 = $busca12->fetchAll(PDO::FETCH_ASSOC);
        echo $linha12['cpf'];
    }
?>