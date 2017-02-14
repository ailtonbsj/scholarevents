<script type="text/javascript">
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
                    recuperarKey();
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
    
    function recuperarKey(){
        var form = $("#inscricaoonline").serializeArray();
        $.ajax({
            "type":"POST",
            "url":"recupera.php",
            "data":{
                "form":form
            },
            "success":function(stringRecebida){
                if(stringRecebida != "ERROR"){
                    $("#yourkey").text(stringRecebida);
                    $("#appsucess").show();
                    $("#appkey").hide();
                }
                else{
                    alert("Dados incorretos!");
                    captchaconfirmado = false;
                    $("#imgcaptchadiv").html("");
                    $("#imgcaptchadiv").html("<img id='imgcaptcha' src='captcha.php?"+Math.round(10000*Math.random())+"' />");
                }
            },
            "error":function(jqxhr, msg, errthown){
                alert(msg);
            }
        });
    }
    
    $(function(){
        $("#inscricaoonline").submit(validaCaptcha);
        $("#appsucess").hide();
    });
</script>

<div id='appkey'>
<h1>Esqueceu sua senha?</h1>

<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: .5em .7em;">
    <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
    Digite seus dados corretamente e clique em recuperar senha.</p>
</div>

<form method="POST" action="" id="inscricaoonline" onsubmit="return false">
    <label for="nome" class="campos_gerais">Nome *</label>
    <input type="text" class="campos_gerais" name="nome" id="nome" title="Nome completo sem caracteres especiais." value="" />

    <label for="email" class="campos_gerais">E-mail *<span id="email_tip"></span></label>
    <input type="text" class="campos_gerais" name="email" id="email" title="Digite um e-mail valido!" value="" />
    
    <label for="celular" class="campos_gerais">Celular *</label>
    <input type="text" class="campos_gerais" maxlength="11" name="celular" id="celular" title="Peencha somente com numeros!" value="" />

    <label for="data_nasc" class="campos_gerais">Data de nascimento *</label>
    <input type="text" class="campos_gerais" name="data_nasc" id="data_nasc" title="Data no formato dd/mm/aaaa" value="" />

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

    <label for="endereco" class="campos_alunos">Endereco *</label>
    <input type="text" class="campos_alunos" name="endereco" id="endereco" title="Digite a rua e o número da casa ou Apartamento." value="" />
    
    <label for="textcaptcha" class="campos_alunos">Verificação de segurança *</label>
    <div id="imgcaptchadiv">
        <img id="imgcaptcha" src="captcha.php">
    </div>
    <input type="text" class="campos_alunos" name="textcaptcha" id="textcaptcha" title="Digite os caracteres que aparecem na image" value="" />
    
    <input type="submit" id="salvar" value="Recuperar Senha" />
    
</form>
</div>
<div id="appsucess">
    <h1>Senha Recuperada!</h1>
    <p>
        Sua senha é: 
        <dt id="yourkey"></dt>
    </p>
</div>