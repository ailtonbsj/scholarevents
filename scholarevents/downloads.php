<h1>Downloads</h1>
<div id="sobre_subevento">
<?php
$sqlDownloads = "SELECT sch_anexos.id_anexo, sch_anexos.descricao, sch_subeventos.titulo FROM sch_anexos,sch_subeventos WHERE sch_anexos.id_subev = sch_subeventos.id ORDER BY sch_subeventos.titulo";
$buscaDownloads = $link1->query($sqlDownloads);
$titulo = '';
foreach($buscaDownloads->fetchAll(PDO::FETCH_ASSOC) as $lnDownloads){
    if($titulo != $lnDownloads['titulo']){
        $titulo = $lnDownloads['titulo'];
        echo "<div class='titulos_download'>" . $titulo . '</div>';
    }
    $url = $lnDownloads['id_anexo'];
    echo "<li class='items_download'><a href='anexos/". $url ."'>" . $lnDownloads['descricao'] . '</a></li>';
}
?>
</div>
<div style="clear: both;"></div>