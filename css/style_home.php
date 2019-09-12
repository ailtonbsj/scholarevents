<?php
header("Content-type: text/css");

require '../link1.php';

$sqlTheme = "SELECT * FROM sch_temas WHERE ativo = 'T'";
$buscaTheme = $link1->query($sqlTheme);
$lnTheme = $buscaTheme->fetchAll(PDO::FETCH_ASSOC)[0];

$cor1 = $lnTheme['cor1']; //#66AA00
$cor2 = $lnTheme['cor2']; //#CFE4A1
$cor3 = $lnTheme['cor3']; //#FF1100
$cor4 = $lnTheme['cor4']; //#FFFFFF
$cor5 = $lnTheme['cor5']; //#000000
$cor6 = $lnTheme['cor6']; //#005500

if (!isset($_SESSION)) {
  session_start();
}

$_SESSION['cor1'] = $cor1;
$_SESSION['cor2'] = $cor2;
$_SESSION['cor3'] = $cor3;
$_SESSION['cor4'] = $cor4;
$_SESSION['cor5'] = $cor5;
$_SESSION['cor6'] = $cor6;

?>
* {
	margin: 0;
	padding: 0;
}

img {
	border: 0;
}

/* Menu Principal Home */
#menu_main {
	height: 40px;
	background-color: <?php echo $cor1 ?>;
}
#menu_main ul {
	padding: 0;
	margin: 0;
	list-style: none;
        z-index: 999;
}
#menu_main > ul {
	height: 40px;
	width: 760px;
	margin: 0 auto;
}
#menu_main  li > ul li {
	width: 220px;
	text-align: left;
	padding-left: 10px;
}
#menu_main li {
	width: 126px;
	height: 26px;
	font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;
	padding: 7px 0;
	background-color: <?php echo $cor1 ?>;
	color: <?php echo $cor4 ?>;
	text-align: center;
	position: relative;
	float: left;
}
#menu_main li:hover {
	background-color: <?php echo $cor3 ?>;
	color: <?php echo $cor4 ?>;
}
#menu_main li > ul {
	position: absolute;
	left: 0px;
	top: 40px;
	color: <?php echo $cor5 ?>;
	display: none;
}
#menu_main li:hover > ul {
	display: block;
}

/* Topo - Logo e Titulo Principal Home */
#topo {
	width: 760px;
	height: 140px;
	background-color: <?php echo $cor2 ?>;
	background-repeat: no-repeat;
	background-position: 10px 10px;
	margin: 0 auto;
}
#titulo_main {
	margin-left: 160px;
	padding: 26px 10px;
	font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;;
	font-size: 30px;
	color: <?php echo $cor1 ?>;
	font-weight: bolder;
	text-transform: none;
}

/* Bottom Home */
#bottom {
	background-color: <?php echo $cor1 ?>;
	height: 130px;
}
#bottom div {
	background-image: url(../images/logo.png);
	background-repeat: no-repeat;
	background-position: 650px 5px;
	height: 130px;
	width: 760px;
	margin: auto auto;
	position: relative;
}
#bottom div span {
	font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;;
	font-size: 12px;
	color: <?php echo $cor4 ?>;
	display: block;
	position: absolute;
	top: 105px;
	left: 230px;
}

/* Corpo Principal Home */
#corpo_principal {
	background-color: <?php echo $cor2 ?>;
	width: 750px;
	margin: 0 auto;
	padding: 5px 5px;
}

/* Banner Rotativo Home */
#banner_rotativo {
	width: 550px;
	float: left;
}

/* Login do Sistema Home */
#login_area {
	background-color: <?php echo $cor1 ?>;
	width: 170px;
	height: 150px;
	padding: 10px;
	float: right;
	-webkit-border-radius: 6px;  
    -moz-border-radius: 6px;  
    border-radius: 6px;	
}

#login_area > span {
	text-align: center;
	font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;
        font-size: 13px;
        padding: 0;
	color:<?php echo $cor4 ?>;
	font-weight: bolder;
	display: block;
}

#login_area > a {
	font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;
        font-size: 13px;
        padding: 0;
        margin-top: 6px;
	color:<?php echo $cor4 ?>;
	font-weight: bolder;
	display: block;
}

#login_area label {
	display: block;
	font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;
	font-size: 13px;
	color: <?php echo $cor4 ?>;
}

#login_area input {
	height: 23px;
	display: block;
	width: 165px;
	-webkit-border-radius: 3px;  
    -moz-border-radius: 3px;  
    border-radius: 3px;
	border: 0px solid <?php echo $cor4 ?>;
	outline: none;
	text-shadow: 0px 1px 0px <?php echo $cor4 ?>;
	background: -webkit-gradient(linear, left top, left bottom bottom, from(<?php echo $cor2 ?>), to(<?php echo $cor4 ?>));  
    background: -moz-linear-gradient(top,  <?php echo $cor2 ?>,  <?php echo $cor4 ?>);
    -webkit-box-shadow: 1px 1px 0px <?php echo $cor4 ?>;  
    -moz-box-shadow: 1px 1px 0px <?php echo $cor4 ?>;  
    box-shadow:  1px 1px 0px <?php echo $cor4 ?>;
}

#login_area input:focus {
-webkit-box-shadow: 0px 0px 5px <?php echo $cor3 ?>;  
    -moz-box-shadow: 0px 0px 5px <?php echo $cor3 ?>;  
    box-shadow: 0px 0px 5px <?php echo $cor3 ?>;
}

#login_area input[type="submit"] {
	margin-top: 6px; 
}

/* Imagens do Subevento Home */
#subeventos ul {
	padding: 0;
	margin: 0;
	list-style: none;
}
#subeventos ul li {
	padding: 0px;
	float: left;
	margin: 0 15px;
	margin-top: 5px;
	-webkit-box-shadow: 0px 0px 6px <?php echo $cor1 ?>;  
    -moz-box-shadow: 0px 0px 6px <?php echo $cor1 ?>;  
    box-shadow: 0px 0px 6px <?php echo $cor1 ?>;
}
#subeventos ul li:hover {
	-webkit-box-shadow: 0px 0px 6px <?php echo $cor3 ?>;  
    -moz-box-shadow: 0px 0px 6px <?php echo $cor3 ?>;  
    box-shadow: 0px 0px 6px <?php echo $cor3 ?>;
}

/* Sobre o evento Home */
#sobre_evento {
	margin-top: 5px;
	width: 500px;
	font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;;
	font-size: 14px;
	text-align: justify;
	color: <?php echo $cor6 ?>;
        float: left;
}

#area_html_1 {
    margin-top: 5px;
    width: 245px;
    float: right;
}

/* Titulo */
h1 {
	padding: 2px 10px;
	color: <?php echo $cor4 ?>;
	font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;;
	font-size: 17px;
	font-weight: bolder;
	background-color: <?php echo $cor1 ?>;
}

/* Pagina Manutencao */
#bloco_manu {
	background-image: url(../images/manutencao.jpg);
	background-repeat: no-repeat;
	background-position: 220px 60px;
	background-color: <?php echo $cor2 ?>;
	width: 760px;
	height: 600px;
	margin: 0 auto;
	font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;;
	font-size: 24px;
	text-align: center;
}

#login_area_manu {
	margin: 0 auto;
	margin-top: 320px;
	background-color: <?php echo $cor1 ?>;
	width: 170px;
	height: 150px;
	padding: 10px;
	-webkit-border-radius: 6px;  
    -moz-border-radius: 6px;  
    border-radius: 6px;	
}

#login_area_manu > span {
	text-align: center;
	font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;;
	font-size: 14px;
	color:<?php echo $cor4 ?>;
	font-weight: bolder;
	display: block;
}

#login_area_manu label {
	display: block;
	font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;;
	font-size: 13px;
	color: <?php echo $cor4 ?>;
}

#login_area_manu input {
	height: 27px;
	display: block;
	width: 165px;
	-webkit-border-radius: 3px;  
    -moz-border-radius: 3px;  
    border-radius: 3px;
	border: 0px solid <?php echo $cor4 ?>;
	outline: none;
	text-shadow: 0px 1px 0px <?php echo $cor4 ?>;
	background: -webkit-gradient(linear, left top, left bottom, from(<?php echo $cor2 ?>), to(<?php echo $cor4 ?>));  
    background: -moz-linear-gradient(top,  <?php echo $cor2 ?>,  <?php echo $cor4 ?>);
     -webkit-box-shadow: 1px 1px 0px <?php echo $cor4 ?>;  
    -moz-box-shadow: 1px 1px 0px <?php echo $cor4 ?>;  
    box-shadow:  1px 1px 0px <?php echo $cor4 ?>;
}

#login_area_manu input:focus {
-webkit-box-shadow: 0px 0px 5px <?php echo $cor3 ?>;  
    -moz-box-shadow: 0px 0px 5px <?php echo $cor3 ?>;  
    box-shadow: 0px 0px 5px <?php echo $cor3 ?>;
}

#login_area_manu input[type="submit"] {
	margin-top: 6px; 
}

#sobre_subevento {
	margin-top: 5px;
        width: 100%;
	font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;;
	font-size: 14px;
	text-align: justify;
	color: <?php echo $cor6 ?>;
        float: left;
}
#sobre_subevento img {
    display: block;
    margin: 5px auto;
}

#lista_anexos {
    margin: 5px 20px;
}

#lista_anexos li {
    margin: 15px 0;
}

.titulos_download {
    font-weight: bold;
    margin: 15px 8px;
}

.items_download {
    margin: 5px 40px;
}

/* Inscrição Online */
#inscricaoonline > * {
	margin: 0;
	padding: 0;
        border: 0;
        font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;
        font-size: 16px;
}
#inscricaoonline > label {
	font-size: 18px;
	color: <?php echo $cor5 ?>;
	text-shadow: 0px 1px 0px <?php echo $cor4 ?>;
	display: block;
	margin-top: 10px;
	margin-left: 15px;
}

#inscricaoonline > input[type="text"], #inscricaoonline > input[type="button"], #inscricaoonline > input[type="submit"], #inscricaoonline > input[type="password"], #inscricaoonline > textarea {
    display: block;
}

#inscricaoonline > input[type="text"], #inscricaoonline > input[type="button"], #inscricaoonline > input[type="submit"], #inscricaoonline > input[type="password"], #inscricaoonline > textarea, #inscricaoonline > select {
        height: 27px;
        width: 365px;
        -webkit-border-radius: 3px;  
        -moz-border-radius: 3px;  
        border-radius: 3px;
        border: 0px solid <?php echo $cor4 ?>;
        outline: none;
        text-shadow: 0px 1px 0px <?php echo $cor4 ?>;
        background: -webkit-gradient(linear, left top, left bottom, from(<?php echo $cor4 ?>), to(<?php echo $cor4 ?>));  
        background: -moz-linear-gradient(top,  <?php echo $cor4 ?>  <?php echo $cor4 ?>);
        -webkit-box-shadow: 1px 1px 0px <?php echo $cor1 ?>;  
        -moz-box-shadow: 1px 1px 0px <?php echo $cor1 ?>;  
        box-shadow:  1px 1px 0px <?php echo $cor1 ?>;
        margin-left: 15px;
}

#inscricaoonline > input[type="submit"] {
        height: 40px;
        width: 200px;
        font-size: 13px;
        text-transform: uppercase;
        margin: 10px auto;
        color: <?php echo $cor1 ?>;
        background: <?php echo $cor4 ?>;
}

#imgcaptcha {
    width: 160px;
    margin: 5px 0 5px 15px;
}

.acont-subevet-box {
    width: 215px;
    height: 260px;
    background-color: <?php echo $cor1 ?>;
    margin: 7px;
    padding: 10px;
    border-radius: 10px;
    float: left;
    font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;
    font-size: 14px;
    color: <?php echo $cor4 ?>;
}

.acont-subevet-box #titulo {
    font-weight: bold;
    text-align: center;
    font-size: 14px;
    height: 50px;
    overflow-y: hidden;
}

.acont-subevet-box #desc {
    display: block;
    overflow-y: auto;
    height: 120px;
    width: 100%;
    font-size: 13px;
    margin: 10px 0;
}

#table-detail-acon th {
    padding: 10px;
    font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;
    font-size: 15px;
    text-align: left;
}

#table-detail-acon td {
    padding: 10px;
    font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;
    font-size: 14px;
}

#table-detail-hor {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
}

#table-detail-hor td, #table-detail-hor th {
        border: solid 1px <?php echo $cor5 ?>;
        padding: 3px 5px;
        margin:  0;
        vertical-align: middle;
        text-align: center;
        font-size: 13px;
}

input[type="button"] {
    -webkit-border-radius: 3px;  
    -moz-border-radius: 3px;
    border-radius: 3px;
    margin: 10px 0;
    border: 0px solid <?php echo $cor4 ?>;
    outline: none;
    height: 27px;
}

.acont-subevet-box input {
    width: 100%;
}

#bt-participar {
    width: 300px;
    height: 40px;
    display: block;
    position: relative;
    margin: 15px auto;
    font-weight: bold;
    cursor: pointer;
    font-size: 15px;
    color: <?php echo $cor4 ?>;
    text-transform: uppercase;
    font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;
}

#area-user-schedule #tab-list, #area-user-schedule #tab-schedule {
    clear: both;
    background-color: <?php echo $cor1 ?>;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
    border-top-left-radius: 5px;
    padding: 6px 12px;
    margin: 0 0 3px 0;
    color: <?php echo $cor4 ?>;
}

#table-list-tab {
    width: 100%;
    font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;
    border-collapse: collapse;
    border-spacing: 0;
}

#table-list-tab td {
    border-bottom: 1px solid <?php echo $cor4 ?>;
    border-top: 1px solid <?php echo $cor4 ?>;
    text-align: center;
    padding: 5px;
}

#table-list-tab td a {
    cursor: pointer;
}

#area-user-schedule #tab-list .sched-datas,#area-user-schedule #tab-schedule .sched-datas {
    background-color: <?php echo $cor2 ?>;
    border-radius: 5px 5px 0 0;
    padding: 6px 12px;
    text-align: center;
    font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;
    width: 70px;
    font-weight: bold;
    font-size: 11px;
    margin: 3px 0 0 0;
    color: <?php echo $cor1 ?>;
}

#area-user-schedule #tab-list .sched-datas-con, #area-user-schedule #tab-schedule .sched-datas-con {
    background-color: <?php echo $cor2 ?>;
    border-radius: 0 5px 5px 5px;
    margin: 0;
    color: <?php echo $cor1 ?>;
    font-size: 11px;
    padding: 6px;
}

#area-user-schedule #tab-schedule .sched-datas-con div {
    position: relative;
    margin: 3px 0;
    height: 18px;
}

#area-user-schedule #tab-schedule .sched-datas-con div span {
    margin: 0 2px;
    position: absolute;
    left: 200px;
    font-size: 14px;
    font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;
    
}
#area-user-schedule #tab-schedule .sched-datas-con div .sch-local {
    position: absolute;
    width: 200px;
    height: 18px;
    left: 0;
    font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;
    font-size: 14px;
    overflow-y: hidden;
}

.hora-sch-comp {
    background-color: <?php echo $cor3 ?>;
    border-radius: 8px;
}

#area-user-confirm input[type='text'] {
    font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;
    font-size: 28px;
    display: block;
    padding: 5px;
    width: 700px;
}

#area-user-confirm input[type='button'] {
    height: 40px;
    width: 100px;
}

#area-user-confirm label {
    font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;
    font-size: 24px;
    margin: 10px 0;
}

#tb-menus {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
}

#tb-menus tr td {
    border:1px solid <?php echo $cor5 ?>;
    text-align: left;
    padding: 5px;
}
#tb-menus tr th {
    border:1px solid <?php echo $cor5 ?>;
    text-align: left;
    padding: 5px;
}

/* Plataforma do Usuario */

#bar-info-platuser {
    text-align: right;
    color: <?php echo $cor1 ?>;
    font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;
    font-size: 17px;
    padding: 5px;
}

#bar-info-platuser a {
    color: white;
    border-radius: 5px;
    background-color: <?php echo $cor1 ?>;
    padding: 5px;
    text-decoration: none;
    width: 130px;
    display: inline-block;
    text-align: center;
    cursor: pointer;
}

#bar-info-platuser a:hover {
    background-color: <?php echo $cor3 ?>;
}

.select-sub-event {
    margin: 8px;
    border-radius: 10px;
    -webkit-box-shadow: 0px 0px 8px <?php echo $cor1 ?>;  
    -moz-box-shadow: 0px 0px 8px <?php echo $cor1 ?>;  
    box-shadow: 0px 0px 8px <?php echo $cor1 ?>;
    margin: 8px;
    float: left;
    cursor: pointer;
}

#area-user-breadcrumb {
    border: 1px solid <?php echo $cor1 ?>;
    font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;
    font-size: 15px;
    margin: 10px 0 3px 0;
    padding: 9px;
    border-radius: 7px;
    color: <?php echo $cor1 ?>;
}

#area-user-breadcrumb a {
    font-weight:  bold;
    color: <?php echo $cor1 ?>;
}

#area-user-breadcrumb a:hover {
    font-weight:  bold;
    color: <?php echo $cor3 ?>;
    text-decoration: underline;
    cursor: pointer;
}

.more_details {
    text-decoration: underline;
}
.more_details:hover {
    color: <?php echo $cor3 ?>;
}

.testec {
    background-color: yellow;
}

#area-user-schedule li {
    list-style: none;
    float: right;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    padding: 6px 12px;
    margin: 0 0 0 3px;
    text-align: center;
    font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;
    text-decoration: none;
    font-weight: bold;
    border-top: 1px solid <?php echo $cor1 ?>;
    border-left: 1px solid <?php echo $cor1 ?>;
    border-right: 1px solid <?php echo $cor1 ?>;
    cursor: pointer;
}

.tab-aba-normal {
    background-color: <?php echo $cor2 ?>;
    color: <?php echo $cor1 ?>;
}

.tab-aba-hover {
    background-color: <?php echo $cor1 ?>;
    color: <?php echo $cor4 ?>;
}