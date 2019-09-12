<?php
    if(isset($_GET['sucess'])){
        if($_GET['sucess'] == "cadastro"){
?>
<div class="ui-state-highlight ui-corner-all" style="margin: 10px 0; padding: 6px;">
<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
<strong>Operação realizada com sucesso!!!</strong>.</p>
</div>
<?php
        }
    }
?>
<script type="text/javascript">
    function deletarUser(id,p,a){
        if(confirm('Tem certeza que deseja deletar???') == true){
            location = "remove_u.php?uid=" + escape(id) + "&prof=" + p + "&alu=" + a;
        }
    }
    $(function(){
        altura = $(document).height();
        $("#corpo_principal").css('height',(altura-180)+'px');
        $("#corpo_principal").css('overflow-y','scroll');
    });
</script>
<form action="?list_user" method="POST" id="busca_users">
    <label for="filt_user">Buscar por</label>
    <select name="filter_tipo" id="filter_tipo">
        <option value="all">Todos os Usuarios</option>
        <option value="prof">Professor</option>
        <option value="aluno">Aluno/Participante</option>
        <!--
        <option value="aval">Avaliador de Artigo</option>
        <option value="orga">Organizador</option>
        -->
        
    </select>
    <label for="filt_user">Filtrar:</label>
    <input id="filt_user" name="filt_user" type="text" /><input type="submit" value="Buscar" />
</form>
<table id="lista_users">
    <thead>
        <tr>
            <th>Codigo</th>
            <th>Nome Completo</th>
            <th>E-mail</th>
            <th>CPF</th>
            <th>Celular</th>
            <th>D. nascimento</th>
            <th class="botoes_tabela">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php
            require '../link1.php';
            
            $sql10 = "SELECT * FROM sch_usuarios";
            if(isset($_POST['filter_tipo'])){
                $tipoF = $_POST['filter_tipo'];
                $userF = $_POST['filt_user'];
                if($tipoF == 'all'){
                    $sql10 = "SELECT * FROM sch_usuarios WHERE ((nome LIKE '%$userF%') OR (email LIKE '%$userF%') OR (cpf LIKE '%$userF%') OR (celular LIKE '%$userF%') OR (telefone LIKE '%$userF%') OR (d_nascimento LIKE '%$userF%'))";
                    echo "<b>Usando filtro para Todos os Usuários</b>";
                }
                else if($tipoF == 'prof'){
                    $sql10 = "SELECT * FROM sch_usuarios WHERE (tipo BETWEEN 8 AND 15) AND ((nome LIKE '%$userF%') OR (email LIKE '%$userF%') OR (cpf LIKE '%$userF%') OR (celular LIKE '%$userF%') OR (telefone LIKE '%$userF%') OR (d_nascimento LIKE '%$userF%'))";
                    echo "<b>Usando filtro para Professores</b>"; 
                }
                else if($tipoF == 'aval'){
                    $sql10 = "SELECT * FROM sch_usuarios WHERE ((tipo BETWEEN 4 AND 7) OR (tipo BETWEEN 12 AND 15)) AND ((nome LIKE '%$userF%') OR (email LIKE '%$userF%') OR (cpf LIKE '%$userF%') OR (celular LIKE '%$userF%') OR (telefone LIKE '%$userF%') OR (d_nascimento LIKE '%$userF%'))";
                    echo "<b>Usando filtro para Avaliadores</b>";
                }
                else if($tipoF == 'orga'){
                    $sql10 = "SELECT * FROM sch_usuarios WHERE ((tipo BETWEEN 2 AND 3) OR (tipo BETWEEN 6 AND 7) OR (tipo BETWEEN 10 AND 11) OR (tipo BETWEEN 14 AND 15)) AND ((nome LIKE '%$userF%') OR (email LIKE '%$userF%') OR (cpf LIKE '%$userF%') OR (celular LIKE '%$userF%') OR (telefone LIKE '%$userF%') OR (d_nascimento LIKE '%$userF%'))";
                    echo "<b>Usando filtro para Organizadores</b>";
                }
                else if($tipoF == 'aluno'){
                    $sql10 = "SELECT * FROM sch_usuarios WHERE (tipo=1 OR tipo=3 OR tipo=5 OR tipo=7 OR tipo=9 OR tipo=11 OR tipo=13 OR tipo=15) AND ((nome LIKE '%$userF%') OR (email LIKE '%$userF%') OR (cpf LIKE '%$userF%') OR (celular LIKE '%$userF%') OR (telefone LIKE '%$userF%') OR (d_nascimento LIKE '%$userF%'))";
                    echo "<b>Usando filtro para Alunos</b>";
                }
            }
            $busca10 = $link1->query($sql10);
            while ($linha10 = $busca10->fetchAll(PDO::FETCH_ASSOC)) {
        ?>
        <tr>
            <td><?php echo $linha10['id'] ?></td>
            <td><?php echo $linha10['nome'] ?></td>
            <td><?php echo $linha10['email'] ?></td>
            <td><?php echo $linha10['cpf'] ?></td>
            <td><?php echo $linha10['celular'] ?></td>
            <td><?php
                if($linha10['d_nascimento'] != ''){
                    $token = explode("-", $linha10['d_nascimento']);
                    echo $token[2] . "/" .$token[1] . "/" . $token[0];
                }
                $tipo_usuario_bin = decbin($linha10['tipo']);
                while(strlen($tipo_usuario_bin)<4){
                    $tipo_usuario_bin = '0' . $tipo_usuario_bin;
                }
            ?></td>
            <td>
                <a href="index.php?add_user=<?php echo $linha10['id'] ?>"><img class="atualizar" title="Atualizar" src="../images/reflesh.png" /></a>
                <a href="javascript:deletarUser(<?php echo $linha10['id'] . "," . $tipo_usuario_bin[0] . "," . $tipo_usuario_bin[3] ?>);"><img class="excluir" title="Excluir" src="../images/excluir.png" /></a>
            </td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>