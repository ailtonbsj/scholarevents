<?php
    include '../link1.php';
    if(isset($_POST['modificar'])){
        $local = $_POST['local'];
        if($_POST['modificar'] == 'nao'){
            $sql14 = "INSERT INTO sch_locais (id,local) VALUES (NULL, '$local');";
        }
        else {
            $id = $_POST['id'];
            $sql14 = "UPDATE sch_locais SET local = '$local' WHERE id = $id;";
        }
        $busca14 = $link1->query($sql14);
        if(!$busca14){
            header("Location: index.php?error=9");
            exit;
        }
?>
<div class="ui-state-highlight ui-corner-all" style="margin: 10px 0; padding: 6px;">
<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
<strong>Operação realizada com sucesso!!!</strong>.</p>
</div>
<?php
    }
    if(isset($_GET['sucess'])){
?>
<div class="ui-state-highlight ui-corner-all" style="margin: 10px 0; padding: 6px;">
<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
<strong>Operação realizada com sucesso!!!</strong>.</p>
</div>
<?php  
    }
?>
<script type="text/javascript">
    function deletaLocal(local_url){
        if(confirm("Tem certeza que deseja deletar este local?")){
            window.location = "remove_u.php?lid=" + local_url;
        }
    }
    $(function(){
        altura = $(document).height();
        $("#corpo_principal").css('height',(altura-180)+'px');
        $("#corpo_principal").css('overflow-y','scroll');
    });
</script>
<form class="box_local" method="POST" action="index.php?list_local">
    <label>Adcionar Novo Local</label>
    <input type="text" name="local" />
    <input type="hidden" name="modificar" value="nao">
    <input type="submit" value="Inserir">
</form>
<?php
if(isset($_GET['list_local'])){
    if($_GET['list_local'] != ""){
?>
<form class="box_local" method="POST" action="index.php?list_local">
    <label>Modificar Local (ID:<?php echo $_GET['list_local'] ?>)</label>
    <input type="text" name="local" value="<?php echo $_GET['valor'] ?>" />
    <input type="hidden" name="modificar" value="sim">
    <input type="hidden" name="id" value="<?php echo $_GET['list_local'] ?>">
    <input type="submit" value="Modificar">
</form>
<?php
    }
 }
?>
<table id="lista_local">
    <thead>
        <tr>
            <th>Codigo</th>
            <th>Local</th>
            <th class="botoes_tabela">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php
            require '../link1.php';
            $sql13 = "SELECT * FROM sch_locais";
            $busca13 = $link1->query($sql13);
            foreach($busca13->fetchAll(PDO::FETCH_ASSOC) as $linha13) {
        ?>
        <tr>
            <td><?php echo $linha13['id'] ?></td>
            <td><?php echo $linha13['local'] ?></td>
            <td>
                <a href="index.php?list_local=<?php echo $linha13['id'] ?>&valor=<?php echo urlencode($linha13['local']) ?>"><img class="atualizar" title="Atualizar" src="../images/reflesh.png" /></a>
                <a href="javascript:deletaLocal(<?php echo $linha13['id'] ?>)"><img class="excluir" title="Excluir" src="../images/excluir.png" /></a>
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>
