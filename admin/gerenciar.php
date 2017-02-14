<!-- AREA DO PHP -->

<?php
$subevento = $_GET['gerenciar'];
$pt = $_GET['pt'];

function captaData($capd){
    $tk = explode(" ",$capd);
    return explode("-",$tk[0]);
}
$EvIni;
$EvFim;
$sqldt = "SELECT * FROM sch_datas WHERE label = 'Evento:Inicio' OR label = 'Evento:Fim'";
$busca = mysql_query($sqldt);
while ($linhadt = mysql_fetch_assoc($busca)){
    switch ($linhadt['label']){
        case "Evento:Inicio":
            $EvIni = captaData($linhadt['data']);
            break;
        case "Evento:Fim":
            $EvFim = captaData($linhadt['data']);
            break;
    }
}
?>

<!-- AREA DO JAVASCRIPT -->

<script type="text/javascript">

estadoAtual = 1;
total_inscritos = -1;

//Função Principal MAIN
$(function(){
    
    //codigo de Configuração de Telas
    
    $("#waitdiv").hide(); //oculta DIV de espera
    $("#add_novo_spacetime").hide(); //oculta Botao AddNovoSpaceTime
    $("#add_novo_acontecimento").hide(); //oculta Tela de Novo Acontecimento
    $("#gen_novo_show").click(alternarEntreTelas); //listener em botão para alterar entre as telas
    $("#bt_filtrar_acon").click(carregaAcontecWithFilter); //listener em botao para filtrar lista de acontecimentos

    // $("#add_novo_spacetime").click(adicionaNovoHorario); //listener em botão para adicionar novo horario
    
    carregaAcontecimentos(); // carrega lista Acontecimentos
    atualizaListaLocaisAndProfessores(); //carrega a lista de professores e locais
    setDateTimePicker(); //ativa DatePicker e TimmePicker!
    setDialogBox(); //Configura a caixa de Dialogo Padrao
    
    //codigo de Adicao de acontecimento
    $("#submit_new_acon").click(insertUpdateAcontecimento); //listener em botão AdcionarNovoEvento
    $("#botao_more_prof").click(addNovoProfessor); //listener em botao Adcionar Professor
    $("#add_novo_spacetime").click(adicionaNovoHorario); //Listener em botao AdcionaHorario
    
});

function alternarEntreTelas(){
    if(estadoAtual == 1){ //muda de Tela Lista --> Adicionar
        estadoAtual = 2;
        total_inscritos = -1;
        $("#show_acontecimentos").hide();
        $("#add_novo_acontecimento").fadeIn(1000);
        $("#gen_novo_show").val("Mostrar Lista");
        limpaCamposAcontec();
    }
    else{ //muda de Tela Adicionar --> Lista
        estadoAtual = 1;
        $("#add_novo_acontecimento").hide();
        $("#show_acontecimentos").fadeIn(1000);
        $("#gen_novo_show").val("Adicionar Novo");
    }
}

function limpaCamposAcontec(){
    $("#id_acon, #titulo_acon, #desc_acon, #totalvagas_acon").val("");
    $("#sub_pago").prop("checked",false);
    $("#prof_hora").hide();
    $("#submit_new_acon").val("Adicionar");
    $("#acontecimentos_prof div").remove();
    $("#lista_horarios tbody").remove();
    $("#lista_horarios thead").after("<tbody><tr></tr></tbody>");
}

function atualizaListaProfessores(){
    $.ajax({
            "type":"POST",
            "url":"busca_profe_local.php",
            "data":{
                "tipo":"professor"
            },
            "success":function(stringRecebida){
                linhasProf = stringRecebida.split("\"");
                if(linhasProf[0] == "SUCESS"){
                    for(i=1;i<linhasProf.length-1;i++){
                        campoProf = linhasProf[i].split("'");
                        var linha = "<option value='"+ campoProf[0] +"'>" + campoProf[1] +" ( "+ campoProf[2] +" )</option>";
                        $("#professores_list").append(linha);
                    }
                    $("#waitdiv_prof").hide();
                }
            },
            "error":function(jqxhr, msg, errthown){
                alert(msg);
                $("#waitdiv_prof").hide();
            }
            });
}

function atualizaListaLocaisAndProfessores(){
    $.ajax({
        "type":"POST",
        "url":"busca_profe_local.php",
        "data":{
                "tipo":"local"
        },
        "success":function(stringRecebida){
                linhasLocal = stringRecebida.split("\"");
                if(linhasLocal[0] == "SUCESS"){
                    for(i=1;i<linhasLocal.length-1;i++){
                        campoLocal = linhasLocal[i].split("'");
                        var linha = "<option value='"+ campoLocal[0] +"'>" + campoLocal[1] +"</option>";
                        $("#list_local_spacetime").append(linha);
                    }
                    $("#waitdiv_horario").hide();
                    $("#add_novo_spacetime").show();
                }
                atualizaListaProfessores();
        },
        "error":function(jqxhr, msg, errthown){
                alert(msg);
                $("#waitdiv_horario").hide();
        }
    });
}

function carregaAcontecimentos(filtroBusca){
    if(filtroBusca == undefined){
        filtroBusca = "";
    }
    $("#waitdivtable").show();
    $.ajax({
            "type":"POST",
            "url":"busca_acontecimento.php",
            "data":{
                "subevent":$("#id_subevent").val(),
                "filtro":filtroBusca
            },
            "success":function(stringRecebida){
                pt='<?php echo $pt ?>';
                if(pt != "palestra"){
                    pt = 3;
                }
                else {
                    pt = 4;
                }
                linhasAcon = stringRecebida.split("\"");
                if(linhasAcon[0] == "SUCESS"){
                    $("#lista_acontecimentos tbody").remove();
                    $("#lista_acontecimentos").append("<tbody></tbody>");
                    for(i=1;i<linhasAcon.length-1;i++){
                        campoAcon = linhasAcon[i].split("'");
                        var linha = "<tr title=\"DESCRIÇÃO: "+campoAcon[4]+"\"><td>"+campoAcon[1]+"</td><td>"+campoAcon[2]+"</td><td>"+campoAcon[pt]+"</td><td>"; //+campoAcon[5]+"</td><td>";
                        linha += "<a href=\"javascript:atualizaAcon("+ i +")\"><img class=\"bttool\" title=\"atualizar\" src=\"../images/reflesh.png\" /></a>";
                        linha += "<a href=\"javascript:deleteAcon('"+campoAcon[0]+"','"+campoAcon[pt]+"');\"><img class=\"bttool\" title=\"deletar\" src=\"../images/close.png\" /></a>";
                        linha += "</td></tr>";
                        $("#lista_acontecimentos").append(linha);
                    }
                    $("#lista_acontecimentos tbody tr:even").css('background','white');
                }
                $("#waitdivtable").hide();
            },
            "error":function(jqxhr, msg, errthown){
                alert(msg);
            }
            });
}

function carregaAcontecWithFilter(){
    var filtro = $("#input_busca_acon").val();
    carregaAcontecimentos(filtro);
}

function setDateTimePicker(){
    $('#add_moment_init, #add_moment_ends').timepicker({
                                                timeFormat: "HH:mm:ss",
                                                hourMin: 6,
                                                hourMax: 23,
                                                hourGrid: 2,
                                                minuteGrid: 7,
                                                showSecond: false,
                                                currentText: 'Hora atual',
                                                closeText: 'Fechar'
                                            });
     var minD = new Date(0);
     minD.setDate(<?php echo $EvIni[2] ?>);
     minD.setMonth(<?php echo $EvIni[1]-1 ?>);
     minD.setYear(<?php echo $EvIni[0] ?>);
     var maxD = new Date(0);
     maxD.setDate(<?php echo $EvFim[2] ?>);
     maxD.setMonth(<?php echo $EvFim[1]-1 ?>);
     maxD.setYear(<?php echo $EvFim[0] ?>);
     $("#add_date_spacetime").datepicker({
         dateFormat: "dd/mm/yy",
         minDate: minD,
         maxDate: maxD
     });
}

function setDialogBox(){
    $( "#dialogbox").dialog({
        resizable: false,
        autoOpen: false,
        height:300,
        width:500,
        modal: true,
        buttons: {
                "Ok": function() {
                        $( this ).dialog( "close" );
                }
        }
    });
}

function showDialogBox(text){
    $("#dialogbox p").remove();
    $("#dialogbox").append("<p>"+text+"</p>");
    $("#dialogbox").dialog("open");
}

function insertUpdateAcontecimento(){
        if(validaCamposAcontec()){
            $.ajax({
            "type":"POST",
            "url":"novo_acontecimento.php",
            "data":{
                "id":$("#id_acon").val(),
                "subevent":$("#id_subevent").val(),
                "titulo":$("#titulo_acon").val(),
                "descricao":$("#desc_acon").val(),
                "totalvagas":$("#totalvagas_acon").val(),
                "pago":document.getElementById("sub_pago").checked
            },
            "success":function(stringRecebida){
                comandos = stringRecebida.split(",");
                if(comandos[0] == "SUCESS_INSERT" || comandos[0] == "SUCESS_UPDATE"){
                    $("#id_acon").val(comandos[1]);
                    $("#prof_hora").fadeIn(1000);
                    $("#submit_new_acon").val("Atualizar informações");
                    carregaAcontecimentos();
                }
                switch(comandos[0]){
                    case "INVALID_FIELDS":
                        showDialogBox("Existe algum campo com dados invalidos ou em branco.");
                        break;
                    case "SUCESS_INSERT":
                        showDialogBox("Dados salvos com sucesso!!!<br />Configure agora os professores e horário.");
                        break;
                    case "SUCESS_UPDATE":
                        showDialogBox("Dados salvos com sucesso!!!<br />");
                        break;
                    case "ERROR_INSERT":
                        showDialogBox("Erro ao tentar inserir dados em database!");
                    break;
                    default:
                        showDialogBox(comandos[0]);
                }
                $("#submit_new_acon").show();
                $("#waitdiv").hide();
            },
            "error":function(jqxhr, msg, errthown){
                showDialogBox(msg);
            }
            });
        }
}

function atualizaAcon(indice){
    dataatual = linhasAcon[indice].split("'");
    $("#id_acon").val(dataatual[0]);
    $("#titulo_acon").val(dataatual[1]);
    $("#desc_acon").val(dataatual[4]);
    $("#totalvagas_acon").val(dataatual[2]);
    total_inscritos = dataatual[3];
    $("#sub_pago").prop("checked",((dataatual[5] == "T")?true:false));
    estadoAtual = 2;
    $("#gen_novo_show").val("Mostrar Lista");
    $("#submit_new_acon").val("Atualizar informações");
    $("#show_acontecimentos").fadeOut(200);
    $("#add_novo_acontecimento").fadeIn(1000);
    $("#prof_hora").fadeIn(500);
    insertDeleteProfessor($("#id_acon").val(),null,"QUERY");
    atualizaTabelaHorario();
}

function insertDeleteProfessor(acontecimento,professor,operacao){
    waitRequestProfessor();
    $.ajax({
            "type":"POST",
            "url":"professor_acontecimento.php",
            "data":{
                "acontecimento":acontecimento,
                "professor":professor,
                "operacao":operacao
            },
            "success":function(stringRecebida){
                cmd = stringRecebida.split("\"");
                if(cmd[0] == "SUCESS"){
                    if(operacao == "QUERY"){
                        $("#acontecimentos_prof div,#acontecimentos_prof label").remove();
                        for(ind=1;ind<cmd.length-1;ind++){
                            camp = cmd[ind].split("'");
                            inserirProfOnSys(camp[1]+"( "+ camp[2] +" )" ,camp[0],$("#id_acon").val());
                        }
                        readyRequestProfessor();
                    }
                    else if(operacao == "INSERT"){
                        inserirProfOnSys(prof_adc,idProf,$("#id_acon").val());
                        readyRequestProfessor();
                    }
                    else if(operacao == "DELETE"){
                        insertDeleteProfessor($("#id_acon").val(),null,"QUERY");
                    }
                }
                else{
                    showDialogBox(stringRecebida);
                    readyRequestProfessor();
                }
            },
            "error":function(jqxhr, msg, errthown){
                showDialogBox(msg);
                readyRequestProfessor();
            }
            });
}

function waitRequestProfessor(){
    $("#botao_more_prof").hide();
    $("#waitdiv_prof").show();
}

function readyRequestProfessor(){
    $("#botao_more_prof").show();
    $("#waitdiv_prof").hide();
}

function inserirProfOnSys(prof_adc,id_p,id_acontm){
    $("#acontecimentos_prof").append("<div><span>"+prof_adc+"</span><a href=\"javascript:insertDeleteProfessor("+id_acontm+","+id_p+",'DELETE')\"><img src=\"../images/excluir.png\" /></a></div>");
    $("#acontecimentos_prof").append("<label style='clear: both;'></label>");
}

function addNovoProfessor(){
    indiceAtual = $("#professores_list").prop("selectedIndex");
    idProf = document.getElementById("professores_list")[indiceAtual].value;
    prof_adc = document.getElementById("professores_list")[indiceAtual].innerHTML;
    insertDeleteProfessor($("#id_acon").val(),idProf,"INSERT");
}

function atualizaTabelaHorario(){
   var aconteci = $("#id_acon").val();
    
    $("#waitdiv_horario").show();
    $.ajax({
        "type":"POST",
        "url":"listspacetime.php",
        "data":{
            "aconteci":aconteci
        },
        "success":function(stringRecebida){
            $("#lista_horarios tbody").remove();
            $("#lista_horarios thead").after("<tbody><tr></tr></tbody>");
            horarios = stringRecebida.split("\"");
            for(i=0;i<horarios.length-1;i++){
                cp = horarios[i].split("'");
                inicial = cp[0].split(" ");
                final = cp[1].split(" ");
                datatr = inicial[0].split('-');
                datatr = datatr[2] + "/" + datatr[1] +"/"+ datatr[0];
                linetr = "<tr><td>"+datatr+"</td><td>"+inicial[1]+"</td><td>"+final[1]+"</td><td>"+cp[2]+"</td><td><a href=\"javascript:deletarHorario("+cp[3]+",'"+cp[0]+"','"+cp[1]+"',"+aconteci+");\"><img src='../images/excluir.png' /></a></td></tr>";
                $("#lista_horarios tbody").append(linetr);
            }
            $("#lista_horarios tbody tr:even").css('background','white');
            $("#waitdiv_horario").hide();
            $("#add_novo_spacetime").show();
        },
        "error":function(jqxhr, msg, errthown){
                showDialogBox(msg);
                $("#waitdiv_horario").hide();
        }
    }); 
}

function adicionaNovoHorario(){
    if(validaNovoHorario()){
        var data = $("#add_date_spacetime").val();
        var inicio = $("#add_moment_init").val();
        var fim = $("#add_moment_ends").val();
        var local = $("#list_local_spacetime").val();
        var aconteci = $("#id_acon").val();
        $("#waitdiv_horario").show();
        $("#add_novo_spacetime").hide();
        
        $.ajax({
            "type":"POST",
            "url":"systemspacetime.php",
            "data":{
                "data":data,
                "inicio":inicio,
                "fim":fim,
                "local":local,
                "aconteci":aconteci
            },
            "success":function(stringRecebida){
                if(stringRecebida == "SUCESS"){
                    atualizaTabelaHorario();
                    showDialogBox("Adicionado com Sucesso!!!");
                }
                else {
                    showDialogBox(stringRecebida);
                    $("#add_novo_spacetime").show();
                }
                $("#waitdiv_horario").hide();
            },
            "error":function(jqxhr, msg, errthown){
                showDialogBox(msg);
            }
            });
        }
}

function deletarHorario(idlocal,momento_ini,momento_fin,acontc){
    if(confirm("Tem certeza que deseja deletar este horário???")){
        $.ajax({
                "type":"POST",
                "url":"removehorario.php",
                "data":{
                    "idlocal":idlocal,
                    "momento_ini":momento_ini,
                    "momento_fin":momento_fin,
                    "acontc":acontc
                },
                        "success":function(stringRecebida){
                            if(stringRecebida == "SUCESS"){
                                atualizaTabelaHorario();
                                showDialogBox("Horário deletado com sucesso!!!");
                            }
                            else {
                                showDialogBox("Problema ao deletar Horário!");
                            }
                        },
                        "error":function(jqxhr, msg, errthown){
                        showDialogBox(msg);
                        $("#waitdiv_horario").hide();
                }
		});
    }
}

function validaCamposAcontec(){
    if($("#titulo_acon").val() == ""){
        $("#titulo_acon").focus();
        showDialogBox("Titulo não preenchido!!!");
        return false;
    }
    if($("#desc_acon").val() == ""){
        $("#desc_acon").focus();
        showDialogBox("Descrição não preenchido!!!");
        return false;
    }
    if($("#totalvagas_acon").val() == ""){
        $("#totalvagas_acon").focus();
        showDialogBox("Total de vagas não preenchido!!!");
        return false;
    }
    if(isNaN($("#totalvagas_acon").val())){
        $("#totalvagas_acon").focus();
        showDialogBox("Digite somente numeros!!!");
        return false;
    }
    if(parseInt($("#totalvagas_acon").val(),10) < total_inscritos){
        $("#totalvagas_acon").focus();
        showDialogBox("Já existe(m) "+total_inscritos+" usuário(s) inscrito(s) nesse curso!!!<br />Digite um valor maior ou igual a "+total_inscritos);
        return false;
    }
    $("#submit_new_acon").hide();
    $("#waitdiv").show();
    return true;
}

function validaNovoHorario(){
    if($("#add_date_spacetime").val() == ""){
        alert("Campo de data vazio!");
        $("#add_date_spacetime").focus();
        return false;
    }
    else if($("#add_moment_init").val() == ""){
        alert("Campo Hora de Inicio vazio!");
        $("#add_moment_init").focus();
        return false;
    }
    else if($("#add_moment_ends").val() == ""){
        alert("Campo de Hora de Término vazio!");
        $("#add_moment_ends").focus();
        return false;
    }
    else {
        var ini = $("#add_moment_init").val();
        var fin = $("#add_moment_ends").val();
        inix = ini.split(":");
        finx = fin.split(":");
        if((inix[0].length != 2) || (inix[1].length != 2) || (inix[2].length != 2) || (finx[0].length != 2) || (finx[1].length != 2) || (finx[2].length != 2)){
            alert("Formato de Hora invalida");
            return false;
        }
        inix[0] = parseInt(inix[0],10);
        inix[1] = parseInt(inix[1],10);
        inix[2] = parseInt(inix[2],10);
        finx[0] = parseInt(finx[0],10);
        finx[1] = parseInt(finx[1],10);
        finx[2] = parseInt(finx[2],10);
        if(!((inix[0]>=0 && inix[0] <=23) && (finx[0]>=0 && finx[0] <=23))){
            alert("Formato de Hora invalida");
            return false;
        }
        if(!((inix[1]>=0 && inix[1]<=59) && (inix[2]>=0 && inix[2]<=59) && (finx[1]>=0 && finx[1]<=59) && (finx[2]>=0 && finx[2]<=59))){
            alert("Formato de Hora invalida");
            return false;
        }
        inix = (inix[0]*3600)+(inix[1]*60)+inix[2];
        finx = (finx[0]*3600)+(finx[1]*60)+finx[2];
        if(!(finx>inix)){
            alert("A Hora de Termino tem quer maior que a hora de inicio!!!");
            return false;
        }
        var datax = $("#add_date_spacetime").val();
        datax = datax.split("/");
        if((datax[0].length != 2) || (datax[1].length != 2) || (datax[2].length != 4)){
            alert("Formato de data invalida!!!\nQuantidade de digitos!");
            return false;
        }
        datax[0] = parseInt(datax[0],10);
        datax[1] = parseInt(datax[1],10);
        datax[2] = parseInt(datax[2],10);
        if(!((datax[0]>=1 && datax[0]<=31) && (datax[1]>=1 && datax[1]<=12) && (datax[2]>=1999))){
           alert("Formato de data invalida!!!\nvalor dos digitos");
           return false;
        }
        return true;
    }
}

function deleteAcon(idacon,insc){
    if(confirm("Tem certeza que deseja deletar???")){
        if(insc != '0'){
            if(!confirm("CUIDADO!!! Tem usuários inscritos nesse acontecimento. Tem certeza que deseja remover?")){
               return false; 
            }
        }
        $.ajax({
                "type":"POST",
                "url":"removeacontecimento.php",
                "data":{
                    "idacon":idacon
                },
                "success":function(stringRecebida){
                    carregaAcontecimentos();
                    console.log(stringRecebida);
                    if(stringRecebida == "SUCCESS"){
                        alert("Removido com Sucesso!");
                    }
                    else{
                        alert("ERROR!");
                    }
                    
                },
                "error":function(jqxhr, msg, errthown){
                showDialogBox(msg);
                }
		});        
    }
}

/*
$(function(){

    $("#show_acontecimentos").fadeIn(1000);
    $("#gen_novo_show").val("Adicionar Novo");
    
});
*/
</script>

<!-- AREA DO XHTML -->

<input id="gen_novo_show" type="submit" value="Adicionar Novo" />

<div id="dialogbox" title="Alerta">
</div>

<div id="show_acontecimentos">
    
<form action="" method="post" id="busca_acon" onsubmit="return false;">
    <label for="filt_user">Pesquisar:</label>
    <input type="text" id="input_busca_acon" /><input id="bt_filtrar_acon" type="submit" value="Buscar" />
</form>
<div id="waitdivtable" class="espera_ajax">
        <img src="../images/wait.gif" /><span>Espere um momento. Carregando...</span>
        <div style="clear: both;"></div>
</div>
<table id="lista_acontecimentos">
<thead>
    <tr>
        <th>Titulo</th>
        <th>Vagas Total</th>
        <?php if(($pt == "minicurso") || ($pt=="visita")) { ?><th>Total Inscritos</th><?php } ?>
        <?php if($pt=="palestra") { ?><th>Descrição</th><?php } ?>
        <!--<th>Pago</th>-->
        <th id="botoes_do_acont">&nbsp;</th>
    </tr>
</thead>
<tbody>
    <tr></tr>
</tbody>
</table>
    
</div>

<div id="add_novo_acontecimento">
    
    <form name="form_acontec" id="form_acontec" onsubmit="return false">
    
        <input type="hidden" name="id_acon" id="id_acon" value="" />
    
        <input type="hidden" name="id_subevent" id="id_subevent" value="<?php echo $subevento ?>">
    
    <label>Titulo</label>
    <input type="text" name="titulo_acon" id="titulo_acon" value="" />

    <label>Descrição</label>
    <textarea name="desc_acon" id="desc_acon" class="info_campo_entrada"></textarea>

    <label>Total de vagas</label>
    <input type="text" name="totalvagas_acon" id="totalvagas_acon" value="" />
    
    <label style='display:none;'>Informações diversas</label>
    <div style="display: none;" class="info_form">
        <input type="checkbox" name="sub_pago" id="sub_pago" class="check_user"> Será necessário pagar para participar deste acontecimento.<br />
    </div>
    <div style="clear: both;"></div>

    <input type="submit" name="submit_new_acon" id="submit_new_acon" value="Adicionar" />
    <div id="waitdiv" class="espera_ajax">
        <img src="../images/wait.gif" /><span>Espere um momento. Carregando...</span>
        <div style="clear: both;"></div>
    </div>
    
    </form>
    
    <div id="prof_hora">

    <label>Configurar Horário</label>
    <div class="caixa_less_border">
        <a href="../index.php?cronograma" target="_blank">(Mostrar cronograma geral)</a>
        <table id="lista_horarios">
        <thead>
            <tr>
                <th>Data</th>
                <th>Hora de Inicio</th>
                <th>Hora de Término</th>
                <th>Local</th>
                <th class="botoes_tabela">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            </tr>
         </tbody>
         <tfoot>
             <tr id="add_spacetime">
                <td><input id="add_date_spacetime" type="text" value="" /></td>
                <td><input id="add_moment_init" type="text" value="" /></td>
                <td><input id="add_moment_ends" type="text" value="" /></td>
                <td><select id="list_local_spacetime"></select></td>
                <td><img id="add_novo_spacetime" title="adicionar" src="../images/more.png" /></td>
            </tr>
         </tfoot>
        </table>
        <div id="waitdiv_horario" class="espera_ajax">
            <img src="../images/wait.gif" /><span>Espere um momento. Carregando...</span>
            <div style="clear: both;"></div>
        </div>
    </div>
    
    <label>Adicionar Professores</label>
    <div class="info_form">
        <span id="gen_professores">Selecione: <select id="professores_list">
                                              </select>
        </span>
        <div id="botao_more_prof"><img title="Adicionar" src="../images/more.png" /></div>
        <div style="clear: both;"></div>
        <div id="waitdiv_prof" class="espera_ajax">
            <img src="../images/wait.gif" /><span>Espere um momento. Carregando...</span>
            <div style="clear: both;"></div>
        </div>
        <div id="acontecimentos_prof"></div>
    </div>
    
    </div>

</div>