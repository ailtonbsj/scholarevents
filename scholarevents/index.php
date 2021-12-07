<?php

if(isset($_POST['host'])){

    $host = $_POST['host'];
    $user = $_POST['user'];
    $senha = $_POST['senha'];
    $db = $_POST['database'];
    
    $link1 = new PDO("mysql:host={$host};port=3307;dbname={$db};charset=utf8", $user, $senha);
    $link1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if($link1){
             
$sqldb[0] = 
"CREATE TABLE IF NOT EXISTS `sch_acontecimentos` (
  `id_acon` bigint(14) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `vagas_total` int(11) NOT NULL,
  `total_inscritos` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `id_subevent` varchar(20) NOT NULL,
  `pago` char(1) NOT NULL DEFAULT 'F',
  PRIMARY KEY (`id_acon`),
  UNIQUE KEY `titulo` (`titulo`),
  KEY `acontsubev` (`id_subevent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$sqldb[1] =
"CREATE TABLE IF NOT EXISTS `sch_alunos` (
  `id` bigint(14) NOT NULL,
  `matricula` varchar(50) DEFAULT NULL,
  `uf` char(2) DEFAULT NULL,
  `cidade` varchar(45) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `endereco` varchar(40) DEFAULT NULL,
  `email_ativo` char(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `matricula` (`matricula`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$sqldb[2] =
"CREATE TABLE IF NOT EXISTS `sch_aluno_acont` (
  `id_al` bigint(14) NOT NULL,
  `id_acon` bigint(14) NOT NULL,
  PRIMARY KEY (`id_al`,`id_acon`),
  KEY `key_acon` (`id_acon`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$sqldb[3] =
"CREATE TABLE IF NOT EXISTS `sch_anexos` (
  `id_subev` varchar(15) NOT NULL,
  `id_anexo` varchar(20) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  PRIMARY KEY (`id_anexo`),
  KEY `anexo_subev` (`id_subev`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$sqldb[4] =
"CREATE TABLE IF NOT EXISTS `sch_datas` (
  `label` varchar(25) NOT NULL,
  `data` datetime NOT NULL,
  PRIMARY KEY (`label`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$inscricaoOnlineInicio = date("Y-m-d 05:00:00");
$inscricaoOnlineFim = date("Y-m-d 08:59:59");
$bloqueioCursos = date("Y-m-d 09:00:00");
$eventoInicio = date("Y-m-d 09:00:00");
$eventoFim = date("Y-m-d 23:30:00");

$sqldb[5] =
"INSERT INTO `sch_datas` (`label`, `data`) VALUES
('BloqueioCursos', '$bloqueioCursos'),
('Evento:Fim', '$eventoFim'),
('Evento:Inicio', '$eventoInicio'),
('InscricaoOnline:Fim', '$inscricaoOnlineFim'),
('InscricaoOnline:Inicio', '$inscricaoOnlineInicio');";

$sqldb[6] =
"CREATE TABLE IF NOT EXISTS `sch_espacotempo` (
  `id_local` int(11) NOT NULL,
  `momento_ini` datetime NOT NULL,
  `momento_fin` datetime NOT NULL,
  `id_acontec` bigint(14) NOT NULL,
  KEY `localspacetime` (`id_local`),
  KEY `aconspacetime` (`id_acontec`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$sqldb[7] =
"CREATE TABLE IF NOT EXISTS `sch_images` (
  `nome_img` varchar(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$sqldb[8] =
"INSERT INTO `sch_images` (`nome_img`) VALUES
('log140609055108.png'),
('cer140616101820.png');";

$sqldb[9] =
"CREATE TABLE IF NOT EXISTS `sch_locais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `local` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `local` (`local`),
  UNIQUE KEY `local_2` (`local`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

$sqldb[10] =
"CREATE TABLE IF NOT EXISTS `sch_menu_mais` (
  `nome_link` varchar(25) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`nome_link`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$sqldb[11] =
"CREATE TABLE IF NOT EXISTS `sch_professores` (
  `id` bigint(14) NOT NULL,
  `minicv` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$sqldb[12] =
"CREATE TABLE IF NOT EXISTS `sch_professor_acontecimento` (
  `id_acon` bigint(14) NOT NULL,
  `id_prof` bigint(14) NOT NULL,
  PRIMARY KEY (`id_acon`,`id_prof`),
  KEY `profkey` (`id_prof`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$sqldb[13] =
"CREATE TABLE IF NOT EXISTS `sch_subeventos` (
  `id` varchar(15) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `descricao` text NOT NULL,
  `plataforma` varchar(10) NOT NULL,
  `inform` varchar(2) NOT NULL,
  `logo` varchar(19) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$sqldb[14] =
"CREATE TABLE IF NOT EXISTS `sch_temas` (
  `id` varchar(12) NOT NULL,
  `cor1` varchar(7) NOT NULL,
  `cor2` varchar(7) NOT NULL,
  `cor3` varchar(7) NOT NULL,
  `cor4` varchar(7) NOT NULL,
  `cor5` varchar(7) NOT NULL,
  `cor6` varchar(7) NOT NULL,
  `block` char(1) NOT NULL,
  `ativo` char(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$sqldb[15] =
"INSERT INTO `sch_temas` (`id`, `cor1`, `cor2`, `cor3`, `cor4`, `cor5`, `cor6`, `block`, `ativo`) VALUES
('* Brazil', '#10840e', '#FFF751', '#0614ab', '#ffffff', '#ffffff', '#08410b', 'T', 'F'),
('* IFCE', '#66AA00', '#CFE4A1', '#FF1100', '#FFFFFF', '#000000', '#005500', 'T', 'T'),
('* InFire', '#f47a00', '#ffb56a', '#cc6600', '#ffffff', '#824100', '#000000', 'T', 'F'),
('* Lilac', '#4b03a9', '#b090ff', '#439bb0', '#ffffff', '#000000', '#8c009e', 'T', 'F'),
('Custom1', '#d41313', '#ff9d8e', '#a10000', '#ffffff', '#000000', '#490000', 'F', 'F'),
('Custom2', '#0062ff', '#86baff', '#013d9d', '#ffffff', '#000000', '#060069', 'F', 'F'),
('Custom3', '#13020a', '#bfbfbf', '#909090', '#ffffff', '#252525', '#272727', 'F', 'F');";

$sqldb[16] =
"CREATE TABLE IF NOT EXISTS `sch_textos` (
  `id` varchar(15) NOT NULL,
  `texto` varchar(2000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$sqldb[17] =
"INSERT INTO `sch_textos` (`id`, `texto`) VALUES
('admin', 'admin'),
('cert0', 'Certificamos que'),
('cert1', 'participou do'),
('cert2', ' no período de'),
('cert3', 'a'),
('cert4', 'na oficina'),
('cert5', 'com carga horária de'),
('cert6', 'horas/aula.'),
('html1', '<div style=\"background:white; border: dashed 1px black;padding:30px;\">Local de código HTML1</div>'),
('html2', '<div style=\"background:white; border: dashed 1px black;padding:30px;\">Local de código HTML2</div>'),
('manutencao', 'inativo'),
('sobre', 'Aqui fica a descrição sobre o evento.'),
('titulo', 'ScholarEvents versão 1.0');";

$sqldb[18] =
"CREATE TABLE IF NOT EXISTS `sch_usuarios` (
  `id` bigint(14) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `cpf` bigint(11) DEFAULT NULL,
  `senha` varchar(12) DEFAULT NULL,
  `celular` bigint(11) DEFAULT NULL,
  `telefone` bigint(11) DEFAULT NULL,
  `d_nascimento` date DEFAULT NULL,
  `tipo` char(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `cpf` (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$sqldb[19] =
"ALTER TABLE `sch_acontecimentos`
  ADD CONSTRAINT `acontsubev` FOREIGN KEY (`id_subevent`) REFERENCES `sch_subeventos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;";

$sqldb[20] =
"ALTER TABLE `sch_alunos`
  ADD CONSTRAINT `key_alunos_usuario` FOREIGN KEY (`id`) REFERENCES `sch_usuarios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;";

$sqldb[21] =
"ALTER TABLE `sch_aluno_acont`
  ADD CONSTRAINT `key_acon` FOREIGN KEY (`id_acon`) REFERENCES `sch_acontecimentos` (`id_acon`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `key_aluno` FOREIGN KEY (`id_al`) REFERENCES `sch_alunos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;";

$sqldb[22] =
"ALTER TABLE `sch_anexos`
  ADD CONSTRAINT `anexo_subeve` FOREIGN KEY (`id_subev`) REFERENCES `sch_subeventos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;";

$sqldb[23] =
"ALTER TABLE `sch_espacotempo`
  ADD CONSTRAINT `aconspacetime` FOREIGN KEY (`id_acontec`) REFERENCES `sch_acontecimentos` (`id_acon`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `localespacotempo` FOREIGN KEY (`id_local`) REFERENCES `sch_locais` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;";

$sqldb[24] =
"ALTER TABLE `sch_professores`
  ADD CONSTRAINT `key_profe_user` FOREIGN KEY (`id`) REFERENCES `sch_usuarios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;";

$sqldb[25] =
"ALTER TABLE `sch_professor_acontecimento`
  ADD CONSTRAINT `aconkey` FOREIGN KEY (`id_acon`) REFERENCES `sch_acontecimentos` (`id_acon`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `profkey` FOREIGN KEY (`id_prof`) REFERENCES `sch_usuarios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;";

for ($i = 0; $i <= 25; $i++) {
  $busca = $link1->query($sqldb[$i]);
    if(!$busca){
        echo "ERROR FATAL";
        exit;
    }
}

$textLink1 = "\$link1 = new PDO(\"mysql:host={$host};port=3307;dbname={$db};charset=utf8\", '$user', '$senha');\n";
$textLink1.= "\$link1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);";

$arqLink1 = @ fopen("link1.php", "w");
if(!$arqLink1){
    echo "Erro de permissao";
    exit;
}
fwrite($arqLink1, "<?php\n\r");
fwrite($arqLink1, $textLink1);
fwrite($arqLink1, "\n\r?>");
fclose($arqLink1);

unlink("index.php");
rename("indexbkp.php", "index.php");

header("location: index.php");
        
    }
    else{
        $error = "err";
    }
    
}

?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Scholar Events</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="css/style_home.css" />
        <link type="text/css" rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.2.custom.min.css" />
        <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.10.2.custom.js"></script>
        <script type="text/javascript">
            $(function(){
                altura = $(document).height();
                $("#corpo_principal").css('height',(altura-140)+'px');
                $("#corpo_principal").css('overflow-y','scroll');
            });
        </script>
    </head>
    <body>
        <div id="corpo_principal">
            <img src="images/logo.png" style="display: block; margin: 0 auto;" />
            <div style="font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;font-size: 20px; text-align: center; color: #66aa00;font-weight: bolder;text-transform: none;">
                Sistema de Gerenciamento de Eventos Acadêmicos ( ScholarEvents 1.0 )<br />
                Para a instalação precisamos primeiro de alguns dados:
            </div>
            <form id="inscricaoonline" method="post" action="index.php" style="border: 1px solid #66aa00; width: 400px; margin: 2px auto; padding: 2px;">
                <label>Host</label>
                <input name="host" type="text" />
                <label>User</label>
                <input name="user" type="text" />
                <label>Senha</label>
                <input name="senha" type="text" />
                <label>Banco de dados</label>
                <input name="database" type="text" />
                <input type="submit" value="Instalar" />
            </form>
        </div>
        <?php
        include 'bottom.php';
        if(isset($error)){
        ?>
        <script type="text/javascript">
        alert("Error nos dados!");
        </script>
        <?php
        }
        ?>
    </body>
</html>

