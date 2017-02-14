<?php
//menu mais
$sqlMenuMais = "SELECT * FROM sch_menu_mais";
$buscaMenuMais = mysql_query($sqlMenuMais,$link1);
?>   
<div id="menu_main">
	<ul>
            <a href="index.php"><li>Inicio</li></a>
		<li>O evento
			<ul>
<?php
require 'link1.php';
$sqlSubEventos = "SELECT * FROM sch_subeventos";
$buscaSubEvento = mysql_query($sqlSubEventos);
if(!$buscaSubEvento){
    echo "erro4";
    exit;
}
while($linhaSubEvento = mysql_fetch_assoc($buscaSubEvento)){
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
                    while($linhaMenuMais = mysql_fetch_assoc($buscaMenuMais)){
                    
                    ?>
                    <a href="<?php echo $linhaMenuMais['url'] ?>"><li><?php echo $linhaMenuMais['nome_link'] ?></li></a>
                    <?php
                    }
                    ?>
                    </ul>
                </li>
	</ul>
</div>
