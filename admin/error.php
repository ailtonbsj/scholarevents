<div class="ui-state-error ui-corner-all" style="margin: 10px 0; padding: 6px;">
<?php

    if(isset($_GET['error'])){
        $tipo_error = $_GET['error'];
        switch ($tipo_error){
            case 1:
                echo "Erro ao buscar usuário em Database!";
                break;
            case 2:
                echo "Erro ao buscar professor em Database!";
                break;
            case 3:
                echo "Erro ao buscar Aluno em Database";
                break;
            case 4:
                echo "Erro ao inserir ou modificar dados de Usuario. Chave primaria ou unica duplicada!";
                break;
            case 5:
                echo "Erro ao inserir ou modificar dados de Professor. Chave primaria ou unica duplicada!";
                break;
            case 6:
                echo "Erro ao inserir ou modificar dados de Aluno. Chave primaria ou unica duplicada!";
                break;
            case 7:
                echo "Erro ao tentar apagar usuario!!!";
                break;
            case 8:
                echo "Erro ao tentar apagar local!!!<br />Ainda está sendo usado em algum subevento!<br />Primeiro remova os vinculos dos subeventos a este local.";
                break;
            case 9:
                echo "Erro ao tentar adicionar ou modificar local!!!";
                break;
            case 10:
                echo "Erro ao modificar informações do Site!!!";
                break;
            case 11:
                echo "Nao pode mover image";
                break;
            case 12:
                echo "Erro de Upload!";
                break;
            case 13:
                echo "Dimensões da Imagem invalida!!!";
                break;
            case 14:
                echo "Falha da tabela de banners!!!";
                break;
            case 15:
                echo "Impossível excluir a banner!!!";
                break;
            case 16:
                echo "Impossível excluir a banner de database!!!";
                break;
            case 666:
                echo "Erro! Tentativa de ataque!";
                break;
            case 'MAX_SIZE':
                echo "<b>Tamanho do arquivo maior que o permitido!</b><br />Imagens somentes menores que 2MB.<br />Outros arquivos somente menores em 6MB.";
                break;
            case 'REM_SUBEV':
                echo "<b>Erro ao tentar remover o subevento!</b>";
                break;
        }
    }

?>
</div>
