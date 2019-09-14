<?php

$sqlWhatCert = "SELECT * FROM sch_images WHERE nome_img LIKE '%cer%'";
$buscaWc = $link1->query($sqlWhatCert);
if(!$buscaWc){
    echo "ERROR";
    exit;
}
$lnWc = $buscaWc->fetchAll(PDO::FETCH_ASSOC)[0];
$certImg = $lnWc['nome_img'];

$sqlCert = "SELECT * FROM sch_textos WHERE (id = 'cert0') OR (id = 'cert1') OR (id = 'cert2') OR (id = 'cert3') OR (id = 'cert4') OR (id = 'cert5') OR (id = 'cert6') OR (id = 'cert7')";
$buscaCert = $link1->query($sqlCert);
if(!$buscaCert){
    echo "ERROR";
    exit;
}
foreach($buscaCert->fetchAll(PDO::FETCH_ASSOC) as $lnCert){
    ${$lnCert['id']} = $lnCert['texto'];
}
?>
<script type="text/javascript">
var dadosCert = new Array();
function modifica(){
    $("#cert0,#cert1,#cert2,#cert3,#cert4,#cert5,#cert6").each(function(i){
        dadosCert[i] = ($(this).html()).toString();
    });
    
    $.ajax({
        "type":"POST",
        "url":"certificadoajax.php",
        "data":{
            "certn": dadosCert
        },
        "success":function(strup){
            stringRecebida = strup;
            if(stringRecebida == "SUCESS"){
                alert("Modificado com Sucesso!");
            }
            else{
                alert(stringRecebida);
            }
        },
        "error":function(jqxhr, msg, errthown){
            alert(msg);
        }
    });
}
$(function(){
    $(".cert-model-edit").each(function(){
        this.contentEditable = true;
    });
    $("#salvar-mod").click(function(){
        modifica();
    });
});
</script>
<div>
    <label>Enviar Imagem de fundo do Certificado</label>
    <form class="info_form" enctype="multipart/form-data" action="uploadimages.php" method="post">
        <input type="hidden" name="tipoupload" id="tipoupload" value="cert" />
        <div class="ui-state-highlight ui-corner-all" style="margin: 10px 0; padding: 6px;">
        <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
        <strong>Só é permitido imagem com extensão jpg ou png com dimensões menores ou igual a 1504 x 1129 pixeis.</strong></p>
        </div>
        Selecione a imagem: <input name="img_logoban" type="file" accept="image/jpeg, image/png, image/jpg"  />
        <input type="submit" value="Enviar" />
    </form>
</div>
<label>Edite o certificado:</label>
<div id="modelcert" style="background-image: url(../images/<?php echo $certImg ?>)">
    <div id="dadosmodel">
        <span name="cert0" id="cert0" class="cert-model-edit"><?php echo $cert0 ?></span>
        <span class="campo-cert-model">Fulano Felix Marcia Silva</span>
        <span name="cert1" id="cert1" class="cert-model-edit"><?php echo $cert1 ?></span>
        <span class="campo-cert-model">Evento Evento Evento Evento</span>
        <span name="cert2" id="cert2" class="cert-model-edit"><?php echo $cert2 ?></span>
        <span class="campo-cert-model">31/02/2050</span>
        <span name="cert3" id="cert3" class="cert-model-edit"><?php echo $cert3 ?></span>
        <span class="campo-cert-model">32/03/2050</span>
        <span name="cert4" id="cert4" class="cert-model-edit"><?php echo $cert4 ?></span>
        <span class="campo-cert-model">Curso Curso Curso Curso</span>
        <span name="cert5" id="cert5" class="cert-model-edit"><?php echo $cert5 ?></span>
        <span class="campo-cert-model">1000</span>
        <span name="cert6" id="cert6" class="cert-model-edit"><?php echo $cert6 ?></span>
    </div>
</div>
<div>
    <input id="salvar-mod" type="button" value="Salvar Modificações" />
    <a href="../geracert.php?teste" target="_blank"><input type="button" value="Visualizar PDF" /></a>
    <a href="../images/certmodel.png.zip" target="_blank"><input type="button" value="Baixar Modelo" /></a>
</div>