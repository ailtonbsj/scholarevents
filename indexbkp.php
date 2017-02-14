<?php
    require './link1.php';
    require './seguranca.php';
    $sqlTexto = "SELECT * FROM sch_textos";
    $buscaTexto = mysql_query($sqlTexto,$link1);
    $titulo_site = "";
    $html1 = "";
    $html2 = "";
    $adminpass = "";
    while($linhaTexto = mysql_fetch_assoc($buscaTexto)){
        switch ($linhaTexto['id']){
            case "titulo":
                $titulo_site = $linhaTexto['texto'];
                break;
            case "html1":
                $html1 = $linhaTexto['texto'];
                break;
            case "html2":
                $html2 = $linhaTexto['texto'];
                break;
            case "sobre":
                $sobre_event = nl2br(strip_tags($linhaTexto['texto']));
                break;
            case "admin":
                $adminpass = $linhaTexto['texto'];
                break;
        }
    }
    //Logo
    $sqlLogoPrincipal = "SELECT * FROM sch_images WHERE nome_img LIKE '%log%'";
    $buscaLogoPrincipal = mysql_query($sqlLogoPrincipal,$link1);
    $linhaLogoPrincipal = mysql_fetch_assoc($buscaLogoPrincipal);
    $imgLogoPrincipal = $linhaLogoPrincipal['nome_img'];
    if(!(file_exists("images/" . $imgLogoPrincipal))){
        $imgLogoPrincipal = "logo.png";
    }
    
    //banners
    $sqlBanPrincipal = "SELECT * FROM sch_images WHERE nome_img LIKE '%ban%'";
    $buscaBanPrincipal = mysql_query($sqlBanPrincipal,$link1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Scholar Events</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="css/style_home.php" />
        <link type="text/css" rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.2.custom.min.css" />
        <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.10.2.custom.js"></script>
        <script type="text/javascript">
            $(function(){
                $("#topo").css("background-image","url(images/<?php echo $imgLogoPrincipal ?>)");
            });
        </script>
    </head>
    <body>
        <?php
        require 'menu_home.php';
        require 'topo_home.php';
        ?>
        <div id="corpo_principal">
        <?php
        if(isset($_GET['subeventos'])){
            include 'subeventos.php';
        }
        else if(isset($_GET['downloads'])){
            include 'downloads.php';
        }
        else if(isset($_GET['cronograma'])){
            include 'cronograma.php';
        }
        else if(isset($_GET['inscricao'])){
            include 'inscricao.php';
        }
        else if(isset($_GET['forget'])){
            include 'forget.php';
        }
        else {
            include 'content_main_home.php';
        }
        ?>
        </div>
        <?php
        include 'bottom.php';
        ?>
    </body>
</html>
