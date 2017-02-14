<?php
require_once '../link1.php';
$sqlThme = "SELECT * FROM sch_temas";
$buscaTheme = mysql_query($sqlThme,$link1);
if(!$buscaTheme){
    echo "ERROR";
    exit;
}
?>
<script type="text/javascript">
var temas = new Array();
function modifyTheme(){
    var dados = $("#formtheme").serializeArray();
    $.ajax({
        "type":"POST",
        "url":"temaajax.php",
        "data":{
            "id":dados
        },
        "success":function(strup){
            alert(strup);
            if(strup == "SUCCESS"){
                window.location = "index.php?tema";
            }
        },
        "error":function(jqxhr, msg, errthown){
            alert(msg);
        }
    });
}

function selectCores(){
    id = $("#idtheme").val();
    $("#cor1").val(temas[id][0]);
    $("#cor2").val(temas[id][1]);
    $("#cor3").val(temas[id][2]);
    $("#cor4").val(temas[id][3]);
    $("#cor5").val(temas[id][4]);
    $("#cor6").val(temas[id][5]);
    $("#cor1,#cor2,#cor3,#cor4,#cor5,#cor6").spectrum({
        showInitial: true,
        showInput: true
    });
}

$(function(){
    <?php
    $sqlThme2 = "SELECT * FROM sch_temas";
    $buscaTheme2 = mysql_query($sqlThme2,$link1);
    if(!$buscaTheme2){
        echo "ERROR";
        exit;
    }
    while($lnTh2 = mysql_fetch_assoc($buscaTheme2)){
        echo "temas['". $lnTh2['id'] ."'] = new Array('". $lnTh2['cor1'] ."','". $lnTh2['cor2'] ."','". $lnTh2['cor3'] ."','". $lnTh2['cor4'] ."','". $lnTh2['cor5'] ."','". $lnTh2['cor6'] ."');\n";
    }
    ?>
    $("#bt-add").click(modifyTheme);
    $("#idtheme").change(function(){
        selectCores();
    });
    selectCores();
});
</script>
<label>Escolha o tema</label>
<form id="formtheme" name="formtheme">
<select id="idtheme" name="idtheme">
    <?php
        while($lnTh = mysql_fetch_assoc($buscaTheme)){
            echo "<option alt='". $lnTh['block'] ."' value=\"". $lnTh['id'] ."\"".  (($lnTh['ativo'] == "T")?(" selected='selected'"):("")) .">". $lnTh['id'] ."</option>";
        }
    ?>
</select>
<div id="cores-theme">
    <div id="div-cor1">
        <input type="text" id="cor1" name="cor1" />
    </div>
    <div id="div-cor2">
        
        <input type="text" id="cor2" name="cor2" />
    </div>
    <div id="div-cor3">
        
        <input type="text" id="cor3" name="cor3" />
    </div>
    <div id="div-cor4">
        
        <input type="text" id="cor4" name="cor4" />
    </div>
    <div id="div-cor5">
        
        <input type="text" id="cor5" name="cor5" />
    </div>
    <div id="div-cor6">
        
        <input type="text" id="cor6" name="cor6" />
    </div>
</div>
<div style='clear: both;'></div>
</form>
<div><input type="button" id="bt-add" name="bt-add" value="Modificar" /></div>
<label>Visualização</label>
<div id="frame-view">
    <iframe src="../index.php" style="width:100%;height: 400px;"></iframe>
</div>