<?php
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
            header("Location: index.php?logininvalid");
            exit;
        }
    }
    else{
        $sqlLogin = "SELECT * FROM sch_usuarios WHERE email = '$user' AND senha = '$password'";
        $buscaLogIn = mysql_query($sqlLogin,$link1);
        if(mysql_num_rows($buscaLogIn) == 1){
            $lin = mysql_fetch_assoc($buscaLogIn);
            $_SESSION['UserId'] = $lin['id'];
            $_SESSION['UserNome'] = $lin['nome'];
            $_SESSION['UserEmail'] = $lin['email'];
            $_SESSION['UserTipo'] = $lin['tipo'];
            $kindUser = $_SESSION["UserTipo"];
            $kindUser = decbin($kindUser);
            while(strlen($kindUser)<4){
                $kindUser = '0' . $kindUser;
            }
            $_SESSION['typeStudent'] = $kindUser[3];
            $_SESSION['typeOrganizer'] = $kindUser[2];
            $_SESSION['typeAppraiser'] = $kindUser[1];
            
            if($_SESSION['typeStudent'] == '0'){
                header("Location: index.php?logininvalid");
                exit;
            }
            
            
            
            header("Location: platformuser.php");
        }
        else {
            header("Location: index.php?logininvalid");
            exit;
        }     
    }
}

?>
<script type="Text/Javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery.sudoSlider.min.js"></script>
<script type="text/javascript" >
    $(document).ready(function(){	
        $("#banner_rotativo").sudoSlider({
            numeric:false,
            auto:true,
            continuous:true,
            prevNext:false
        });
        
        <?php
        if(isset($_GET['logininvalid'])){
        ?>
        alert("Login invalido! Acesso negado!");
        <?php
        }
        ?>
        
    });
</script>
<div>
	<div id="banner_rotativo" >
    <ul>
        <?php
                if($buscaBanPrincipal->rowCount() == 0){
            echo "<li><img src=\"images/banner.png\" alt=\"image description\"/></li>";
        }
        foreach($buscaBanPrincipal->fetchAll(PDO::FETCH_ASSOC) as $linhaBanPrincipal){        
        ?>
        <li><img src="images/<?php echo $linhaBanPrincipal['nome_img'] ?>" alt="image description"/></li>
        <?php
        }
        ?>
    </ul>
	</div>
	<form id="login_area" action="index.php" method="post">
		<span>Acesso ao Sistema</span>
		<label for="user">E-mail</label><input type="text" name="user" id="user" />
		<label for="password">Senha</label><input type="password" name="password" id="password" />
		<input type="submit" value="Acessar" />
                <a href='index.php?forget'>Esqueceu a senha?</a>
	</form>
</div>
<div style="clear: both;"></div>
<div id="subeventos">
	<ul>
<?php
require 'link1.php';
$sqlSubEventos = "SELECT * FROM sch_subeventos";
$buscaSubEvento = $link1->query($sqlSubEventos);
if(!$buscaSubEvento){
    echo "erro4";
    exit;
}
while($linhaSubEvento = $buscaSubEvento->fetchAll(PDO::FETCH_ASSOC)){
    echo "<a href=\"index.php?subeventos=". $linhaSubEvento['id'] ."\"><li>" . "<img src=\"images/". $linhaSubEvento['logo'] . "\" /></li></a>";
}
?>
	</ul>
	<div style="clear: both;"></div>
</div>
<div style="clear: both;"></div>
<div>
	<div id="sobre_evento">
		<h1>Sobre o Evento</h1>
                <?php echo $sobre_event ?>
	</div>
	<div id="area_html_1"><?php echo $html1 ?></div>
        <div style="clear: both;"></div>
</div>
<div id="area_html_2"><?php echo $html2 ?></div>
<div style="clear: both;"></div>