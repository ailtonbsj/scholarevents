<?php

    if (!isset($_SESSION)) {
        session_start();
    }
    if(!isset($_SESSION['platformAdmin'])){
        session_unset();
        header("Location: ../index.php");
    }

    $corpo = 'list_user';
    if(isset($_GET['add_user'])){
        $corpo = 'add_user';
    }
    else if(isset ($_GET['error'])){
        $corpo = 'error';
    }
    else if(isset($_GET['list_local'])){
        $corpo = 'list_local';
    }
    else if(isset ($_GET['infor'])){
        $corpo = 'infor';
    }
    else if(isset($_GET['novosub'])){
        $corpo = 'novosub';
    }
    else if(isset($_GET['gerenciar'])){
        $corpo = 'gerenciar';
    }
    else if(isset($_GET['certificado'])){
        $corpo = 'certificado';
    }
    else if(isset($_GET['tema'])){
        $corpo = 'tema';
    }
    else if(isset ($_GET['sucessremev'])){
        $corpo = 'sucessremev';
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Scholar Events - Admin</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="../css/ui-lightness/jquery-ui-1.10.2.custom.min.css">
        <link type="text/css" rel="stylesheet" href="../css/jquery-ui-timepicker-addon.css" />
        <link rel="stylesheet" href="../css/style_admin.css" />
        <script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="../js/jquery-ui-1.10.2.custom.js"></script>
        <script type="text/javascript" src="../js/jquery-ui-timepicker-addon.js"></script>
        <script type="text/javascript" src="../js/spectrum.js"></script>
        <link rel='stylesheet' href='../css/spectrum.css' />
        
        <script type="text/javascript">
        $(function(){
            $("table tbody tr:even").css('background','white');
        });
        </script>
    </head>
    <body>
        <?php
            require './menu_admin.php';
        ?>
        <div id="corpo_principal">
            <?php
                switch($corpo){
                    case 'list_user':
                        include './list_user.php';
                        break;
                    case 'add_user':
                        include './add_user.php';
                        break;
                    case 'error':
                        include './error.php';
                        break;
                    case 'list_local':
                        include './list_local.php';
                        break;
                    case 'infor':
                        include './infor.php';
                        break;
                    case 'novosub':
                        include './novosubevent.php';
                        break;
                    case 'gerenciar':
                        include './gerenciar.php';
                        break;
                    case 'certificado':
                        include './certificado.php';
                        break;
                    case 'tema':
                        include './tema.php';
                        break;
                    case 'sucessremev':
                        include './sucessremev.php';
                        break;
                }
            ?>
        </div>
        <?php
        include './bottom.php';
        ?>
    </body>
</html>
