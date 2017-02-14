<?php
if (!isset($_SESSION)) {
  session_start();
}
date_default_timezone_set("Brazil/East");
$agora = date("Y-m-d H:i:s");
$sqlDfim = "SELECT * FROM sch_datas WHERE label = 'InscricaoOnline:Fim' AND NOT(data < '$agora')";
$buscaInscF = mysql_query($sqlDfim);
$inscricoesaberta = false;
$texto = "";
if(mysql_num_rows($buscaInscF) == 0){
    //fechada
    $texto = "<strong>Inscrições encerradas!!!</strong>";
    
}else {
    $sqlDini = "SELECT * FROM sch_datas WHERE label = 'InscricaoOnline:Inicio' AND NOT(data < '$agora')";
    $buscaInsc = mysql_query($sqlDini);
    if(mysql_num_rows($buscaInsc) == 0){
        //inscrições abertas
        $inscricoesaberta = true;
        $DFinalInsc = mysql_fetch_assoc($buscaInscF);
        $dfinalconf = explode(" ",$DFinalInsc['data']);
        $dtconfigfin = explode("-",$dfinalconf[0]);
        $texto = "<strong>As inscrições irão se encerrar na data: ";
        $texto .= $dtconfigfin[2] . "/" . $dtconfigfin[1] . "/" . $dtconfigfin[0];
        $texto .= " as " . $dfinalconf[1];
        $texto .= "</strong>";
    }
    else {
        //inscrições serao abertas
        $linha = mysql_fetch_assoc($buscaInsc);
        $dataininscrica = explode(" ", $linha['data']);
        $dtconfg = explode("-", $dataininscrica[0]);
        $texto = "<strong>As inscrições on-line só estarão disponiveis na data: </strong>";
        $texto .= $dtconfg[2] . "/" . $dtconfg[1] . "/" . $dtconfg[0];
        $texto .= " a partir das " . $dataininscrica[1];
    }
}
?>
<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: .5em .7em;">
        <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
        <?php echo $texto ?></p>
</div>
<?php
if(isset($_GET['error'])){
?>
<script type="text/javascript">
    alert("Error ao inserir usuário!");
</script>
<?php
}
if($inscricoesaberta){
    $texto = "Os campos com asterisco (*) são obrigatório!!!";
?>
<div class="ui-state-highlight ui-corner-all" style="margin-top: 10px; padding: .5em .7em;">
        <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
        <?php echo $texto ?></p>
</div>
<script type="text/javascript">
var emailInit = "";
var cpfInit = "";
var captchaconfirmado = false;
function validaData(data) {
    var data_nasc = data;
    dia = data_nasc.substring(0,2);
    mes = data_nasc.substring(3,5);
    ano = data_nasc.substring(6,10);
    if(isNaN(dia) || isNaN(mes) || isNaN(ano)) {
        //Formato de data Invalida
	return "invalidFormat";
    }
    if(parseInt(dia)>31 || parseInt(mes)>12 || parseInt(ano)<1912){
        //Data invalido
	return "invalidDate";
    }
    return "valido";
}

function validaEmail(){
    var textBoxEmail = $("#email").val();
    
    if(textBoxEmail != ""){
        if(textBoxEmail.indexOf('@')==-1 || textBoxEmail.indexOf('.')==-1){
            $("#email_tip").text("(Invalido!)").css("color","red");
            $("#email_valido").val("nao");
        }
        else {
            var valor = escape($("#email").val());
            $.ajax({
            "type":"POST",
            "url":"admin/ajaxquery.php",
            "data":"valoremail=" + valor,
            "success":function(dados){
                //alert(dados+"|"+emailInit+"|"+dados.length+"|"+emailInit.length);
                if(!((dados == emailInit) || (dados==""))){
                    $("#email_valido").val("nao");
                    $("#email_tip").text("(Já existe!)" + dados).css("color","red");
                }
                else {
                    $("#email_valido").val("sim");
                    $("#email_tip").text("(Válido!!!)").css("color","green");
                }                
            }
            }); 
        }
    }
    else{
        $("#email_valido").val("nao");
        $("#email_tip").text("");
    }
}

function validaCpf(){
    var textBoxCPF = $("#cpf").val();
    
    if(textBoxCPF != ""){
        if(isNaN(textBoxCPF) || (textBoxCPF.length != 11)){
            $("#cpf_tip").text("(Invalido!)").css("color","red");
            $("#cpf_valido").val("nao");
        }
        else{
            var valor = escape($("#cpf").val());
            $.ajax({
            "type":"POST",
            "url":"admin/ajaxquery.php",
            "data":"valorcpf=" + valor,
            "success":function(dados){
                if(!((dados == cpfInit) || (dados==""))){
                    $("#cpf_valido").val("nao");
                    $("#cpf_tip").text("(Já existe!)").css("color","red");
                }
                else {
                    $("#cpf_valido").val("sim");
                    $("#cpf_tip").text("(Válido!!!)").css("color","green");
                }                
            }
            }); 
        }
    }
    else{
        $("#cpf_valido").val("sim");
        $("#cpf_tip").text(""); 
    }
}
    
function validaEnvioCamposOnline(){
    var textBoxNome = $("#nome").val();
    var textBoxEmail = $("#email").val();
    var hideBoxEmail = $("#email_valido").val();
    var textBoxCelular = $("#celular").val();
    var textBoxDate = $("#data_nasc").val();
    var hideBoxCPF = $("#cpf_valido").val();
    var textBoxTelefone = $("#telefone").val();
    var textBoxSenha = $("#senha").val();
    var textBoxSenha2 = $("#senha2").val();
    var textBoxCidade = $("#cidade").val();
    var textBoxBairro = $("#bairro").val();
    var textBoxEndereco = $("#endereco").val();
    
    if(textBoxNome == ""){
        alert('Preencha o nome de usuario');
        $("#nome").focus();
        return false;
    }
    if(textBoxEmail == ""){
        alert("Digite um e-mail!");
        $("#email").focus();
        return false;
    }
    if(hideBoxEmail == "nao"){
        alert('Verifique o campo de email');
        $("#email").focus();
        return false;
    }
    if(textBoxCelular != ""){
        if(isNaN(textBoxCelular) || textBoxCelular.length<8){
            alert('Verifique o celular');
            $("#celular").focus();
            return false;
        }
    }
    else{
        alert('Campo do celular vazio!');
        $("#celular").focus();
        return false; 
    }
    
    if(textBoxDate != ""){
        var saida = validaData(textBoxDate);
        if(saida != "valido"){
            alert("Erro no campo Data: " + saida);
            $("#data_nasc").focus();
            return false;
        }
    }
    else {
        alert("Campo de Data vazio!");
        $("#data_nasc").focus();
        return false; 
    }
    //configurar aqui CPF vazio
    if(hideBoxCPF == "nao"){
        alert('Verifique o campo de CPF');
        $("#cpf").focus();
        return false;
    }
    
    if(textBoxTelefone != ""){
        if(isNaN(textBoxTelefone) || textBoxTelefone.length<8){
            alert('Verifique o telefone');
            $("#telefone").focus();
            return false;
        }
    }
    
    if(textBoxSenha == ""){
        alert("Digite a senha!");
        $("#senha").focus();
        return false;
    }
    else if(textBoxSenha.length < 6 || textBoxSenha.length > 12){
        alert("Senha muito pequena!");
        $("#senha").focus();
        return false;
    }
    else if(textBoxSenha != textBoxSenha2){
        alert("Senhas diferentes. Por favor digite novamente!");
        $("#senha2").val("");
        $("#senha").val("").focus();
        return false;
    }
    
    if(textBoxCidade == ""){
        alert("Campo Cidade em vazio!");
        $("#cidade").focus();
        return false;
    }
    
    if(textBoxBairro == ""){
        alert("Campo Bairro em vazio!");
        $("#bairro").focus();
        return false;
    }
    
    if(textBoxEndereco == ""){
        alert("Campo Endereco em vazio!");
        $("#endereco").focus();
        return false;
    }
    
    if($("#textcaptcha").val() == ""){
        alert("Campo de verificação em vazio!");
        $("#textcaptcha").focus();
        return false;
    }
    
    if(!captchaconfirmado){
        validaCaptcha();
    }
            
    return captchaconfirmado;
}

function validaCaptcha(){
    var texto = $("#textcaptcha").val();
    $.ajax({
        "type":"POST",
        "url":"captchaajax.php",
        "data":{
            "texto":texto
        },
        "success":function(stringRecebida){
            if(stringRecebida == "SUCESSO"){
                captchaconfirmado = true;
                $("#inscricaoonline").submit();
            }
            else{
                $("#textcaptcha").focus();
                captchaconfirmado = false;
                $("#imgcaptchadiv").html("");
                $("#imgcaptchadiv").html("<img id='imgcaptcha' src='captcha.php?"+Math.round(10000*Math.random())+"' />");
                alert("Texto de verificação digitado errado!");
            }
        },
        "error":function(jqxhr, msg, errthown){
            alert(msg);
        }
    });    
}

$(function(){
    emailInit = $("#email").val();
    cpfInit = $("#cpf").val();
    $("#inscricaoonline").tooltip({ position: { my: "left+15 center", at: "right center" } });
    $("#inscricaoonline").submit(validaEnvioCamposOnline);
    $("#email").focusout(validaEmail);
    $("#email").keyup(validaEmail);
    $("#cpf").focusout(validaCpf);
    $("#cpf").keyup(validaCpf);
    $("#data_nasc").datepicker({
        dateFormat: "dd/mm/yy",
	changeYear: true,
	yearRange: "1980:" + (new Date()).getFullYear()
    });
   
});
</script>

<form method="POST" action="inseriraluno.php" id="inscricaoonline">
    <input type="hidden" name="email_valido" id="email_valido" value="sim">
    <input type="hidden" name="cpf_valido" id="cpf_valido" value="sim">
    
    <label for="nome" class="campos_gerais">Nome *</label>
    <input type="text" class="campos_gerais" name="nome" id="nome" title="Nome completo sem caracteres especiais." value="" />

    <label for="email" class="campos_gerais">E-mail *<span id="email_tip"></span></label>
    <input type="text" class="campos_gerais" name="email" id="email" title="Digite um e-mail valido!" value="" />
    <label for="celular" class="campos_gerais">Celular *</label>
    <input type="text" class="campos_gerais" maxlength="11" name="celular" id="celular" title="Peencha somente com numeros!" value="" />

    <label for="data_nasc" class="campos_gerais">Data de nascimento *</label>
    <input type="text" class="campos_gerais" name="data_nasc" id="data_nasc" title="Data no formato dd/mm/aaaa" value="" />

    <label for="cpf" class="campos_gerais">CPF <span id="cpf_tip"></span></label>
    <input type="text" class="campos_gerais" name="cpf" maxlength="11" id="cpf" title="Digite 11 digitos, somente numeros!" value="" />

    <label for="telefone" class="campos_gerais">Telefone</label>
    <input type="text" class="campos_gerais" maxlength="11" name="telefone" id="telefone" title="Peencha somente com numeros!" value="" />

    <label for="senha" class="campos_comuns">Senha *</label>
    <input type="password" class="campos_comuns" maxlength="12" name="senha" id="senha" title="Minimo 6 caracteres e no maximo 12." value="" />

    <label for="senha2" class="campos_comuns">Redigite a senha *</label>
    <input type="password" class="campos_comuns" maxlength="12" name="senha2" id="senha2" title="Repita a senha!" value="" />

    <label for="matricula" class="campos_alunos">Matricula Academica</label>
    <input type="text" class="campos_alunos" name="matricula" id="matricula" title="Digite o numero da matricula." value="" />

    <label for="uf" class="campos_alunos">UF *</label>
    <select name="uf" class="campos_alunos" id="uf" title="Selecione o Estado">
        <option value="AC">Acre</option>
        <option value="AL">Alagoas</option>
        <option value="AP">Amapá</option>
        <option value="AM">Amazonas</option>
        <option value="BA">Bahia</option>
        <option value="CE" selected="selected">Ceará</option>
        <option value="DF">Distrito Federal</option>
        <option value="ES">Espírito Santo</option>
        <option value="GO">Goiás</option>
        <option value="MA">Maranhão</option>
        <option value="MT">Mato Grosso</option>
        <option value="MS">Mato Grosso do Sul</option>
        <option value="MG">Minas Gerais</option>
        <option value="PA">Pará</option>
        <option value="PB">Paraíba</option>
        <option value="PR">Paraná</option>
        <option value="PE">Pernambuco</option>
        <option value="PI">Piauí</option>
        <option value="RJ">Rio de Janeiro</option>
        <option value="RN">Rio Grande do Norte</option>
        <option value="RS">Rio Grande do Sul</option>
        <option value="RO">Rondônia</option>
        <option value="RR">Roraima</option>
        <option value="SC">Santa Catarina</option>
        <option value="SP">São Paulo</option>
        <option value="SE">Sergipe</option>
        <option value="TO">Tocantins</option>
    </select>

    <label for="cidade" class="campos_alunos">Cidade *</label>
    <input type="text" class="campos_alunos" name="cidade" id="cidade" title="Digite o nome do município onde mora." value="" />

    <label for="bairro" class="campos_alunos">Bairro *</label>
    <input type="text" class="campos_alunos" name="bairro" id="bairro" title="Digite o Bairro, Conjunto ou sítio." value="" />

    <label for="endereco" class="campos_alunos">Endereco *</label>
    <input type="text" class="campos_alunos" name="endereco" id="endereco" title="Digite a rua e o número da casa ou Apartamento." value="" />
    
    <label for="textcaptcha" class="campos_alunos">Verificação de segurança *</label>
    <div id="imgcaptchadiv">
        <img id="imgcaptcha" src="captcha.php">
    </div>
    <input type="text" class="campos_alunos" name="textcaptcha" id="textcaptcha" title="Digite os caracteres que aparecem na image" value="" />
    
    <input type="submit" id="salvar" value="Inscrever!" />
    
</form>
<?php
}
else {
?>
<script type="text/javascript">
$(function(){
	altura = $(document).height();
	$("#corpo_principal").css('height',(altura-320)+'px');
});
</script>
<?php
}
?>