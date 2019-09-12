<?php
//menu mais
$sqlMenuMais = "SELECT * FROM sch_menu_mais";
$buscaMenuMais = $link1->query($sqlMenuMais);
?>   
<div id="menu_main">
	<ul>
            <a href="index.php"><li>Inicio</li></a>
		<li>O evento
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
    echo "<a href=\"index.php?subeventos=". $linhaSubEvento['id'] ."\"><li>" . $linhaSubEvento['titulo'] . "</li></a>";
}
?>
			</ul>
		</li>
                <a href="index.php?inscricao"><li>Inscrição</li></a>
                <a href="index.php?downloads"><li>Downloads</li></a>
                <a href="index.php?cronograma"><li>Cronograma</li></a>
		<li>Mais
                    <ul>
                    <?php
                    while($linhaMenuMais = $buscaMenuMais->fetchAll(PDO::FETCH_ASSOC)){
                    
                    ?>
                    <a href="<?php echo $linhaMenuMais['url'] ?>"><li><?php echo $linhaMenuMais['nome_link'] ?></li></a>
                    <?php
                    }
                    ?>
                    </ul>
                </li>
	</ul>
</div>
