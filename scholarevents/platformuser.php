<?php
require './link1.php';
date_default_timezone_set("Brazil/East");

if (!isset($_SESSION)) {
    session_start();
}
if(!isset($_SESSION["UserId"])){
    session_unset();
    header("Location: index.php");
}

$titulo_site = "";
$sqlTexto = "SELECT * FROM sch_textos";
$buscaTexto = $link1->query($sqlTexto);
foreach($buscaTexto->fetchAll(PDO::FETCH_ASSOC) as $linhaTexto){
        switch ($linhaTexto['id']){
            case "titulo":
                $titulo_site = $linhaTexto['texto'];
                break;
        }
}
//Logo
$sqlLogoPrincipal = "SELECT * FROM sch_images WHERE nome_img LIKE '%log%'";
$buscaLogoPrincipal = $link1->query($sqlLogoPrincipal);
$linhaLogoPrincipal = $buscaLogoPrincipal->fetchAll(PDO::FETCH_ASSOC)[0];
$imgLogoPrincipal = $linhaLogoPrincipal['nome_img'];
if(!(file_exists("images/" . $imgLogoPrincipal))){
    $imgLogoPrincipal = "logo.png";
}

$certAtive = '0';
$datanow = date("Y-m-d H:i:s");
$sqlEndEv = "SELECT * FROM sch_datas WHERE (label = 'Evento:Fim') AND (data < '$datanow')";
$buscaEndEv = $link1->query($sqlEndEv);
$totalRegs = $buscaEndEv->rowCount();
if($totalRegs == 1){
    $certAtive = '1';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Scholar Events</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="css/style_home.php" />
        <link type="text/css" rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.2.custom.min.css" />
        <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.10.2.custom.js"></script>
        <script type="text/javascript">
            var idUser = "<?php echo $_SESSION["UserId"] ?>";
            var certif = "<?php echo $certAtive ?>";
            var listAconUser = null;
            var horaAconUser = null;
            
            var chooseplatform = "<a onclick='showChoose();'>Escolha a plataforma</a>";
            var titlesubcli;
            var idsubcli;
            var listacontecimento;
            var acontAllArray;
            var needToConfirm = true;
            var fisthTime = false; // active area to change name on certification
            
            var stringRecebida;
            function callAjaxJson(type,id,callback){
                $.ajax({
                    "type":"POST",
                    "url":"platformuserajaxquery.php",
                    "data":{
                        "id":id,
                        "type":type
                    },
                    "success":function(strup){
                        stringRecebida = strup;
                        callback();
                    },
                    "error":function(jqxhr, msg, errthown){
                        showDialogBox(msg);
                    }
                });
            }
            
            function clickSubEvent(){
                idsubcli = $(this).attr('idsub');
                titlesubcli = $(this).attr('titlesub');
                showTableAcon(idsubcli);
            }
            
            function showChoose(){
                $("#area-user-breadcrumb").html(chooseplatform +" > ");
                $("#area-user-tableacont").hide();
                $("#area-user-details").hide();
                $("#area-user-seletor").fadeIn(1000);
                $("#area-user-confirm").hide();
                $("#area-user-cert").hide();
            }

            function callAllAcont(callback){
                callAjaxJson("basic",null,function(){
                    if(stringRecebida != 'ERROR'){
                        acontAllArray = eval(stringRecebida);
                        callback();
                    }
                });
            }
            
            function showTableAcon(idvalue){
                listacontecimento = "<a onclick='showTableAcon(idsubcli);'>"+ titlesubcli +"</a>";
                $("#area-user-breadcrumb").html(chooseplatform +" > "+ listacontecimento);
                if(idsubcli == 'certificado'){
                    $("#area-user-seletor").hide();
                    if(fisthTime == true){
                        $("#area-user-confirm").show();
                        $("#area-user-cert").hide();
                        fisthTime = false;
                    }
                    else {
                        $("#area-user-confirm").hide();
                        $("#area-user-cert").show();
                    }
                }
                else{
                    $("#area-user-tableacont").html("<img src='images/wait.gif' />");
                    $("#area-user-tableacont").fadeIn(1000);
                    $("#area-user-details").hide();
                    $("#area-user-seletor").hide();
                    $("#area-user-cert").hide();

                    callAllAcont(function(){
                        $("#area-user-tableacont").html("");
                        for(lines in acontAllArray){
                                if(acontAllArray[lines]['id_subevent'] == idvalue){
                                    cursohtml = "<div class='acont-subevet-box'><div id='titulo'>"+
                                    acontAllArray[lines]['titulo'] +"</div><div id='desc'>"+
                                    acontAllArray[lines]['descricao']+"</div><div>Total de Vagas: "+
                                    acontAllArray[lines]['vagas_total']+"</div><div>Total inscritos: "+
                                    acontAllArray[lines]['total_inscritos']+"</div><input id='"+
                                    acontAllArray[lines]['id_acon'] +"' type='button' value='Mais Detalhes' /></div>";
                                    $("#area-user-tableacont").append(cursohtml);
                                }
                            }
                            $("#area-user-tableacont").append("<div style='clear: both;'></div>");
                            $("#area-user-tableacont div input").click(function(){
                                showDetail($(this).attr('id'));
                            });
                    });
                }          
            }
            
            function showDetail(idvalue){
                //exibe e oculta areas
                $("#area-user-tableacont").hide();
                $("#area-user-details").fadeIn(1000);
                $("#area-user-seletor").hide();
                $("#area-user-confirm").hide();
                $("#area-user-cert").hide();
                $("#detail-plus-title").html("<img src='images/wait.gif' />");
                $("#detail-plus-desc").html("<img src='images/wait.gif' />");
                $("#detail-plus-totalvaga").html("<img src='images/wait.gif' />");
                $("#detail-plus-totalinsc").html("<img src='images/wait.gif' />");
                $("#detail-plus-horario").html("<img src='images/wait.gif' />");
                $("#detail-plus-prof").html("<img src='images/wait.gif' />");
                $("#area-botao-carrega").html("<img src='images/wait.gif' />");
                //mostra horario do acontecimento selecionado e boto inserir
                callAjaxJson("horaprof",idvalue,function(){
                        $("#detail-plus-horario").html("");
                        $("#detail-plus-prof").html("");
                        if(stringRecebida != "ERROR"){
                            //carrega horario
                            var jsonSet = eval(stringRecebida);
                            var jsonres = jsonSet[0];
                            var horarioHtml = "<table id='table-detail-hor'><tbody><tr><th>Data</th><th>Hora de Inicio</th><th>Hora de Término</th><th>Local</th></tr>";
                            if(jsonres == null){
                                horarioHtml += "<td colspan='4' style='text-align:left;'>Não informado.</td>";
                            }
                            for(regs in jsonres){
                                horarioHtml += "<tr>";
                                
                                var inicio = (jsonres[regs])['momento_ini'];
                                var fim = (jsonres[regs])['momento_fin'];
                                var local = (jsonres[regs])['local'];
                                var data_ini_str = inicio['data'][2]+"/"+inicio['data'][1]+"/"+inicio['data'][0];
                                var data_fin_str = fim['data'][2]+"/"+fim['data'][1]+"/"+fim['data'][0];
                                var data_ini_strEn = inicio['data'][1]+"/"+inicio['data'][2]+"/"+inicio['data'][0];
                                var data_fin_strEn = fim['data'][1]+"/"+fim['data'][2]+"/"+fim['data'][0];
                                
                                horarioHtml += "<td>";
                                horarioHtml += data_fin_str+" ("+intToDay((new Date(data_fin_strEn)).getDay())+")";
                                horarioHtml += "</td><td>";
                                horarioHtml += inicio['hora'];
                                horarioHtml += "</td><td>";
                                horarioHtml += fim['hora'];
                                horarioHtml += "</td><td>";
                                horarioHtml += local;
                                horarioHtml += "</td>";
                        
                                horarioHtml += "</tr>";
                            }
                            
                            horarioHtml += "</tbody></table>";
                            
                            $("#detail-plus-horario").append(horarioHtml);
                            //carrega professores
                            var profs = jsonSet[1];
                            if(profs == null){
                                $("#detail-plus-prof").append("Não informado.");
                            }
                            for(keys in profs){
                                $("#detail-plus-prof").append("<div>"+profs[keys]['nome']+" ("+profs[keys]['email']+")"+"</div>");
                            }
                        }
                        /////
                        //atualiza lista de acontecimentos
                        callAllAcont(function(){
                            //captura o acontecimento selecionado
                            for(lis in acontAllArray){
                                if((acontAllArray[lis])['id_acon'] == idvalue){
                                    acontNow = acontAllArray[lis];
                                    break;
                                }
                            }
                            //atualiza breadcrumb
                            titlesubcli = acontNow['titulo_sub'];
                            idsubcli = acontNow['id_subevent'];
                            dtls = " > <a onclick='showDetail(\""+idvalue+"\");'>Detalhes</a>";
                            listacontecimento = "<a onclick='showTableAcon(idsubcli);'>"+ titlesubcli +"</a>";
                            $("#area-user-breadcrumb").html(chooseplatform +" > "+ listacontecimento + dtls);
                            //mostra acontecimento selecionado
                            $("#detail-plus-title").text(acontNow['titulo']);
                            $("#detail-plus-desc").text(acontNow['descricao']);
                            $("#detail-plus-totalvaga").text(acontNow['vagas_total']);
                            $("#detail-plus-totalinsc").text(acontNow['total_inscritos']);
                            /////
                            carregaInserir(idvalue);
                        });
                });
            }
            
            function intToDay(value){
                switch(value){
                    case 0:
                        return "Domingo";
                        break;
                    case 1:
                        return "Segunda-feira";
                        break;
                    case 2:
                        return "Terça-feira";
                        break;
                    case 3:
                        return "Quarta-feira";
                        break;
                    case 4:
                        return "Quinta-feira";
                        break;
                    case 5:
                        return "Sexta-feira";
                        break;
                    case 6:
                        return "Sábado";
                        break;
                }
            }
            
            function carregaInserir(idvalue){
                var buttonAcon = "okey";
                for(key in acontAllArray){
                    if(acontAllArray[key]['id_acon'] == idvalue){
                       var vt = acontAllArray[key]['vagas_total'];
                       var ti = acontAllArray[key]['total_inscritos'];
                       if((vt-ti)<=0){
                           buttonAcon = "full";
                       }
                       break;
                    }
                }
                
                for(key in listAconUser){
                    if(listAconUser[key]['id_acon'] == idvalue){
                        buttonAcon = "cancel";
                        break;
                    }
                }
                
                $("#area-botao-carrega").html("")
                .html("<input type='button' id=\"bt-participar\" value='Participar do Curso' />");
                switch(buttonAcon){
                    case "okey":
                        $("#bt-participar").css('background-color','#66BB00')
                        .val('Participar').click(function(){
                            inserirPart(idvalue);
                        });
                        break;
                    case "cancel":
                        $("#bt-participar").css('background-color','#cd0a0a')
                        .val('Cancelar participação').click(function(){
                            removePart(idvalue);
                        });
                        break;
                    case "full":
                        $("#bt-participar").css('background-color','#e78f08')
                        .val('Não há vagas');
                        break
                }  
                
            }
            
            function refreshTabAconUser(){
                $("#tab-list").html("<img src='images/wait.gif' />");
                $("#tab-schedule").html("<img src='images/wait.gif' />");
                callAjaxJson("useracon",idUser,function(){
                    if(stringRecebida != "ERROR"){
                        chegJson = eval(stringRecebida);
                        listAconUser = chegJson[0];
                        horaAconUser = chegJson[1];
                        refreshListAconUser(listAconUser);
                        refreshScheAconUser(horaAconUser);
                    }
                });
            }
            
            function refreshListAconUser(listAconUser){
                var objHtml;
                if(listAconUser == null){
                    objHtml = "Você aida não está participando de nenhum evento. Selecione a plataforma e escolha os cursos.";
                }
                else{
                    var objHtml = "<table id='table-list-tab'>";
                    for(keys in listAconUser){
                        objHtml += "<tr>";
                        objHtml += "<td>"+listAconUser[keys]['titulo']+"</td>";
                        objHtml += "<td>"+listAconUser[keys]['subevento']+"</td>";
                        objHtml += "<td><a class='more_details' onclick='showDetail(\""+ listAconUser[keys]['id_acon'] +"\");'>Mais Detalhes</a></td>";
                        objHtml += "<td><a onclick='removePart(\"" + listAconUser[keys]['id_acon'] + "\");'><img src='images/excluir.png' /></a></td>";
                        objHtml += "</tr>";
                    }
                    objHtml += "</table>";
                }
                $("#tab-list").html(objHtml);
                if(certif == '1'){
                    makeAreaCert(listAconUser);
                }
            };
            
            function refreshScheAconUser(horaAconUser){
                var data = "";
                var place = "";
                var objTag = "";
                var subniveisData = new Array();
                if(horaAconUser == null){
                    objTag = "Você aida não está participando de nenhum evento. Selecione a plataforma e escolha os cursos.";
                    $("#tab-schedule").html(objTag);
                }
                else{
                    cont=0;
                    for(key in horaAconUser){
                        dt = horaAconUser[key]['momento_ini']['data'][2] + "/" + horaAconUser[key]['momento_ini']['data'][1]
                            + "/" + horaAconUser[key]['momento_ini']['data'][0];
                        lc= horaAconUser[key]['local'];
                        if(subniveisData[dt] == undefined){
                            subniveisData[dt] = new Array();
                        }
                        if(subniveisData[dt][lc] == undefined){
                            subniveisData[dt][lc] = new Array();
                        }
                        subniveisData[dt][lc][key] = horaAconUser[key];
                    }
                    
                    for(k in subniveisData){
                        objTag += "<div class='sched-datas'>"+k+"</div><div class='sched-datas-con'>";
                        objTag += "<div class='label-hora' style='position:relative;'></div>";
                        for(l in subniveisData[k]){
                            objTag += "<div><span class='sch-local' title='" + l + "'>"+ l +"</span>";
                            for(m in subniveisData[k][l]){
                                var hi = subniveisData[k][l][m]['momento_ini']['hora'];
                                var hf = subniveisData[k][l][m]['momento_fin']['hora'];
                                var hora_ini = (subniveisData[k][l][m]['momento_ini']['hora']).split(":");
                                var hora_fin = (subniveisData[k][l][m]['momento_fin']['hora']).split(":");
                                hoursI = parseInt(hora_ini[0],10)+(parseInt(hora_ini[1],10)/60)+(parseInt(hora_ini[2],10)/(60*60));
                                hoursF = parseInt(hora_fin[0],10)+(parseInt(hora_fin[1],10)/60)+(parseInt(hora_fin[2],10)/(60*60));
                                posInicial = (200+(((hoursI/6)-1)*168));
                                posFinal = (((hoursF-hoursI)/6)*168);
                                objTag += "<span class='hora-sch-comp' style='left:" + posInicial + "px; width:";
                                objTag += posFinal +"px;' title='";
                                objTag += subniveisData[k][l][m]['titulo'];
                                objTag += "\nInicio: "+hi+"\nFim: "+hf+"' alt='"+subniveisData[k][l][m]['titulo']+"'>&nbsp;</span>";
                            }
                            objTag += "</div>";
                            
                        };
                        objTag += "</div>";
                    }
                    
                    $("#tab-schedule").html(objTag);

                    for(i=6;i<=23;i++){
                    lb = "<span style='left:"+(200+(((i/6)-1)*168))+"px;'>"+i+"h</span>";
                    $(".label-hora").append(lb);
                    }

                    /////
                    $(".hora-sch-comp").mouseenter(function(){
                    $(this).html("");
                    $(this).append("<marquee style='color:black;' title=\""+ $(this).attr("title") +"\">"+$(this).attr("alt")+"</marquee>");
                    }).mouseleave(function(){
                    $(this).html("&nbsp;");
                    });
                }   
            }
            
            function inserirPart(id_acon){
                //showDialogBox(stringRecebida);
                callAjaxJson("participate",id_acon,function(){
                    if(stringRecebida == "SUCCESS"){
                        refreshTabAconUser();
                        showDetail(id_acon);
                        showDialogBox("Operação realizada com Sucesso.");
                    }
                    else if(stringRecebida == "BLOQUEIO"){
                        showDialogBox("O período de escolha dos cursos terminou!");
                    }
                    else{
                        var data = eval(stringRecebida);
                        for(k in acontAllArray){
                            if(data[0]['id_acon'] == acontAllArray[k]['id_acon']){
                                showDialogBox("Você não pode participar deste acontecimento, pois colide com: <br /><br /><br />" + acontAllArray[k]['titulo']);
                                break;
                            }
                        }
                                                
                    }
                });
            }
            
            function removePart(id_acon){
                if(!confirm('Voce tem certeza que quer deletar???')){
                    return false;
                }                
                callAjaxJson("removeuser",id_acon,function(){
                    if(stringRecebida == "SUCCESS"){
                        refreshTabAconUser();
                        showDetail(id_acon);
                        showDialogBox("Operação realizada com Sucesso.");
                    }
                    else if(stringRecebida == "BLOQUEIO"){
                        showDialogBox("O período de escolha dos cursos terminou!");
                    }
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
            
            function makeAreaCert(listAconUser){
                var objHtml;
                if(listAconUser == null){
                    objHtml = "Você aida não está participando de nenhum evento. Selecione a plataforma e escolha os cursos.";
                }
                else{
                    var objHtml = "<table id='table-list-tab'>";
                    for(keys in listAconUser){
                        objHtml += "<tr>";
                        objHtml += "<td>"+listAconUser[keys]['titulo']+"</td>";
                        objHtml += "<td>"+listAconUser[keys]['subevento']+"</td>";
                        objHtml += "<td><a class='more_details' href='geracert.php?aid="+ listAconUser[keys]['id_acon'] +"' target='_blank'>Baixar em PDF</a></td>";
                        objHtml += "</tr>";
                    }
                    objHtml += "</table>";
                }
                $("#area-user-cert").html(objHtml);
            }
            
            function aplicaEfeitoTab(){
                $("#tab-list-aba").click(function(){
                    $("#tab-schedule").hide();
                    $("#tab-list").show();
                    $("#tab-schedule-aba").removeClass("tab-aba-hover").addClass("tab-aba-normal");
                    $(this).addClass("tab-aba-hover");
                });
                $("#tab-schedule-aba").click(function(){
                    $("#tab-schedule").show();
                    $("#tab-list").hide();
                    $("#tab-list-aba").removeClass("tab-aba-hover").addClass("tab-aba-normal");
                    $(this).addClass("tab-aba-hover");
                });
            }            
          
            $(function(){
                //image logo
                $("#topo").css("background-image","url(images/<?php echo $imgLogoPrincipal ?>)");
                //Inicializa dialogBoxs
                setDialogBox();
                //breadcrumbs
                showChoose();
                //Inicializa Schedule
                callAllAcont(function(){
                    refreshTabAconUser(); 
                });
                 aplicaEfeitoTab();
                //Inicializa Plataforma
                $(".select-sub-event").click(clickSubEvent);
                //
                window.onbeforeunload = function() {
                    if (needToConfirm) {
                    return "";
                    }
                };
                $("#bt-exit").click(function(){
                    needToConfirm = false;
                    window.location = "logoff.php";
                });
                $("#yes").click(function(){
                    $("#area-user-cert").show();
                    $("#area-user-confirm").hide();
                });
                $("#alterar").hide().click(function(){
                    $("#alterar").hide();
                    $("#wait-fullname").show();
                    callAjaxJson("changeName",$("#fullname").val(),function(){
                        if(stringRecebida == "ERROR"){
                            showDialogBox("Falha!");
                        }
                        $("#yes").click();
                        $("#wait-fullname").hide();
                    });
                });
                $("#wait-fullname").hide();
                $("#no").click(function(){
                    $("#yes").hide();
                    $("#no").hide();
                    $("#alterar").show();
                    $("#fullname").removeAttr('disabled');
                    $("#fullname").focus();
                });
                
                $("#tab-list-aba").click();
            });
        </script>
        
    </head>
    <body>
        <?php
        require 'menu_home.php';
        require 'topo_home.php';
        ?>
        <div id="corpo_principal">
            <div id="dialogbox" title="Alerta">
            </div>
            <div id="bar-info-platuser">
                Seja bem-vindo, <?php echo $_SESSION["UserNome"] ?> <!--( <?php echo $_SESSION["UserEmail"] ?> )-->.
                <a id="bt-exit">Sair do Sistema</a>
            </div>
            
            <div id="area-user-schedule">
                <ul>
                    <li id="tab-list-aba">Seus eventos</li>
                    <li id="tab-schedule-aba">Seu horário</li>
                </ul>
                <div id="tab-list"></div>
                <div id="tab-schedule"></div>    
            </div>
            
            <div id="area-user-breadcrumb">
            </div>
        
            <div id="area-user-seletor">
                <?php
                $kindUser = $_SESSION["UserTipo"];
                $kindUser = decbin($kindUser);
                while(strlen($kindUser)<4){
                    $kindUser = '0' . $kindUser;
                }

                $typeStudent = $_SESSION['typeStudent'];
                $typeOrganizer = $_SESSION['typeOrganizer'];
                $typeAppraiser = $_SESSION['typeAppraiser'];

                if($typeStudent == '1'){
                    $sqlPlatform = "SELECT * FROM sch_subeventos";
                    $queryPlatform = $link1->query($sqlPlatform);
                    if(!$queryPlatform){
                        echo 'Error!';
                        exit;
                    }
                    foreach($queryPlatform->fetchAll(PDO::FETCH_ASSOC) as $linePlat){
                        $logo = $linePlat['logo'];
                        $plataforma = $linePlat['plataforma'];
                        $idSubEvent = $linePlat['id'];
                        $titleSubEvent = $linePlat['titulo'];

                        if(($plataforma == 'minicurso') || ($plataforma == 'visita')){
                            echo "<img class='select-sub-event' src='images/$logo' idsub='$idSubEvent' titlesub='$titleSubEvent' />";
                        }

                    }

                }
                if($certAtive == '1'){
                    echo "<img class='select-sub-event' src='images/certif_icon.png' idsub='certificado' titlesub='Certificados' />";
                }
                if($typeOrganizer == '1') {
                    echo "<div class='select-sub-event'>"
                        . "<div style='display:none;'>$idSubEvent</div>"
                        . "<img src='images/organizador.png' />"
                        . "</div>";

                }
                if($typeAppraiser == '1') {
                    echo "<div class='select-sub-event'>"
                        . "<div style='display:none;'>$idSubEvent</div>"
                        . "<img src='images/avaliador.png' />"
                        . "</div>";

                }
                ?>
                <div style="clear: both;"></div>
            
            </div>
            
            <div id="area-user-tableacont">
            </div>
            
            <div id="area-user-details">
                <table id="table-detail-acon">
                    <tbody>
                        <tr>
                            <th>Titulo</th><td id="detail-plus-title"></td>
                        </tr>
                        <tr>
                            <th>Descrição</th><td id="detail-plus-desc"></td>
                        </tr>
                        <tr>
                            <th>Total de Vagas</th><td id="detail-plus-totalvaga"></td>
                        </tr>
                        <tr>
                            <th>Total de Inscritos</th><td id="detail-plus-totalinsc"></td>
                        </tr>
                        <tr>
                            <th>Horário</th><td id="detail-plus-horario"></td>
                        </tr>
                        <tr>
                            <th>Professores</th><td id="detail-plus-prof"></td>
                        </tr>
                    </tbody>
                </table>
                <div id='area-botao-carrega'></div>
            </div>
            
            <?php
            if($certAtive == '1'){
            ?>
            <div id="area-user-cert">
            </div>
            <div id="area-user-confirm">
                <label>Seu nome completo está correto?</label>
                <input type="text" name="fullname" id="fullname" disabled="disabled" value="<?php echo $_SESSION['UserNome'] ?>" />
                <input type="button" id="yes" value="SIM" />
                <input type="button" id="no" value="NAO" />
                <input type="button" id="alterar" value="Alterar" />
                <img src="images/wait.gif" id='wait-fullname' />
            </div>
            <?php
            }
            ?>
            
        </div>
        <?php
        include 'bottom.php';
        ?>
    </body>
</html>