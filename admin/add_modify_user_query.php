<?php
    //Conexao com DB
    require '../link1.php';
    
    if(isset($_POST['id'])){
        $id_usuario = $_POST['id'];
        $tipo_usuario = $_POST['tipo_usuario'];
        if($tipo_usuario == 0 || $tipo_usuario > 15){
            echo "ERRO 1";
            exit;
        }
        $tipo_usuario_bin = decbin($tipo_usuario);
        while(strlen($tipo_usuario_bin)<4){
            $tipo_usuario_bin = '0' . $tipo_usuario_bin;
        }
        $isProf = ($tipo_usuario_bin[0] == '1') ? true:false;
        //$isAvali = ($tipo_usuario_bin[1] == '1') ? true:false;
        //$isOrgan = ($tipo_usuario_bin[2] == '1') ? true:false;
        $isAluno = ($tipo_usuario_bin[3] == '1') ? true:false;
        
        $novo_user = $_POST['novo_user'];
        $novo_prof = $_POST['novo_prof'];
        $novo_aluno = $_POST['novo_aluno'];
        $nome = ($_POST['nome'] == '') ? 'NULL':"'". $_POST['nome'] ."'";
        $email = ($_POST['email'] == '') ? 'NULL':"'" . $_POST['email'] . "'";
        $celular = ($_POST['celular'] == '') ? 'NULL':"'". $_POST['celular'] ."'";
        $data_nasc = $_POST['data_nasc'];
        $token_data = explode("/", $data_nasc);
        $data_nasc = $token_data[2] . "-" . $token_data[1] . "-" . $token_data[0];
        $data_nasc = ($_POST['data_nasc']== '')? 'NULL':"'". $data_nasc ."'";
        $cpf = ($_POST['cpf'] == '') ? 'NULL':"'". $_POST['cpf'] ."'";
        $telefone = ($_POST['telefone'] == '') ? 'NULL': "'". $_POST['telefone'] ."'";
        $senha = ($_POST['senha'] == '') ? 'NULL':"'". $_POST['senha'] ."'";
        
        $sql4 = "INSERT INTO sch_usuarios (id,nome,email,cpf,senha,celular,telefone,d_nascimento,tipo) VALUES "
                . "('$id_usuario', $nome, $email, $cpf, $senha,$celular,$telefone,$data_nasc, '$tipo_usuario');";
        $sql5 = "UPDATE sch_usuarios SET nome = $nome, email = $email, cpf = $cpf, senha = $senha, celular = $celular,"
                . " telefone = $telefone, d_nascimento = $data_nasc, tipo = '$tipo_usuario' WHERE id = $id_usuario;";
        if($novo_user){
            $busca4 = mysql_query($sql4, $link1);
        }
        else{
            $busca4 = mysql_query($sql5, $link1);
        }
        if($busca4){
            //Atualiza db Prof and Aluno here
            if($isProf){
                //trata db de professores
                $minicv = ($_POST['minicv'] == '') ? 'NULL':"'". $_POST['minicv'] ."'";
                $sql6 = "INSERT INTO sch_professores (id,minicv) VALUES ($id_usuario, $minicv);";
                $sql7 = "UPDATE sch_professores SET minicv = $minicv WHERE id = $id_usuario;";
                if($novo_prof){
                    $busca5 = mysql_query($sql6,$link1);
                }
                else{
                    $busca5 = mysql_query($sql7,$link1);
                }
                if(!$busca5){
                    header("Location: index.php?error=5");
                    exit;
                }
            }
            else if(!$novo_user) {
                //here remove prof
                $sqlRemp = "DELETE FROM sch_professores WHERE id = '$id_usuario'";
                mysql_query($sqlRemp);
            }
            if($isAluno){
                //trata db de aluno
                $matricula = ($_POST['matricula'] == '') ? 'NULL':"'". $_POST['matricula'] ."'";
                $uf = "'". $_POST['uf'] ."'";
                $cidade = ($_POST['cidade'] == '') ? 'NULL':"'". $_POST['cidade'] ."'";
                $bairro = ($_POST['bairro'] == '') ? 'NULL':"'". $_POST['bairro'] ."'";
                $endereco = ($_POST['endereco'] == '') ? 'NULL':"'". $_POST['endereco'] ."'";
                $sql8 = "INSERT INTO sch_alunos (id,matricula,uf,cidade,bairro,endereco,email_ativo) VALUES "
                        . "($id_usuario, $matricula, $uf, $cidade, $bairro, $endereco, 'F');";
                $sql9 = "UPDATE sch_alunos SET matricula = $matricula, uf = $uf, cidade = $cidade, bairro = $bairro,"
                        . " endereco = $endereco WHERE id = $id_usuario;";
                if($novo_aluno){
                    $busca6 = mysql_query($sql8,$link1);
                }
                else{
                    $busca6 = mysql_query($sql9,$link1);
                }
                if(!$busca6){
                    header("Location: index.php?error=6");
                    exit;
                }
            }
            else if(!$novo_user) {
                $sqlRemAlun = "DELETE FROM sch_alunos WHERE id = '$id_usuario'";
                mysql_query($sqlRemAlun);
            }
            header("Location: index.php?list_user&sucess=cadastro");
        }
        else{
            header("Location: index.php?error=4");
            exit;
        }
    }
    else{
        header("Location: index.php");
    }
?>

