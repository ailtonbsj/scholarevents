<?php
include './link1.php';
$sqlTexto = "SELECT * FROM sch_textos WHERE id='admin'";
$buscaTexto = $link1->query($sqlTexto);
foreach($buscaTexto->fetchAll(PDO::FETCH_ASSOC) as $linhaTexto){
    switch ($linhaTexto['id']){
        case "admin":
            $adminpass = $linhaTexto['texto'];
            break;
    }
}
if(isset($_POST['user'])){
    $user = $_POST['user'];
    $password = $_POST['password'];
    if (!isset($_SESSION)) {
        session_start();
    }
    if($user == 'admin'){
        if($adminpass == $password){
            $_SESSION['platformAdmin'] = "Active";
            header("Location: admin/");
            exit;
        }
        else{
            header("Location: manutencao.php?logininvalid");
            exit;
        }     
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Em Manutenção</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width"/>
        <link rel="stylesheet" href="css/style_home.css" />
        <script type="text/javascript" > 
            setTimeout("window.location='index.php'",30000);
        <?php
        if(isset($_GET['logininvalid'])){
        ?>
        alert("Login invalido! Acesso negado!");
        <?php
        }
        ?>
    </script>
    </head>
    <body>
        <div id="bloco_manu">
	<div>Site temporariamente em manutenção!<br />Aguarde alguns minutos...</div>
        <form id="login_area_manu" method="post" action="manutencao.php">
		<span>Administrador</span>
		<label for="user">Usuário</label><input type="text" name="user" id="user" />
		<label for="password">Senha</label><input type="password" name="password" id="password" />
		<input type="submit" value="Acessar" />
	</form>
        </div>
    </body>
</html>
