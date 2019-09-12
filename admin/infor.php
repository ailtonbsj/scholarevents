<?php

    include_once '../link1.php';
    
    if(isset($_GET['s'])){
        if($_GET['s'] == "inativo"){
            $dtm = "ativo";
        }else{
            $dtm = "inativo";
            
        }
        $sqlmanu = "UPDATE sch_textos SET texto = '". $dtm ."' WHERE id = 'manutencao'";
        
        $buscamanu = $link1->query($sqlmanu);
        if(!$buscamanu){
            $manuf = "sim";
        }
        else{
            $manuf = "nao";
        }
    }
    
    $sqlTexto = "SELECT * FROM sch_textos";
    $buscaTexto = $link1->query($sqlTexto);
    $titulo_site = "";
    $html1 = "";
    $html2 = "";
    foreach($buscaTexto->fetchAll(PDO::FETCH_ASSOC) as $linhaTexto){
        switch ($linhaTexto['id']){
            case "titulo":
                $titulo_site = $linhaTexto['texto'];
                break;
            case "html1":
                $html1 = $linhaTexto['texto'];
                break;
            case "html2":
                $html2 = $linhaTexto['texto'];
                break;
            case "sobre":
                $sobre_event = $linhaTexto['texto'];
                break;
            case "manutencao":
                $statusmanu = $linhaTexto['texto'];
                break;
        }
    }
    
    $sqlMenuMais = "SELECT * FROM sch_menu_mais";
    $buscaMenuMais = $link1->query($sqlMenuMais);
    
    $sqlLogoPrincipal = "SELECT * FROM sch_images WHERE nome_img LIKE '%log%'";
    $buscaLogoPrincipal = $link1->query($sqlLogoPrincipal);
    $linhaLogoPrincipal = $buscaLogoPrincipal->fetchAll(PDO::FETCH_ASSOC)[0];
    $imgLogoPrincipal = $linhaLogoPrincipal['nome_img'];
    if(!file_exists("../images/" . $imgLogoPrincipal)){
        $imgLogoPrincipal = "logo.png";
    }
    
    $sqlBanPrincipal = "SELECT * FROM sch_images WHERE nome_img LIKE '%ban%'";
    $buscaBanPrincipal = $link1->query($sqlBanPrincipal);
    
    if(isset($_GET['sucess'])){
?>
<div class="ui-state-highlight ui-corner-all" style="margin: 10px 0; padding: 6px;">
<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
<strong>Operação realizada com sucesso!!!</strong>.</p>
</div>
<?php
    }
    if(isset($manuf)){
        if($manuf == "sim"){
?>
<div class="ui-state-highlight ui-corner-all" style="margin: 10px 0; padding: 6px;">
<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
<strong>Error!!!</strong>.</p>
</div>
<?php
        }else{
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
function deletarMenuMais(obj){
    if(confirm("Tem certeza que deseja deletar link?")) window.location = "remove_u.php?linkid=" + obj;
}
function mostraImgBanner(nomeImg){
    $("#info_banner").attr("src","../images/"+nomeImg);
}
function deletarImgBanner(idImg){
    if(confirm("Você deseja remover esse banner???")) window.location = "remove_u.php?bannerid=" + idImg;
}
function chamarAjax(DLabel,DdataTime){
    $.ajax({
            "type":"POST",
            "url":"datasdoevento.php",
            "data":{
                "label":DLabel,
                "data":DdataTime
            },
            "success":function(stringRecebida){
                alert(stringRecebida);
                $(".btmodific").show();
            },
            "error":function(jqxhr, msg, errthown){
                alert(msg);
            }
            });
}

$(function(){
    
    $(".tipodataini").datepicker({dateFormat: "dd/mm/yy 05:00:00"});
    $(".tipodatafin").datepicker({dateFormat: "dd/mm/yy 23:30:00"});
    $(".tipodataini, .tipodatafin").css("display","inline");
    $(".btmodific").css("margin-top","0");
    $("#beventoinicio").click(function(){
        $(".btmodific").hide();
        chamarAjax("Evento:Inicio",$("#deventoinicio").val());
    });
    $("#beventofim").click(function(){
        $(".btmodific").hide();
        chamarAjax("Evento:Fim",$("#deventofim").val());
    });
    $("#binscricaoonlineinicio").click(function(){
        $(".btmodific").hide();
        chamarAjax("InscricaoOnline:Inicio",$("#dinscricaoonlineinicio").val());
    });
    $("#binscricaoonlinefim").click(function(){
        $(".btmodific").hide();
        chamarAjax("InscricaoOnline:Fim",$("#dinscricaoonlinefim").val());
    });
    $("#bblockescolha").click(function(){
        $(".btmodific").hide();
        chamarAjax("BloqueioCursos",$("#dblockescolha").val());
    });
    
    //sendkey
    $("#sendkey").click(function(){
        if($("#keynow1").val() == ""){
            alert("Campo de senha em branco!");
            $("#keynow1").focus();
            return false;
        }
        if($("#keynew1").val() == ""){
            alert("Campo de senha em branco!");
            $("#keynew1").focus();
            return false;
        }
        if($("#keynew1").val() != $("#keynew2").val()){
            alert("As senhas não são iguais!!!");
            $("#keynew1").val("");
            $("#keynew1").focus();
            $("#keynew2").val("");
            return false;
        }
        var ser = $("#alterkeyadmin").serializeArray();
        $.ajax({
            "type":"POST",
            "url":"modifykeydata.php",
            "data":ser,
            "success":function(stringRecebida){
                if(stringRecebida == "INCORRECT"){
                    alert("Campo senha atual incorreto!");
                }
                else if(stringRecebida == "SUCESS"){
                    alert("Senha alterada com sucesso!!!");
                }
                else if(stringRecebida == "ERROR"){
                    alert("Error de conexao!!!");
                }
            },
            "error":function(jqxhr, msg, errthown){
                alert(msg);
            }
            });
        
    });
    
    $("#manusite").click(function(){
        var status = $(this).attr("alt");
        window.location = "?infor=manu&s=" + status;
    });
    
});

</script>
<?php
$infor = $_GET['infor'];
if($infor == "init"){
?>
<form method="POST" action="atualiza_inform.php">
<label>Titulo do site</label>
<input type="text" name="info_titulo" id="info_titulo" class="info_campo_entrada" value="<?php echo $titulo_site ?>" />
<input type="submit" id="info_campo_salvar" value="Salvar" />
<div style="clear: both;"></div>
</form>

<label>Logo</label>
<form class="info_form" enctype="multipart/form-data" action="uploadimages.php" method="post">
    <input type="hidden" name="tipoupload" id="tipoupload" value="logo" />
    <div id="logo_image_view">
        <img src="../images/<?php echo $imgLogoPrincipal ?>" class="info_logo" />
    </div>
    <div id="logo_botoes">
        <div class="ui-state-highlight ui-corner-all" style="margin: 10px 0; padding: 6px;">
        <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
        <strong>Só é permitido imagem com extensão jpg ou png com dimensões menores ou igual a 147x131 pixeis.</strong></p>
        </div>
        Selecione uma imagem: <input type="file" name="img_logoban" accept="image/jpeg, image/png, image/jpg"  />
        <input type="submit" value="Modificar" id="info_campo_salvar" />
    </div>
    <div style="clear: both;"></div>
    
    
    
</form>

<label>Banner</label>
<form class="info_form" enctype="multipart/form-data" action="uploadimages.php" method="post">
    <input type="hidden" name="tipoupload" id="tipoupload" value="ban" />
    <div id="sis_banner">
        <div>
            <table border="1">
                <thead>
                    <tr>
                       <th>Lista de Imagens do banner</th>
                       <th id="info_banner_exlcuir"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $urlImg = "banner.png";
                    foreach($buscaBanPrincipal->fetchAll(PDO::FETCH_ASSOC) as $linhaBanPrincipal){
                        $urlImg = $linhaBanPrincipal['nome_img'];
                    ?>
                    <tr>
                        <td onmousemove="mostraImgBanner('<?php echo $linhaBanPrincipal['nome_img'] ?>')"><?php echo $linhaBanPrincipal['nome_img'] ?></td>
                        <td><a href="javascript:deletarImgBanner('<?php echo $linhaBanPrincipal['nome_img'] ?>');"><img class="excluir" title="Excluir" src="../images/excluir.png" /></a></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

        </div>
        <div>
            <img src="../images/<?php echo $urlImg ?>" id="info_banner" />
        </div>
    </div>
    <div style="clear: both;"></div>
    <div class="ui-state-highlight ui-corner-all" style="margin: 10px 0; padding: 6px;">
    <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
    <strong>Só são permitidos imagens com extensão jpg ou png com dimensões menores ou igual a 550x170 pixeis.</strong></p>
    </div>
    Adicionar uma Imagem: <input type="file" name="img_logoban" accept="image/jpeg, image/png, image/jpg"  />
    <input type="submit" value="Upload" id="info_campo_salvar" />
    <div style="clear: both;"></div>
</form>

<form method="POST" action="atualiza_inform.php">
<label>Sobre o evento</label>
<textarea name="sobre" id="sobre" class="info_campo_entrada"><?php echo $sobre_event ?></textarea>
<input type="submit" value="Salvar" id="info_campo_salvar" />
<div style="clear: both;"></div>
</form>

<form method="POST" action="atualiza_inform.php">
<label>HTML 1</label>
<textarea name="html1" id="html1" class="info_campo_entrada"><?php echo $html1 ?></textarea>
<input type="submit" value="Salvar" id="info_campo_salvar" />
<div style="clear: both;"></div>
</form>

<form method="POST" action="atualiza_inform.php">
<label>HTML 2</label>
<textarea name="html2" id="html2" class="info_campo_entrada"><?php echo $html2 ?></textarea>
<input type="submit" value="Salvar" id="info_campo_salvar" />
<div style="clear: both;"></div>
</form>

<label>Links do menu Mais</label>
<div class="info_form">
<div id="tabela_mais_links">
    <table border="1">
        <thead>
            <tr>
               <th>Lista de Links</th>
               <th id="info_banner_exlcuir"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($buscaMenuMais->fetchAll(PDO::FETCH_ASSOC) as $linhaMenuMais){
            ?>
            <tr>
                <td><a href="<?php echo $linhaMenuMais['url'] ?>"><?php echo $linhaMenuMais['nome_link'] ?></a></td>
                <td><a href="javascript:deletarMenuMais('<?php echo $linhaMenuMais['nome_link'] ?>');"><img class="excluir" title="Excluir" src="../images/excluir.png" /></a></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<div id="formulario_mais_links">
    <form method="POST" action="atualiza_inform.php">
    <label>Titulo do Link</label>
    <input type="text" name="nome_link" id="nome_link" />
    <label>Url</label><input type="text" name="url_link" id="url_link" />
    <input type="submit" value="Adicionar" />
    </form>
</div>
<div style="clear: both;"></div>
</div>
<?php
}
elseif($infor == "datas"){
?>
<label>Datas do Evento</label>
<div class="info_form">
<?php

    function converteData($datasql){
        $arrayDatas = explode(" ", $datasql);
        $arrayYear = explode("-",$arrayDatas[0]);
        return $arrayYear[2] . "/" . $arrayYear[1] . "/" . $arrayYear[0] . " " . $arrayDatas[1];
    }

    $sqlData = "SELECT * FROM sch_datas WHERE label = 'Evento:FIM' OR label = 'Evento:Inicio' OR label = 'InscricaoOnline:Fim' OR label = 'InscricaoOnline:Inicio' OR label = 'BloqueioCursos'";
    $busca = mysql_query($sqlData,$link1);
    while($linha = mysql_fetch_assoc($busca)){
        switch ($linha['label']){
            case "Evento:Inicio":
                $eventoInicio = converteData($linha['data']);
                break;
            case "Evento:Fim":
                $eventoFim = converteData($linha['data']);
                break;
            case "InscricaoOnline:Fim":
                $InscricaoOnlineFim = converteData($linha['data']);
                break;
            case "InscricaoOnline:Inicio":
                $InscricaoOnlineInicio = converteData($linha['data']);
                break;
            case "BloqueioCursos":
                $BloqueioCursos = converteData($linha['data']);
                break;
        }
    }
    
?>
    <label>Data inicial do Evento</label>
    <input type="text" class="tipodataini" id="deventoinicio" value="<?php echo $eventoInicio ?>" />
    <input type="button" class="btmodific" id="beventoinicio" value="Modificar" />
    <label>Data final do Evento</label>
    <input type="text" class="tipodatafin" id="deventofim" value="<?php echo $eventoFim ?>" />
    <input type="button" class="btmodific" id="beventofim" value="Modificar" />
    <label>Data inicial das inscrições online</label>
    <input type="text" class="tipodataini" id="dinscricaoonlineinicio" value="<?php echo $InscricaoOnlineInicio ?>" />
    <input type="button" class="btmodific" id="binscricaoonlineinicio" value="Modificar" />
    <label>Data final das inscrições online</label>
    <input type="text" class="tipodatafin" id="dinscricaoonlinefim" value="<?php echo $InscricaoOnlineFim ?>" />
    <input type="button" class="btmodific" id="binscricaoonlinefim" value="Modificar" />
    <label>Data de bloqueio de escolha de cursos/palesras</label>
    <input type="text" class="tipodatafin" id="dblockescolha" value="<?php echo $BloqueioCursos ?>" />
    <input type="button" class="btmodific" id="bblockescolha" value="Modificar" />
    
</div>
<script type="text/javascript">
$(function(){
    altura = $(document).height();
    $("#corpo_principal").css('height',(altura-180)+'px');
});
</script>
<?php
}
elseif($infor == "manu"){
?>
<div class="info_form">
<label>Sistema em manutenção (site off-line): 
    <?php
    if($statusmanu == "ativo"){
    ?>
    <span style="color: #cd0a0a; font-weight: bold;">ATIVO!</span>
    <?php
    }else{
    ?>
    <span style="color: #66AA00; font-weight: bold;">DESATIVO!</span>
    <?php
    }
    ?>
</label>
<input type="button" class="btmodific" id="manusite" value="Modificar" alt="<?php echo $statusmanu ?>" />
</div>

<label>Alterar Senha de Administrador</label>
<div class="info_form">
    <form id="alterkeyadmin" onsubmit="">
    <label>Digite a senha atual</label>
    <input type="password" id="keynow1" name="keynow1" value="" maxlength="12" />
    
    <label>Digite a nova senha</label>
    <input type="password" id="keynew1" name="keynew1" value="" maxlength="12" />
    
    <label>Digite novamente a nova senha</label>
    <input type="password" id="keynew2" name="keynew2" value="" maxlength="12" />
    
    <input type="button" id="sendkey" value="Modificar" />
    </form>
    
</div>
<script type="text/javascript">
$(function(){
    altura = $(document).height();
    $("#corpo_principal").css('height',(altura-180)+'px');
});
</script>
<?php
}
?>