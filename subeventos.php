<?php
$subevento = $_GET['subeventos'];
$sqlSubeventos = "SELECT * FROM sch_subeventos WHERE id = '$subevento'";
$buscaSubevent = $link1->query($sqlSubeventos);
$lnSubEv = $buscaSubevent->fetchAll(PDO::FETCH_ASSOC)[0];
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
    $buscaAnexos = $link1->query($sqlAnexos);
    echo "<ul id='lista_anexos'>";
    if($buscaAnexos->rowCount() == 0){
        echo "Não existe nenhum anexo!";
    }
    foreach($buscaAnexos->fetchAll(PDO::FETCH_ASSOC) as $lnAnexos){
        echo "<li><a href='anexos/". $lnAnexos['id_anexo'] ."'>". $lnAnexos['descricao'] ."</a></li>";
    }
    echo "</ul>";
    ?>
    <h1>Lista de Acontecimentos</h1>
    <div id="lista_anexos">
    <?php
    $sqlListaAcon = "SELECT id_acon,titulo,descricao FROM sch_acontecimentos WHERE id_subevent = '$subevento'";
    $buscaListAcon = $link1->query($sqlListaAcon);
    echo "<table id='tb-menus'>";
    echo "<th width='160px'>Titulo</th><th>Descrição</th><th width='200px'>Horário</th><th>Ministrantes</th>";
    foreach($buscaListAcon->fetchAll(PDO::FETCH_ASSOC) as $lnListAcon){
        echo "<tr>";
        echo "<td>" . $lnListAcon['titulo']. "</td>";
        echo "<td>" . $lnListAcon['descricao']. "</td>";
        $idAcon = $lnListAcon['id_acon'];
        $sqlHr = "SELECT sch_espacotempo.momento_ini,sch_espacotempo.momento_fin,sch_locais.local FROM sch_espacotempo,sch_locais WHERE (sch_locais.id = sch_espacotempo.id_local) AND (id_acontec = '$idAcon') ORDER BY momento_ini ASC";
        $buscaHr = $link1->query($sqlHr);
        echo "<td>";
        foreach($buscaHr->fetchAll(PDO::FETCH_ASSOC) as $lnhr){
             echo $lnhr['local'] . "<br />";
             $inic = explode(" ", $lnhr['momento_ini']);
             $dtini = explode("-", $inic[0]);
             $datains = $dtini[2] . "/" . $dtini[1];
             
             $fina = explode(" ", $lnhr['momento_fin']);
             echo "($datains  $inic[1] as $fina[1]) <br />";
        }
		echo "</td><td>";
		$sqlMinis = "SELECT * FROM sch_professor_acontecimento,sch_usuarios WHERE id_prof = id AND id_acon = '$idAcon'";
        $buscaMinis = $link1->query($sqlMinis);
        $firstItem = true;
		foreach($buscaMinis->fetchAll(PDO::FETCH_ASSOC) as $linMinis){
            if($firstItem){
                $firstItem = false;
                echo $linMinis['nome'];
            }
            else
			    echo ",<br />" . $linMinis['nome'];
		}
        echo "</td></tr>";
    }
    echo "</table>";
    ?>
    </div>
</div>
<div style="clear: both;"></div>