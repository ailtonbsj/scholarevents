<?php
if(isset($_GET['sucess'])){
    if($_GET['sucess'] == '1'){
?>
<script type="text/javascript">
    $(function(){
        alert("Evento adicionado com Sucesso!!! Agora você já pode adicionar o logo do subevento e anexos!!!");
    });
</script>
<?php
    }
    if($_GET['sucess'] == '2'){
?>
<div class="ui-state-highlight ui-corner-all" style="margin: 10px 0; padding: 6px;">
<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
<strong>Operação realizada com sucesso!!!</strong>.</p>
</div>
<?php 
    }
}
?>
<form action="novosub_script.php" method="POST">
<?php

require '../link1.php';

$titulo = "";
$descricao = "";
$platformSub = "minicurso";
$pagoSub = false;
$certSub = false;

$novoSubEv = $_GET['novosub'];
if($novoSubEv == ""){
?>
    <script type="text/javascript">
    $(function(){
        altura = $(document).height();
        $("#corpo_principal").css('height',(altura-180)+'px');
        
    });
    </script>
    <input type="hidden" name="idsubev" id="idsubev" value="new" />
<?php
}
else{
    $sqlSubEvento = "SELECT * FROM sch_subeventos WHERE id = '$novoSubEv'";
    $buscaSubEvento = $link1->query($sqlSubEvento);
    if(!$buscaSubEvento){
        echo "erro3";
        exit;
    }
    $linhaSubEv = $buscaSubEvento->fetchAll(PDO::FETCH_ASSOC)[0];
    $idsubev = $linhaSubEv['id'];
    $titulo = $linhaSubEv['titulo'];
    $platformSub = $linhaSubEv['plataforma'];
    $descricao = $linhaSubEv['descricao'];
    $logo = $linhaSubEv['logo'];
    $inform = $linhaSubEv['inform'];
    $pagoSub = ($inform[0] == 'T') ? true:false;
    $certSub = ($inform[1] == 'T') ? true:false;
?>
    <input type="hidden" name="idsubev" id="idsubev" value="<?php echo $novoSubEv; ?>" />
<?php
}
?>
<label>Titulo do Subevento</label>
<input type="text" name="titulo_subev" id="titulo_subev" class="info_campo_entrada" value="<?php echo $titulo ?>" />

<label>Tipo da plataforma online do Subevento</label>
<div class="info_form">
    <script type="text/javascript">
    $(function(){
        $("#botao_gerenciar").click(function(){
            var tipo = '<?php echo $platformSub ?>';
            var plataforma = 'null';
            switch(tipo){
                case 'minicurso':
                    plataforma = 'pt=minicurso&gerenciar';
                    break;
                case 'palestra':
                    plataforma = 'pt=palestra&gerenciar';
                    break;
                case 'visita':
                    plataforma = 'pt=visita&gerenciar';
                    break;
                case 'simposio':
                    plataforma = 'platform2';
                    break;
                case 'competicao':
                    plataforma = 'platform3';
                    break;
            }
            window.location = "index.php?"+ plataforma +"=<?php echo $novoSubEv; ?>";
        });
        
        $("#removesub").click(function(){
            if(confirm("CUIDADO! Isso irá deletar todos os dados desse subevento!")){
                if(confirm("Você tem certeza???")){
                    var idsub = $(this).attr('alt');
                    window.location = "removesubev.php?sid="+idsub;
                }
            }
        });
    });
    </script>
<?php
$nomeDaPlatForm = "";
switch ($platformSub){
    case "minicurso":
        $nomeDaPlatForm = "Sistema de Minicursos";
        break;
    case "palestra":
        $nomeDaPlatForm = "Sistema de Palestras";
        break;
    case "visita":
        $nomeDaPlatForm = "Sistema de Visitas Técnicas";
        break;
    case "competicao":
        $nomeDaPlatForm = "Sistema de Gerenciamento de Competições";
        break;
    case "simposio":
        $nomeDaPlatForm = "Sistema de Artigos para Simpósio";
        break;
        
}
if($novoSubEv != ""){
    echo "Tipo de Plataforma: " . $nomeDaPlatForm;
    echo "<input id=\"botao_gerenciar\" type=\"button\" value=\"Clique para gerenciar a Plataforma.\" />";
    echo "<div style='display:none'>";
}
else {
    echo "<div>";
}
?>
    <input type="radio" name="radio_platform" id="radio_platform" value="minicurso" class="check_user"<?php if($platformSub == 'minicurso'){ echo ' checked="checked"';} ?>> Minicursos<br />
    <input type="radio" name="radio_platform" id="radio_platform" value="palestra" class="check_user"<?php if($platformSub == 'palestra'){ echo ' checked="checked"';} ?>> Palestras<br />
    <input type="radio" name="radio_platform" id="radio_platform" value="visita" class="check_user"<?php if($platformSub == 'visita'){ echo ' checked="checked"';} ?>> Visitas Tecnicas<br />
    <!--
    <input type="radio" name="radio_platform" id="radio_platform" disabled="disabled" value="simposio" class="check_user"<?php if($platformSub == 'simposio'){ echo ' checked="checked"';} ?>> Simpósio (publicação de artigos)<br />
    <input type="radio" name="radio_platform" id="radio_platform" disabled="disabled" value="competicao" class="check_user"<?php if($platformSub == 'competicao'){ echo ' checked="checked"';} ?>> Competições<br />
    -->
<?php
echo "</div>";
?>
</div>

<label>Descrição do subevento</label>
<textarea name="desc_subev" id="desc_subev" class="info_campo_entrada"><?php echo $descricao; ?></textarea>


<label style="display: none;">Informações diversas</label>
<div class="info_form"  style="display: none;">
    <input type="checkbox" name="sub_pago" id="sub_pago" class="check_user" value="sim"<?php if($pagoSub) echo ' checked="checked"'; ?>> Inscrição para subevento pago.<br />
    <input type="checkbox" name="sub_cert" id="sub_cert" class="check_user" value="sim"<?php if($certSub) echo ' checked="checked"'; ?>> Emitir Certificado para usuários no final do evento.
</div>

<div style="clear: both;"></div>
<?php
if($novoSubEv == ""){
?>
<input type="submit" id="salvar" value="Criar Novo Subevento!" />
<?php
}
else{
?>
<a name="anchor1"></a>
<input type="submit" id="salvar" value="Atualizar Dados!" />
<?php
}
?>
</form>

<?php
if($novoSubEv != ""){
?>

<label>Logo do subevento</label>
<form action="uploadsublogos.php" enctype="multipart/form-data" method="post" class="info_form">
    <input type="hidden" name="idsubev" id="idsubev" value="<?php echo $idsubev ?>" />
    <div id="logo_image_view">
        <img src="../images/<?php echo $logo ?>" class="info_logo" />
    </div>
    <div id="logo_botoes">
        <div class="ui-state-highlight ui-corner-all" style="margin: 10px 0; padding: 6px;">
        <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
        <strong>Só é permitido imagem com extensão jpg ou png com dimensões menores ou igual a 155x155 pixeis.</strong></p>
        </div>
        Selecione uma imagem: <input type="file" name="img_logsubev" accept="image/jpeg, image/png, image/jpg"  />
        <input type="submit" value="Modificar" id="info_campo_salvar" />
    </div>
    <div style="clear: both;"></div>
</form>

<label>Arquivos Anexos</label>
<script type="text/javascript">
    function deleteAnexo(id){
        if(confirm("Tem certeza que deseja deletar anexo?")) window.location = "remove_anexo.php?subev=<?php echo $idsubev ?>&idanexo=" + id;
    }
</script>
<div class="info_form">
<div id="tabela_mais_links">
    <table border="1">
        <thead>
            <tr>
               <th>Lista de anexos</th>
               <th></th>
               <th id="info_banner_exlcuir"></th>
            </tr>
        </thead>
        <tbody>
<?php
$sqlBuscaAnexos = "SELECT * FROM sch_anexos WHERE id_subev='$idsubev'";
$buscaAnexos = $link1->query($sqlBuscaAnexos);

foreach($buscaAnexos->fetchAll(PDO::FETCH_ASSOC) as $linhaAnexos){
?>
            <tr>
                <td><?php echo $linhaAnexos['descricao'] ?></td>
                <td><a href="../anexos/<?php echo $linhaAnexos['id_anexo'] ?>">Abrir</a></td>
                <td><a href="javascript:deleteAnexo('<?php echo $linhaAnexos['id_anexo'] ?>');"><img class="excluir" title="Excluir" src="../images/excluir.png" /></a></td>
            </tr>
<?php
}
?>
        </tbody>
    </table>
</div>
<div id="formulario_mais_links">
    <form method="post" action="uploadanexo.php" enctype="multipart/form-data">
    <input type="hidden" name="idsubev" id="idsubev" value="<?php echo $idsubev ?>" />
    <label>Titulo do novo Anexo</label>
    <input type="text" name="descricao_anexo" id="descricao_anexo" />
    <label>Selecione o arquivo:</label> <input type="file" name="file_anexo" id="file_anexo" accept=""  />
    <div class="ui-state-highlight ui-corner-all" style="margin: 10px 0; padding: 6px;">
    <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
    <strong>Só é permitido arquivo com extensão pdf ou docx menores do que 5MB.</strong></p>
    </div>
    <input type="submit" value="Adicionar" />
    </form>
</div>
<div style="clear: both;"></div>
</div>
<div>
    <input type="button" id="removesub" alt='<?php echo $idsubev ?>' value="Remover Subevento" style="margin: 0 auto; display: block; background-color: darkred; color: white;" />
</div>
<?php
}
?>