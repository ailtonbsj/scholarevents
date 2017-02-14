<?php
$subevento = $_GET['subeventos'];
$sqlSubeventos = "SELECT * FROM sch_subeventos WHERE id = '$subevento'";
$buscaSubevent = mysql_query($sqlSubeventos, $link1);
$lnSubEv = mysql_fetch_assoc($buscaSubevent);
?>

<div id="sobre_subevento">
    <h1> <?php echo $lnSubEv['titulo'] ?></h1>
    <img src="images/<?php echo $lnSubEv['logo'] ?>" />
    <div id="lista_anexos">
    <?php
    echo nl2br($lnSubEv['descricao']);
    ?>
    </div>
    <h1>Anexos</h1>
    <?php
    $sqlAnexos = "SELECT * FROM sch_anexos WHERE id_subev = '$subevento'";
    $buscaAnexos = mysql_query($sqlAnexos, $link1);
    echo "<ul id='lista_anexos'>";
    if(mysql_num_rows($buscaAnexos) == 0){
        echo "Não existe nenhum anexo!";
    }
    while($lnAnexos = mysql_fetch_assoc($buscaAnexos)){
        echo "<li><a href='anexos/". $lnAnexos['id_anexo'] ."'>". $lnAnexos['descricao'] ."</a></li>";
    }
    echo "</ul>";
    ?>
    <h1>Lista de Acontecimentos</h1>
    <div id="lista_anexos">
    <?php
    $sqlListaAcon = "SELECT id_acon,titulo,descricao FROM sch_acontecimentos WHERE id_subevent = '$subevento'";
    $buscaListAcon = mysql_query($sqlListaAcon);
    echo "<table id='tb-menus'>";
    echo "<th width='160px'>Titulo</th><th>Descrição</th><th width='200px'>Horário</th><th>Ministrantes</th>";
    while($lnListAcon = mysql_fetch_assoc($buscaListAcon)){
        echo "<tr>";
        echo "<td>" . $lnListAcon['titulo']. "</td>";
        echo "<td>" . $lnListAcon['descricao']. "</td>";
        $idAcon = $lnListAcon['id_acon'];
        $sqlHr = "SELECT sch_espacotempo.momento_ini,sch_espacotempo.momento_fin,sch_locais.local FROM sch_espacotempo,sch_locais WHERE (sch_locais.id = sch_espacotempo.id_local) AND (id_acontec = '$idAcon') ORDER BY momento_ini ASC";
        $buscaHr = mysql_query($sqlHr);
        echo "<td>";
        while($lnhr = mysql_fetch_assoc($buscaHr)){
             echo $lnhr['local'] . "<br />";
             $inic = explode(" ", $lnhr['momento_ini']);
             $dtini = explode("-", $inic[0]);
             $datains = $dtini[2] . "/" . $dtini[1];
             
             $fina = explode(" ", $lnhr['momento_fin']);
             echo "($datains  $inic[1] as $fina[1]) <br />";
        }
		echo "</td><td>";
		$sqlMinis = "SELECT * FROM sch_professor_acontecimento,sch_usuarios WHERE id_prof = id AND id_acon = '$idAcon'";
		$buscaMinis = mysql_query($sqlMinis);
		while($linMinis = mysql_fetch_assoc($buscaMinis)){
			echo $linMinis['nome'] . "<br />";
		}
        echo "</td></tr>";
    }
    echo "</table>";
    ?>
    </div>
</div>
<div style="clear: both;"></div>