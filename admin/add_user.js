var emailInit = "";
var cpfInit = "";
$(function(){
    emailInit = $("#email").val();
    cpfInit = $("#cpf").val();
    $("#campos").submit(validaEnvioCampos);
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
//////////////////////////////////////////////////[

/* valida campos de add_user */
function validaEnvioCampos(){
    var hideBoxTipo = $("#tipo_usuario").val();
    var textBoxNome = $("#nome").val();
    var textBoxEmail = $("#email").val();
    var hideBoxEmail = $("#email_valido").val();
    var textBoxCelular = $("#celular").val();
    var textBoxDate = $("#data_nasc").val();
    var hideBoxCPF = $("#cpf_valido").val();
    var textBoxTelefone = $("#telefone").val();
    var textBoxSenha = $("#senha").val();
    var textBoxSenha2 = $("#senha2").val();
    
    if(hideBoxTipo == "0"){
        alert("Escolha uma opção!");
        return false;
    }    
    if(textBoxNome == ""){
        alert('Preencha o nome de usuario');
        $("#nome").focus();
        return false;
    }
    if(hideBoxEmail == "nao"){
        alert('Verifique o campo de email');
        $("#email").focus();
        return false;
    }
    
    if(textBoxCelular != ""){
        if(isNaN(textBoxCelular)){
            alert('Verifique o celular');
            $("#celular").focus();
            return false;
        }
    }
    
    if(textBoxDate != ""){
        var saida = validaData(textBoxDate);
        if(saida != "valido"){
            alert("Erro no campo Data: " + saida);
            $("#data_nasc").focus();
            return false;
        }
    }
    
    if(hideBoxCPF == "nao"){
        alert('Verifique o campo de CPF');
        $("#cpf").focus();
        return false;
    }
    
    if(textBoxTelefone != ""){
        if(isNaN(textBoxTelefone)){
            alert('Verifique o telefone');
            $("#telefone").focus();
            return false;
        }
    }
    
    checkboxAvaliador = document.getElementById("chk_avaliador").checked;
    checkboxOrganizador = document.getElementById("chk_organizador").checked;
    checkboxAluno = document.getElementById("chk_aluno").checked;
    
    if(checkboxAvaliador || checkboxOrganizador || checkboxAluno){
        if(textBoxEmail == ""){
            alert("Digite um e-mail!");
            $("#email").focus();
            return false;
        }
        if(textBoxSenha == ""){
            alert("Digite a senha!");
            $("#senha").focus();
            return false;
        }
        else if(textBoxSenha != textBoxSenha2){
            alert("Senhas diferentes. Por favor digite novamente!");
            $("#senha2").val("");
            $("#senha").val("").focus();
            return false;
        }
    }
    return true;
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
            "url":"ajaxquery.php",
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
            "url":"ajaxquery.php",
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
        
        $("#email_valido").val("sim");
        $("#email_tip").text("");
    }
}

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