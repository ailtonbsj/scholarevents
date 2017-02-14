<div id="menu_main">
	<ul>
		<li>Recursos
			<ul>
				<a href="?add_user"><li>Adicionar Usuário</li></a>
				<a href="?list_user"><li>Listar Usuários</li></a>
				<li class="divisor"></li>
                                <a href="?list_local"><li>Add/Ver Locais</li></a>
			</ul>
		</li>
		<li>Subeventos
			<ul>
<?php
require '../link1.php';
$sqlSubEventos = "SELECT * FROM sch_subeventos";
$buscaSubEvento = mysql_query($sqlSubEventos);
if(!$buscaSubEvento){
    echo "erro4";
    exit;
}
while($linhaSubEvento = mysql_fetch_assoc($buscaSubEvento)){
    echo "<a href=\"?novosub=". $linhaSubEvento['id'] ."\"><li>" . $linhaSubEvento['titulo'] . "</li></a>";
}
?>
				<li class="divisor"></li>
                                <a href="?novosub"><li>Novo Subevento</li></a>
			</ul>
		</li>
                <li>Informações
                    <ul>
                            <a href="?infor=init"><li>Pagina Inicial</li></a>
                            <a href="?infor=datas"><li>Datas do Evento</li></a>
                    </ul>
                </li>
                <a href="?certificado"><li>Certificados</li></a>
                <a href="?tema"><li>Temas</li></a>
		<a href="?infor=manu"><li>Manutenção</li></a>
                <li id="bt_sair"><a href="../logoff.php"><img src="images/exit.png" title="Sair" /></a></li>
	<div style="clear: both;"></div>
	</ul>
</div>