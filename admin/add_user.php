<?php
    //Conexao com DB
    require '../link1.php';
        
    $novo_user = true; //flag para inserir ou modificar usuario
    $novo_prof = true; //flag para inserir ou modificar professor
    $novo_aluno = true; //flag para inserir ou modificar aluno
    $id_user = 0; //variavel para Id no Usuario atual
    if(isset($_GET['add_user'])){
        if($_GET['add_user'] != ''){ //modificacao ou criacao de novo usuario
            $novo_user = false;
            $id_user = $_GET['add_user'];
        }
    }
    if($novo_user){
        //novo usuario
        $id_user = date("ymdHis"); //novo Id para usuario
    }
    else{ //modificacao de usuario
        $sql1 = "SELECT * FROM sch_usuarios WHERE id=$id_user";
        $busca1 = $link1->query($sql1);
        if(!$busca1){
            header("Location: index.php?error=1");
            exit;
        }
        if($busca1->rowCount() == 0){
            header("Location: index.php?error=1");
            exit;
        }
        $linha1 = $busca1->fetchAll(PDO::FETCH_ASSOC)[0];
        $busca1->closeCursor();
        $tipos = decbin($linha1['tipo']);
        while(strlen($tipos)<4){
            $tipos = '0' . $tipos;
        }
        // $tipo[3 a 0] isso acessa checkboxs
        if($tipos[0] == '1'){ //professor
            $novo_prof = false;
            $sql2 = "SELECT * FROM sch_professores WHERE id='$id_user'"; 
            $busca2 = $link1->query($sql2);
            if(!$busca2){
                header("Location: index.php?error=2");
                exit;
            }
            if($busca2->rowCount() == 0){
                header("Location: index.php?error=2");
                exit;
            }
            $linha_prof = $busca2->fetchAll(PDO::FETCH_ASSOC);
        }
        if($tipos[3] == '1'){ //aluno
            $novo_aluno = false;
            $sql3 = "SELECT * FROM sch_alunos WHERE id='$id_user'";
            $busca3 = $link1->query($sql3);
            if(!$busca3){
                header("Location: index.php?error=3");
                exit;
            }
            if($busca3->rowCount() == 0){
                header("Location: index.php?error=3");
                exit;
            }
            $linha_aluno = $busca3->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>
<script type="text/javascript" src="add_user.js"></script>
<script type="text/javascript">
    function controlaCheck(){
            /*
            chk_prof = false;
            $("#chk_professor").attr("checked",function(){
                chk_prof = this.checked;
            });
            
            chk_avalia = false;
            $("#chk_avaliador").attr("checked",function(){
                chk_avalia = this.checked;
            });
            
            chk_organiz = false;
            $("#chk_organizador").attr("checked",function(){
                chk_organiz = this.checked;
            });
            
            chk_alun = false;
            $("#chk_aluno").attr("checked",function(){
                chk_alun = this.checked;
            });
            */
            
            chk_prof = document.getElementById("chk_professor").checked;
            chk_avalia = document.getElementById("chk_avaliador").checked;
            chk_organiz = document.getElementById("chk_organizador").checked;
            chk_alun = document.getElementById("chk_aluno").checked;

            chk_prof = chk_prof ? '1' : '0';
            chk_avalia = chk_avalia ? '1' : '0';
            chk_organiz = chk_organiz ? '1' : '0';
            chk_alun = chk_alun ? '1' : '0';
            tipo_user = parseInt((chk_prof + chk_avalia + chk_organiz + chk_alun),2);
            $("#tipo_usuario").val(tipo_user);
            $(".campos_gerais").css("display","none");
            $(".campos_comuns").css("display","none");
            $(".campos_professores").css("display","none");
            $(".campos_alunos").css("display","none");
            if(chk_prof === '1'){
                $(".campos_gerais").css("display","block");
                $(".campos_professores").css("display","block");
            }
            if(chk_avalia === '1'){
                $(".campos_gerais").css("display","block");
                $(".campos_comuns").css("display","block");
            }
            if(chk_organiz === '1'){
                $(".campos_gerais").css("display","block");
                $(".campos_comuns").css("display","block");
            }
            if(chk_alun === '1'){
                $(".campos_gerais").css("display","block");
                $(".campos_alunos").css("display","block");
                $(".campos_comuns").css("display","block");
            }
    }
    $(function(){
        $(".campos_gerais").css("display","none");
        $(".campos_comuns").css("display","none");
        $(".campos_professores").css("display","none");
        $(".campos_alunos").css("display","none");
        $("#campos").tooltip({ position: { my: "left+15 center", at: "right center" } });
        controlaCheck();
        $(".check_user").click(function(){
            controlaCheck();
        });
        $("#campos").css('display','block');
        altura = $(document).height();
        $("#corpo_principal").css('height',(altura-180)+'px');
        $("#corpo_principal").css('overflow-y','scroll');
    });
</script>

<div id="seletor_tipo_user">
    
    <input type="checkbox" name="chk_professor" id="chk_professor" class="check_user" value="Professor"<?php
    if(!$novo_user){
        if($tipos[0] == '1'){
            echo " checked=\"checked\"";
        }
    }
    ?> />
    <label for="chk_professor">Professor</label>
    
    <input style="display: none;" type="checkbox" name="chk_avaliador" id="chk_avaliador" class="check_user" value="avaliador"<?php
    if(!$novo_user){
        if($tipos[1] == '1'){
            echo " checked=\"checked\"";
        }
    }
    ?> />
    <label style="display: none;" for="chk_avaliador">Avaliador de Artigo</label>
    
    <input style="display: none;" type="checkbox" name="chk_organizador" id="chk_organizador" class="check_user" value="organizador"<?php
    if(!$novo_user){
        if($tipos[2] == '1'){
            echo " checked=\"checked\"";
        }
    }
    ?> />
    <label style="display: none;" for="chk_organizador">Organizador</label>
    <input type="checkbox" name="chk_aluno" id="chk_aluno" class="check_user" value="aluno"<?php
    if(!$novo_user){
        if($tipos[3] == '1'){
        echo " checked=\"checked\"";
        }
    }
    ?> />
    <label for="chk_aluno">Aluno/Participante</label>
</div>

<form method="POST" action="add_modify_user_query.php" id="campos" style="display: none;">

        <input type="hidden" name="id" id="id" value="<?php echo $id_user ?>" />
        <input type="hidden" name="tipo_usuario" id="tipo_usuario" value="" />
        <input type="hidden" name="novo_user" id="novo_user" value="<?php echo $novo_user?>">
        <input type="hidden" name="novo_prof" id="novo_prof" value="<?php echo $novo_prof?>">
        <input type="hidden" name="novo_aluno" id="novo_aluno" value="<?php echo $novo_aluno?>">
        <input type="hidden" name="email_valido" id="email_valido" value="sim">
        <input type="hidden" name="cpf_valido" id="cpf_valido" value="sim">

        <label for="nome" class="campos_gerais">Nome</label>
        <input type="text" class="campos_gerais" name="nome" id="nome" title="Nome completo sem caracteres especiais." value="<?php
            if(!$novo_user){echo $linha1['nome'];}
        ?>" />

	<label for="email" class="campos_gerais">E-mail <span id="email_tip"></span></label>
	<input type="text" class="campos_gerais" name="email" id="email" title="Digite um e-mail valido!" value="<?php
            if(!$novo_user){echo $linha1['email'];}
        ?>" />
	<label for="celular" class="campos_gerais">Celular</label>
	<input type="text" class="campos_gerais" name="celular" id="celular" title="Peencha somente com numeros!" value="<?php
            if(!$novo_user){echo $linha1['celular'];}
        ?>" />

	<label for="data_nasc" class="campos_gerais">Data de nascimento</label>
	<input type="text" class="campos_gerais" name="data_nasc" id="data_nasc" title="Data no formato dd/mm/aaa" value="<?php
            if(!$novo_user){
                if($linha1['d_nascimento'] != ''){
                    $token = explode("-", $linha1['d_nascimento']);
                    echo $token[2] .'/'. $token[1] .'/'. $token[0];   
                }
            }
        ?>" />
	
	<label for="cpf" class="campos_gerais">CPF <span id="cpf_tip"></span></label>
        <input type="text" class="campos_gerais" name="cpf" maxlength="11" id="cpf" title="Digite 11 digitos, somente numeros!" value="<?php
            if(!$novo_user){echo $linha1['cpf'];}
        ?>" />
	
	<label for="telefone" class="campos_gerais">Telefone</label>
	<input type="text" class="campos_gerais" name="telefone" id="telefone" title="Peencha somente com numeros!" value="<?php
            if(!$novo_user){echo $linha1['telefone'];}
        ?>" />

	<label for="senha" class="campos_comuns">Senha</label>
	<input type="password" class="campos_comuns" name="senha" id="senha" title="Minimo 6 caracteres e no maximo 12." value="<?php
            if(!$novo_user){echo $linha1['senha'];}
        ?>" />
	
	<label for="senha2" class="campos_comuns">Redigite a senha</label>
	<input type="password" class="campos_comuns" name="senha2" id="senha2" title="Repita a senha!" value="<?php
            if(!$novo_user){echo $linha1['senha'];}
        ?>" />

	<label for="matricula" class="campos_alunos">Matricula Academica</label>
	<input type="text" class="campos_alunos" name="matricula" id="matricula" title="Digite o numero da matricula." value="<?php
            if(!$novo_aluno){
                echo $linha_aluno['matricula'];
            }
        ?>" />
	
	<label for="uf" class="campos_alunos">UF</label>
	<select name="uf" class="campos_alunos" id="uf" title="Selecione o Estado">
            <?php
                $opt = "CE";
                if(!$novo_aluno){
                    $opt = $linha_aluno['uf'];
                }
            ?>
            <option value="AC"<?php echo ($opt == "AC") ? " selected=\"selected\"":"" ?>>Acre</option>
            <option value="AL"<?php echo ($opt == "AL") ? " selected=\"selected\"":"" ?>>Alagoas</option>
            <option value="AP"<?php echo ($opt == "AP") ? " selected=\"selected\"":"" ?>>Amapá</option>
            <option value="AM"<?php echo ($opt == "AM") ? " selected=\"selected\"":"" ?>>Amazonas</option>
            <option value="BA"<?php echo ($opt == "BA") ? " selected=\"selected\"":"" ?>>Bahia</option>
            <option value="CE"<?php echo ($opt == "CE") ? " selected=\"selected\"":"" ?>>Ceará</option>
            <option value="DF"<?php echo ($opt == "DF") ? " selected=\"selected\"":"" ?>>Distrito Federal</option>
            <option value="ES"<?php echo ($opt == "ES") ? " selected=\"selected\"":"" ?>>Espírito Santo</option>
            <option value="GO"<?php echo ($opt == "GO") ? " selected=\"selected\"":"" ?>>Goiás</option>
            <option value="MA"<?php echo ($opt == "MA") ? " selected=\"selected\"":"" ?>>Maranhão</option>
            <option value="MT"<?php echo ($opt == "MT") ? " selected=\"selected\"":"" ?>>Mato Grosso</option>
            <option value="MS"<?php echo ($opt == "MS") ? " selected=\"selected\"":"" ?>>Mato Grosso do Sul</option>
            <option value="MG"<?php echo ($opt == "MG") ? " selected=\"selected\"":"" ?>>Minas Gerais</option>
            <option value="PA"<?php echo ($opt == "PA") ? " selected=\"selected\"":"" ?>>Pará</option>
            <option value="PB"<?php echo ($opt == "PB") ? " selected=\"selected\"":"" ?>>Paraíba</option>
            <option value="PR"<?php echo ($opt == "PR") ? " selected=\"selected\"":"" ?>>Paraná</option>
            <option value="PE"<?php echo ($opt == "PE") ? " selected=\"selected\"":"" ?>>Pernambuco</option>
            <option value="PI"<?php echo ($opt == "PI") ? " selected=\"selected\"":"" ?>>Piauí</option>
            <option value="RJ"<?php echo ($opt == "RJ") ? " selected=\"selected\"":"" ?>>Rio de Janeiro</option>
            <option value="RN"<?php echo ($opt == "RN") ? " selected=\"selected\"":"" ?>>Rio Grande do Norte</option>
            <option value="RS"<?php echo ($opt == "RS") ? " selected=\"selected\"":"" ?>>Rio Grande do Sul</option>
            <option value="RO"<?php echo ($opt == "RO") ? " selected=\"selected\"":"" ?>>Rondônia</option>
            <option value="RR"<?php echo ($opt == "RR") ? " selected=\"selected\"":"" ?>>Roraima</option>
            <option value="SC"<?php echo ($opt == "SC") ? " selected=\"selected\"":"" ?>>Santa Catarina</option>
            <option value="SP"<?php echo ($opt == "SP") ? " selected=\"selected\"":"" ?>>São Paulo</option>
            <option value="SE"<?php echo ($opt == "SE") ? " selected=\"selected\"":"" ?>>Sergipe</option>
            <option value="TO"<?php echo ($opt == "TO") ? " selected=\"selected\"":"" ?>>Tocantins</option>
	</select>
	
	<label for="cidade" class="campos_alunos">Cidade</label>
	<input type="text" class="campos_alunos" name="cidade" id="cidade" title="" value="<?php
            if(!$novo_aluno){
                echo $linha_aluno['cidade'];
            }
        ?>" />
	
	<label for="bairro" class="campos_alunos">Bairro</label>
	<input type="text" class="campos_alunos" name="bairro" id="bairro" title="" value="<?php
            if(!$novo_aluno){
                echo $linha_aluno['bairro'];
            }
        ?>" />
	
	<label for="endereco" class="campos_alunos">Endereco</label>
	<input type="text" class="campos_alunos" name="endereco" id="endereco" title="" value="<?php
            if(!$novo_aluno){
                echo $linha_aluno['endereco'];
            }
        ?>" />

	<label for="minicv" class="campos_professores">Mini CV</label>
	<textarea name="minicv" class="campos_professores" id="minicv" title="Descreva aqui um miniCV do professor ou palestrante." ><?php
            if(!$novo_prof){
                echo $linha_prof['minicv'];
            }
        ?></textarea>

<input type="submit" id="salvar" value="Salvar!" />

</form>