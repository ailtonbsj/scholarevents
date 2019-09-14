<?php

include './link1.php';

//inicia sessao
if (!isset($_SESSION)) {
  session_start();
}
//variaveis do formulario
$textoCaptcha = $_POST['textcaptcha'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$cpf = ($_POST['cpf'] == '')?'NULL':"'". $_POST['cpf'] ."'";
$senha = $_POST['senha'];
$celular = $_POST['celular'];
$telefone = ($_POST['telefone']=='')?'NULL':"'" . $_POST['telefone'] . "'";
$nascimento = explode("/", $_POST['data_nasc']);
$nascimento = $nascimento[2] . "-" . $nascimento[1] . "-" . $nascimento[0];
$matricula = ($_POST['matricula'] == '')?'NULL':"'" . $_POST['matricula'] . "'";
$uf = $_POST['uf'];
$cidade = $_POST['cidade'];
$bairro = $_POST['bairro'];
$endereco = $_POST['endereco'];

if($_SESSION["captcha"] != $textoCaptcha){
    //header("Location: index.php?inscricao&error");
    exit;
}
else{
    $id = date("ymdHis");
    $emailAtivo = 'F';
    //consulta em usuario
    $sqlUsuario = "INSERT INTO sch_usuarios (id, nome, email, cpf, senha, celular, telefone, d_nascimento, tipo) VALUES ("
            . "'$id', '$nome', '$email', $cpf, '$senha', '$celular', $telefone, '$nascimento', '1')";
    $buscausuario = $link1->query($sqlUsuario);
    if(!$buscausuario){
        header("Location: index.php?inscricao&error");
        exit;
    }
    //consulta em aluno
    $sqlAluno = "INSERT INTO sch_alunos (id, matricula, uf, cidade, bairro, endereco, email_ativo) VALUES ("
            . "'$id', $matricula, '$uf', '$cidade', '$bairro', '$endereco', 'F')";
    $buscaAluno = $link1->query($sqlAluno);
    if(!$buscaAluno){
        header("Location: index.php?inscricao&error");
        exit;
    }
    $_SESSION['UserId'] = $id;
    $_SESSION['UserNome'] = $nome;
    $_SESSION['UserEmail'] = $email;
    $_SESSION['UserTipo'] = '1';
    $_SESSION['typeStudent'] = '1';
    $_SESSION['typeOrganizer'] = '0';
    $_SESSION['typeAppraiser'] = '0';
    header("Location: platformuser.php");
}
?>